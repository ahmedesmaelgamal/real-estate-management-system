<?php

namespace App\Services\Admin;

use App\Models\CaseUpdateType;
use App\Models\User;
use App\Services\BaseService;
use Yajra\DataTables\DataTables;

class CaseUpdateTypeService extends BaseService
{
    protected string $folder = 'admin/case_update_type';
    protected string $route = 'case_update_type';

    public function __construct(protected CaseUpdateType $objModel, protected User $users)
    {
        parent::__construct($objModel);
    }

    public function index($request)
    {


        if ($request->ajax()) {


            $case = 0;
            // if ($request->has('case_id')) {
            //     $case = $this->case->with('topics')->find($request->case_id);
            //     $obj = $case ? $case->topics : collect(); 
            // } else {
            //     $obj = $this->getDataTable(); 
            // }

            $obj = $this->getDataTable();

            return DataTables::of($obj)
                ->addColumn('title', function ($obj) {
                    return $obj->getTranslation('title', app()->getLocale());
                })
                ->editColumn("status" , function($obj){
                    return $this->statusDatatable($obj);
                })
                ->addColumn('action', function ($obj) use ($case) { // ✅ أضفنا use هنا
                    // $deleteCheck = $obj->cases()->exists(); // returns true if it has cases
                    $deleteCheck = 0;

                    $buttons = '
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                <li>
                                    <a class="dropdown-item editBtn editTopicBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                        <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                    </a>
                                </li>
                        ';

                    // ✅ شرط الزرار Delete
                    if (!$case) {
                        if (!$deleteCheck) {
                            $buttons .= '
                    <li>
                             <button class="dropdown-item text-danger topicDeleteBtn" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal" data-id="' . $obj->id . '" data-title="' . $obj->getTranslation('title', app()->getLocale()) . '">
                                                <i class="fas fa-trash"></i> ' . trns("delete") . '
                                            </button>
                        </li>';
                        } else {
                            $buttons .= '
                    <li>
                        <button class="dropdown-item text-danger cantDeleteButton" data-bs-toggle="modal"
                            data-bs-target="#cantDeleteModal" data-title="' . $obj->getTranslation('title', app()->getLocale()) . '">
                            <i class="fas fa-trash"></i> ' . trns("delete") . '
                        </button>
                    </li>';
                        }
                    }

                    $buttons .= '</ul></div>';

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
            "users" => $this->users->get(),
        ]);
    }

    public function store($data): \Illuminate\Http\JsonResponse
    {
        try {
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
            "users" => $this->users->get(),
        ]);
    }

    
    public function update($data, $id)
    {

        $oldObj = $this->getById($id);

        try {
            $oldObj->update($data);
            return response()->json(['status' => 200, 'message' => trns('Data updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage()]);
        }
    }
}
