<?php

namespace App\Services\Admin;

use App\Exports\DynamicModelExport;
use App\Imports\PreviewUserImport;
use App\Imports\UserImport;
use App\Mail\UserPasswordMail;
use App\Models\Admin;
use App\Models\Association;
use App\Models\Unit;
use App\Models\User as ObjModel;
use App\Models\Vote;
use App\Models\VoteDetailHasUser;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\DataTables;

class UserService extends BaseService
{
    protected string $folder = 'admin/user';
    protected string $route = 'users';

    public function __construct(
        protected ObjModel $objModel,
        protected Mail $mail,
        protected Vote $voteModel,
        protected Association $associationModel,
        protected Unit $unit
    ) {
        parent::__construct($objModel);
    }

    public function index($request)
    {
        if ($request->ajax()) {
            $query = $this->model->query();

            // dd($request->vote_detail_id);
            // ===============================
            // 🔹 Filter by vote_id & vote_detail_id
            // ===============================
            // if ($request->filled("vote_id") && $request->filled("vote_detail_id")) {
            //     $vote = $this->voteModel->find($request->vote_id);

            //     if ($request->stage_id == 1) {
            //         // Stage 1: جميع المستخدمين في الجمعية
            //         $association = $vote->association;
            //         $users_ids = $association->users()->pluck("id");
            //         $query->whereIn("id", $users_ids);
            //     } else {
            //         // Stage 2 & 3
            //         $association = $vote->association;
            //         $allUsers = $association->users()->pluck("id"); // كل المستخدمين في الجمعية

            //         // المستخدمين الذين صوتوا في هذه المرحلة فقط
            //         $votedUsers = \App\Models\VoteDetailHasUser::where("vote_id", $request->vote_id)
            //             ->where("vote_detail_id", $request->vote_detail_id)
            //             ->pluck("user_id");

            //         // دمجهم: voted + unvoted
            //         $users_ids = $allUsers; // كل المستخدمين
            //         // بعدين سنستخدم left join لإظهار من صوت أو لم يصوت

            //         $query->whereIn("id", $users_ids);
            //     }
            // }



            if ($request->filled("vote_id") && $request->filled("vote_detail_id")) {
                $vote = $this->voteModel->find($request->vote_id);
                $association = $vote->association;

                // كل المستخدمين في الجمعية
                $allUsers = $association->users()->pluck("id")->toArray();

                if ($request->stage_id == 1) {
                    // Stage 1: كل المستخدمين
                    $query->whereIn("id", $allUsers);
                } elseif ($request->stage_id == 2) {
                    // Stage 2:
                    $stage1Voted = \App\Models\VoteDetailHasUser::where("vote_id", $request->vote_id)
                        ->where("stage_number", 1)
                        ->pluck("user_id")->toArray();

                    $stage2Voted = \App\Models\VoteDetailHasUser::where("vote_id", $request->vote_id)
                        ->where("stage_number", 2)
                        ->pluck("user_id")->toArray();

                    // unvoted in any stage = allUsers - voted in stage 1 & 2
                    $unvoted = array_diff($allUsers, array_merge($stage1Voted, $stage2Voted));

                    // Stage 2 users = voted in stage 2 + unvoted
                    $stage2Users = array_merge($stage2Voted, $unvoted);

                    $query->whereIn("id", $stage2Users);
                } elseif ($request->stage_id == 3) {
                    // Stage 3:
                    $stage1Voted = \App\Models\VoteDetailHasUser::where("vote_id", $request->vote_id)
                        ->where("stage_number", 1)
                        ->pluck("user_id")->toArray();

                    $stage2Voted = \App\Models\VoteDetailHasUser::where("vote_id", $request->vote_id)
                        ->where("stage_number", 2)
                        ->pluck("user_id")->toArray();

                    $stage3Voted = \App\Models\VoteDetailHasUser::where("vote_id", $request->vote_id)
                        ->where("stage_number", 3)
                        ->pluck("user_id")->toArray();

                    // unvoted = allUsers - voted stage 1 & 2 & 3
                    $unvoted = array_diff($allUsers, array_merge($stage1Voted, $stage2Voted, $stage3Voted));

                    // Stage 3 users = voted in stage 3 + unvoted
                    $stage3Users = array_merge($stage3Voted, $unvoted);

                    $query->whereIn("id", $stage3Users);
                }
            }





            // if ($request->filled("vote_id") && $request->filled("vote_detail_id") && $request->vote_detail_id == 1) {
            //     $users_ids = VoteDetailHasUser::where("vote_id", $request->vote_id)
            //         ->where("vote_detail_id", $request->vote_detail_id)
            //         ->pluck("user_id");

            //     $query->whereIn("id", $users_ids);
            // }



            // ===============================
            // 🔹 Search filters (optional)
            // ===============================
            if ($request->filled('keys') && $request->filled('values')) {
                $query = $this->search(
                    $query,
                    $request->get('keys'),
                    $request->get('values')
                );
            }

            $results = $query->get();

            return DataTables::of($results)
                ->addColumn('action', function ($obj) use ($request) {
                    $buttons = '';

                    if ($request->filled("vote_id") && $request->filled("vote_detail_id")) {
                        $vote = $this->voteModel->find($request->vote_id);

                        if ($vote && $request->stage_id == $vote->stage_number) {

                            $hasVoted = \App\Models\VoteDetailHasUser::where('user_id', $obj->id)
                                ->where('vote_id', $request->vote_id)
                                ->where('vote_detail_id', $request->vote_detail_id)
                                ->exists();

                            if (! $hasVoted) {
                                $buttons = '
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" 
                                                id="dropdownMenuButton' . $obj->id . '" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false" 
                                                style="background-color: transparent; border: none;">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu" 
                                            style="z-index: 99999; background-color: #EAEAEA;" 
                                            aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                            <li>
                                                <button class="dropdown-item make-vote-btn" 
                                                        data-user-id="' . $obj->id . '" 
                                                        data-vote-id="' . $request->vote_id . '" 
                                                        data-vote-detail-id="' . $request->vote_detail_id . '">
                                                    <i class="fa-solid fa-user-check me-1" title="User Vote"></i> 
                                                    ' . trns("make_vote")                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    . '
                                                </button>
                                            </li>

                                        </ul>
                                    </div>';
                            } else {
                                $buttons = '
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" 
                                                id="dropdownMenuButton' . $obj->id . '" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false" 
                                                style="background-color: transparent; border: none;">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu" 
                                            style="z-index: 99999; background-color: #EAEAEA;" 
                                            aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                            <li>
                                                <button class="dropdown-item make-vote-btn" 
                                                        data-user-id="' . $obj->id . '" 
                                                        data-vote-id="' . $request->vote_id . '" 
                                                        data-vote-detail-id="' . $request->vote_detail_id . '">
                                                    <i class="fa-solid fa-user-check me-1" title="User Vote"></i> 
                                                    ' . trns("edit_vote") . '
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item vote-images-btn" 
                                                        data-user-id="' . $obj->id . '" 
                                                        data-vote-id="' . $request->vote_id . '" 
                                                        data-vote-detail-id="' . $request->vote_detail_id . '">
                                                    <i class="fa-solid fa-user-check me-1" title="User Vote"></i> 
                                                    ' . trns("show_image") . '
                                                </button>
                                            </li>
                                        </ul>
                                    </div>';
                            }
                        }
                    } else {

                        $buttons = '<div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                <li>
                                    <a class="dropdown-item" href="' . route($this->route . '.show', $obj->id) . '">
                                        <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                    </a>
                                </li>';

                        if (auth('admin')->user()->can('update_user')) {
                            $buttons .= '
                                <li>
                                    <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                        <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                    </a>
                                </li>';
                        }

                        if (auth('admin')->user()->can('delete_user')) {
                            if (!$obj->has_relations) {
                                $buttons .= '
                            <li>
                                <a class="dropdown-item" style="color: red; cursor: pointer; margin-right: 5px;"
                                data-bs-toggle="modal"
                                data-bs-target="#delete_modal"
                                data-id="' . $obj->id . '"
                                data-title="' . $obj->name . '">
                                    <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                    ' . trns("delete") . '
                                </a>
                            </li>';
                            } else {
                                $buttons .= '
                            <li>
                                <a class="dropdown-item show-cant-delete-modal"
                                style="color: red; cursor: pointer; margin-right: 5px;"
                                data-bs-toggle="modal"
                                data-bs-target="#cantDeleteModal"
                                data-title="' . trns('You_cant_delete_this_user_because_it_has_relations_with_units') . '">
                                    <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                    ' . trns("delete") . '
                                </a>
                            </li>';
                            }
                        }

                        $buttons .= '
                                    <li>
                                        <a class="dropdown-item toggleStatusBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                            ' . ($obj->status == 1 ? trns("Deactivate_user") : trns("Activate_user")) . '
                                        </a>
                                    </li>
                                </ul>
                            </div>';
                    }
                    return $buttons;
                })
                ->editColumn('name', function ($obj) {
                    $nameParts = explode(' ', $obj->name);
                    return count($nameParts) > 6 ? $nameParts[0] . ' ' . $nameParts[1] . ' ' . $nameParts[2]  . " " . $nameParts[3]  . " " . $nameParts[4] . " " . $nameParts[5] . " " . $nameParts[6]   : $obj->name;
                })
                ->editColumn('email', fn($obj) => $obj->email)
                ->editColumn('phone', fn($obj) => $obj->phone ?? "-")
                ->editColumn('created_at', fn($obj) => $obj->created_at->format("Y-m-d"))
                ->editColumn('status', function ($obj) use ($request) {
                    if ($request->filled("vote_id") && $request->filled("vote_detail_id") && $request->filled("stage_id")) {

                        $voteRecord = \App\Models\VoteDetailHasUser::where('user_id', $obj->id)
                            ->where('vote_id', $request->vote_id)
                            ->where('vote_detail_id', $request->vote_detail_id)
                            ->first();

                        if ($voteRecord && $voteRecord->stage_number == $request->stage_id) {
                            $creator = $voteRecord->vote_creator == 'admin' ? 'Admin' : 'User';
                            $action = ucfirst($voteRecord->vote_action);

                            $badgeColor = $voteRecord->vote_action == 'yes' ? 'success' : 'danger';
                            return '<span class="badge bg-' . $badgeColor . '">' . $action . '</span>';
                        }

                        return '<span class="badge bg-primary">' . trns('Not Voted') . '</span>';
                    }


                    return $obj->status == 1
                        ? '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px;">' . trns("Active") . '</span>'
                        : '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px;">' . trns("Inactive") . '</span>';
                })
                ->editColumn('voted_by', function ($obj) use ($request) {
                    if ($request->filled("vote_id") && $request->filled("vote_detail_id") && $request->filled("stage_id")) {
                        $voteRecord = \App\Models\VoteDetailHasUser::where('user_id', $obj->id)
                            ->where('vote_id', $request->vote_id)
                            ->where('vote_detail_id', $request->vote_detail_id)
                            ->with(['admin:id,name', 'user:id,name'])
                            ->first();

                        if (!$voteRecord) {
                            return trns('-');
                        }

                        if ($voteRecord->vote_creator === "admin") {
                            return $voteRecord->admin?->name ?? trns('-');
                        } else {
                            return $voteRecord->user?->name ?? trns('-');
                        }
                    }

                    return trns('-');
                })

                ->rawColumns(['status'])

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


    public function show($model)
    {
        return view('admin.user.parts.show', [
            "obj" => $model
        ]);
    }

    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
        ]);
    }

    public function singlePageCreate()
    {
        return view("{$this->folder}/parts/singlePageCreate", [
            'storeRoute' => route("{$this->route}.store"),
        ]);
    }

    public function store($data)
    {
        $data['phone'] = '+966' . $data['phone'];

        try {
            $user = $this->createData($data);

            // Send email
            // try {
            //     Mail::to($user->email)->send(new UserPasswordMail($user));
            // } catch (\Exception $e) {
            //     // Log the error or handle it as needed
            //     Log::error('Failed to send email: ' . $e->getMessage());
            // }

            $response = [
                'status' => 200,
                'message' => 'created successfully'
            ];

            if (array_key_exists('singlePageCreate', $data)) {
                $response['redirect_to'] =
                    ($data['submit_type'] ?? null) === 'create_and_redirect'
                    ? route('users.index')
                    : route('users.singlePageCreate');
            }

            return response()->json($response);
        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => $e->getMessage()
            ];

            if (array_key_exists('singlePageCreate', $data)) {
                $response['redirect_to'] = route('users.singlePageCreate');
            }

            return response()->json($response);
        }
    }


    public function getAssociationUsers($id)
    {
        try {
            $association = $this->associationModel->find($id);

            if (!$association) {
                return response()->json([
                    'status' => 404,
                    'users' => []
                ]);
            }

            $users = $association->users()->get(); // get() مهم هنا لأنه مش علاقة Eloquent أصلية

            return response()->json([
                'status' => 200,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'users' => [],
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getUserById($id)
    {
        try {
            $user = $this->model->find($id);

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'user' => null
                ]);
            }



            return response()->json([
                'status' => 200,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'user' => null,
                'message' => $e->getMessage()
            ]);
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

        if (empty($data['password'])) {
            $data['password'] = $oldObj->password;
        } else {
            $data['password'] = bcrypt($data['password']);
        }


        try {
            $data['phone'] = '+966' . $data['phone'];

            $oldObj->update($data);
            return response()->json(['status' => 200, 'message' => trns('Data updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.', $e->getMessage()), trns('error') => $e->getMessage()]);
        }
    }


    public function showGenerateForm($request, $id)
    {

        return view("{$this->folder}/parts/password", [
            'storePassRoute' => route("password.store"),
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

    public function addExcel()
    {
        return view("{$this->folder}/parts/addExcel", [
            'storeExcelRoute' => route("{$this->route}.store.excel"),
        ]);
    }


    public function storeExcel($request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);



        try {
            $file = $request->file('excel_file');

            $reader = new PreviewUserImport();
            Excel::import($reader, $file);
            $rows = $reader->rows;

            $errors = [];

            foreach ($rows as $index => $row) {
                // Validate each row
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'national_id' => 'required|max:10', // delete
                    'phone' => 'required|max:9',
                    'status' => 'in:1,0'
                ];
                $validator = Validator::make($row->toArray(), $rules);

                if ($validator->fails()) {
                    $errors[] = [
                        'row' => $index + 1,
                        'errors' => $validator->errors()->all()
                    ];
                }
            }

            if (!empty($errors)) {
                return response()->json([
                    'status' => 422,
                    'message' => $errors
                ], 422);
            }

            Excel::import(new UserImport, $file);

            return response()->json([
                'status' => 200,
                'message' => 'تم الاستيراد بنجاح.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'حدث خطأ أثناء الاستيراد.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function exportExcel()
    {
        $export = new DynamicModelExport(\App\Models\User::class);
        $fileName = 'users_export_' . date('Y-m-d') . '.xlsx';
        return Excel::download($export, $fileName);
    }

    public function getUnits($id)
    {
        $user = $this->objModel->find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'status' => 404,
            ]);
        }

        // جلب كل unit_ids الخاصة بالمستخدم
        $units_ids = $user->unitOwners()->pluck("unit_id"); // هترجع Collection من IDs

        // جلب كل الوحدات باستخدام whereIn مباشرة على الـ Collection
        $units = $this->unit->whereIn('id', $units_ids)->get();

        return response()->json([
            'units' => $units,
            'status' => 200,
        ]);
    }
}
