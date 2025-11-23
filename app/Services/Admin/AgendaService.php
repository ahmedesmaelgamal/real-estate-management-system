<?php

namespace App\Services\Admin;

use App\Models\Agenda as ObjModel;
use App\Models\MeetHasAgenda;
use App\Models\Meeting;
use App\Models\User;
use App\Services\BaseService;
use Yajra\DataTables\DataTables;

class AgendaService extends BaseService
{
    protected string $folder = 'admin/Meeting_agenda';
    protected string $route = 'agenda';

    public function __construct(protected ObjModel $objModel, protected Meeting $meeting, protected User $users)
    {
        parent::__construct($objModel);
    }

    public function index($request)
    {
        if ($request->ajax()) {

            if ($request->has('meeting_id')) {
                $meeting = $this->meeting->with('agendas')->find($request->meeting_id);


                $obj = $meeting ? $meeting->agendas : collect();
            } else {
                $obj = $this->getDataTable();
            }

            return DataTables::of($obj)
                ->addColumn('name', function ($obj) {
                    return $obj->getTranslation('name', app()->getLocale());
                })
                ->editColumn("description", function ($obj) {
                    return $this->subStrText($obj->description) ?? "-";
                })
                ->editColumn("date", function ($obj) {
                    return $obj->date ? $obj->date : "-";
                })

                ->addColumn('action', function ($obj) use ($request) {
                    $deleteCheck = $obj->meetings()->exists();

                    $buttons = '
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                <a class="dropdown-item editBtn editAgendaButton" href="javascript:void(0);" data-id="' . $obj->id . '">
                                    <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                </a>
                            </li>
                    ';

                    // if($request->has("meeting_id") ){

                    // }else{
                    // if (!$deleteCheck) {
                    $buttons .= '
                        <li>
                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                data-bs-target="#delete_modal_of_agenda" 
                                data-id="' . $obj->id . '" 
                                data-title="' . $obj->getTranslation('name', app()->getLocale()) . '">
                                <i class="fas fa-trash"></i> ' . trns("delete") . '
                            </button>
                        </li>
                    ';

                    // }else{
                    //     $buttons .= '
                    //         <li>
                    //             <button class="dropdown-item text-danger cantDeleteButton" data-bs-toggle="modal"
                    //                 data-bs-target="#cantDeleteModal" data-title="' . $obj->getTranslation('name', app()->getLocale()) . '">
                    //                 <i class="fas fa-trash"></i> ' . trns("delete") . '
                    //             </button>
                    //         </li>
                    //     ';
                    // }
                    // }

                    $buttons .= '
                        </ul>
                    </div>
                    ';

                    return $buttons;
                })

                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        }

        return view($this->folder . '/index', [
            'createRoute' => route($this->route . '.create'),
            'bladeName' => trns($this->route),
            'route' => $this->route,
        ]);
    }

    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            "users"  => $this->users->where("status", 1)->get()
        ]);
    }

    public function store($data): \Illuminate\Http\JsonResponse
    {
        try {
            // Set status
            $data['status'] = 1;

            // add session_id
            $data['session_id'] = session()->getId();

            // Create agenda
            $agenda = $this->createData($data);

            // Attach agenda to meeting if meet_id exists
            if (!empty($data['meet_id'])) {
                MeetHasAgenda::create([
                    'meeting_id' => $data['meet_id'],
                    'agenda_id'  => $agenda->id,
                ]);
            }

            return response()->json([
                'status' => 200,
                'agenda' => [
                    'id' => $agenda->id,
                    'name' => $agenda->getTranslation('name', app()->getLocale()),
                    'description' => $agenda->getTranslation('description', app()->getLocale()),
                ],
                'message' => trns('Data created successfully.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => trns('Something went wrong.'),
                'error' => $e->getMessage()
            ]);
        }
    }



    public function getData()
    {
        $agendas = $this->objModel->get()->map(function ($agenda) {
            return [
                'id' => $agenda->id,
                'name' => $agenda->getTranslation('name', app()->getLocale()),
                'description' => $agenda->getTranslation('description', app()->getLocale()),
                'date' => $agenda->date,
            ];
        });

        return response()->json(['status' => 200, 'agendas' => $agendas]);
    }


    public function edit($obj)
    {
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
            "users"  => $this->users->where("status", 1)->get()
        ]);
    }





    public function update($data, $id)
    {
        $oldObj = $this->getById($id);

        try {
            $data["status"] = 1;
            $oldObj->update($data);
            return response()->json(['status' => 200, 'message' => trns('Data updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage()]);
        }
    }
}
