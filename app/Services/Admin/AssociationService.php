<?php

namespace App\Services\Admin;

use App\Exports\DynamicModelExport;
use App\Imports\AssociationImport;
use App\Imports\DynamicModelImport;
use App\Imports\PreviewAssociationImport;
use App\Models\Admin;
use App\Models\Association as ObjModel;
use App\Models\AssociationModel;
use App\Models\RealState;
use App\Models\RealStateOwner;
use App\Models\Unit;
use App\Models\UnitOwner;
use App\Models\User;
use App\Services\BaseService;
use App\Traits\map;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Yajra\DataTables\DataTables;

class AssociationService extends BaseService
{

    use map;

    protected string $folder = 'admin/association';
    protected string $route = 'associations';

    public function __construct(
        protected ObjModel $objModel,
        protected UnitOwner $unitOwner,
        protected RealStateOwner $realStateOwner,
        protected User $user,
        protected RealState $realState,
        protected Unit $unit,
        protected Excel $excel,
        protected AssociationModel $associationModel,
        protected Media $media,
        protected Admin $admin
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
                    $buttons = '
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item" href="' . route($this->route . '.show', $obj->id) . '">
                                        <i class="fa-solid fa-eye me-1"></i> ' . trns("show") . '
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item editBtn association_show_edit" href="javascript:void(0);" data-title="' . trns('Edit_Association') . '" data-id="' . $obj->id . '">
                                        <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                    </a>
                                </li>
                    ';

                    if (!checkIfModelHasRecords(\App\Models\RealState::class, 'association_id', $obj->id)) {
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
                                data-title="' . trns('You_cant_delete_this_association_please_delete_all_real_states_first') . '">
                                    <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                                                ' . trns(key: "delete") . '
                                </a>
                            </li>

                        ';
                    }




                    $buttons .= '
    <li>
        <a class="dropdown-item" href="' . route($this->route . '.show', $obj->id) . '#association_real_states' . '">
            <img src="' . asset('assets/building_1_line.png') . '" style="width: 20px; height: 20px; margin-right: 5px;">
            ' . trns("see_real_states") . '
        </a>
    </li>
    <li>
        <a class="dropdown-item" href="' . route($this->route . '.show', $obj->id) . '#association_units' . '">
            <img src="' . asset('assets/greatwall_line.png') . '" style="width: 20px; height: 20px; margin-right: 5px;">
            ' . trns('see_units') . '
        </a>
    </li>
    <li>
        <button class="dropdown-item openStatusModel" id="toggleStatusBtn" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
            ' . ($obj->status == 1 ? trns("Deactivate_association") : trns("Activate_association")) . '
        </button>
    </li>
    </ul>
</div>
';

                    return $buttons;
                })->editColumn('status', function ($obj) {
                    if ($obj->status == 1) {
                        return '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns("Active") . '</span>';
                    } else {
                        return '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns("Inactive") . '</span>';
                    }
                })
                ->editColumn('name', function ($obj) {
                    return $obj->getTranslation('name', app()->getLocale());
                })
                ->addColumn("owner_number", function ($obj) {
                    $association = $obj->with('realStates.units.getOwners')->find($obj->id);

                    $ownerCount = $association->realStates
                        ->flatMap(function ($realState) {
                            return $realState->units;
                        })
                        ->flatMap(function ($unit) {
                            return $unit->getOwners;
                        })
                        ->unique('id')
                        ->count();

                    return $ownerCount;
                })
                ->addColumn("real_stat_count", function ($obj) {
                    return $obj->RealStates?->count() ?? 0;
                })
                ->addColumn("units_counts", function ($obj) {
                    $totalUnits = $obj->RealStates?->sum(function ($realState) {
                        return $realState->units()->count();
                    });

                    return $totalUnits ?? 0;
                })

                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/index', [
                'obj' => $this->objModel->first(),
                'createRoute' => route($this->route . '.create'),
                'bladeName' => trns($this->route),
                'route' => $this->route,
                'allAssociations' => $this->objModel->count(),
                'activeAssociations' => $this->objModel->where('status', 1)->count(),
                'inactiveAssociations' => $this->objModel->where('status', 0)->count(),
            ]);
        }
    }
    public function stopReason($request): \Illuminate\Http\JsonResponse
    {
        try {
            $id = $request->input('id');
            $obj = $this->model->find($id);
            $obj->status = !$obj->status;
            $request->stop_reason ? $obj->interception_reason = $request->stop_reason : null;
            $obj->save();
            return response()->json(['status' => 200, 'message' => trns('status updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('something_went_wrong')]);
        }
    }

    public function getAssociationById($id)
    {
        $association = $this->objModel->find($id);
        if (!$association) {
            return response()->json(['status' => 404, 'message' => 'Association not found']);
        }
        return response()->json(['status' => 200, 'data' => $association]);
    }

    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            'associationManagers' => $this->admin->where('status', '1')->get(),
            'associationModels' => $this->associationModel->where('status', '1')->get(),
        ]);
    }
    public function addExcel()
    {
        return view("{$this->folder}/parts/addExcel", [
            'storeExcelRoute' => route("{$this->route}.store.excel"),
        ]);
    }
    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {

        $export = new DynamicModelExport(\App\Models\Association::class);
        $fileName = 'users_export_' . date('Y-m-d') . '.xlsx';
        return Excel::download($export, $fileName);
    }






    public function storeExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('excel_file');

            $reader = new PreviewAssociationImport();
            Excel::import($reader, $file);
            $rows = $reader->rows;

            $errors = [];

            foreach ($rows as $index => $row) {
                $email = $row['association_manager_email'] ?? null;

                if (!$email || !Admin::where('email', $email)->exists()) {
                    $errors[] = trns('Invalid_association_manager_email_at_row_:index') . $index + 1;
                }
            }

            if (!empty($errors)) {
                return response()->json([
                    'status' => 422,
                    'message' => $errors
                ], 422);
            }

            Excel::import(new AssociationImport, $file);

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

    public function singlePageCreate()
    {
        return view("{$this->folder}/parts/singlePageCreate", [
            'facilityManagementTemplates' => $this->associationModel->where('status', '1')->get(),
            'storeRoute' => route("{$this->route}.store"),
            'associationManagers' => $this->admin->get(),
            'associationModels' => $this->associationModel->where('status', '1')->get(),

        ]);
    }

    public function show($id)
    {
        return view("{$this->folder}/parts/show", [
            'obj' => $this->getById($id),
            'route' => 'association.real_states',
            "editRoute" => "associations"
        ]);
    }

    public function store($data): \Illuminate\Http\JsonResponse
    {
        try {
            $mainData = Arr::except($data, ['logo', 'images', 'files']);
            $mainData["admin_id"] = auth()->user()->id;
            if (array_key_exists("status", $mainData)) {
                if (isset($mainData["status"]) && $mainData["status"] === "on") {
                    $mainData["status"] = 1;
                    $data["interception_reason"] = null;
                } else {
                    $mainData["status"] = 0;
                }
            }

            $association = $this->createData($mainData);

            if (isset($data['logo'])) {
                $this->storeMediaLibrary($data['logo'], $association, "logo", "logo");
            }
            if (isset($data['images'])) {
                $this->storeMediaLibrary($data['images'], $association, "images", "images");
            }
            if (isset($data['files'])) {
                $this->storeMediaLibrary($data['files'], $association, "files", "files");
            }




            if (isset($data['singlePageCreate']) && $data['singlePageCreate'] == 1 && isset($data['submit_type']) && $data['submit_type'] == 'create_and_redirect') {
                return response()->json(['status' => 200, 'redirect_to' => url('admin/associations'), 'message' => trns('Data created successfully.')]);
            } elseif (isset($data['singlePageCreate']) && $data['singlePageCreate'] == 1 && isset($data['submit_type']) && $data['submit_type'] == 'create_and_stay') {
                return response()->json(['status' => 200, 'redirect_to' => url('admin/associations/singlePageCreate'), 'message' => trns('Data created successfully.')]);
            }


            return response()->json(['status' => 200, 'message' => trns('create success')]);
        } catch (\Exception $e) {

            if (array_key_exists('singlePageCreate', $data)) {
                return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage(), 'redirect_to' => route('associations.singlePageCreate')]);
            } else {
                return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage(), 'redirect_to' => route('associations.index')]);
            }
        }
    }


    public function storeSinglePageCreate($request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'number' => 'required|integer',
            'unit_count' => 'required|integer',
            'approval_date' => 'required|date',
            'establish_date' => 'required|date',
            'due_date' => 'required|date',
            'unified_number' => 'required|integer',
            'establish_number' => 'required|numeric',
            'status' => 'boolean',
            'interception_reason' => 'nullable|string|max:255',
            'association_manager_id' => 'nullable|exists:users,id',
            'appointment_start_date' => 'nullable|date',
            'appointment_end_date' => 'nullable|date|after_or_equal:appointment_start_date',
            'monthly_fees' => 'nullable|numeric',
            'is_commission' => 'boolean',
            'facility_management_template' => 'nullable|string|in:template1,template2,template3,template4',
            'lat' => 'nullable|numeric',
            'long' => 'nullable|numeric',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if (isset($validatedData["status"]) && $validatedData["status"] === 1) {
            $data["interception_reason"] = null;
        }

        if ($validatedData->fails()) {
            return redirect()->back()->with('error', $validatedData->errors()->first());
        }

        $data = $request->all();

        $association = $this->createData($data);
        if (isset($data['logo'])) {
            $this->storeMediaLibrary($data['logo'], $association, "logo", "logo");
        }
        if (isset($data['images'])) {
            $this->storeMediaLibrary($data['images'], $association, "images", "images");
        }
        if (isset($data['files'])) {
            $this->storeMediaLibrary($data['files'], $association, "files", "files");
        }

        return redirect()->back()->with('success', trns('Data created successfully.'));
    }

    public function edit($obj)
    {
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj->load(['AssociationManager', 'AssociationModel']),
            'updateRoute' => route("{$this->route}.update", $obj->id),
            'associationManagers' => $this->admin->where('status', 1)->get(),
            'associationModels' => $this->associationModel->where('status', '1')->get(),

        ]);
    }

    public function update($data, $id)
    {
        $oldObj = $this->getById($id);

        if (isset($data['logo'])) {
            $this->storeMediaLibrary($data['logo'], $oldObj, "logo", "logo");
        }
        if (isset($data['existing_images'])) {
            $oldObj->getMedia('images')->whereNotIn('id', $data['existing_images'])->each->delete();
        }

        if (isset($data['existing_files'])) {
            $oldObj->getMedia('files')->whereNotIn('id', $data['existing_files'])->each->delete();
        }

        if (isset($data['new_images'])) {
            $this->storeMediaLibrary($data['new_images'], $oldObj, "images", "images", false);
        }

        if (isset($data['new_files'])) {
            $this->storeMediaLibrary($data['new_files'], $oldObj, "files", "files", false);
        }
        try {
            if (isset($data["status"]) && $data["status"] == 1) {
                $data["interception_reason"] = null;
            }
            $oldObj->update($data);
            return response()->json(['status' => 200, 'message' => trns('Data updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage()]);
        }
    }


    public function realStates($request)
    {


        if ($request->ajax()) {
            $obj = $this->realState->get();
            return DataTables::of($obj)

                ->editColumn('created_at', function ($obj) {
                    return $obj->created_at->format('Y-m-d');
                })
                ->editColumn('status', function ($obj) {
                    return $this->statusDatatable($obj);  // تأكد بيرجع HTML أو Badge
                })
                ->rawColumns(['status'])  // ← مهم لو status بيرجع HTML
                ->addIndexColumn()
                ->make(true);
        } else {
            return view($this->folder . '/show', [
                //                'createRoute' => route($this->route . '.create'),
                //                'bladeName' => trns($this->route),
                //                'route' => $this->route,
            ]);
        }
    }

    public function units($request, $id)
    {
        if ($request->ajax()) {
            //            $obj = $this->objModel->realStates()->get();
            $obj = $this->unit->where('id', $id)->with(['RealState', 'unitOwners', 'realState.association'])->get();
            return DataTables::of($obj)
                //                ->addColumn('action', function ($obj) {
                //                    $buttons = '
                //                        <button type="button" data-id="' . $obj->id . '" class="btn btn-pill btn-info-light editBtn">
                //                            <i class="fa fa-edit"></i>
                //                        </button>
                //                        <button class="btn btn-pill btn-danger-light" data-bs-toggle="modal"
                //                            data-bs-target="#delete_modal" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
                //                            <i class="fas fa-trash"></i>
                //                        </button>
                //                    ';
                //                    return $buttons;
                //                })
                ->addColumn('unit_code', function ($obj) {
                    return $obj->unit_code;
                })->editColumn('real_state_number', function ($obj) {
                    return $obj->RealState->real_state_number;
                })->editColumn('unit_number', function ($obj) {
                    return $obj->unit_number;
                })->editColumn('floor_count', function ($obj) {
                    return $obj->floor_count;
                })->editColumn('association_name', function ($obj) {
                    //                    dd($obj->RealState->association->name);
                    return $obj->RealState->association->name;
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        } else {
            return view($this->folder . '/show', [
                //                'createRoute' => route($this->route . '.create'),
                //                'bladeName' => trns($this->route),
                //                'route' => $this->route,
            ]);
        }
    }

    public function unitData($id)
    {
        try {
            $unit = $this->unit->where('id', $id)->with(['RealState', 'unitOwners', 'RealState.association'])->first();
            //            if ($unit->association_id) {
            //                $unit->association = $this->objModel->find($unit->association_id);
            //            } else {
            //                $unit->association = null;
            //            }

            $unitOwner = $unit->unitOwners()->get()->sortByDesc('percentage')->first();
            return view('admin.association.parts.show_unit', [
                'obj' => $unit,
                'unitOwner' => $unitOwner,
                'bladeName' => $unit->unit_number,
            ]);
        } catch (\Exception $e) {
            // Redirect back with error message if something fails
            return redirect()->back()->with('error', 'Failed to load real estate details.');
        }
    }

    public function realStateData($request, $id)
    {

        try {
            $realState = $this->realState->with('realStateDetails', 'realStateOwners')->findOrFail($id);

            if ($realState->association_id) {
                $realState->association = $this->objModel->find($realState->association_id);
            } else {
                $realState->association = null;
            }

            return view('admin.association.parts.show_real_state', [
                'obj' => $realState,
                'bladeName' => $realState->name,
            ]);
        } catch (\Exception $e) {
            // Redirect back with error message if something fails
            return redirect()->back()->with('error', 'Failed to load real estate details.');
        }
    }

    public function associationData($request, $id)
    {

        try {
            $realState = $this->realState->with('realStateDetails', 'realStateOwners')->findOrFail($id);

            if ($realState->association_id) {
                $realState->association = $this->objModel->find($realState->association_id);
            } else {
                $realState->association = null;
            }

            return view('admin.association.parts.show_real_state', [
                'obj' => $realState,
                'bladeName' => trns($realState->name),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load real estate details.');
        }
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



    public function realStateShow($request, $id)
    {

        $realStates = $this->realState->where('association_id', $id);
        return DataTables::of($realStates)
            ->editColumn('created_at', function ($obj) {
                return $obj->created_at->format('d/m/Y');
            })
            ->editColumn('status', function ($obj) {
                if ($obj->status == 1) {
                    return '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns("Active") . '</span>';
                } else {
                    return '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns("Inactive") . '</span>';
                }
            })->addColumn('units_count', function ($obj) {
                return $obj->units()->count() ?? 0;
            })->addColumn('location', function ($obj) {

                $map = $this->getMap($obj->lat, $obj->long);
                if ($map) {
                    return '<span class="btn btn-sm body-span-msg" data-body="' . $map . '">' . Str::limit($map, limit: 20) . '</span>';
                } else {
                    $url = "https://www.google.com/maps?q={$obj->lat},{$obj->long}";
                    return '<a href="' . $url . '" target="_blank" class="btn btn-pill btn-info-light">' . trns('Show') . '</a>';
                }
            })->editColumn('name', function ($obj) {
                return $obj->name;
            })->addColumn('action', function ($obj) {
                $buttons = '
                        <button type="button" data-id="' . $obj->id . '" class="btn btn-pill btn-info-light editBtn">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" data-id="' . $obj->id . '" class="btn btn-pill btn-danger-light deleteBtn">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                return $buttons;
            })
            ->addColumn('actions', function ($obj) {
                $buttons = '
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li>
                                <a class="dropdown-item" href="' . route('real_states.show', $obj->id) . '">
                                    <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item editRealStateBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                    <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                </a>
                            </li>

                             <!-- <li>
                                        <a class="dropdown-item" href="' . route('real_states.show', $obj->id) . '#realStateUnits' . '">
                                            <img src="' . asset('assets/greatwall_line.png') . '" style="width: 20px; height: 20px; margin-right: 5px;">
                                            مشاهدة الوحدات
                                        </a>
                                    </li> -->

                            <li>
                                <a class="dropdown-item toggleRealStateStatusBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                    ' . ($obj->status == 1 ? trns('Deactivate real_State') : trns('Activate real_State')) . '
                                </a>
                            </li>
                        </ul>
                    </div>';
                return $buttons;
            })


            ->rawColumns(['status', "actions", 'location'])
            ->make(true);
    }

    public function real_statesOwwnerShip($request, $id)
    {

        $real_state_ids = $this->realState->where('association_id', $id)->pluck('id');
        $usersId = $this->realStateOwner->whereIn('real_state_id', $real_state_ids)->pluck('user_id');
        $owners = $this->user->whereIn('id', $usersId);
        return DataTables::of($owners)
            ->editColumn('name', function ($obj) {
                return $obj->name;
            })
            ->addColumn('status', function ($row) {
                return $row->status ? trns('active') : trns('inactive');
            })
            ->addColumn('email', function ($row) {
                return $row->email ?? '-';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d') ?? '-';
            })->addColumn('actions', function ($obj) {
                $buttons = '
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" style="background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                <li>
                                    <a class="dropdown-item" href="' . route('users.show', $obj->id) . '">
                                        <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                    </a>
                                </li>';

                // if (auth('admin')->user()->can('update_user')) {
                //     $buttons .= '
                //                     <li>
                //                         <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                //                             <img src="'.asset('edit.png').'" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                //                         </a>
                //                     </li>';
                // }

                // if (auth('admin')->user()->can('delete_user')) {
                //     $buttons .= '
                //            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                //                 data-bs-target="#delete_modal" data-id="' . $obj->id . '" data-title="' . $obj->name . '">
                //                 <i class="fas fa-trash"></i> '.trns("delete").'
                //             </button>';
                // }

                $buttons .= '
                                    <li>
                                        <a class="dropdown-item toggleUserStatusBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                            ' . ($obj->status == 1 ? trns("Deactivate_user") : trns("Activate_user")) . '
                                        </a>
                                    </li>
                                </ul>
                            </div>';

                return $buttons;
            })


            ->rawColumns(['status', "actions"])
            ->make(true);
    }




    //  units datatable
    public function getUnits($association_id)
    {

        $units = $this->unit->whereHas('realState', function ($query) use ($association_id) {
            $query->where('association_id', $association_id);
        });
        return DataTables::of($units)
            ->addColumn('status', content: function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge" style="background-color: #6AFFB2; color: #1F2A37; border-radius: 30px">' . trns("Active") . '</span>';
                } else {
                    return '<span class="badge" style="background-color: #FFBABA; color: #1F2A37; border-radius: 30px">' . trns("Inactive") . '</span>';
                }
            })
            ->addColumn('real_state_number', content: function ($row) {
                return $row->RealState ? $row->RealState->real_state_number : '-';
            })->addColumn('real_state_owners_name', content: function ($row) {


                $owners = $row->unitOwners->map(function ($owner) {
                    return [
                        'name' => $owner->user->name ?? 'N/A',
                        'percentage' => $owner->percentage
                    ];
                })->toArray();

                return '
                        <button type="button"
                        class="show-owners-btn"
                        style= "border: 1px solid #06e7c1; border-radius: 50px; background-color: transparent;"
                                data-id="' . $row->id . '"
                                data-owners="' . htmlspecialchars(json_encode($owners), ENT_QUOTES, 'UTF-8') . '"
                                data-bs-toggle="modal"
                                data-bs-target="#show_owners">
                            ' . trns('view_owners') . '
                        </button>
                    ';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d') ?? '-';
            })
            ->addColumn('actions', function ($obj) {
                $buttons = '
                                <div class="dropdown" style="position: relative;">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="' . route('units.show', $obj->id) . '">
                                                <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                                    </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item editUnitsBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                                <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                            </a>
                                        </li>
                                       <li>
                                            <button class="dropdown-item toggleUnitsStatusBtn" id="toggleStatusBtn" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                                ' . ($obj->status == 1 ? trns("Deactivate_units") : trns("Activate_units")) . '
                                            </button>
                                        </li>

                                    </ul>
                                </div>
                            ';
                return $buttons;
            })
            ->rawColumns(['status', 'location', "actions", 'real_state_owners_name'])
            ->make(true);
    }



    // the images datatable
    public function unitsTableOwnerShip($request, $id)
    {

        $real_state_ids = $this->realState->where('association_id', $id)->pluck('id');
        $unitsIds = $this->unit->whereIn('real_state_id', $real_state_ids)->pluck('id');
        $usersId = $this->unitOwner->whereIn('unit_id', $unitsIds)->pluck('user_id');
        $owners = $this->user->whereIn('id', $usersId);
        return DataTables::of($owners)
            ->editColumn('name', function ($obj) {
                return $obj->name;
            })
            ->addColumn('status', function ($row) {
                return $row->status ? trns('active') : trns('inactive');
            })
            ->addColumn('email', function ($row) {
                return $row->email ?? '-';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d') ?? '-';
            })
            ->addColumn('actions', function ($obj) {
                $buttons = '
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" style="background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                                <li>
                                    <a class="dropdown-item" href="' . route('users.show', $obj->id) . '">
                                        <i class="fa-solid fa-eye me-1"></i> ' . trns("View") . '
                                    </a>
                                </li>';
                $buttons .= '
                                <li>
                                    <a class="dropdown-item toggleUserStatusBtn" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                        ' . ($obj->status == 1 ? trns("Deactivate_user") : trns("Activate_user")) . '
                                    </a>
                                </li>
                            </ul>
                        </div>';
                return $buttons;
            })
            ->rawColumns(['status', "actions"])
            ->make(true);
    }







    public function imagesShow($request, $id)
    {
        $association = $this->model->find($id);
        $images = $association->media->where("collection_name", "images");
        return DataTables::of($images)
            ->editColumn("size", function ($image) {
                return $image->size / 1024 . " KB";
            })
            ->addColumn('admin_id', function ($image) {
                return $this->admin->where("id", $image->custom_properties['admin_id'])->first()->name ?? '-';
            })
            ->addColumn('image', function ($image) {
                $url = asset('storage/association/' . $image->model_id . '/images/' . $image->file_name);
                return '
                    <span style="cursor: pointer;" onclick="openModal(\'' . $url . '\')">
                        <i class="fas fa-file"></i>
                    </span>
                ';
            })
            ->addColumn('action', function ($image) {

                $url = asset('storage/association/' . $image->model_id . '/images/' . $image->file_name);
                $buttons = '
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="z-index: 9999; background-color: #EAEAEA; text-align: right;" aria-labelledby="dropdownMenuButton1">
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


    public function associationDeleteImages($request)
    {
        $image = $this->media->where("id", $request->id)->first();
        if ($image) {
            $image->delete();
            return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
        } else {
            return response()->json(['status' => 404, 'message' => trns('image_not_found')]);
        }
    }

    public function AssociationDeletefile($request)
    {
        $image = $this->media->where("id", $request->id)->first();
        if ($image) {
            $image->delete();
            return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
        } else {
            return response()->json(['status' => 404, 'message' => trns('image_not_found')]);
        }
    }

    public function getUsers($id)
    {
        $association = $this->objModel->find($id);

        if (!$association) {
            return response()->json([
                'status' => 404,
                'users' => []
            ]);
        }

        // استدعاء العلاقة مباشرة كـ method
        $users = $association->users()->get(); // users() هنا method مش property

        return response()->json([
            'status' => $users->isNotEmpty() ? 200 : 404,
            'user' => $users
        ]);
    }




    //    associations files
    public function filesShow($id)
    {
        $association = $this->model->find($id);
        $images = $association->media->where("collection_name", "files");
        return DataTables::of($images)
            ->editColumn("size", function ($image) {
                return $image->size / 1024 . " KB";
            })
            ->addColumn('admin_id', function ($image) {
                return $this->admin->where("id", $image->custom_properties['admin_id'])->first()->name ?? '-';
            })
            ->addColumn('image', function ($image) {
                $url = asset('storage/association/' . $image->model_id . '/files/' . $image->file_name);
                return '
                    <span style="cursor: pointer;" onclick="openFileModal(\'' . $url . '\')">
                        <i class="fas fa-file"></i>
                    </span>
                ';
            })
            ->addColumn('action', function ($image) {

                $url = asset('storage/association/' . $image->model_id . '/files/' . $image->file_name);
                $buttons = '
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="z-index: 9999; background-color: rgb(234, 234, 234);; text-align: right;" aria-labelledby="dropdownMenuButton1">
                                        <li class="m-2">
                                                <span style="cursor: pointer; margin-bottom: 10px;" onclick="openFileModal(\'' . $url . '\')">
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
                                            <span class="delete_file" style="cursor: pointer;margin-bottom: 10px;"
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


    public function associationDeleteFiles($request)
    {
        $file = $this->media->where("id", $request->id)->first();
        if ($file) {
            $file->delete();
            return response()->json(['status' => 200, 'message' => trns('deleted_successfully')]);
        } else {
            return response()->json(['status' => 404, 'message' => trns('image_not_found')]);
        }
    }
}
