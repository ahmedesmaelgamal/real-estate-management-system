<?php

namespace App\Services\Admin;

use App\Exports\DynamicModelExport;
use App\Imports\ElectricOrWaterOfUnitImport;
use App\Imports\PreviewElectricOrWaterimport;
use App\Imports\PreviewElectricOrWaterOfUnitimport;
use App\Imports\UnitImport;
use App\Models\Admin;
use App\Models\Association;
use App\Models\RealState;
use App\Models\Unit as ObjModel;
use App\Models\UnitElectric;
use App\Models\UnitOwner;
use App\Models\UnitWater;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Yajra\DataTables\DataTables;

class UnitService extends BaseService
{
    protected string $folder = 'admin/unit';
    protected string $route = 'units';

    public function __construct(
        protected ObjModel $objModel,
        protected RealStateService $realStateService,
        protected UserService $userService,
        protected UnitOwnerService $unitOwnerService,
        protected Association $association,
        protected RealState $realState,
        protected User $user,
        protected UnitOwner $unitOwner,
        protected Media $media,
        protected Admin $admin,
        protected UnitElectric $unitElectric,
        protected UnitWater $unitWater
    ) {
        parent::__construct($objModel);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->input('search');
            $searchSelect = $request->input('search_select');
            $units = $this->model->query()
                ->select('*')
                ->with(['unitOwners.user', 'RealState', 'RealState.association'])
                ->when($search && $searchSelect, function ($query) use ($search, $searchSelect) {
                    $query->where(function ($q) use ($search, $searchSelect) {
                        switch ($searchSelect) {
                            case 'unit_code':
                                $q->where('unit_code', 'LIKE', "%{$search}%");
                                break;

                            case 'owners_name':
                                $q->whereHas('unitOwners.user', function ($q) use ($search) {
                                    $q->where('name', 'LIKE', "%{$search}%");
                                });
                                break;

                            case 'RealStates_number':
                                $q->whereHas('RealState', function ($q) use ($search) {
                                    $q->where('number', 'LIKE', "%{$search}%");
                                });
                                break;

                            case 'unit_number':
                                $q->where('unit_number', 'LIKE', "%{$search}%");
                                break;

                            case 'floor_count':
                                $q->where('floor_count', 'LIKE', "%{$search}%");
                                break;

                            case 'assocation_name':
                                $q->whereHas('RealState.association', function ($q) use ($search) {
                                    $q->where('name', 'LIKE', "%{$search}%");
                                });
                                break;
                        }
                    });
                });

            // if user_id exist delete all prev filters and get the units owned to user
            if ($request->filled("user_id")) {
                // نحصل على IDs للوحدات المملوكة للمستخدم
                $unitIds = UnitOwner::where("user_id", $request->user_id)
                    ->pluck("unit_id")
                    ->toArray();

                // نحذف الفلاتر السابقة ونبدأ فلترة جديدة
                $units = $this->model->query()
                    ->select('*')
                    ->with(['unitOwners.user', 'RealState', 'RealState.association'])
                    ->whereIn("id", $unitIds);
            }


            return DataTables::of($units)

                ->addColumn('action', function ($obj) {
                    $buttons = '<div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="' . route($this->route . '.show', $obj->id) . '">
                                                <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                                    </a>
                                        </li>

                                ';

                    // if (auth("admin")->check() && auth("admin")->user()->can("update_unit")) {
                        $buttons .= '
                                                <li>
                                                        <a class="dropdown-item editBtn unit_show_edit EditUnitBTN"     data-title="' . trns('Edit_Unit') . '"  data-id="' . $obj->id . '">
                                                            <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                                        </a>
                                                    </li>
                                        <li>
        <a class="dropdown-item deleteunitBtn" style="color: red; cursor: pointer;   margin-right: 5px;"
        data-bs-toggle="modal"
        data-bs-target="#delete_modal"
        data-id="' . $obj->id . '"
        data-title="' . $obj->name . '">
    <i class="fas fa-trash" style="margin-left: 5px;"></i>
    ' . trns("delete") . '    </a>
    </li>

                                        ';
                    // };
                    $buttons .= '
                                        <li>
                                            <button class="dropdown-item openStatusModel toggleUnitStatus" id="toggleStatusBtn" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                                 ' . ($obj->status == 1 ? trns("deactivate_unit") : trns("activate_unit")) . '
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            ';
                    return $buttons;
                })
                ->addColumn('real_state_number', function ($obj) {
                    return $obj->RealState->real_state_number ?? 'N/A';
                })


                ->addColumn("assocation_name", function ($obj) {
                    return @$obj->association->name;
                })
                ->editColumn('status', function ($obj) {
                    if ($obj->status == 1) {
                        return '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns("Active") . '</span>';
                    } else {
                        return '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns("Inactive") . '</span>';
                    }
                })
                ->addColumn('user_id', function ($obj) {
                    $owners = $obj->unitOwners->map(function ($owner) {
                        return [
                            'name' => $owner->user->name ?? 'N/A',
                            'percentage' => $owner->percentage
                        ];
                    })->toArray();

                    return '
                        <button type="button"
                        class="show-owners-btn"
                        style= "border: 1px solid #06e7c1; border-radius: 50px; background-color: transparent;"
                                data-id="' . $obj->id . '"
                                data-owners="' . htmlspecialchars(json_encode($owners), ENT_QUOTES, 'UTF-8') . '"
                                data-bs-toggle="modal"
                                data-bs-target="#show_owners">
                            ' . trns('view_owners') . '
                        </button>
                    ';
                })
                ->addColumn('floor_count', function ($obj) {
                    return $obj->floor_count ?? 'N/A';
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/index', [
                'createRoute' => route($this->route . '.create'),
                'bladeName' => trns($this->route),
                'realStates' => $this->realStateService->getAll(),
                'route' => $this->route,
                'allUnites' => $this->objModel->count(),
                'activeUnites' => $this->objModel->where('status', 1)->count(),
                'inactiveUnites' => $this->objModel->where('status', 0)->count(),
            ]);
        }
    }





    public function addExcel()
    {
        return view("{$this->folder}/parts/addExcel", [
            'storeExcelRoute' => route("{$this->route}.store.excel"),
        ]);
    }
    public function stopReason($request): \Illuminate\Http\JsonResponse
    {
        //        try {
        $id = $request->input('id');
        $obj = $this->model->find($id);
        $obj->status = !$obj->status;
        $request->stop_reason ? $obj->stop_reason = $request->stop_reason : null;
        $obj->save();
        return response()->json(['status' => 200, 'message' => trns('status updated successfully.')]);
        //        } catch (\Exception $e) {
        //            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        //        }
    }

    public function storeExcel($request)
    {

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);



        try {
            Excel::import(new UnitImport, $request->file('excel_file'));
            return back()->with('success', 'تم الاستيراد بنجاح');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'خطأ في الاستيراد: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $export = new DynamicModelExport(\App\Models\Unit::class);
        $fileName = 'units_export_' . date('Y-m-d') . '.xlsx';
        return Excel::download($export, $fileName);
    }



    public function create($request = null)
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            'realStates' => $this->realState->get(),
            'users' => $this->userService->model->where('status', 1)->get(),
            'oldUserIds' => old('user_ids', []),
            'associations' => $this->association->get(),
            'association_id' => $request?->input('association_id') ?? null,
            'real_state_id' => $request?->input('real_state_id') ?? null,
            'oldPercentages' => old('percentages', [])
        ]);
    }

    public function showCreate($realState_id): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $realState = $this->realStateService->model->find($realState_id);
        if (!$realState) {
            abort(404);
        }
        $associationId = $realState->association_id;
        $association = $this->association->find($associationId);

        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            'realState' => $realState,
            'users' => $this->userService->model->where('status', 1)->get(),
            'association' => $association,

        ]);
    }



    public function singleCreate()
    {
        return view("{$this->folder}/parts/singlePageCreate", [
            'storeRoute' => route("{$this->route}.store"),
            'realStates' => $this->realStateService->getAll(),
            'users' => $this->userService->model->where('status', operator: 1)->get(),
            'associations' => $this->association->get()
        ]);
    }

    public function store($data)
    {
        try {
            if (isset($data['status'])) {

                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }


            $userIds = $data['user_ids'];
            $percentages = $data['percentages'] ?? [];

            $unit = $this->model->create([
                "real_state_id" => $data['real_state_id'],
                "unit_number" => $data['unit_number'],
                "description" => $data['description'],
                "space" => $data['space'],
                "status" => $data['status'],
                "unit_code" => $data['unit_code'],
                "floor_count" => $data['floor_count'],
                "bathrooms_count" => $data['bathrooms_count'],
                "bedrooms_count" => $data['bedrooms_count'],
                "northern_border" => $data['northern_border'],
                "southern_border" => $data['southern_border'],
                "eastern_border" => $data['eastern_border'],
                "western_border" => $data['western_border'],
                "stop_reason" => $data['stop_reason'],
                "admin_id" => auth()->user()->id,
            ]);



            if (isset($data['images'])) {
                $this->storeMediaLibrary($data['images'], $unit, 'image', 'images');
            }

            if (isset($data['files'])) {
                $this->storeMediaLibrary($data['files'], $unit, 'files', 'files');
            }

            if (isset($data['logo'])) {
                $this->storeMediaLibrary($data['logo'], $unit, 'logo', 'logos');
            }

            foreach ($userIds as $userId) {
                $this->unitOwner->create([
                    'user_id' => $userId,
                    'unit_id' => $unit->id,
                    'percentage' => $percentages[$userId]
                ]);
            }

            $electricData = [];
            foreach ($data['electric_account_number'] ?? [] as $i => $electricAccountNumber) {
                $subscriptionNumber = $data['electric_subscription_number'][$i] ?? null;
                $meterNumber = $data['electric_meter_number'][$i] ?? null;
                $electric_name = $data['electric_name'][$i] ?? null;
                if ($electricAccountNumber && $subscriptionNumber && $meterNumber) {
                    $electricData[] = [
                        'electric_account_number' => $electricAccountNumber,
                        'electric_subscription_number' => $subscriptionNumber,
                        'electric_meter_number' => $meterNumber,
                        'electric_name' => $electric_name,
                    ];
                }
            }

            $waterData = [];
            foreach ($data['water_account_number'] ?? [] as $i => $waterAccountNumber) {
                $WaterMeterNumber = $data['water_meter_number'][$i] ?? null;
                $water_name = $data['water_name'][$i] ?? null;
                if ($waterAccountNumber && $WaterMeterNumber) {
                    $waterData[] = [
                        'water_account_number' => $waterAccountNumber,
                        'water_meter_number' => $WaterMeterNumber,
                        'water_name' => $water_name,
                    ];
                }
            }
            foreach ($electricData as $electricDatum) {
                $unit->unitElectric()->create((array) $electricDatum);
            }

            foreach ($waterData as $waterDatum) {
                $unit->unitWater()->create((array) $waterDatum);
            }

            if (isset($data['singlePageCreate'])) {
                if (isset($data['submit_type']) && $data['submit_type'] == 'create_and_redirect') {
                    return response()->json([
                        'status' => 200,
                        'redirect_to' => route($this->route . '.index'),
                        'message' => trns('created successfully')
                    ]);
                } else if (isset($data['submit_type']) && $data['submit_type'] == 'create_and_stay') {
                    return response()->json([
                        'status' => 200,
                        'redirect_to' => route($this->route . '.singlePageCreate'),
                        'message' => trns('created successfully')
                    ]);
                }
            }

            return response()->json(['status' => 200, 'message' => trns('Data created successfully.')]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => trns('Something went wrong.'),
                'error' => $e->getMessage()
            ]);
        }
    }

    public function edit($obj): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
            'realStates' => $this->realStateService->getAll(),
            'users' => $this->userService->model->where('status', 1)->get(),
            'associations' => $this->association->get(),
            'unitsElectrics' => $this->unitElectric->where('unit_id', $obj->id)->get(),
            'unitsWaters' => $this->unitWater->where('unit_id', $obj->id)->get(),
        ]);
    }

    public function update($data, $id): \Illuminate\Http\JsonResponse
    {
        $unit = $this->getById($id);

        if (isset($data["status"]) && $data["status"] == 1) {
            $data["stop_reason"] = null;
        }
        $unit->update(Arr::except($data, ['user_ids', 'percentages', 'images', 'files', 'logo', 'existing_images', 'existing_files', 'new_images', 'new_files', 'electric_account_number', 'electric_subscription_number', 'electric_name', 'electric_meter_number', 'water_account_number', 'water_meter_number', 'water_name']));


        if (isset($data['logo'])) {
            $this->storeMediaLibrary($data['logo'], $unit, 'logo', 'logos');
        }
        if (isset($data['existing_images'])) {
            $unit->getMedia('images')->whereNotIn('id', $data['existing_images'])->each->delete();
        }

        if (isset($data['existing_files'])) {
            $unit->getMedia('files')->whereNotIn('id', $data['existing_files'])->each->delete();
        }

        if (isset($data['new_images'])) {
            $this->storeMediaLibrary($data['new_images'], $unit, "images", "images", false);
        }

        if (isset($data['new_files'])) {
            $this->storeMediaLibrary($data['new_files'], $unit, "files", "files", false);
        }

        $electricData = [];

        // delete all electric data first
        $unit->unitElectric()->delete();
        //store new electric data
        foreach ($data['electric_account_number'] ?? [] as $i => $electricAccountNumber) {
            $subscriptionNumber = $data['electric_subscription_number'][$i] ?? null;
            $meterNumber = $data['electric_meter_number'][$i] ?? null;
            $electric_name = $data['electric_name'][$i] ?? null;
            if ($electricAccountNumber && $subscriptionNumber && $meterNumber) {
                $electricData[] = [
                    'electric_account_number' => $electricAccountNumber,
                    'electric_subscription_number' => $subscriptionNumber,
                    'electric_meter_number' => $meterNumber,
                    'electric_name' => $electric_name,
                ];
            }
        }


        $unit->unitWater()->delete();
        $waterData = [];
        foreach ($data['water_account_number'] ?? [] as $i => $waterAccountNumber) {
            $WaterMeterNumber = $data['water_meter_number'][$i] ?? null;
            $water_name = $data['water_name'][$i] ?? null;
            if ($waterAccountNumber && $WaterMeterNumber) {
                $waterData[] = [
                    'water_account_number' => $waterAccountNumber,
                    'water_meter_number' => $WaterMeterNumber,
                    'water_name' => $water_name,
                ];
            }
        }

        foreach ($electricData as $electricDatum) {
            $unit->unitElectric()->create((array) $electricDatum);
        }

        foreach ($waterData as $waterDatum) {
            $unit->unitWater()->create((array) $waterDatum);
        }

        // Update owners if provided
        if (isset($data['user_ids']) && isset($data['percentages'])) {
            $request = new Request($data);
            $ownersResponse = $this->updateOwners($request, $id);

            if ($ownersResponse->getStatusCode() !== 200) {
                return $ownersResponse;
            }
        }

        return response()->json(['status' => 200, 'message' => trns('Data updated successfully.')]);
    }


    public function updateOwners(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $unit = $this->getById($id);
        // Validate the request
        $validator = validator()->make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'percentages' => 'required|array',
            'percentages.*' => 'numeric|min:1|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => trns('Validation failed'),
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if percentages sum to 100
        $totalPercentage = array_sum($request->percentages);
        if ($totalPercentage != 100) {
            return response()->json([
                'status' => 422,
                'message' => trns('Total percentage must equal 100%'),
            ], 422);
        }

        DB::beginTransaction();
        // try {
        // First delete existing owners
        $unit->unitOwners()->delete();
        foreach ($request->user_ids as $userId) {
            if (isset($request->percentages[$userId])) {
                $unit->unitOwners()->create([
                    'user_id' => $userId,
                    'percentage' => $request->percentages[$userId]
                ]);
            }
        }


        DB::commit();

        return response()->json([
            'status' => 200,
            'message' => trns('Owners updated successfully.'),
        ]);
        // } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => 500,
            'message' => trns('Something went wrong.'),
            'error' => $e->getMessage()
        ]);
    }




    public function editOwners($id): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $unit = $this->objModel->with([
            'unitOwners.user',
            'realState',
            'realState.association'

            //            'association'
        ])->findOrFail($id);

        $realStates = $this->realStateService->model->get();
        $users = $this->userService->model->get();
        $associations = $this->association->get(); // Assuming you have this
        //        dd($id);
        return view('admin.unit.parts.edit-owners', [
            'route' => $this->route,
            'obj' => $unit,
            'realStates' => $realStates,
            'users' => $users,
            'associations' => $associations,
            'updateRoute' => route('units.updateOwners', $id)
        ]);
    }

    public function show($id): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $unit = $this->objModel->where('id', $id)->with(
            'RealState',
            'RealState.realStateDetails'
        )->first();

        if (!$unit) {
            abort(404, trns('Unit not found.'));
        }

        return view("{$this->folder}/parts/show", [
            'obj' => $this->getById($id),
            'route' => 'association.real_states',
            'bladeName' => 'unit(' . $unit->unit_number . ')',
            'delete_selected_route_electric_or_waters' => route('unit.electrics.or.waters.delete.selected'),

        ]);
    }






    public function unitOwners($request, $id)
    {
        if ($request->ajax()) {
            $unitIds = $this->objModel->where('real_state_id', $id)->pluck('id');
            $userIds = $this->unitOwner->whereIn('unit_id', $unitIds)->pluck('user_id')->toArray();
            $obj = $this->user->whereIn('id', $userIds)
                ->select('id', 'name', 'email', 'phone', 'national_id', 'status')
                ->get();

            return DataTables::of($obj)
                ->editColumn('name', function ($obj) {
                    $nameParts = explode(' ', $obj->name);
                    $firstName = $nameParts[0];
                    return $firstName;
                })
                ->addColumn('email', fn($obj) => $obj->email ?? 'N/A')
                ->addColumn('phone', fn($obj) => $obj->phone ?? 'N/A')
                ->addColumn('national_id', fn($obj) => $obj->national_id ?? 'N/A')
                ->addColumn('unit_ownership', function ($obj) {
                    return $this->unitOwner->where('user_id', $obj->id)->first()->percentage . '%' ?? 'N/A';
                })
                ->addColumn('status', function ($obj) {
                    if ($obj->status == 1) {
                        return ' <span class="badge"
                                    style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns('active') . '</span>';
                    } else {
                        return '<span class="badge"
                                    style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns('inactive') . '</span>';
                    }
                })



                ->addColumn('action', function ($obj) {
                    $buttons = '
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="' . route('users.show', $obj->id) . '">
                                                <i class="fa-solid fa-eye me-1"></i>' . trns('View') . '
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            ';
                    //  <li>
                    //                 <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                    //                     <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns('Edit') . '
                    //                 </a>
                    //             </li>   // comment for less time
                    return $buttons;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }

    public function getRealState($request): \Illuminate\Http\JsonResponse
    {
        try {
            $association = $this->association->where('id', $request->id)->first();

            if (!$association) {
                return response()->json(['status' => 404, 'message' => trns('Association not found.')]);
            }

            $realState = $this->realStateService->model->where('association_id', $association->id)->get();
            return response()->json(['status' => 200, 'message' => trns('Data retrieved successfully.'), 'data' => $realState]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), 'error' => $e->getMessage()]);
        }
    }










    // untis images handleing

    public function imagesShow($id)
    {
        $unit = $this->model->find($id);
        $images = $unit->media->where("collection_name", "images");
        return DataTables::of($images)
            ->editColumn("size", function ($image) {
                return $image->size / 1024 . " KB";
            })
            ->addColumn('admin_id', function ($image) {
                return $this->admin->where("id", $image->custom_properties['admin_id'])->first()->name ?? '-';
            })
            ->addColumn('image', function ($image) {
                $url = asset('storage/unit/' . $image->model_id . '/images/' . $image->file_name);
                return '
                    <span style="cursor: pointer;" onclick="openModal(\'' . $url . '\')">
                        <i class="fas fa-file"></i>
                    </span>
                ';
            })
            ->addColumn('action', function ($image) {

                $url = asset('storage/unit/' . $image->model_id . '/images/' . $image->file_name);
                $buttons = '
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="background-color: #EAEAEA; text-align: right;" aria-labelledby="dropdownMenuButton1">
                                        <li class="m-2">
                                                <span style="cursor: pointer; margin-bottom: 10px;" onclick="openModal(\'' . $url . '\')">
                                                    <i class="fas fa-eye"></i>
                                                    ' . trns("Show") . '
                                                </span>
                                        </li>
                                        <li class="m-2">
                                            <span class="download-img" style="cursor: pointer;margin-bottom: 10px;"
                                                data-fileName="' . $image->file_name . '"
                                                data-url="' . $url . '">
                                                <i class="fas fa-download"></i> ' . trns("download") . '
                                            </span>

                                        </li>

                                        <li class="m-2">
                                            <span class="delete_img" style="cursor: pointer;margin-bottom: 10px;"
                                                data-id="' . $image->id . '">
                                                <i class="fas fa-trash"></i> ' . trns("Delete") . '
                                            </span>
                                        </li>

                                    </ul>
                                </div>
                            ';

                return $buttons;
            })

            ->rawColumns(["image", "action"])

            ->make(true);
    }


    public function unitsDeleteImages($request)
    {
        $image = $this->media->where("id", $request->id)->first();
        if ($image) {
            $image->delete();
            return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
        } else {
            return response()->json(['status' => 404, 'message' => trns('image_not_found')]);
        }
    }


    public function getElectrics($request, $id)
    {
        if ($request->ajax()) {
            $obj = $this->model->find($id);




            return DataTables::of($obj->unitElectric)
                ->editColumn('created_at', function ($obj) {
                    return $obj->created_at->format('Y-m-d');
                })->addColumn('action', function ($obj) {
                    $buttons = '<div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                            <a class="dropdown-item editElectricOrWaterBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-type="electric" data-route="' . route('unit.electrics.edit', $obj->id) . '">
                                                <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;">' . trns("Edit") . '
                                            </a>
                                        </li>


 <li>
                                <a class="dropdown-item text-danger" style="cursor:pointer;" data-bs-toggle="modal"
                                   data-bs-target="#delete_electric_or_water_modal" data-type="water" data-route="' . route('unit.electrics.delete', $obj->id) . '" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
                                    <i class="fas fa-trash"></i> ' . trns("delete") . '
                                </a>
                            </li>
                        ';
                    $buttons .= '
                        </ul>
                    </div>



                        ';

                    return $buttons;
                })

                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.unit.parts.show');
        }
    }

    public function getWaters($request, $id)
    {
        if ($request->ajax()) {
            $obj = $this->model->find($id);




            return DataTables::of($obj->unitWater)
                ->editColumn('created_at', function ($obj) {
                    return $obj->created_at->format('Y-m-d');
                })->addColumn('action', function ($obj) {
                    $buttons = '<div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                            <a class="dropdown-item editElectricOrWaterBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-type="water" data-route="' . route('unit.waters.edit', $obj->id) . '">
                                                <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;">' . trns("Edit") . '
                                            </a>
                                        </li>



                            <li>
                                <a class="dropdown-item text-danger" style="cursor:pointer;" data-bs-toggle="modal"
                                   data-bs-target="#delete_electric_or_water_modal" data-type="water" data-route="' . route('unit.waters.delete', $obj->id) . '" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
                                    <i class="fas fa-trash"></i> ' . trns("delete") . '
                                </a>
                            </li>
                        ';
                    $buttons .= '
                        </ul>
                    </div>



                        ';

                    return $buttons;
                })


                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.unit.parts.show');
        }
    }



    public function unitOwnersByUnit($request, $id)
    {
        if ($request->ajax()) {
            $userIds = $this->unitOwner->where('unit_id', $id)->pluck('user_id')->toArray();
            $obj = $this->user->whereIn('id', $userIds)
                ->select('id', 'name', 'email', 'phone', 'national_id', 'status')
                ->get();

            return DataTables::of($obj)
                ->editColumn('name', function ($obj) {
                    $nameParts = explode(' ', $obj->name);
                    $firstName = $nameParts[0];
                    return $firstName;
                })->addColumn('email', fn($obj) => $obj->email ?? 'N/A')
                ->addColumn('phone', fn($obj) => $obj->phone ?? 'N/A')
                ->addColumn('national_id', fn($obj) => $obj->national_id ?? 'N/A')
                ->addColumn('unit_ownership', function ($obj) {
                    return $this->unitOwner->where('user_id', $obj->id)->first()->percentage . '%' ?? 'N/A';
                })
                ->addColumn('status', function ($obj) {
                    if ($obj->status == 1) {
                        return ' <span class="badge"
                                    style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns('active') . '</span>';
                    } else {
                        return '<span class="badge"
                                    style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns('inactive') . '</span>';
                    }
                })



                ->addColumn('action', function ($obj) {
                    $buttons = '
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="' . route('users.show', $obj->id) . '">
                                                <i class="fa-solid fa-eye me-1"></i>' . trns('View') . '
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            ';

                    return $buttons;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
    }


    public function createElectricsToUnit($id)
    {
        return view('admin.unit.parts.CreateElectrics', [
            'unitId' => $id,
            'storeRoute' => route('unit.electrics.store', $id),
        ]);
    }


    public function storeElectricsToUnit($request)
    {

        $unit = $this->model->find($request['unit_id']);
        $obj = $unit->unitElectric()->create($request);

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('created_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }
    public function createWatersToUnit($id)
    {
        return view('admin.unit.parts.CreateWaters', [
            'unitId' => $id,
            'storeRoute' => route('unit.waters.store', $id),
        ]);
    }


    public function storeWatersToUnit($request)
    {

        $unit = $this->model->find($request['unit_id']);
        $obj = $unit->unitWater()->create($request);

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('created_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }

    public function editElectricsToUnit($id)
    {
        $obj = $this->unitElectric->find($id);
        return view('admin.unit.parts.EditElectrics', [
            'obj' => $obj,
            'updateRoute' => route('unit.electrics.update', $id),
        ]);
    }

    public function updateElectricsToUnit($request, $id)
    {
        $obj = $this->unitElectric->find($id);
        $obj->update($request);

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('updated_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }


    public function editWatersToUnit($id)
    {
        $obj = $this->unitWater->find($id);
        return view('admin.unit.parts.EditWaters', [
            'obj' => $obj,
            'updateRoute' => route('unit.waters.update', $id),
        ]);
    }

    public function updateWatersToUnit($request, $id)
    {
        $obj = $this->unitWater->find($id);
        $obj->update($request);

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('updated_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }


    public function deleteElectrics($id)
    {
        $obj = $this->unitElectric->find($id);
        $obj->delete();

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }


    public function deleteWaters($id)
    {
        $obj = $this->unitWater->find($id);
        $obj->delete();

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }


    public function deleteSelectedElectricsOrWaters($request)
    {
        $ids = $request->input('ids', []);
        $type = $request->input('type');

        if ($type == 'electrics') {
            $this->unitElectric->destroy($ids);
        } elseif ($type == 'waters') {
            $this->unitWater->destroy($ids);
        }

        return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
    }


    public function addExcelElectricOrWater()
    {
        return view("{$this->folder}/parts/addExcelOfElectricOrWater", [
            'storeExcelOfElectricOrWaterRoute' => route("unit.store.electric_or_water.excel"),
        ]);
    }


    public function storeExcelElectricOrWater($request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls,csv'
            ]);


            $file = $request->file('excel_file');

            $reader = new PreviewElectricOrWaterOfUnitimport();
            Excel::import($reader, $file);
            $rows = $reader->rows;


            $errors = [];

            foreach ($rows as $index => $row) {
                $rules = [
                    'unit_number' => 'required|exists:units,unit_number',
                    'electric_name' => 'required',
                    'electric_account_number' => 'required',
                    'electric_subscription_number' => 'required',
                    'electric_meter_number' => 'required',
                    'water_name' => 'required',
                    'water_account_number' => 'required',
                    'water_meter_number' => 'required',
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



            Excel::import(new ElectricOrWaterOfUnitImport, $request->file('excel_file'));
            return back()->with('success', 'تم الاستيراد بنجاح');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'خطأ في الاستيراد: ' . $e->getMessage())
                ->withInput();
        }
    }
}
