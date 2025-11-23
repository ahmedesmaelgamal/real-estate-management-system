<?php

namespace App\Services\Admin;

use App\Exports\DynamicModelExport;
use App\Models\Association;
use App\Models\User;
use App\Models\Vote;
use App\Services\BaseService;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PreviewVoteImport;
use App\Mail\NewVoteNotificationMail;
use App\Models\VoteDetail;
use App\Models\VoteDetailHasUser;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;


class VotesService extends BaseService
{
    protected string $folder = 'admin/votes';
    protected string $route = 'votes';

    public function __construct(
        protected Vote $objModel,
        protected  Association $association,
        protected  User $users,
    ) {
        parent::__construct($objModel);
    }

    public function index($request)
    {



        if ($request->ajax()) {
            $obj = $this->objModel
                ->with(['firstDetail', 'secondDetail', 'thirdDetail', 'association'])
                ->when($request->filled('keys') && $request->filled('values'), function ($q) use ($request) {
                    $key = $request->get('keys')[0] ?? null;
                    $value = $request->get('values')[0] ?? null;

                    if ($key && $value) {
                        if (in_array($key, ['start_date', 'end_date', 'audience_count'])) {
                            $q->whereHas('voteDetails', function ($detailQuery) use ($key, $value) {
                                if ($key === 'audience_count') {
                                    $detailQuery->whereRaw("(yes_audience + no_audience) = ?", [$value]);
                                } else {
                                    $detailQuery->where($key, 'like', "%{$value}%");
                                }
                            });
                        } elseif ($key === 'association_id') {
                            $q->where('association_id', $value);
                        } elseif ($key === 'status') {
                            $q->where('status', $value);
                        } elseif ($key === 'created_at') {
                            $q->whereDate('created_at', $value); // format YYYY-MM-DD
                        } else {
                            $q->where($key, 'like', "%{$value}%");
                        }
                    }
                })
                ->when($request->filled('association_id'), function ($q) use ($request) {
                    $q->where('association_id', $request->association_id);
                })
                ->get();




            return DataTables::of($obj)
                ->editColumn("association_id", fn($obj) => $obj->association?->localized_name)
                ->editColumn("title", fn($obj) => $obj->title_trans ?? "-")
                ->editColumn("description", fn($obj) => $obj->description_trans ?? "-")

                ->editColumn("start_date", function ($obj) {
                    switch ($obj->stage_number) {
                        case 1:
                            return optional($obj->firstDetail?->start_date)->format("Y-m-d");
                        case 2:
                            return optional($obj->secondDetail?->start_date)->format("Y-m-d");
                        case 3:
                            return optional($obj->thirdDetail?->start_date)->format("Y-m-d");
                        default:
                            return '';
                    }
                })

                ->editColumn("created_at", function ($obj) {
                    return $obj->created_at->format("Y-m-d");
                })

                ->editColumn("end_date", function ($obj) {

                    switch ($obj->stage_number) {
                        case 1:
                            return optional($obj->voteDetails->where("id", $obj->first_detail_id)->first()->end_date)->format("Y-m-d");
                        case 2:
                            return optional($obj->voteDetails->where("id", $obj->second_detail_id)->first()->end_date)->format("Y-m-d");
                        case 3:
                            return optional($obj->voteDetails->where("id", $obj->third_detail_id)->first()->end_date)->format("Y-m-d");
                        default:
                            return '';
                    }
                })

                ->addColumn("audience_number", function ($obj) {
                    $detail = null;
                    switch ($obj->stage_number) {
                        case 1:
                            $detail = $obj->voteDetails->where("id", $obj->first_detail_id)->first();
                            break;
                        case 2:
                            $detail = $obj->voteDetails->where("id", $obj->second_detail_id)->first();
                            break;
                        case 3:
                            $detail = $obj->voteDetails->where("id", $obj->third_detail_id)->first();
                            break;
                    }
                    return $detail ? $detail->yes_audience + $detail->no_audience : 0;
                })

                ->addColumn("owners_number", fn($obj) => $this->users->count())

                ->addColumn('unVoted', function ($obj) {
                    $detailIds = [
                        $obj->first_detail_id,
                        $obj->second_detail_id,
                        $obj->third_detail_id,
                    ];

                    $detailIds = array_filter($detailIds);

                    $details = $obj->voteDetails->whereIn('id', $detailIds);

                    $totalAudience = $details->sum(function ($detail) {
                        return ($detail->yes_audience ?? 0) + ($detail->no_audience ?? 0);
                    });

                    return $obj->audience_number - $totalAudience;
                })


                ->editColumn("status", function ($obj) {
                    return $obj->status == 1
                        ? "<p style='background-color: #6AFFB2; color: #1F2A37; border-radius: 30px; text-align: center;'>" . trns("active") . "</p>"
                        : "<p style='background-color: #FFBABA; color: #1F2A37; border-radius: 30px; text-align: center;'>" . trns("inactive") . "</p>";
                })

                ->addColumn('action', function ($obj) {

                    // ✅ Determine which detail to use
                    $detail = null;
                    switch ($obj->stage_number) {
                        case 1:
                            $detail = $obj->voteDetails->where("id", $obj->first_detail_id)->first();
                            break;
                        case 2:
                            $detail = $obj->voteDetails->where("id", $obj->second_detail_id)->first();
                            break;
                        case 3:
                            $detail = $obj->voteDetails->where("id", $obj->third_detail_id)->first();
                            break;
                    }

                    $buttons = '
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;"
                                aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                <li>
                                    <a class="dropdown-item " href="' . route('votes.show', $obj->id) . '" data-id="' . $obj->id . '">
                                        <i class="fa fa-eye"></i> ' . trns("see") . '
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item editBtn editVoteBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                        <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1"
                                        style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                    </a>
                                </li>';


                    if ($detail && $detail->end_date <= now()) {
                        $buttons .= '
                        <li>
                            <a class="dropdown-item revote_btn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                ' . trns("revote") . '
                            </a>
                        </li>';
                    }


                    $buttons .= '
                        <li>
                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                id="voteDeleteBtn"
                                data-bs-target="#delete_modal" data-id="' . $obj->id . '"
                                data-title="' . $obj->association->getTranslation('name', app()->getLocale()) . '">
                                <i class="fas fa-trash"></i> ' . trns("delete") . '
                            </button>
                        </li>
                        <li>
                            <a class="dropdown-item toggleStatusBtn toggleVoteStatusBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                ' . ($obj->status == 1 ? trns("stop_the_vote") : trns("turn_on_vote")) . '
                            </a>
                        </li>
                    </ul>
                </div>';

// =======
//             <div class="dropdown">
//                 <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '"
//                     data-bs-toggle="dropdown" aria-expanded="false"
//                     style="background-color: transparent; border: none;">
//                     <i class="fa-solid fa-ellipsis"></i>
//                 </button>
//                 <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;"
//                     aria-labelledby="dropdownMenuButton' . $obj->id . '">
//                     <li>
//                         <a class="dropdown-item " href="' . route('votes.show', $obj->id) . '" data-id="' . $obj->id . '">
//                             <i class="fa fa-eye"></i> ' . trns("see") . '
//                         </a>
//                     </li>
//                     <li>
//                         <a class="dropdown-item editBtn editVoteBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
//                             <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1"
//                             style="width: 24px; height: 24px;"> ' . trns("Edit") . '
//                         </a>
//                     </li>
//                     <li>
//                         <a class="dropdown-item revote_btn" href="javascript:void(0);" data-id="' . $obj->id . '" >
//                             ' . trns("revote") . '
//                         </a>
//                     </li>
//                     <li>
//                         <button class="dropdown-item text-danger" data-bs-toggle="modal"
//                         id="voteDeleteBtn"
//                             data-bs-target="#delete_modal" data-id="' . $obj->id . '"
//                             data-title="' . $obj->association->getTranslation('name', app()->getLocale()) . '">
//                             <i class="fas fa-trash"></i> ' . trns("delete") . '
//                         </button>
//                     </li>
//                     <li>
//                         <a class="dropdown-item toggleStatusBtn toggleVoteStatusBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
//                             ' . ($obj->status == 1 ? trns("stop_the_vote") : trns("turn_on_vote")) . '
//                         </a>
//                     </li>

//                 </ul>
//             </div>';
// >>>>>>> dev
                    return $buttons;
                })


                ->escapeColumns([])
                ->make(true);
        }

        return view($this->folder . '/index', [
            'createRoute' => route($this->route . '.create'),
            'bladeName'   => trns($this->route),
            'route'       => $this->route,
            'associations' => $this->association->get(),
            "totalCount" => $this->objModel->count(),
            "activeCount" => $this->objModel->where("status", 1)->count(),
            "inactiveCount" => $this->objModel->where("status", 0)->count(),
        ]);
    }


    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute'   => route("votes.store"),
            'associations' => $this->association->where("status", 1)->get(),
            "audience_count" => $this->users->where("status", 1)->count(),
        ]);
    }

    public function singlePageCreate()
    {
        return view("admin.votes.parts.singlePageCreate", [
            'storeRoute'   => route("votes.store"),
            'associations' => $this->association->where("status", 1)->get(),
            "audience_count" => $this->users->where("status", 1)->count(),
        ]);
    }

    public function store($data)
    {
        try {
            $vote = $this->objModel->create([
                'association_id'  => $data['association_id'],
                'status'          => 1,
                'stage_number'    => 1,
                'vote_percentage' => $data['vote_percentage'],
                'audience_number' => $data['audience_number'],
                'title'           => $data['title'],         // ده array ['ar' => ..., 'en' => ...]
                'description'     => $data['description'],   // array ['ar' => ..., 'en' => ...]
            ]);


            $voteDetail = $vote->voteDetails()->create([
                'vote_id'         => $vote->id,
                'start_date'      => $data['start_date'],
                'end_date'        => $data['end_date'],
                'vote_percentage' => $data['vote_percentage'],
                'yes_audience'    => 0,
                'no_audience'     => 0,
            ]);

            $vote->update([
                'first_detail_id' => $voteDetail->id,
            ]);

            $association = $this->association
                ->with('realStates.units.getOwners')
                ->find($data['association_id']);

            $owners = $association->realStates
                ->flatMap(fn($realState) => $realState->units)
                ->flatMap(fn($unit) => $unit->getOwners)
                ->unique('id');

            // foreach ($owners as $owner) {
            //     if (!empty($owner->email)) {
            //         Mail::to($owner->email)->send(new NewVoteNotificationMail($vote, $owner, $voteDetail));
            //     }
            // }

            // ✅ check if request is ajax
            if (request()->ajax()) {
                return response()->json([
                    'status'      => 200,
                    'mymessage'   => trns('data created successfully'),
                    'redirect_to' => route('votes.show', $vote->id),
                ]);
            }

            // ✅ fallback for normal non-ajax
            return redirect()->route('votes.show', $vote->id)
                ->with('success', trns('data created successfully'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $e->errors(),
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'status'  => 500,
                    'message' => $e->getMessage(),
                ], 500);
            }
            return back()->with('error', $e->getMessage());
        }
    }



    public function show($obj)
    {
        $firstDetail  = $obj->voteDetails->where('id', $obj->first_detail_id)->first();
        $secondDetail = $obj->voteDetails->where('id', $obj->second_detail_id)->first();
        $thirdDetail  = $obj->voteDetails->where('id', $obj->third_detail_id)->first();

        $detail = null;
        switch ($obj->stage_number) {
            case 1:
                $detail = $firstDetail;
                break;
            case 2:
                $detail = $secondDetail;
                break;
            case 3:
                $detail = $thirdDetail;
                break;
        }

        $canRevote = false;
        if ($detail && $detail->end_date <= now()) {
            $canRevote = true;
        }

        return view("{$this->folder}/parts/show", [
            'obj'           => $obj,
            'firstDetail'   => $firstDetail,
            'secondDetail'  => $secondDetail,
            'thirdDetail'   => $thirdDetail,
            'owners_count'  => $obj->audience_number,
            'route'         => 'votes.show',
            'editRoute'     => 'votes',
            'canRevote'     => $canRevote, // ✅ sent to view
        ]);
    }



    public function getVoteImage($request)
    {

        // dd($request->all());
        $voteDetailUser = \App\Models\VoteDetailHasUser::where('user_id', $request->user_id)
            ->where('vote_id', $request->vote_id)
            ->where('vote_detail_id', $request->vote_detail_id)
            ->first();

        if ($voteDetailUser && $voteDetailUser->file) {
            $fileUrl = asset('storage/' . $voteDetailUser->file); // assuming file saved in storage/app/public
            return response()->json(['file_url' => $fileUrl]);
        }

        return response()->json(['file_url' => null]);
    }

    public function getVoteData($request)
    {
        $vote = \App\Models\VoteDetailHasUser::where('user_id', $request->user_id)
            ->where('vote_id', $request->vote_id)
            ->where('vote_detail_id', $request->vote_detail_id)
            ->first();

        if ($vote) {
            return response()->json([
                'exists' => true,
                'vote_action' => $vote->vote_action,
                'file_url' => $vote->file ? asset('storage/' . $vote->file) : null,
            ]);
        }

        return response()->json(['exists' => false]);
    }




    public function edit($obj)
    {
        $associations = $this->association->get();

        $detail = null;
        switch ($obj->stage_number) {
            case 1:
                $detail = $obj->voteDetails->where('id', $obj->first_detail_id)->first();
                break;
            case 2:
                $detail = $obj->voteDetails->where('id', $obj->second_detail_id)->first();
                break;
            case 3:
                $detail = $obj->voteDetails->where('id', $obj->third_detail_id)->first();
                break;
        }

        return view("{$this->folder}/parts/edit", [
            'obj'          => $obj,
            'detail'       => $detail,
            'associations' => $associations,
            'updateRoute'  => route("{$this->route}.update", $obj->id),
            "owners_number" => $this->users->where("status", 1)->count(),
        ]);
    }




    public function update($data, $id)
    {
        try {
            $vote = $this->objModel->findOrFail($id);


            // ✅ update translatable fields
            $vote->setTranslations('title', [
                'ar' => $data['title']['ar'],
                'en' => $data['title']['en'],
            ]);

            $vote->setTranslations('description', [
                'ar' => $data['description']['ar'],
                'en' => $data['description']['en'],
            ]);


            $vote->save();

            // find correct vote_detail based on stage_number
            $detail = null;
            switch ($vote->stage_number) {
                case 1:
                    $detail = $vote->firstDetail;
                    break;
                case 2:
                    $detail = $vote->secondDetail;
                    break;
                case 3:
                    $detail = $vote->thirdDetail;
                    break;
            }

            if ($detail) {
                $detail->update([
                    'start_date' => $data['start_date'],
                    'end_date'   => $data['end_date'],
                    // 'vote_percentage' => $data['vote_percentage'],
                ]);
            }

            return response()->json([
                'status'    => 200,
                'mymessage' => trns('Data updated successfully.'),
                'redirect_to' => route('votes.index'),
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 500,
                'mymessage' => trns('Something went wrong.'),
                'error'     => $e->getMessage(),
            ], 500);
        }
    }


    public function revoteShow($obj)
    {
        $associations = $this->association->get();


        $currentDetail = $obj->voteDetails()
            ->when($obj->stage_number == 1, fn($q) => $q->where('id', $obj->first_detail_id))
            ->when($obj->stage_number == 2, fn($q) => $q->where('id', $obj->second_detail_id))
            ->when($obj->stage_number == 3, fn($q) => $q->where('id', $obj->third_detail_id))
            ->first();


        return view("{$this->folder}/parts/revote", [
            'obj'            => $obj,
            'associations'   => $associations,
            'revoteRoute'    => route("{$this->route}.revote.revoting", $obj->id),
            'owners_number'  => $this->users->count(),
            'currentDetail'    => $currentDetail,
        ]);
    }




    public function revote($data)
    {
        $model = $this->objModel->findOrFail($data["id"]);

        $currentStage = max(1, $model->stage_number);

        if ($currentStage >= 3) {
            return response()->json([
                'status'  => 200,
                'message' => trns('vote_in_latest_stage')
            ]);
        }

        $model->stage_number = $currentStage + 1;
        $model->vote_percentage = $data['vote_percentage'];
        $model->save();

        $voteDetail = $model->voteDetails()->create([
            "vote_id" => $model->id,
            'start_date'   => $data['start_date'],
            'end_date'     => $data['end_date'],
            'vote_percentage' => $data['vote_percentage'],
            'yes_audience' => 0,
            'no_audience'  => 0,
        ]);

        if ($currentStage == 1) {
            $model->second_detail_id = $voteDetail->id;
        } elseif ($currentStage == 2) {
            $model->third_detail_id = $voteDetail->id;
        } else {
            return response()->json([
                'status'  => 200,
                'message' => trns('vote_in_latest_stage')
            ]);
        }

        $model->save();

        return response()->json([
            'status'      => 200,
            'mymessage'   => trns('data created successfully'),
            'redirect_to' => route('votes.index'),
        ]);
    }

    public function makeVote($request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vote_id' => 'required|exists:votes,id',
            'vote_action' => 'required|in:yes,no',
            "file" => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $vote = $this->objModel->findOrFail($request->vote_id);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('vote_supporting_documents', 'public');
        } else {
            $filePath = null;
        }

        if ($vote->stage_number == 1) {
            $voteDetailId = $vote->firstDetail->id ?? null;
        } elseif ($vote->stage_number == 2) {
            $voteDetailId = $vote->secondDetail->id ?? null;
        } elseif ($vote->stage_number == 3) {
            $voteDetailId = $vote->thirdDetail->id ?? null;
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid stage number in vote.',
            ]);
        }


        if (!$voteDetailId) {
            return response()->json([
                'status' => 400,
                'message' => 'Vote detail not found for this stage.',
            ]);
        }

        $voteDetail = VoteDetail::find($voteDetailId);

        if ($request->vote_action == "yes") {
            $voteDetail->yes_audience = ($voteDetail->yes_audience ?? 0) + 1;
            // $voteDetail->file = $filePath;
        } else {
            $voteDetail->no_audience = ($voteDetail->no_audience ?? 0) + 1;
            // $voteDetail->file = $filePath;
        }

        $voteDetail->save();


        \App\Models\VoteDetailHasUser::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'vote_id' => $request->vote_id,
                'vote_detail_id' => $voteDetailId,
            ],
            [
                'stage_number' => $vote->stage_number,
                'vote_action' => $request->vote_action,
                'vote_creator' => 'admin',
                'admin_id' => auth('admin')->id(),
                "file" => $filePath,
            ]
        );

        return response()->json([
            'status' => 200,
            'message' => trns('vote_recorded_successfully'),
        ]);
    }



    public function checkVotes()
    {
        foreach ($this->objModel->where("status", 1)->get() as $vote) {

            $detail = null;
            switch ($vote->stage_number) {
                case 1:
                    $detail = $vote->firstDetail;
                    break;
                case 2:
                    $detail = $vote->secondDetail;
                    break;
                case 3:
                    $detail = $vote->thirdDetail;
                    break;
            }

            if ($detail) {
                $percentage =  round((max(($detail->yes_audience + $detail->no_audience), 1) / $this->users->count()) * 100);
                if ($percentage >= $detail->vote_percentage) {
                    $vote->status = 0;
                    $vote->save();
                }
                return redirect()->back()->with('success', trns("votes_checked_successfully"));
            }
            if ($detail && $detail->end_date && $detail->end_date->isPast()) {
                $vote->status = 0;
                $vote->save();
                return redirect()->back()->with('success', trns("votes_checked_successfully"));
            }
            return redirect()->back()->with('success', trns("votes_checked_successfully"));
        }
    }



    public function getAssociationOwners($id)
    {
        $association = $this->association
            ->with('realStates.units.getOwners')
            ->find($id);

        if (!$association) {
            return response()->json(['count' => 0]);
        }

        $ownerCount = $association->realStates
            ->flatMap(fn($realState) => $realState->units)
            ->flatMap(fn($unit) => $unit->getOwners)
            ->unique('id')
            ->count();

        return response()->json([
            'count' => $ownerCount,
        ]);
    }



    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $export = new DynamicModelExport(\App\Models\Vote::class);
        $fileName = 'votes_' . date('Y-m-d') . '.xlsx';
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
            'vote_excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('vote_excel_file');

            // Step 1: Preview the rows
            $preview = new PreviewVoteImport();
            Excel::import($preview, $file);
            $rows = $preview->rows;

            $errors = [];
            $votesData = [];

            foreach ($rows as $index => $row) {
                // Check if association exists
                $association = \App\Models\Association::where('name->ar', $row->get('association_id'))
                    ->orWhere('name->en', $row->get('association_id'))
                    ->first();

                if (!$association) {
                    $errors[] = "Row " . ($index + 1) . ": Association not found.";
                    continue;
                }

                $votesData[] = [
                    'row' => $row,
                    'association_id' => $association->id,
                ];
            }

            if (!empty($errors)) {
                return response()->json([
                    'status' => 422,
                    'message' => $errors
                ], 422);
            }

            // Step 2: Store votes + details
            foreach ($votesData as $data) {
                try {
                    \DB::beginTransaction();

                    $row = $data['row'];

                    // Create vote
                    $vote = \App\Models\Vote::create([
                        'association_id'   => $data['association_id'],
                        'first_detail_id'  => null,
                        'second_detail_id' => null,
                        'third_detail_id'  => null,
                        'stage_number'     => 0,
                        'vote_percentage'  => $row->get('final_percentage') ?? 0,
                    ]);

                    $stageNumber = 0;
                    $detailIds = [
                        'first_detail_id' => null,
                        'second_detail_id' => null,
                        'third_detail_id' => null,
                    ];

                    // Stage 1
                    if (!empty($row->get('stage1_start_date'))) {
                        $detail1 = \App\Models\VoteDetail::create([
                            'vote_id'        => $vote->id,
                            'start_date'     => $row->get('stage1_start_date'),
                            'end_date'       => $row->get('stage1_end_date'),
                            'yes_audience'   => $row->get('stage1_yes_audience') ?? 0,
                            'no_audience'    => $row->get('stage1_no_audience') ?? 0,
                            'vote_percentage' => $row->get('stage1_vote_percentage') ?? 0,
                        ]);
                        $detailIds['first_detail_id'] = $detail1->id;
                        $stageNumber = 1;
                    } else {
                        \DB::rollBack();
                        continue;
                    }

                    // Stage 2
                    if (!empty($row->get('stage2_start_date'))) {
                        $detail2 = \App\Models\VoteDetail::create([
                            'vote_id'        => $vote->id,
                            'start_date'     => $row->get('stage2_start_date'),
                            'end_date'       => $row->get('stage2_end_date'),
                            'yes_audience'   => $row->get('stage2_yes_audience') ?? 0,
                            'no_audience'    => $row->get('stage2_no_audience') ?? 0,
                            'vote_percentage' => $row->get('stage2_vote_percentage') ?? 0,
                        ]);
                        $detailIds['second_detail_id'] = $detail2->id;
                        $stageNumber = 2;
                    }

                    // Stage 3
                    if (!empty($row->get('stage3_start_date'))) {
                        $detail3 = \App\Models\VoteDetail::create([
                            'vote_id'        => $vote->id,
                            'start_date'     => $row->get('stage3_start_date'),
                            'end_date'       => $row->get('stage3_end_date'),
                            'yes_audience'   => $row->get('stage3_yes_audience') ?? 0,
                            'no_audience'    => $row->get('stage3_no_audience') ?? 0,
                            'vote_percentage' => $row->get('stage3_vote_percentage') ?? 0,
                        ]);
                        $detailIds['third_detail_id'] = $detail3->id;
                        $stageNumber = 3;
                    }

                    // Update vote
                    $vote->update([
                        'first_detail_id'  => $detailIds['first_detail_id'],
                        'second_detail_id' => $detailIds['second_detail_id'],
                        'third_detail_id'  => $detailIds['third_detail_id'],
                        'stage_number'     => $stageNumber,
                    ]);

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
                'message' => __('Votes imported successfully.')
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
}
