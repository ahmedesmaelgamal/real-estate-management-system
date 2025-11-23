<?php

namespace App\Services\Admin;

use App\Exports\DynamicModelExport;
use App\Imports\PreviewElectricOrWaterimport;
use App\Imports\ElectricOrWaterImport;
use App\Imports\RealStateImport;
use App\Models\Admin;
use App\Models\Association;
use App\Models\LegalOwnership;
use App\Models\RealState as ObjModel;
use App\Models\RealState;
use App\Models\RealStateDetail;
use App\Models\RealStateElectric;
use App\Models\RealStateOwner;
use App\Models\RealStateWater;
use App\Models\Unit;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Yajra\DataTables\DataTables;

class RealStateService extends BaseService
{
    protected string $folder = 'admin/real_state';
    protected string $route = 'real_states';

    public function __construct(
        protected ObjModel $objModel,
        protected RealStateDetail $realStateDetail,
        protected RealStateOwner $realStateOwnerShop,
        protected Association $association,
        protected User $user,
        protected Unit $unit,
        protected RealState $realState,
        protected Media $media,
        protected Admin $admin,
        protected LegalOwnership $legalOwnership,
        protected RealStateElectric $realStateElectric,
        protected RealStateWater $realStateWater
    ) {
        parent::__construct($objModel);
    }

    public function index($request)
    {
        if ($request->ajax()) {
            $query = $this->model->query();

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
                    $buttons = '<div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                <a class="dropdown-item" href="' . route($this->route . '.show', $obj->id) . '">
                                    <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                </a>
                            </li>
                    ';


                    if (auth("admin")->user()->can('update_real_state')) {
                        $buttons .= '
                                <li>
                                    <a class="dropdown-item editBtn real_state_show_edit" href="javascript:void(0);" data-title="' . trns('Edit_Real_State') . '" data-id="' . $obj->id . '">
                                        <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                    </a>
                                </li>
 ';

                        if (!checkIfModelHasRecords(\App\Models\Unit::class, 'real_state_id', $obj->id)) {
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
                                data-title="' . trns('you_cant_delete_this_real_state_please_delete_all_aunits_first') . '">
                                    <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                                                ' . trns(key: "delete") . '
                                </a>
                            </li>

                        ';
                        }
                    }

                    $buttons .= '<li>
                                        <a class="dropdown-item" href="' . route($this->route . '.show', $obj->id) . '#realStateUnits' . '">
                                            <img src="' . asset('assets/greatwall_line.png') . '" style="width: 20px; height: 20px; margin-right: 5px;">
                                            مشاهدة الوحدات
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item openStatusModel toggleRealStatesStatusBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                            ' . ($obj->status == 1 ? trns('Deactivate real_State') : trns('Activate real_State')) . '
                                        </a>
                                    </li>
                                </ul>
                            </div>';
                    return $buttons;
                })
                ->editColumn('name', function ($obj) {
                    return $obj->getTranslation('name', app()->getLocale());
                })


