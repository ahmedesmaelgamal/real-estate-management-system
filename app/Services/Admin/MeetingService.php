<?php

namespace App\Services\Admin;

use App\Exports\DynamicModelExport;
use App\Mail\NewMeetingNotificationMail;
use App\Mail\NewVoteNotificationMail;
use App\Models\Admin;
use App\Models\Agenda;
use App\Models\Association;
use App\Models\Topic;
use App\Models\Meeting as ObjModel;
use App\Models\User;
use App\Services\BaseService;
use App\Traits\FirebaseNotification;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class MeetingService extends BaseService
{
    use FirebaseNotification;
    protected string $folder = 'admin/meetings';
    protected string $route = 'meetings';

    public function __construct(protected ObjModel $objModel, protected Association $association, protected User $users, protected Admin $admin, protected  Topic $topicModel, protected Agenda $agendaModel, protected Association $associationModel)
    {
        parent::__construct($objModel);
    }

    public function index($request)
    {
        if ($request->ajax()) {

            $query = $this->objModel->with(["association", "agenda", "topic", "owner"]);


            if ($request->filled('association_id')) {
                $query->where('association_id', $request->association_id);
            }


            if ($request->filled('keys') && $request->filled('values')) {
                $key = $request->get('keys')[0] ?? null;
                $value = $request->get('values')[0] ?? null;

                if ($key && $value) {
                    switch ($key) {
                        case 'association_id':
                            $association = $this->associationModel->where('name->ar', $value)
                                ->orWhere('name->en', $value)
                                ->first();
                            if ($association) {
                                $query->where('association_id', $association->id);
                            }
                            break;

                        // case 'agenda':
                        //     $query->where('agenda_id', $value);
                        //     break;

                        case 'owner_id':
                            $admin = $this->admin->where('name', $value)->first();
                            if ($admin) {
                                $query->where('owner_id', $admin->id);
                            }
                            break;

                        case 'date':
                            $query->whereDate('date', $value);
                            break;

                        case 'created_at':
                            $query->whereDate('created_at', $value);
                            break;

                        default:
                            $query->where($key, 'like', "%$value%");
                            break;
                    }
                }
            }

            $query->latest();


            return DataTables::of($query)
                ->editColumn("owner_id", fn($obj) => $obj->owner?->name ?? '')
                ->editColumn("created_by", fn($obj) => $obj->creator?->name ?? '-')
                ->editColumn("association_id", fn($obj) => $obj->association?->getTranslation("name", app()->getLocale()) ?? '')
                // ->editColumn("topic_id", function ($obj) {
                //     return $obj->topic->map(fn($t) => $t->getTranslation('title', app()->getLocale()))->implode(', ');
                // })
                
                ->editColumn("topic", function ($obj) {
                    return $obj->topic ?? "-";
                })
                ->editColumn("date", fn($obj) => $obj->date?->format('Y-m-d') ?? '')
                ->editColumn("created_at", fn($obj) => $obj->created_at->format("Y-m-d"))
                ->addColumn('action', function ($obj) {
                    return '
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                <li><a class="dropdown-item" href="' . route('meetings.show', $obj->id) . '"><i class="fa fa-eye"></i> ' . trns("see") . '</a></li>
                                <li><a class="dropdown-item editBtn editMeetingBtn" href="javascript:void(0);" data-id="' . $obj->id . '"><img src="' . asset('edit.png') . '" style="width: 24px; height: 24px;"> ' . trns("Edit") . '</a></li>
                                <li><a class="dropdown-item delayBtn" href="javascript:void(0);" data-id="' . $obj->id . '">' . trns("delay_meet") . '</a></li>
                                <li><a class="dropdown-item" href="' . route("meetings.download", $obj->id) . '">' . trns("donwload_meet") . '</a></li>
                                <li><button class="dropdown-item text-danger" id="meetingDeleteBtn" data-bs-toggle="modal" data-bs-target="#delete_modal" data-id="' . $obj->id . '"><i class="fas fa-trash"></i> ' . trns("delete") . '</button></li>
                            </ul>
                        </div>';
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        }


        return view($this->folder . '/index', [
            'createRoute' => route($this->route . '.create'),
            'bladeName'   => trns($this->route),
            'route'       => $this->route,
            "associations" => $this->associationModel->get(),
            "agendas"      => $this->agendaModel->get(),
            "users"       => $this->users->get(),
        ]);
    }



    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            "users" => $this->users->get(),
            "topics" => $this->topicModel->get(),
            "agendas" => [],
            // "agendas" => $this->agendaModel->get(),
            "associations" => $this->associationModel->where("status", 1)->get(),
            "users"       => $this->users->where("status", 1)->get(),
        ]);
    }

    public function show($id)
    {
        $obj = $this->objModel->with(["association", "owner", "agenda", "topics", "users"])->findOrFail($id);

        return  view("{$this->folder}/parts/show", [
            'obj'           => $obj,
            'route'         => 'meetings',
            'editRoute'     => 'meetings',

        ]);
    }

    public function singlePageCreate()
    {
        return view("{$this->folder}/parts/singlePageCreate", [
            'storeRoute' => route("{$this->route}.store"),
            "users" => $this->users->get(),
            "topics" => $this->topicModel->get(),
            "agendas" => [],
            // "agendas" => $this->agendaModel->get(),
            "associations" => $this->associationModel->where("status", 1)->get(),
            "users"       => $this->users->where("status", 1)->get(),
        ]);
    }

    public function store(array $data)
    {
        // try {
            $meeting = $this->objModel->create([
                'association_id' => $data['association_id'],
                'topic' => $data['topic'],
                'owner_id'       => $data['owner_id'],
                'date'           => $data['date'] ?? now(),
                'address'        => $data['address'] ?? '',
                'created_by'     => auth('admin')->id(),
                'other_topic'    => $data['other_topic'] ?? "",
            ]);

            if (isset($data['users_id'])) {
                $meeting->users()->sync($data['users_id']);
            }

            if (isset($data['topic_id'])) {
                $meeting->topics()->sync($data['topic_id']);
            }

            if (isset($data['agenda_id'])) {
                $meeting->agendas()->sync($data['agenda_id']);
            }

            foreach($data['agenda_id'] as $agendaIs){
                $agenda = $this->agendaModel->find($agendaIs);
                $agenda->update(['taken' , 1]);
            }

            $association = $this->association
                ->with('realStates.units.getOwners')
                ->find($data['association_id']);

            $owners = $association->realStates
                ->flatMap(fn($realState) => $realState->units)
                ->flatMap(fn($unit) => $unit->getOwners)
                ->unique('id');

            // Optional: send mail notifications
            // foreach ($owners as $owner) {
            //     if (!empty($owner->email)) {
            //         Mail::to($owner->email)->send(new NewMeetingNotificationMail($meeting, $owner));
            //     }
            // }

            return response()->json([
                'status'  => 200,
                'message' => trns('Data created successfully.')
            ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status'  => 500,
        //         'message' => trns('Something went wrong.'),
        //         'error'   => $e->getMessage()
        //     ]);
        // }
    }


    public function edit($obj)
    {
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
            "users" => $this->users->get(),
            "topics" => $this->topicModel->get(),
            "agendas" => $obj->agendas,
            "users"       => $this->users->where("status", 1)->get(),
            "associations" => $this->associationModel->where("status", 1)->get(),
        ]);
    }



    public function getOwners($id)
    {
        
        $association = $this->associationModel->with('admin')->find($id);
        $admin = $association?->admin;

        
        return response()->json([
            'status' => $admin ? 200 : 404,
            'user'   => $admin
        ]);
    }




    public function update($data, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $meeting = $this->objModel->find($id);

            if (!$meeting) {
                return response()->json([
                    'message' => trns('Data not found.')
                ], 404);
            }

            $meeting->update([
                "association_id" => $data['association_id'] ?? $meeting->association_id,
                "topic" => $data['topic'] ?? $meeting->topic,
                "owner_id"       => $data['owner_id'] ?? $meeting->owner_id,
                "date"           => $data['date'] ?? $meeting->date,
                "address"        => $data['address'] ?? $meeting->address,
                "other_topic"    => $data["other_topic"] ?? $meeting->other_topic,
            ]);

            if (!empty($data['users_id']) && is_array($data['users_id'])) {
                $meeting->users()->sync($data['users_id']);
            }

            if (!empty($data['topic_id']) && is_array($data['topic_id'])) {
                $meeting->topics()->sync($data['topic_id']); // ✅ fix naming to plural
            }

            if (!empty($data['agenda_id']) && is_array($data['agenda_id'])) {
                $meeting->agendas()->sync($data['agenda_id']); // ✅ new many-to-many relation
            }

            foreach($data['agenda_id'] as $agendaIs){
                $agenda = $this->agendaModel->find($agendaIs);
                $agenda->update(['taken' , 1]);
            }

            return response()->json([
                'message' => trns('Data updated successfully.'),
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => trns('Something went wrong.'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }






    public function sendNotification($data, $id): \Illuminate\Http\JsonResponse
    {
        dd($data, $id);
        try {
            $meeting = $this->objModel->find($id);

            if (!$meeting) {
                return response()->json([
                    'status' => 404,
                    'message' => trns('Data not found.')
                ]);
            }

            $users = $meeting->users;
            foreach ($users as $user) {
                $this->sendFcm(
                    [
                        'title' => $data[trns("meeting_notification")],
                        'body'  => $data['message'],
                    ],
                    [$user->id],
                );
            }

            return response()->json([
                'status' => 200,
                'message' => trns('Notification sent successfully.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => trns('Something went wrong.'),
                trns('error') => $e->getMessage()
            ]);
        }
    }



    public function getAssociationOwners($id)
    {
        $association = $this->association
            ->with('realStates.units.getOwners')
            ->find($id);

        if (!$association) {
            return response()->json(['users' => []]);
        }

        $owners = $association->realStates
            ->flatMap(fn($realState) => $realState->units)
            ->flatMap(fn($unit) => $unit->getOwners)
            ->unique('id')
            ->values(); // optional: reindex the collection

        return response()->json([
            'users' => $owners->map(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
            ]),
        ]);
    }




    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $export = new DynamicModelExport(\App\Models\Meeting::class);
        $fileName = 'meet_' . date('Y-m-d') . '.xlsx';
        return Excel::download($export, $fileName);
    }




    public function addExcel()
    {
        return view("{$this->folder}/parts/addExcel", [
            'storeExcelRoute' => route("{$this->route}.store.excel"),
        ]);
    }

    public function storeExcel($request)
    {
        $request->validate([
            'meeting_excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('meeting_excel_file');

            // Step 1: Preview the rows
            $preview = new \App\Imports\PreviewMeetingImport();
            \Maatwebsite\Excel\Facades\Excel::import($preview, $file);
            $rows = $preview->rows;

            $errors = [];
            $meetingsData = [];

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 1;

                // ✅ Association
                $associationName = trim($row->get('association'));
                $association = \App\Models\Association::where(function ($q) use ($associationName) {
                    $q->whereRaw("JSON_UNQUOTE(name->'$.ar') = ?", [$associationName])
                        ->orWhereRaw("JSON_UNQUOTE(name->'$.en') = ?", [$associationName]);
                })->first();

                if (!$association) {
                    $errors[] = "Row {$rowNumber}: Association not found.";
                    continue;
                }

                $agendaInput = $row->get('agendas') ?? '';

                // إذا كانت JSON مثل ["1","2"] نفككها
                if (str_starts_with($agendaInput, '[')) {
                    $agendaNames = json_decode($agendaInput, true);
                    if (!is_array($agendaNames)) {
                        $agendaNames = [];
                    }
                } else {
                    $agendaNames = array_filter(array_map('trim', explode(',', $agendaInput)));
                }

                if (empty($agendaNames)) {
                    $errors[] = "Row {$rowNumber}: Agendas column is empty.";
                    continue;
                }

                // البحث في DB كما قبل
                $agendas = \App\Models\Agenda::where(function ($q) use ($agendaNames) {
                    foreach ($agendaNames as $name) {
                        $q->orWhere(function ($q2) use ($name) {
                            $q2->whereRaw("JSON_UNQUOTE(name->'$.ar') = ?", [$name])
                                ->orWhereRaw("JSON_UNQUOTE(name->'$.en') = ?", [$name]);
                        });
                    }
                })->pluck('id');

                if ($agendas->isEmpty()) {
                    $errors[] = "Row {$rowNumber}: Agendas not found in database. Names: " . implode(', ', $agendaNames);
                    continue;
                }


                // ✅ Topics (single column, comma-separated)
                $topicsInput = array_filter(array_map('trim', explode(',', $row->get('topics'))));
                $topics = \App\Models\Topic::where(function ($q) use ($topicsInput) {
                    foreach ($topicsInput as $t) {
                        $q->orWhere(function ($q2) use ($t) {
                            $q2->whereRaw("JSON_UNQUOTE(title->'$.ar') = ?", [$t])
                                ->orWhereRaw("JSON_UNQUOTE(title->'$.en') = ?", [$t]);
                        });
                    }
                })->pluck('id');

                if ($topics->isEmpty()) {
                    $errors[] = "Row {$rowNumber}: Topics not found in database. Names: " . implode(', ', $topicsInput);
                    continue;
                }

                // ✅ Owner (Admin)
                $adminName = trim($row->get('owner'));
                $admin = \App\Models\Admin::where('name', $adminName)->first();
                if (!$admin) {
                    $errors[] = "Row {$rowNumber}: Admin not found.";
                    continue;
                }

                $meetingsData[] = [
                    'row'            => $row,
                    'association_id' => $association->id,
                    'agenda_ids'     => $agendas,
                    'topic_ids'      => $topics,
                    'owner_id'       => $admin->id,
                ];
            }

            if (!empty($errors)) {
                return response()->json([
                    'status' => 422,
                    'message' => $errors
                ], 422);
            }

            // Step 2: Store meetings
            foreach ($meetingsData as $data) {
                try {
                    \DB::beginTransaction();

                    $row = $data['row'];

                    $meeting = \App\Models\Meeting::create([
                        'association_id' => $data['association_id'],
                        'created_by'     => auth('admin')->id(),
                        'owner_id'       => $data['owner_id'],
                        'date'           => $row->get('date') ?? now(),
                        'address'        => $row->get('address') ?? '',
                    ]);

                    // ✅ Sync topics and agendas
                    $meeting->topics()->sync($data['topic_ids']);
                    $meeting->agendas()->sync($data['agenda_ids']);

                    \DB::commit();
                } catch (\Exception $e) {
                    \DB::rollBack();
                    $errors[] = "Row error: " . $e->getMessage();
                }
            }

            if (!empty($errors)) {
                return response()->json([
                    'status' => 422,
                    'message' => $errors
                ], 422);
            }

            return response()->json([
                'status' => 200,
                'message' => __('Meetings imported successfully.')
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => __('An error occurred during import.'),
                'error' => $e->getMessage()
            ]);
        }
    }





    public function download($id)
    {
        try {
            $meeting = $this->objModel->with([
                'association',
                'owner',
                'users',
                'agenda',
                'topics',
                'meetSummary.owner', // eager-load owner of summary for performance
            ])->findOrFail($id);

            return view('admin.meetings.parts.report', compact('meeting'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('An error occurred while generating the report: ') . $e->getMessage());
        }
    }





    // GET /meetings/{id} - return JSON for the modal
    public function showDate($meeting)
    {
        return response()->json([
            'id' => $meeting->id,
            'date' => $meeting->date ? $meeting->date->format('Y-m-d\TH:i') : null, // format for datetime-local
        ]);
    }
}
