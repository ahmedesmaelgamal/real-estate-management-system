<?php

namespace App\Services\Admin;

use App\Models\ContractName as ObjModel;
use App\Models\ContractType;
use App\Services\BaseService;
use Yajra\DataTables\DataTables;

class ContractNamesService extends BaseService
{
    protected string $folder = 'admin/contract_names';
    protected string $route = 'names';

    public function __construct(ObjModel $objModel , protected ContractType $contractType)
    {
        parent::__construct($objModel);
    }

    public function index($request)
    {
        if ($request->ajax()) {
            $obj = $this->getDataTable();

            return DataTables::of($obj)
                ->addColumn('name', function ($obj) {
                    return $obj->getTranslation('name', app()->getLocale());
                })
                ->editColumn("contract_type_id" , function ($obj){
                    return $obj->contractType->getTranslation("title" , app()->getLocale());
                })
                ->addColumn('action', function ($obj) {
                    $canDelete = !$obj->contracts()->exists() ; 

                    $buttons = '
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                    <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                </a>
                            </li>
                    ';

                    if ($canDelete) {
                        $buttons .= '
                            <li>
                                <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete_modal" data-id="' . $obj->id . '" data-title="' . $obj->getTranslation('name', app()->getLocale()) . '">
                                    <i class="fas fa-trash"></i> ' . trns("delete") . '
                                </button>
                            </li>
                        ';
                    } else {
                        $buttons .= '
                            <li>
                                <button class="dropdown-item text-danger cantDeleteButton" data-bs-toggle="modal"
                                    data-bs-target="#cantDeleteModal">
                                    <i class="fas fa-trash"></i> ' . trns("delete") . '
                                </button>
                            </li>
                        ';
                    }

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
        $contractTypes = $this->contractType->get();
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            "contractTypes" => $contractTypes
        ]);
    }

    public function store($data): \Illuminate\Http\JsonResponse
    {
        try {
            $this->createData($data);
            return response()->json(['status' => 200, 'message' => trns('Data created successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage()]);
        }
    }

    public function edit($obj)
    {
        $contractTypes = $this->contractType->get();
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
            "contractTypes" => $contractTypes
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
