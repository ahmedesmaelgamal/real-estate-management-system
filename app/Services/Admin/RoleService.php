<?php

namespace App\Services\Admin;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission as PermissionObj;
use Spatie\Permission\Models\Role as RoleObj;
use Yajra\DataTables\DataTables;

class RoleService extends BaseService
{
    protected string $folder = 'admin/role';
    protected string $route = 'roles';
    protected RoleObj $roleObj;
    protected PermissionObj $permissionObj;

    public function __construct(PermissionObj $permissionObj,RoleObj $roleObj)
    {
        $this->roleObj=$roleObj;
        $this->permissionObj=$permissionObj;
        parent::__construct($roleObj);
    }

    public function index($request)
    {
        if ($request->ajax()) {
            $models = $this->model->get();
            return DataTables::of($models)
                ->addColumn('action', function ($models) {

                    $buttons = '
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $models->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $models->id . '">
                            <li>
                                <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="' . $models->id . '">
                                    <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                </a>
                            </li>
                            <li>
                                 <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                                    data-bs-target="#delete_modal" data-id="' . $models->id . '" data-title="' . $models->title . '">
                                                    <i class="fas fa-trash"></i> '.trns("delete").'
                                                </button>
                            </li>
                        </ul>
                    </div>';
//                    if(auth("admin")->check() && auth("admin")->user()->can("update_role") && $models->id != 1){
//                        $buttons .= '
//                                <button type="button" data-id="' . $models->id . '" class="btn btn-pill btn-info-light editBtn">
//                                    <i class="fa fa-edit"></i>
//                                </button>
//
//                        ';
//                    };
//                    if(auth("admin")->check() && auth("admin")->user()->can("delete_role") && $models->id != 1){
//                        $buttons .= '
//                                <button class="btn btn-pill btn-danger-light" data-bs-toggle="modal"
//                                    data-bs-target="#delete_modal" data-id="' . $models->id . '" data-title="' . $models->name . '">
//                                    <i class="fas fa-trash"></i>
//                                </button>
//
//                        ';
//                    };

                        return $buttons;
                })
                ->addColumn('name',function($model){
                    return $model->name;
                })
                ->addColumn('permissions', function ($models) {
                    return $models->permissions->count() > 0 ? '<span class="badge badge-success">' .
                       $models->permissions->count() .' '. trns('permissions')
                        . '</span>' :
                        'No Permissions';
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/index', [
                'route' => $this->route
            ]);
        }
    }

    public function create()
    {
        $permissions = $this->permissionObj->get();
        $roles = $this->roleObj->get();
        return view($this->folder . '/parts/create', [
            'permissions' => $permissions,
            'storeRoute' => route($this->route . '.store'),
            'roles'=>$roles
        ]);
    }


    public function store($data): JsonResponse
    {
        $model = $this->createData($data);

        if ($model) {
            $permissions = $this->permissionObj->query()
                ->whereIn('name', $data['permissions'])
                ->where('guard_name', $data['guard_name'])
                ->get();
            $model->syncPermissions($permissions);

            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }


    public function edit($role)
    {
        return view($this->folder . '/parts/edit', [
            'obj' => $role,
            'old_permissions' => $role->permissions()->pluck('name')->toArray(),
            'updateRoute' => route($this->route . '.update', $role->id),
        ]);
    }

    public function update($id, $data)
    {
        $model = $this->getById($id);

        if ($this->updateData($id, $data)) {
            $permissions = $this->permissionObj->query()->whereIn('name', $data['permissions'])->get();
            $model->syncPermissions($permissions);
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }
}
