<?php

namespace App\Services\Admin;

use App\Mail\AdminPasswordMail;

use App\Models\Admin as ObjModel;
use App\Models\Association;
use Spatie\Activitylog\Models\Activity as ActivityObj;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as RoleObj;
use Yajra\DataTables\DataTables;

class AdminService extends BaseService
{
    protected string $folder = 'admin/admin';
    protected string $route = 'admins';
    protected ActivityObj $activityObj;
    protected RoleObj $roleObj;
    protected ObjModel $objModel;



    public function __construct(
        ObjModel $model,
        ActivityObj $activityObj,
        RoleObj $roleObj,
        ObjModel $objModel,
        protected Association $associationModel
    ) {
        $this->objModel = $objModel;
        $this->activityObj = $activityObj;
        $this->roleObj = $roleObj;
        parent::__construct($model);
    }

    public function index($request)
    {

        if ($request->ajax()) {

            $query = $this->model->query();
            $query->where("id", "!=", auth("admin")->user()->id);

            if ($request->filled('keys') && $request->filled('values')) {
                $query = $this->search(
                    $query,
                    $request->get('keys'),
                    $request->get('values')
                );
            }

            $results = $query->get();

            return DataTables::of($results)
                ->addColumn('action', function ($obj) {
                    $buttons = '
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                    <li>
                                        <a class="dropdown-item" href="' . route($this->route . '.show', $obj->id) . '">
                                            <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                        </a>
                                    </li>';

                    if (auth("admin")->user()->can('update_admin')) {
                        $buttons .= '
                                        <li>
                                            <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                                <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;">' . trns("Edit") . '
                                            </a>
                                        </li>';
                    };

                    if (auth("admin")->user()->can('delete_admin')) {
                        if (!$obj->has_relations) {
                            $buttons .= '
                            <li>
                                <a class="dropdown-item" style="color: red; cursor: pointer; margin-right: 5px;"
                                data-bs-toggle="modal"
                                data-bs-target="#delete_modal"
                                data-id="' . $obj->id . '"
                                data-title="' . $obj->name . '">
                                    <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                    ' . trns(key: "delete") . '
                                </a>
                            </li>
                        ';
                        } else {
                            $buttons .= '
                          <li>
                                <a class="dropdown-item show-cant-delete-modal"
                                style="color: red; cursor: pointer; margin-right: 5px;"
                                data-bs-toggle="modal"
                                data-bs-target="#cantDeleteModal"
                                data-title="' . trns('You_cant_delete_this_admin_because_it_has_relations_with_associations') . '">
                                    <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                                                ' . trns(key: "delete") . '
                                </a>
                            </li>

                        ';
                        }
                    }


                    $buttons .= '
                                    <li>
                                        <button class="dropdown-item toggleStatusBtn" id="toggleStatusBtn" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                            ' . ($obj->status == 1 ? trns("Deactivate_admin") : trns("Activate_admin")) . '
                                        </button>
                                    </li>
                                </ul>
                            </div>';

                    return $buttons;
                })->editColumn("national_id", function ($admins) {
                    return $admins->national_id;
                })
                ->addColumn("role", function ($obj) {
                    return $obj->getRoleNames()->first();
                })->editColumn('name', function ($obj) {
                    $nameParts = explode(' ', $obj->name);
                    $firstName = $nameParts[0];
                    return $firstName;
                })
                ->editColumn('status', function ($obj) {
                    if ($obj->status == 1) {
                        return '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px;">' . trns("Active") . '</span>';
                    } else {
                        return '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px;">' . trns("Inactive") . '</span>';
                    }
                })

                ->editColumn("created_at", function ($admins) {
                    return $admins->created_at->format("Y-m-d");
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {

            return view($this->folder . '/index', [
                "route" => $this->route
            ]);
        }
    }


    public function myProfile()
    {
        $admin = auth()->guard('admin')->user();
        $activities = $this->activityObj->where('causer_id', Auth::user()->id)->get();

        return view(
            $this->folder . '/profile',
            [
                'admin' => $admin,
                'createRoute' => route($this->route . '.create'),
                'bladeName' => trns($this->route),
                'route' => 'admins',
                'updateRoute' => 'myProfile',
                'activities' => $activities,
            ]
        );
    }



    public function show($model)
    {
        return view('admin.admin.parts.show', [
            "obj" => $model
        ]);
    }


    public function create()
    {
        $code = $this->generateCode();
        $roles = $this->roleObj->get();
        return view($this->folder . '/parts/create', [
            'code' => $code,
            'storeRoute' => route($this->route . '.store'),
            'roles' => $roles
        ]);
    }

    public function singlePageCreate()
    {
        $code = $this->generateCode();
        $roles = $this->roleObj->get();
        return view($this->folder . '/parts/singlePageCreate', [
            'code' => $code,
            'storeRoute' => route($this->route . '.store'),
            'roles' => $roles
        ]);
    }


    public function store($data)
    {



        $role = $this->roleObj->find($data['role_id'])->first();

        if (!$role) {
            return response()->json(['status' => 404, 'message' => 'Role not found']);
        }

        if (isset($data['image'])) {
            $data['image'] = $this->handleFile($data['image'], 'admin');
        }

        unset($data['role_id']);

        $data['phone'] = '966' . $data['phone'];
        $data['status'] = 1;

        $model = $this->createData($data);
        $admin = $this->model->where('code', $data['code'])->first();
        $admin->assignRole([$role->name]);
        try {
            Mail::to($model->email)->send(new AdminPasswordMail($model));
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
        }

        if ($model) {
            try {
                if (array_key_exists('singlePageCreate', $data)) {
                    if ($data['submit_type'] == 'create_and_redirect') {

                        return response()->json([
                            'status' => 200,
                            'redirect_to' => route('admins.index'),
                            'message' => 'created successfully'
                        ]);
                    } elseif ($data['submit_type'] == 'create_and_stay') {
                        return response()->json([
                            'status' => 200,
                            'redirect_to' => route('admins.singlePageCreate'),
                            'message' => 'created successfully'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'created successfully'
                    ]);
                }
            } catch (\Exception $e) {
                if (array_key_exists("singlePageCreate", $data)) {
                    return response()->json([
                        'status' => 200,
                        'redirect_to' => route('admins.singlePageCreate'),
                        'message' => 'created successfully'
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        // 'redirect_to' => route('admins.index'),
                        'message' => 'created field'
                    ]);
                }
            }
        }
    }

    public function getAssociationAdmin($id){
        $association = $this->associationModel->find($id);

        if(!$association || !$association->association_manager_id){
            return response()->json(['status' => 404, 'message' => 'Association or Admin not found']);
        }

        $admin = $association->admin;

        if(!$admin){
            return response()->json(['status' => 404, 'message' => 'Admin not found']);
        }
        return response()->json(['status' => 200, 'admin' => $admin]);
    }


    public function edit($admin)
    {
        $roles = $this->roleObj->get();
        return view($this->folder . '/parts/edit', [
            'admin' => $admin,
            'updateRoute' => route($this->route . '.update', $admin->id),
            'roles' => $roles

        ]);
    }


    public function update($data, $id)
    {


        $role = $this->roleObj->find($data['role_id']);
        if (!$role) {
            return response()->json(['status' => 404, 'message' => 'Role not found']);
        }

        unset($data['role_id']);
        $admin = $this->getById($id);
        $model = $this->updateData($id, $data);
        $admin->syncRoles([$role->name]);
        if ($model) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }


    public function updateProfile($data)
    {
        if (isset($data['image'])) {
            $oldObj = $this->getById(Auth::user()->id);

            if ($oldObj->image) {
                $this->deleteFile($oldObj->image);
            }
            $data['image'] = $this->handleFile($data['image'], 'admin');
        }


        if ($data['password'] && $data['password'] != null) {

            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }


        if ($this->updateData(Auth::user()->id, $data)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }


    public function updateProfileImage($data)
    {
        $oldObj = $this->getById(Auth::user()->id);
        if (isset($data['image'])) {
            $data['image'] = $this->handleFile($data['image'], 'admin');
        }
        if ($oldObj->image) {
            $this->deleteFile($oldObj->image);
        }

        if ($this->updateData(Auth::user()->id, $data)) {
            return response()->json(['status' => 200, 'redirect' => route('myProfile')]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

    protected function generateCode(): string
    {
        do {
            $code = Str::random(11);
        } while ($this->firstWhere(['code' => $code]));

        return $code;
    }

    // passswor d assign
    public function showGenerateForm($request, $id)
    {

        return view("{$this->folder}/parts/password", [
            'storePassRoute' => route("admin.password.store"),
            'id' => $id
        ]);
    }

    public function passwordStore($request, $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->password = Hash::make($request->password);
        $user->status = 1;
        $user->save();

        auth()->login($user);

        return redirect()->route('adminHome');
    }
}