                ->addColumn('unitNumber', function ($obj) {
                    return $obj->Units->count();
                })
                ->editColumn('association_id', function ($obj) {
                    return $obj->association ? $obj->association?->name : "(┬┬﹏┬┬)";
                })->editColumn('location', function ($obj) {
                    $url = "https://www.google.com/maps?q={$obj->lat},{$obj->long}";
                    return $url;
                })->editColumn('stop_reason', function ($obj) {
                    return $obj->stop_reason;
                })->editColumn('created_at', function ($obj) {
                    return $obj->created_at->format('Y-m-d');
                })->editColumn('status', function ($obj) {
                    if ($obj->status == 1) {
                        return '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns("Active") . '</span>';
                    } else {
                        return '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns("Inactive") . '</span>';
                    }
                })

                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/index', [
                'createRoute' => route($this->route . '.create'),
                'bladeName' => trns($this->route),
                'route' => $this->route,
                'allRealState' => $this->objModel->count(),
                'activeRealState' => $this->objModel->where('status', 1)->count(),
                'inactiveRealState' => $this->objModel->where('status', 0)->count(),
            ]);
        }
    }


    public function show($id)
    {
        $model = $this->getById($id);

        $bladeName = "real_state_management";
        $unitCount = $this->unit
            ->whereIn('real_state_id', $model->association?->RealStates?->pluck('id') ?? [])
            ->count();
        return view('admin.real_state.parts.show', [
            "obj" => $this->getById($id),
            'units' => @$model->Units,
            "bladeName" => $bladeName,
            'unitCount' => $unitCount,
            'route' => 'units',
            'delete_selected_route_electric_or_waters' => route('real_state.electrics.or.waters.delete.selected'),
        ]);
    }





    public function create($request = null)
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            "associations" => $this->association->get(),
            "legalOwnerships" => $this->legalOwnership->get(),
            'association_id' => $request?->input('association_id') ?? null,
        ]);
    }

    public function singlePageCreate()
    {
        return view("{$this->folder}/parts/singlePageCreate", [
            'storeRoute' => route("{$this->route}.store"),
            "associations" => $this->association->get(),
            "legalOwnerships" => $this->legalOwnership->get(),
        ]);
    }


    public function store($data)
    {
        if (isset($data['status'])) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $detailData = Arr::except($data, [
            "logo",
            "singlePage",
            "files",
            "images",
            'name',
            'association_id',
            'lat',
            'long',
            'ownership_ids',
            'electric_account_number',
            'electric_meter_number',
            'electric_subscription_number',
            'electric_name',
            'water_meter_number',
            'water_account_number',
            'water_name',
        ]);

        $mainData = Arr::only($data, [
            'name',
            'association_id',
            'stop_reason',
            'lat',
            'long',
            'real_state_number',
            'legal_ownership_id',
            'legal_ownership_other',
            'stop_reason',
            'status',
        ]);
        $electricData = [];
        foreach ($data['electric_account_number'] ?? [] as $i => $electricAccountNumber) {
            $subscriptionNumber = $data['electric_subscription_number'][$i] ?? null;
            $meterNumber = $data['electric_meter_number'][$i] ?? null;
            $electricName = $data['electric_name'][$i] ?? null;
            if ($electricAccountNumber && $subscriptionNumber && $meterNumber) {
                $electricData[] = [
                    'electric_account_number' => $electricAccountNumber,
                    'electric_subscription_number' => $subscriptionNumber,
                    'electric_meter_number' => $meterNumber,
                    'electric_name' => $electricName,
                ];
            }
        }

        $waterData = [];
        foreach ($data['water_account_number'] ?? [] as $i => $waterAccountNumber) {
            $WaterMeterNumber = $data['water_meter_number'][$i] ?? null;
            $waterName = $data['water_name'][$i] ?? null;
            if ($waterAccountNumber && $WaterMeterNumber) {
                $waterData[] = [
                    'water_account_number' => $waterAccountNumber,
                    'water_meter_number' => $WaterMeterNumber,
                    'water_name' => $waterName,
                ];
            }
        }

        if (isset($mainData['legal_ownership_id']) && $mainData['legal_ownership_id'] == 'other') {
            unset($mainData['legal_ownership_id']);
        }
        $detailData['bank_account_number'] = 'SA' . $data['bank_account_number'];

        $mainData["admin_id"] = auth()->check() ? auth()->user()->id : 1;

        $realState = $this->createData($mainData);

        $detailData['real_state_id'] = $realState->id;

        $realState->realStateDetails()->create($detailData);
        foreach ($electricData as $electricDatum) {
            $realState->realStateElectric()->create((array) $electricDatum);
        }

        foreach ($waterData as $waterDatum) {
            $realState->realStateWater()->create((array) $waterDatum);
        }

        $ownershipIds = $data['ownership_ids'] ?? [];

        $ownershipArray = collect($ownershipIds)->map(function ($id) {
            return ['user_id' => $id];
        })->toArray();

        $realState->RealStateOwnerShips()->createMany($ownershipArray);

        if (isset($data['logo'])) {
            $this->storeMediaLibrary($data['logo'], $realState, "logo", "logos");
        }
        if (isset($data['images'])) {
            $this->storeMediaLibrary($data['images'], $realState, "images", "images");
        }
        if (isset($data['files'])) {
            $this->storeMediaLibrary($data['files'], $realState, "files", "files");
        }
        if (array_key_exists('singlePageCreate', $data)) {
            if (isset($data['submit_type']) && $data['submit_type'] == 'create_and_redirect') {
                return response()->json([
                    'status' => 200,
                    'redirect_to' => route('real_states.index'),
                    'message' => trns('created successfully')
                ]);
            } else if (isset($data['submit_type']) && $data['submit_type'] == 'create_and_stay') {
                return response()->json([
                    'status' => 200,
                    'redirect_to' => route('real_states.singlePageCreate'),
                    'message' => trns('created successfully')
                ]);
            }
        }

        return response()->json([
            'status' => 200,
            'redirect_to' => route('real_states.index'),
            'message' => trns('created successfully')
        ]);
    }


    public function edit($obj)
    {
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
            "associations" => $this->association->get(),
            "legalOwnerships" => $this->legalOwnership->get(),
            'realStateElectrics' => $this->realStateElectric->where('real_state_id', $obj->id)->get(),
            'realStateWaters' => $this->realStateWater->where('real_state_id', $obj->id)->get(),
        ]);
    }
    public function updateStatus($status, $id)
    {
        try {
            $obj = $this->getById($id);
            $obj->update([
                'status' => $status
            ]);
            return response()->json(['status' => 200, 'message' => trns('status updated successfully.')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => trns('Something went wrong while updating the status.'), trns('error') => $e->getMessage()]);
        }
    }
    public function update($data, $id)
    {

        try {
            $oldObj = $this->getById($id);

            $detailData = Arr::except($data, [
                'electric_meter_number',
                'electric_account_number',
                'electric_subscription_number',
                'electric_name',
                'water_meter_number',
                'water_account_number',
                'water_name',

                "logo",
                "singlePage",
                "files",
                "images",
                'existing_images',
                'new_images',
                'existing_files',
                'new_files',
                'name',
                'association_id',
                'lat',
                'long',
                'ownership_ids',
                'stop_reason',
                'status',
                'legal_ownership_id',
                'legal_ownership_other',
            ]);

            $mainData = Arr::only($data, [
                'name',
                'association_id',
                'lat',
                'long',
                'real_state_number',
                'legal_ownership_id',
                'legal_ownership_other',
                'stop_reason',
                'status',
            ]);


            $electricData = [];

            // delete all electric data first
            $oldObj->realStateElectric()->delete();
            //store new electric data
            foreach ($data['electric_account_number'] ?? [] as $i => $electricAccountNumber) {
                $subscriptionNumber = $data['electric_subscription_number'][$i] ?? null;
                $meterNumber = $data['electric_meter_number'][$i] ?? null;
                $electricName = $data['electric_name'][$i] ?? null;
                if ($electricAccountNumber && $subscriptionNumber && $meterNumber) {
                    $electricData[] = [
                        'electric_account_number' => $electricAccountNumber,
                        'electric_subscription_number' => $subscriptionNumber,
                        'electric_meter_number' => $meterNumber,
                        'electric_name' => $electricName,
                    ];
                }
            }


            $oldObj->realStateWater()->delete();
            $waterData = [];
            foreach ($data['water_account_number'] ?? [] as $i => $waterAccountNumber) {
                $WaterMeterNumber = $data['water_meter_number'][$i] ?? null;
                $waterName = $data['water_name'][$i] ?? null;
                if ($waterAccountNumber && $WaterMeterNumber) {
                    $waterData[] = [
                        'water_account_number' => $waterAccountNumber,
                        'water_meter_number' => $WaterMeterNumber,
                        'water_name' => $waterName,
                    ];
                }
            }

            foreach ($electricData as $electricDatum) {
                $oldObj->realStateElectric()->create((array) $electricDatum);
            }

            foreach ($waterData as $waterDatum) {
                $oldObj->realStateWater()->create((array) $waterDatum);
            }





            if (isset($mainData['legal_ownership_id']) && $mainData['legal_ownership_id'] == 'other') {
                unset($mainData['legal_ownership_id']);
            }
            if (isset($mainData["status"]) && $mainData["status"] == 1) {
                $mainData["status"] = 1;
                $mainData["interception_reason"] = null;
            }


            $mainData["admin_id"] = auth()->check() ? auth()->user()->id : 1;

            $this->realStateDetail->where('real_state_id', $oldObj->id)->update($detailData);




            $ownershipIds = $data['ownership_ids'] ?? [];

            $ownershipArray = collect($ownershipIds)->map(function ($id) {
                return ['user_id' => $id];
            })->toArray();

            $oldObj->RealStateOwnerShips()->delete();
            $oldObj->RealStateOwnerShips()->createMany($ownershipArray);

            // Handle existing media deletion
            if (isset($data['existing_images'])) {
                $oldObj->getMedia('images')->whereNotIn('id', $data['existing_images'])->each->delete();
            }

            if (isset($data['existing_files'])) {
                $oldObj->getMedia('files')->whereNotIn('id', $data['existing_files'])->each->delete();
            }

            // Handle media uploads
            if (isset($data['logo'])) {
                $this->storeMediaLibrary($data['logo'], $oldObj, "logo", "logos");
            }

            if (isset($data['images'])) {
                $this->storeMediaLibrary($data['images'], $oldObj, "images", "images");
            }

            if (isset($data['new_images'])) {
                $this->storeMediaLibrary($data['new_images'], $oldObj, "images", "images", false);
            }

            if (isset($data['files'])) {
                $this->storeMediaLibrary($data['files'], $oldObj, "files", "files");
            }

            if (isset($data['new_files'])) {
                $this->storeMediaLibrary($data['new_files'], $oldObj, "files", "files", false);
            }


            // Handle response based on submit type (similar to store function)
            if (array_key_exists('singlePageUpdate', $data)) {
                if (isset($data['submit_type']) && $data['submit_type'] == 'update_and_redirect') {
                    return response()->json([
                        'status' => 200,
                        'redirect_to' => route('real_states.index'),
                        'message' => trns('Data updated successfully.')
                    ]);
                } else if (isset($data['submit_type']) && $data['submit_type'] == 'update_and_stay') {
                    return response()->json([
                        'status' => 200,
                        'redirect_to' => route('real_states.edit', $oldObj->id),
                        'message' => trns('Data updated successfully.')
                    ]);
                }
            }

            return response()->json([
                'status' => 200,
                'redirect_to' => route('real_states.index'),
                'message' => trns('Data updated successfully.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => trns('Something went wrong.'),
                'error' => $e->getMessage()
            ]);
        }
    }




    public function StopReason($request)
    {
        try {
            $id = $request->input('id');
            $obj = $this->model->find($id);
            $obj->status = !$obj->status;
            $request->stop_reason ? $obj->stop_reason = $request->stop_reason : null;
            $obj->save();
            return response()->json(['status' => 200, 'message' => trns('status updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }

    // custom functions


    public function showMainInformation($id)
    {
        $obj = $this->objModel->with('association', 'users')->findOrFail($id);
        return view('admin.real_state.parts.main-information', [
            'obj' => $obj
        ]);
    }

    public function showProperty($request, $id)
    {
        if ($request->ajax()) {
            $units = $this->model->with('Units')->findOrFail($id)->Units;


            return DataTables::of($units)

                ->addColumn('action', function ($obj) {
                    $buttons = '
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="background-color: #EAEAEA;">
                                <li>
                                    <a class="dropdown-item" href="' . route('units.show', $obj->id) . '">
                                        <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                        <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item suspendUserBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-bs-toggle="modal" data-bs-target="#delete_modal" data-title="' . $obj->name . '">
                                        <i class="fas fa-trash ms-1"></i> ' . trns("Delete") . '
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                    return $buttons;
                })


                ->addColumn('unit_code', function ($obj) {
                    return $obj->unit_code ?? 'N/A';
                })
                ->addColumn('real_state_number', function ($obj) {
                    return $obj->RealState->real_state_number ?? 'N/A';
                })
                ->addColumn('owner_name', function ($obj) {
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
                ->addColumn('unit_number', function ($obj) {
                    return $obj->unit_number ?? 'N/A';
                })


                ->addColumn("association_name", function ($obj) {
                    return @$obj->association->name;
                })

                ->addColumn('floor_count', function ($obj) {
                    return $obj->floor_count ?? 'N/A';
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
        }
    }


    public function RealStateOwners($request, $id)
    {
        if ($request->ajax()) {
            $realState = $this->realState->with('realStateOwners.user')->where('id', $id)->first();
            $obj = $realState?->realStateOwners->pluck('user');

            return DataTables::of($obj)
                ->addColumn('id', function ($obj) {
                    return $obj->id ?? 'N/A';
                })
                ->addColumn('name', function ($obj) {
                    return $obj->name ?? 'N/A';
                })
                ->addColumn('email', function ($obj) {
                    return $obj->email ?? 'N/A';
                })
                ->addColumn('phone', function ($obj) {
                    return $obj->phone ?? 'N/A';
                })
                ->addColumn('national_id', function ($obj) {

                    return $obj->national_id ?? 'N/A';
                })

                ->editColumn('status', function ($obj) {
                    if ($obj->status == 1) {
                        return '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns("Active") . '</span>';
                    } else {
                        return '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns("Inactive") . '</span>';
                    }
                })


                ->addColumn('action', function ($obj) {
                    $buttons = '
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                <li>
                                    <a class="dropdown-item" href="' . route('users' . '.show', $obj->id) . '">
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



                    $buttons .= '
                                    <li>
                                        <a class="dropdown-item toggleStatusBtn toggleRealStateUserStatusBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                            ' . ($obj->status == 1 ? trns("stop_user") : trns("operate_user")) . '
                                        </a>
                                    </li>
                                </ul>
                            </div>';
                    return $buttons;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
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
            Excel::import(new RealStateImport, $request->file('excel_file'));
            return back()->with('success', 'تم الاستيراد بنجاح');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'خطأ في الاستيراد: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $export = new DynamicModelExport(ObjModel::class);
        $fileName = 'real_states_export_' . date('Y-m-d') . '.xlsx';
        return Excel::download($export, $fileName);
    }

    public function showAssociation($id)
    {
        $obj = $this->objModel->with('association')->findOrFail($id);
        return view('admin.real_state.parts.association', [
            'obj' => $obj
        ]);
    }

    public function showImages($id)
    {
        $obj = $this->objModel->findOrFail($id);
        return view('admin.real_state.parts.images', [
            'obj' => $obj
        ]);
    }

    public function showDocuments($id)
    {
        $obj = $this->objModel->findOrFail($id);
        return view('admin.real_state.parts.documents', [
            'obj' => $obj
        ]);
    }
    public function unitState($request, $realStateId)
    {
        if ($request->ajax()) {
            try {
                $units = Unit::where('real_state_id', $realStateId)
                    ->with(['association:id,name'])
                    ->select([
                        'id',
                        'unit_number',
                        'description',
                        'space',
                        'unit_code',
                        'floor_count',
                        'status',
                        'created_at',
                        'real_state_id',
                        'association_id'
                    ]);

                return DataTables::of($units)
                    ->editColumn('unit_number', fn($unit) => $unit->unit_number ?: '-')
                    ->editColumn('description', fn($unit) => Str::limit($unit->description, 50) ?: '-')
                    ->editColumn('space', fn($unit) => $unit->space ? $unit->space . ' m²' : '-')
                    ->editColumn('status', function ($unit) {
                        $status = $unit->status == 1 ? 'active' : 'inactive';
                        $class = $unit->status == 1 ? 'success' : 'danger';
                        return '<span class="badge bg-' . $class . '">' . trns($status) . '</span>';
                    })
                    ->editColumn('created_at', fn($unit) => $unit->created_at->format('Y-m-d'))
                    ->addIndexColumn()
                    ->rawColumns(['status'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('Error in unitState method: ' . $e->getMessage());
                return response()->json(['error' => trns('error_occurred')], 500);
            }
        }

        return view('admin.real_states.show', compact('realStateId'));
    }
    public function getRealStates($request)
    {
        $associationId = $request->input('association_id');

        // Fetch real states based on the association ID
        $realStates = $this->realState->where('association_id', $associationId)->get(['id', 'name']);

        return response()->json($realStates);
    }







    // the images code
    public function imagesShow($id)
    {
        $realState = $this->model->find($id);
        $images = $realState->media->where("collection_name", "images");
        return DataTables::of($images)
            ->editColumn("size", function ($image) {
                return $image->size / 1024 . " KB";
            })
            ->addColumn('admin_id', function ($image) {
                return $this->admin->where("id", $image->custom_properties['admin_id'])->first()->name ?? '-';
            })
            ->addColumn('image', function ($image) {
                $url = asset('storage/realstate/' . $image->model_id . '/images/' . $image->file_name);
                return '
                    <span style="cursor: pointer;" onclick="openModal(\'' . $url . '\')">
                        <i class="fas fa-file"></i>
                    </span>
                ';
            })
            ->addColumn('action', function ($image) {

                $url = asset('storage/realstate/' . $image->model_id . '/images/' . $image->file_name);
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


    public function RealStateDeleteImages($request)
    {
        $image = $this->media->where("id", $request->id)->first();
        if ($image) {
            $image->delete();
            return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
        } else {
            return response()->json(['status' => 404, 'message' => trns('image_not_found')]);
        }
    }

    public function getRealStatesByAssociation(Request $request)
    {
        $realStates = $this->model->where('association_id', $request->id)
            ->select('id', 'name')
            ->get();

        return response()->json($realStates);
    }



    public function getElectrics($request, $id)
    {
        if ($request->ajax()) {
            $obj = $this->model->find($id);




            return DataTables::of($obj->realStateElectric)
                ->editColumn('created_at', function ($obj) {
                    return $obj->created_at->format('Y-m-d');
                })->addColumn('action', function ($obj) {
                    $buttons = '<div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                            <a class="dropdown-item editElectricOrWaterBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-type="electric" data-route="' . route('real_state.electrics.edit', $obj->id) . '">
                                                <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;">' . trns("Edit") . '
                                            </a>
                                        </li>


 <li>
                                <a class="dropdown-item text-danger" style="cursor:pointer;" data-bs-toggle="modal"
                                   data-bs-target="#delete_electric_or_water_modal" data-type="water" data-route="' . route('real_state.electrics.delete', $obj->id) . '" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
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
            return view('admin.real_state.parts.show');
        }
    }

    public function getWaters($request, $id)
    {
        if ($request->ajax()) {
            $obj = $this->model->find($id);




            return DataTables::of($obj->realStateWater)
                ->editColumn('created_at', function ($obj) {
                    return $obj->created_at->format('Y-m-d');
                })->addColumn('action', function ($obj) {
                    $buttons = '<div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                            <a class="dropdown-item editElectricOrWaterBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-type="water" data-route="' . route('real_state.waters.edit', $obj->id) . '">
                                                <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;">' . trns("Edit") . '
                                            </a>
                                        </li>



                            <li>
                                <a class="dropdown-item text-danger" style="cursor:pointer;" data-bs-toggle="modal"
                                   data-bs-target="#delete_electric_or_water_modal" data-type="water" data-route="' . route('real_state.waters.delete', $obj->id) . '" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
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
            return view('admin.real_state.parts.show');
        }
    }











    public function createElectricsToRealState($id)
    {
        return view('admin.real_state.parts.CreateElectrics', [
            'realStateId' => $id,
            'storeRoute' => route('real_state.electrics.store', $id),
        ]);
    }


    public function storeElectricsToRealState($request)
    {

        $realState = $this->model->find($request['real_state_id']);
        $obj = $realState->realStateElectric()->create($request);

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('created_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }
    public function createWatersToRealState($id)
    {
        return view('admin.real_state.parts.CreateWaters', [
            'realStateId' => $id,
            'storeRoute' => route('real_state.waters.store', $id),
        ]);
    }


    public function storeWatersToRealState($request)
    {

        $realState = $this->model->find($request['real_state_id']);
        $obj = $realState->realStateWater()->create($request);

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('created_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }

    public function editElectricsToRealState($id)
    {
        $obj = $this->realStateElectric->find($id);
        return view('admin.real_state.parts.EditElectrics', [
            'obj' => $obj,
            'updateRoute' => route('real_state.electrics.update', $id),
        ]);
    }

    public function updateElectricsToRealState($request, $id)
    {
        $obj = $this->realStateElectric->find($id);
        $obj->update($request);

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('updated_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }


    public function editWatersToRealState($id)
    {
        $obj = $this->realStateWater->find($id);
        return view('admin.real_state.parts.EditWaters', [
            'obj' => $obj,
            'updateRoute' => route('real_state.waters.update', $id),
        ]);
    }

    public function updateWatersToRealState($request, $id)
    {
        $obj = $this->realStateWater->find($id);
        $obj->update($request);

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('updated_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }


    public function deleteElectrics($id)
    {
        $obj = $this->realStateElectric->find($id);
        $obj->delete();

        if ($obj) {
            return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
        } else {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }


    public function deleteWaters($id)
    {
        $obj = $this->realStateWater->find($id);
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
            // dd($ids);
            $this->realStateElectric->destroy($ids);
        } elseif ($type == 'waters') {
            $this->realStateWater->destroy($ids);
        }

        return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
    }


    public function addExcelElectricOrWater()
    {
        return view("{$this->folder}/parts/addExcelOfElectricOrWater", [
            'storeExcelOfElectricOrWaterRoute' => route("real_state.store.electric_or_water.excel"),
        ]);
    }


    public function storeExcelElectricOrWater($request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls,csv'
            ]);

            $file = $request->file('excel_file');

            $reader = new PreviewElectricOrWaterimport();
            Excel::import($reader, $file);
            $rows = $reader->rows;


            $errors = [];

            foreach ($rows as $index => $row) {
                $rules = [
                    'real_state_number' => 'required|exists:real_state,real_state_number',
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



            Excel::import(new ElectricOrWaterImport, $request->file('excel_file'));
            return back()->with('success', 'تم الاستيراد بنجاح');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'خطأ في الاستيراد: ' . $e->getMessage())
                ->withInput();
        }
    }
}
