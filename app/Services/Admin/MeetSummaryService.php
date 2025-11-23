<?php

namespace App\Services\Admin;

use App\Models\Meeting;
use App\Models\MeetSummary as ObjModel;
use App\Models\User;
use App\Services\BaseService;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class MeetSummaryService extends BaseService
{
    protected string $folder = 'admin/meetSummary';
    protected string $route = 'meetSummary';

    public function __construct(protected ObjModel $objModel, protected User $users, protected Meeting $meeting)
    {
        parent::__construct($objModel);
    }

    public function index($request)
    {
        if ($request->ajax()) {
            if ($request->has('meeting_id')) {
                $meeting = $this->meeting->with('meetSummary.owner')->find($request->meeting_id);
                $obj = $meeting ? $meeting->meetSummary()->with('owner')->get() : collect();
            } else {
                $obj = $this->getDataTable();
            }

            return DataTables::of($obj)
                ->addColumn('title', function ($obj) {
                    return $obj->getTranslation('title', app()->getLocale());
                })
                ->editColumn("description", function ($obj) {
                    return $obj->description;
                })
                ->editColumn("owner_id", function ($obj) {
                    return $obj->owner ? $obj->owner->name : '';
                })
                ->addColumn('action', function ($obj) {
                    // Check if the topic has any meetings
                    $deleteCheck = $obj->meeting()->exists(); // returns true if it has meetings

                    $buttons = '
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                <a class="dropdown-item editSummaryButton editBtn " href="javascript:void(0);" data-id="' . $obj->id . '">
                                    <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                </a>
                            </li>
                    ';

                    // Only show delete if there are NO meetings
                    $buttons .= '
                            <li>
                                <button class="dropdown-item text-danger deleteBtn"
                                    data-id="' . $obj->id . '"
                                    data-title="' . e($obj->getTranslation('title', app()->getLocale())) . '"
                                    data-bs-toggle="modal"
                                    data-bs-target="#delete_modal">
                                    <i class="fas fa-trash"></i> ' . trns("delete") . '
                                </button>
                            </li>
                        ';



                    $buttons .= '
                        </ul>
                    </div>
                    ';

                    return $buttons;
                })
                ->editColumn("created_at", function ($obj) {
                    return $obj->created_at->format("Y-m-d");
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
            "users" => $this->users->where("status", 1)->get(),
        ]);
    }

    public function store($data): \Illuminate\Http\JsonResponse
    {
        try {
            $data['status'] = 1;
         
            $this->createData($data);
            return response()->json([
                'status'  => 200,
                'message' => trns('Data created successfully.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'message' => trns('Something went wrong.'),
                'error'   => $e->getMessage()
            ]);
        }
    }



    public function edit($obj)
    {
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
            "users" => $this->users->where("status", 1)->get(),
        ]);
    }

    public function update($data, $id)
    {
        $oldObj = $this->getById($id);

        $data["user_id"] = $data["owner_id"];
        try {
            $data["status"] = 1;
            $oldObj->update($data);
            return response()->json(['status' => 200, 'message' => trns('Data updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage()]);
        }
    }
}
