<?php

namespace App\Services\Admin;

use App\Models\AssociationModel as ObjModel;
use App\Services\BaseService;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AssociationModelService extends BaseService
{
    protected string $folder = 'admin/association_model';
    protected string $route = 'association_models';

    public function __construct(ObjModel $objModel)
    {
        parent::__construct($objModel);
    }

    public function index($request)
    {
        if ($request->ajax()) {
            $obj = $this->getDataTable();
            return DataTables::of($obj)
                ->addColumn('title', function ($obj) {
                    return $obj->title;
                })
                ->addColumn('description', function ($obj) {
                    return $obj->description;
                })
                ->addColumn('status', function ($obj) {
                    return $obj->status ? '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns('Active') . '</span>' : '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns('Inactive') . '</span>';
                })
                ->addColumn('action', function ($obj) {
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
                            <li>
                                <a class="dropdown-item toggleAssociationModelBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                    ' . ($obj->status == 1 ? trns('deactivate_association_model') : trns('activate_association_model')) . '
                                </a>
                            </li>
                        </ul>
                    </div>';
                    return $buttons;
                })->editColumn('description', function ($obj) {
                    return '<span class="btn btn-sm body-span-msg" data-body="' . $obj->description . '">' . Str::limit($obj->description, limit: 20) . '</span>';
                })

                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/index', [
                'createRoute' => route($this->route . '.create'),
                'bladeName' => trns($this->route),
                'route' => $this->route,
            ]);
        }
    }

    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
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
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
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
