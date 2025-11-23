<?php

namespace App\Services\Admin;

use App\Exports\DynamicModelExport;
use App\Imports\CourtCaseImports;
use App\Models\Association;
use App\Models\CaseType;
use App\Models\CourtCase;
use App\Models\JudiciatyType;
use App\Models\Meeting;
use App\Models\RealState;
use App\Models\topic_has_meet;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class CourtCasesService extends BaseService
{
    protected string $folder = 'admin/court_case';
    protected string $route = 'court_case';
    public function __construct(
        protected CourtCase $objModel,
        protected User $users,
        protected CaseType $caseTypes,
        protected JudiciatyType $JudiciatyType,
        protected Association $assocation,
        protected RealState $realState,
    ) {
        parent::__construct($objModel);
    }

    public function index($request)
    {
        if ($request->ajax()) {
            $case = 0;

            $obj = $this->objModel::with([
                'caseType',
                'judiciatyType',
                'association',
                'owner',
                'unit',
                'caseUpdates',
            ]);


            if ($request->filled('keys') && $request->filled('values')) {
                $key = $request->get('keys')[0] ?? null;
                $value = $request->get('values')[0] ?? null;

                if ($key && $value) {
                    switch ($key) {
                        case 'case_number':
                            $obj->where('case_number', $value);
                            break;

                        case 'case_date':
                            $obj->whereDate('case_date', $value);
                            break;

                        case 'case_type':
                            $obj->whereHas('caseType', function ($q) use ($value) {
                                $q->where('id', $value);
                            });
                            break;

                        case 'owner_id':
                            $obj->whereHas('owner', function ($q) use ($value) {
                                $q->where('id', $value);
                            });
                            break;

                        case 'RealState_name':
                            $obj->whereHas('unit', function ($q) use ($value) {
                                $q->whereHas('realState', function ($subQ) use ($value) {
                                    $subQ->where('real_state.id', $value); // Specify the table name
                                });
                            });
                            break;
                        default:
                            $obj->where($key, 'like', "%{$value}%");
                            break;
                    }
                }
            }


            if ($request->has('user_id') && $request->filled('user_id')) {
                $obj->where('owner_id', $request->user_id);
            }

            $obj->latest();




            // $obj = $this->getDataTable(); // الدالة دي بترجع query model

            return DataTables::of($obj)
                ->addColumn('case_type', fn($obj) => $obj->caseType?->getTranslation('title', app()->getLocale()))
                ->editColumn('unit_id', function ($obj) {
                    return $obj?->unit?->RealState?->getTranslation("name", app()->getLocale());
                })
                ->editColumn('owner_id', fn($obj) => $obj->owner?->name ?? '-')
                ->editColumn("created_at", function ($obj) {
                    return $obj->created_at->format("Y-m-d");
                })
                ->addColumn('action', function ($obj) use ($case) {

                    $buttons = '
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; border: none;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;" aria-labelledby="dropdownMenuButton' . $obj->id . '">
                            <li><a class="dropdown-item" href="' . route('court_case.show', $obj->id) . '"><i class="fa fa-eye"></i> ' . trns("see") . '</a></li>
                            <li>
                                <a class="dropdown-item editBtn editCaseBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                    <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1" style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                                </a>
                            </li>
                            <li> 
                                <button class="dropdown-item courtCaseDeleteBtn text-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete_modal" data-id="' . $obj->id . '" >
                                    <i class="fas fa-trash"></i> ' . trns("delete") . '
                                </button>
                            </li>
                            <li>
                                <a class="dropdown-item openStatusModel togglecaseStatus" href="javascript:void(0);" data-id="' . $obj->id . '" data-status="' . $obj->status . '">
                                    ' . ($obj->status == 1 ? trns('Deactivate_court_case') : trns('Activate_court_case')) . '
                                </a>
                            </li>
                            
                            
                        </ul>
                    </div>';

                    return $buttons;
                })
                ->addIndexColumn()
                ->escapeColumns([])
                ->make(true);
        }

        return view($this->folder . '/index', [
            'createRoute' => route($this->route . '.create'),
            'bladeName'   => trns($this->route),
            'route'       => $this->route,
            'case_types'       => $this->caseTypes->get(),
            'users'       => $this->users->get(),
            'realStates'       => $this->realState->get(),
        ]);
    }
    public function show($id)
    {
        $obj = $this->objModel->with("unit", "owner", "association", "judiciatyType", "caseType", "caseUpdates")->find($id);

        return  view("{$this->folder}/parts/show", [
            'obj'           => $obj,
            'route'         => $this->route,
            'editRoute'     => $this->route,
        ]);
    }
    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            "case_types" => $this->caseTypes->get(),
            "judiciatyType" => $this->JudiciatyType->where("status", 1)->get(),
            "associations" => $this->assocation->get(),
        ]);
    }
    public function singlePageCreate()
    {
        return view("{$this->folder}/parts/singlePageCreate", [
            'storeRoute' => route("{$this->route}.store"),
            "case_types" => $this->caseTypes->get(),
            "judiciatyType" => $this->JudiciatyType->where("status", 1)->get(),
            "associations" => $this->assocation->get(),
        ]);
    }
    public function store($data)
    {
        try {

            $fromSinglePage = $data['singlePage'] ?? 0;

            $data = collect($data)->except("singlePage")->toArray();

            $data['status'] = 1;

            $filesData = $data['files'] ?? null;

            $mainData = collect($data)->except("files")->toArray();

            $courtCase = $this->createData($mainData);

            if (!empty($filesData)) {
                $this->storeMediaLibrary($filesData, $courtCase, "files", "files");
            }

            // if ($fromSinglePage) {
            //     return redirect()->route("court_case.singlePageCreate")->with(trns('Data created successfully.'));
            // }

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
            "case_types" => $this->caseTypes->get(),
            "judiciatyType" => $this->JudiciatyType->where("status", 1)->get(),
            "associations" => $this->assocation->get(),
        ]);
    }
    public function update($data, $id)
    {

        $oldObj = $this->getById($id);

        $filesData = $data['new_files'] ?? null;

        if (isset($data['existing_files'])) {
            $oldObj->getMedia('files')->whereNotIn('id', $data['existing_files'])->each->delete();
        }

        if (isset($data['new_files'])) {
            $this->storeMediaLibrary($filesData, $oldObj, "files", "files", true);
        }

        try {
            $oldObj->update($data);
            return response()->json(['status' => 200, 'message' => trns('Data updated successfully.')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => trns('Something went wrong.'), trns('error') => $e->getMessage()]);
        }
    }

    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $export = new DynamicModelExport(\App\Models\CourtCase::class);
        $fileName = 'court_case' . date('Y-m-d') . '.xlsx';
        return Excel::download($export, $fileName);
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
            'court_case_excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        // try {
        $file = $request->file('court_case_excel_file');

        // Step 1: Preview the rows
        $preview = new CourtCaseImports();
        Excel::import($preview, $file);
        $rows = $preview->rows;
        // dd("importer loaded", $rows, $preview);


        $errors = [];
        $casesData = [];

        // dd($rows);
        foreach ($rows as $index => $row) {

            // Columns to check - if all empty break
            $importantColumns = [
                'case_number',
                'case_type',
                'judiciaty_type',
                'association',
                'unit_number',
            ];

            $allEmpty = true;
            foreach ($importantColumns as $col) {
                if ($row->get($col)) {
                    $allEmpty = false;
                    break;
                }
            }

            if ($allEmpty) {
                break; // Stop import
            }

            // Lookup related models
            $caseType = \App\Models\CaseType::where('title->ar', $row->get('case_type'))
                ->orWhere('title->en', $row->get('case_type'))
                ->first();
            // dd($caseType);

            $judiciatyType = \App\Models\JudiciatyType::where('title->ar', $row->get('judiciaty_type'))
                ->orWhere('title->en', $row->get('judiciaty_type'))
                ->first();

            $association = \App\Models\Association::where('name->ar', $row->get('association'))
                ->orWhere('name->en', $row->get('association'))
                ->first();

            $owner = \App\Models\Association::where('name->ar', $row->get('owner'))
                ->orWhere('name->en', $row->get('owner'))
                ->first();

            $unit = \App\Models\Unit::where('unit_number', $row->get('unit_number'))
                ->first();

            $casesData[] = [
                'row' => $row,
                'case_type_id'      => $caseType->id ?? null,
                'judiciaty_type_id' => $judiciatyType->id ?? null,
                'association_id'    => $association->id ?? null,
                'owner_id'          => $owner->id ?? null,
                'unit_id'           => $unit->id ?? null,
            ];
        }


        if (!empty($errors)) {
            return response()->json([
                'status' => 422,
                'message' => $errors
            ], 422);
        }

        // Step 2: Store court cases
        // Step 2: Store court cases
        foreach ($casesData as $data) {

            $row = $data['row'];

            // Skip missing required columns
            if (
                empty($row['case_number']) ||
                empty($data['case_type_id']) ||
                empty($data['judiciaty_type_id']) ||
                empty($data['association_id']) ||
                empty($data['unit_id'])
            ) {
                continue; // IGNORE this row
            }

            DB::beginTransaction();

            try {

                $courtCase = $this->objModel->create([
                    'case_number'       => $row['case_number'],
                    'case_type_id'      => $data['case_type_id'],
                    'judiciaty_type_id' => $data['judiciaty_type_id'],
                    'association_id'    => $data['association_id'],
                    'owner_id'          => $data['owner_id'],   // can be null
                    'unit_id'           => $data['unit_id'],

                    'case_date'         => $row['case_date'] ?? null,
                    'case_price'        => $row['case_price'] ?? null,
                    'judiciaty_date'    => $row['judiciaty_date'] ?? null,
                    'topic'             => $row['topic'] ?? null,
                    'description'       => $row['description'] ?? null,
                ]);

                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                // Skip row that failed, do NOT stop process
                continue;
            }
        }

        return response()->json([
            'status' => 200,
            'message' => __('Court cases imported successfully.')
        ]);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'status' => 500,
        //         'message' => __('An error occurred during import.'),
        //         'error' => $e->getMessage()
        //     ]);
        // }
    }
}
