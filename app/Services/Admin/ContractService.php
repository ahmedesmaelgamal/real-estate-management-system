<?php

namespace App\Services\Admin;

use App\Exports\DynamicModelExport;
use App\Imports\AssociationImport;
use App\Imports\ContractImport;
use App\Imports\PreviewContractImport;
use App\Imports\PreviewAssociationImport;
use App\Models\Admin;
use App\Models\Association;
use App\Models\Contract;
use App\Models\Contract as ObjModel;
use App\Models\ContractPartyDetail;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use App\Models\ContractParty;
use App\Models\ContractType;
use App\Models\ContractName;
use App\Models\ContractTerm;
use App\Models\ContractLocation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\FacadesDB;

class ContractService extends BaseService
{
    protected string $folder = 'admin/contracts';
    protected string $route = 'contracts';

    public function __construct(
        protected ObjModel $objModel,
        protected ContractParty $contractParty,
        protected ContractType $contractType,
        protected ContractName $contractName,
        protected ContractTerm $contractTerms,
        protected ContractLocation $contractLocation,
        protected ContractPartyDetail $contractPartyDetail,
        protected Association $associationModel,
        protected User $userModel,
    ) {
        parent::__construct($objModel);
    }


    public function index($request)
    {
        if ($request->ajax()) {
            $obj = $this->objModel::with([
                'contractType',
                'contractName',
                'contractLocation',
                'contractTerms',
                'firstParties',
                'secondParties',
            ]);

            if ($request->has("user_id") && !empty($request->get("user_id"))) {
                $user_id = $request->user_id;
                $obj = $obj->whereHas('contractPartyDetails', function ($q) use ($user_id) {
                    $q->where('model_id', $user_id)
                        ->where('model_type', User::class);
                });
            }

            if ($request->has("association_id") && !empty($request->get("association_id"))) {
                $association_id = $request->association_id;
                $obj = $obj->where('association_id', $association_id);
            }

            if ($request->filled('keys') && $request->filled('values')) {
                $key = $request->get('keys')[0] ?? null;
                $value = $request->get('values')[0] ?? null;

                if ($key && $value) {
                    switch ($key) {
                        case 'id':
                            $obj->where('id', $value);
                            break;

                        case 'date':
                            $obj->whereDate('date', $value);
                            break;

                        case 'type':
                            $obj->whereHas('contractType', function ($q) use ($value) {
                                $q->where('id', $value);
                            });
                            break;

                        case 'name':
                            $obj->whereHas('contractName', function ($q) use ($value) {
                                $q->where('id', $value);
                            });
                            break;

                        case 'location':
                            $obj->whereHas('contractLocation', function ($q) use ($value) {
                                $q->where('id', $value);
                            });
                            break;

                        case 'first_party':
                            $obj->whereHas('firstParty', function ($q) use ($value) {
                                $q->where('id', $value);
                            });
                            break;

                        case 'second_party':
                            $obj->whereHas('secondParty', function ($q) use ($value) {
                                $q->where('id', $value);
                            });
                            break;

                        default:
                            $obj->where($key, 'like', "%{$value}%");
                            break;
                    }
                }
            }

            $obj->latest();


            return DataTables::of($obj)
                ->editColumn('date', fn($obj) => $obj->date ? $obj->date->format("Y-m-d") : '-')
                ->addColumn('type', fn($obj) => $obj->contractType?->getTranslation("title", app()->getLocale()) ?? '-')
                ->addColumn('name', fn($obj) => $obj->contractName?->getTranslation("name", app()->getLocale()) ?? '-')
                ->addColumn('location', function ($obj) {
                    $lat  = $obj->contractLocation?->lat;
                    $long = $obj->contractLocation?->long;
                    if ($lat && $long) {
                        $url   = "https://www.google.com/maps?q={$lat},{$long}";
                        $title = $obj->contractLocation?->getTranslation("title", app()->getLocale());
                        return "<a class='btn btn-outline-success' href=\"{$url}\" target=\"_blank\">{$title}</a>";
                    }
                    return ($obj->contract_location ?? "-");
                })
                ->addColumn('firstParty', fn($obj) => $obj->firstParties->first()?->party_name ?? '-')
                ->addColumn('secondParty', fn($obj) => $obj->secondParties->first()?->party_name ?? '-')
                ->addColumn('action', function ($obj) {
                    $buttons = '
                <div class="dropdown">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton' . $obj->id . '"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        style="background-color: transparent; border: none;">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu" style="z-index: 99999; background-color: #EAEAEA;"
                        aria-labelledby="dropdownMenuButton' . $obj->id . '">
                        <li>
                            <a class="dropdown-item " href="' . route('contracts.show', $obj->id) . '" data-id="' . $obj->id . '">
                                <i class="fa fa-eye"></i> ' . trns("see") . '
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item editBtn editcontractBtn" href="javascript:void(0);" data-id="' . $obj->id . '">
                                <img src="' . asset('edit.png') . '" alt="no-icon" class="img-fluid ms-1"
                                style="width: 24px; height: 24px;"> ' . trns("Edit") . '
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item " target="_blank" href="' . route("contracts.download", $obj->id) . '" data-id="' . $obj->id . '">
                                ' . trns("donwload_contract") . '
                            </a>
                        </li>

                        <li>
                            <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                data-bs-target="#delete_modal" data-id="' . $obj->id . '"
                                data-title="' . $obj->getTranslation('title', app()->getLocale()) . '">
                                <i class="fas fa-trash"></i> ' . trns("delete") . '
                            </button>
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
            "types" => $this->contractType->get(),
            "names" => $this->contractName->get(),
            "locations" => $this->contractLocation->get(),
            "terms" => $this->contractTerms->get(),
            "parties" => $this->contractPartyDetail->where('party_type', 'first')->get(),
            "secondParties" => $this->contractPartyDetail->where('party_type', 'second')->get(),
        ]);
    }






    public function create()
    {
        return view("{$this->folder}/parts/create", [
            'storeRoute' => route("{$this->route}.store"),
            'contracts'         => $this->objModel->get(),
            'parties'           => $this->contractParty->get(),
            'contractTypes'     => $this->contractType->get(),
            'contractNames'     => $this->contractName->get(),
            'contractTerms'     => [],
            'contractLocations' => $this->contractLocation->get(),
            'associations' => $this->associationModel->get(),
            'users' => $this->userModel->get(),
        ]);
    }


    public function createByAssociation()
    {
        return view("{$this->folder}/parts/associationCreate", [
            'storeRoute' => route("{$this->route}.store"),
            'contracts'         => $this->objModel->get(),
            'parties'           => $this->contractParty->get(),
            'contractTypes'     => $this->contractType->get(),
            'contractNames'     => $this->contractName->get(),
            'contractTerms'     => $this->contractTerms->get(),
            'contractLocations' => $this->contractLocation->get(),
            'associations' => $this->associationModel->get(),
            'users' => $this->userModel->get(),
        ]);
    }

    public function store($data)
    {


        try {
            DB::beginTransaction();

            $contract = $this->objModel->create([
                'contract_type_id'         => $data['contract_type_id'],
                'contract_name_id'         => $data['contract_name_id'],
                'contract_location_id'     => $data['contract_location_id'] == 'other' ? null : $data['contract_location_id'],
                'contract_location'        => $data['contract_location_id'] == 'other' ? $data['contract_location'] : null,
                'contract_first_party_id'  => $data['contract_party_id'],
                'contract_second_party_id' => $data['contract_party_two_id'],
                'date'                     => $data['date'],
                'introduction'             => $data['introduction'] ?? null,
                'contract_address'         => $data['contract_address'] ?? null,
                'association_id'           => $data['association_id'] ?? null,
            ]);


            if (!empty($data['images'])) {
                $this->storeMediaLibrary($data['images'], $contract, "images", "images");
            }

            if (!empty($data['contract_term_id'])) {
                $termIds = $data['contract_term_id'];

                $contract->contractTerms()->sync($termIds);

                \App\Models\ContractTerm::whereIn('id', $termIds)
                    ->update([
                        "taken"      => 1,
                        "session_id" => null,
                    ]);
            }

            // Terms (many to many)
            // if (!empty($data['contract_term_id'])) {
            //     $contract->contractTerms()->sync($data['contract_term_id']);
            // }

            // foreach ($data["contract_term_id"] as $termId) {
            //     $term = $this->contractTerms->find($termId);
            //     $term->update([
            //         "taken" => 1
            //     ]);
            // }

            if (!empty($data['contract_type'])) {
                $contract->contract_type = $data['contract_type'];
            }

            if ($data["contract_type"] === "association") {
                // if the contract is with association
                if (!empty($data['association_id'])) {

                    $contract["association_id"] = $data['association_id'];
                    // First Party details
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'      => $data['association_admin_id'] ?? null,
                        'model_type'      => \App\Models\Admin::class ?? null,
                        'party_name'      => $data['party_name']['first'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['first'] ?? null,
                        'party_phone'     => $data['party_phone']['first'] ?? null,
                        'party_email'     => $data['party_email']['first'] ?? null,
                        'party_address'   => $data['party_address']['first'] ?? null,
                        'party_type'      => 'first',
                    ]);


                    // Second Party details
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'      => $data['contract_party_two_id'] ?? null,
                        'model_type'      => \App\Models\ContractParty::class ?? null,
                        'party_name'      => $data['party_name']['second'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['second'] ?? null,
                        'party_phone'     => $data['party_phone']['second'] ?? null,
                        'party_email'     => $data['party_email']['second'] ?? null,
                        'party_address'   => $data['party_address']['second'] ?? null,
                        'party_type'      => 'second',
                    ]);
                }
            } else if ($data["contract_type"] === "owners_with_owner") {
                $contract["association_id"] = $data['user_association_id'];
                // First Party details
                $first_detail = $this->contractPartyDetail->create([
                    'contract_id'     => $contract->id,
                    'model_id'      => $data['first_association_user_id'] ?? null,
                    'model_type'      => \App\Models\User::class ?? null,
                    'party_name'      => $data['party_name']['first'] ?? null,
                    'party_nation_id' => $data['party_nation_id']['first'] ?? null,
                    'party_phone'     => $data['party_phone']['first'] ?? 0000000,
                    'party_email'     => $data['party_email']['first'] ?? null,
                    'party_address'   => $data['party_address']['first'] ?? null,
                    'party_type'      => 'first',
                ]);

                // Second Party details
                $second_detail = $this->contractPartyDetail->create([
                    'contract_id'     => $contract->id,
                    'model_id'      => $data['second_association_user_id'] ?? null,
                    'model_type'      => \App\Models\User::class ?? null,
                    'party_name'      => $data['party_name']['second'] ?? null,
                    'party_nation_id' => $data['party_nation_id']['second'] ?? null,
                    'party_phone'     => $data['party_phone']['second'] ?? 0000000,
                    'party_email'     => $data['party_email']['second'] ?? null,
                    'party_address'   => $data['party_address']['second'] ?? null,
                    'party_type'      => 'second',
                ]);
            } else if ($data["contract_type"] === "owners_with_partner") {
                $contract["association_id"] = $data['user_partner_association_id'];
                // First Party details
                $first_detail = $this->contractPartyDetail->create([
                    'contract_id'     => $contract->id,
                    'model_id'      => $data['first_association_user_id'] ?? null,
                    'model_type'      => \App\Models\User::class ?? null,
                    'party_name'      => $data['party_name']['first'] ?? null,
                    'party_nation_id' => $data['party_nation_id']['first'] ?? null,
                    'party_phone'     => $data['party_phone']['first'] ?? 0000000,
                    'party_email'     => $data['party_email']['first'] ?? null,
                    'party_address'   => $data['party_address']['first'] ?? null,
                    'party_type'      => 'first',
                ]);

                // Second Party details
                $second_detail = $this->contractPartyDetail->create([
                    'contract_id'     => $contract->id,
                    'model_id'      => $data['contract_party_two_id'] ?? null,
                    'model_type'      => \App\Models\ContractParty::class ?? null,
                    'party_name'      => $data['party_name']['second'] ?? null,
                    'party_nation_id' => $data['party_nation_id']['second'] ?? null,
                    'party_phone'     => $data['party_phone']['second'] ?? 0000000,
                    'party_email'     => $data['party_email']['second'] ?? null,
                    'party_address'   => $data['party_address']['second'] ?? null,
                    'party_type'      => 'second',
                ]);
            } else {
                $firstDetals = $this->contractPartyDetail->create([
                    'contract_id'     => $contract->id,
                    'model_id'      => $data['contract_party_id'] ?? null,
                    'model_type'      => \App\Models\ContractParty::class ?? null,
                    'party_name'      => $data['party_name']['first'] ?? null,
                    'party_nation_id' => $data['party_nation_id']['first'] ?? null,
                    'party_phone'     => $data['party_phone']['first'] ?? null,
                    'party_email'     => $data['party_email']['first'] ?? null,
                    'party_address'   => $data['party_address']['first'] ?? null,
                    'party_type'      => 'first',
                ]);

                // Second Party details
                $secondDetails = $this->contractPartyDetail->create([
                    'contract_id'     => $contract->id,
                    'model_id'      => $data['contract_party_two_id'] ?? null,
                    'model_type'      => \App\Models\ContractParty::class ?? null,
                    'party_name'      => $data['party_name']['second'] ?? null,
                    'party_nation_id' => $data['party_nation_id']['second'] ?? null,
                    'party_phone'     => $data['party_phone']['second'] ?? null,
                    'party_email'     => $data['party_email']['second'] ?? null,
                    'party_address'   => $data['party_address']['second'] ?? null,
                    'party_type'      => 'second',
                ]);

                // dd($firstDetals , $secondDetails , $data);
            }

            // dd($data);

            $contract->save();


            // if (!empty($data['users_id'])) {
            //     $contract->users()->sync($data['users_id']);
            // } else {
            //     $contract->users()->detach();
            // }

            DB::commit();

            return response()->json([
                'status'    => 200,
                'mymessage' => trns('Data updated successfully.'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'mymessage' => trns("Data could not be stored."),
                'error' => $e->getMessage()
            ], 500);
        }
    }





    public function singlePageCreate()
    {
        return view("{$this->folder}/parts/singlePageCreate", [
            'storeRoute'        => route("{$this->route}.store"),
            'contracts'         => $this->objModel->get(),
            'parties'           => $this->contractParty->get(),
            'contractTypes'     => $this->contractType->get(),
            'contractNames'     => $this->contractName->get(),
            'contractTerms'     => [],
            'contractLocations' => $this->contractLocation->get(),
            'associations' => $this->associationModel->get(),
            'users' => $this->userModel->get(),
        ]);
    }

    public function show($obj)
    {
        return view("{$this->folder}/parts/show", [
            'obj' => $obj,
            'route' => 'contract.show',
            "editRoute" => "associations",
            "types" => $this->contractType->get(),
            "names" => $this->contractName->get(),
            "locations" => $this->contractLocation->get(),
            "terms" => $this->contractTerms->get(),
            "parties" => $this->contractPartyDetail->where('party_type', 'first')->get(),
            "secondParties" => $this->contractPartyDetail->where('party_type', 'second')->get(),
            "first_party" => $this->contractParty->where('id', $obj->contract_first_party_id)->first(),
            "second_party" => $this->contractParty->where('id', $obj->contract_second_party_id)->first(),

        ]);
    }

    public function edit($obj)
    {
        return view("{$this->folder}/parts/edit", [
            'obj' => $obj,
            'updateRoute' => route("{$this->route}.update", $obj->id),
            'contractTypes' => $this->contractType->get(),
            'contractNames' => $this->contractName->get(),
            'contractLocations' => $this->contractLocation->get(),
            'parties' => $this->contractParty->get(),
            'contractTerms' => $obj->contractTerms,
            'associations' => $this->associationModel->get(),
            'users' => $this->userModel->get(),
        ]);
    }

    public function update($data, $id)
    {
        $contract = $this->getById($id);

        try {
            DB::beginTransaction();

            $contract->update([
                'contract_type_id'         => $data['contract_type_id'],
                'contract_name_id'         => $data['contract_name_id'],
                'contract_location_id'     => $data['contract_location_id'] === 'other' ? null : $data['contract_location_id'],
                'contract_location'        => $data['contract_location_id'] === 'other' ? $data['contract_location'] : null,
                'contract_first_party_id'  => $data['contract_party_id'],
                'contract_second_party_id' => $data['contract_party_two_id'],
                'date'                     => $data['date'],
                'introduction'             => $data['introduction'] ?? null,
                'contract_address'         => $data['contract_address'] ?? null,
                'contract_type'            => $data['contract_type'] ?? $contract->contract_type,
            ]);


            if (isset($data['existing_images'])) {
                $contract->getMedia('images')->whereNotIn('id', $data['existing_images'])->each->delete();
            }

            if (isset($data['new_images'])) {
                $this->storeMediaLibrary($data['new_images'], $contract, "images", "images", false);
            }

            $contract->contractTerms()->sync($data['contract_term_id'] ?? []);

            foreach ($data["contract_term_id"] as $termId) {
                $term = $this->contractTerms->find($termId);
                $term->update([
                    "taken" => 1
                ]);
            }


            $contract->contractPartyDetails()->delete();

            switch ($data["contract_type"]) {
                case "association":
                    $contract["association_id"] = $data['association_id'] ?? null;

                    // الطرف الأول
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'        => $data['association_admin_id'] ?? null,
                        'model_type'      => \App\Models\Admin::class,
                        'party_name'      => $data['party_name']['first'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['first'] ?? null,
                        'party_phone'     => $data['party_phone']['first'] ?? null,
                        'party_email'     => $data['party_email']['first'] ?? null,
                        'party_address'   => $data['party_address']['first'] ?? null,
                        'party_type'      => 'first',
                    ]);

                    // الطرف الثاني
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'        => $data['contract_party_two_id'] ?? null,
                        'model_type'      => \App\Models\ContractParty::class,
                        'party_name'      => $data['party_name']['second'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['second'] ?? null,
                        'party_phone'     => $data['party_phone']['second'] ?? null,
                        'party_email'     => $data['party_email']['second'] ?? null,
                        'party_address'   => $data['party_address']['second'] ?? null,
                        'party_type'      => 'second',
                    ]);
                    break;

                case "owners_with_owner":
                    $contract["association_id"] = $data['user_association_id'] ?? null;

                    // الطرف الأول
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'        => $data['first_association_user_id'] ?? null,
                        'model_type'      => \App\Models\User::class,
                        'party_name'      => $data['party_name']['first'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['first'] ?? null,
                        'party_phone'     => $data['party_phone']['first'] ?? 0000000,
                        'party_email'     => $data['party_email']['first'] ?? null,
                        'party_address'   => $data['party_address']['first'] ?? null,
                        'party_type'      => 'first',
                    ]);

                    // الطرف الثاني
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'        => $data['second_association_user_id'] ?? null,
                        'model_type'      => \App\Models\User::class,
                        'party_name'      => $data['party_name']['second'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['second'] ?? null,
                        'party_phone'     => $data['party_phone']['second'] ?? 0000000,
                        'party_email'     => $data['party_email']['second'] ?? null,
                        'party_address'   => $data['party_address']['second'] ?? null,
                        'party_type'      => 'second',
                    ]);
                    break;

                case "owners_with_partner":
                    $contract["association_id"] = $data['user_partner_association_id'] ?? null;

                    // الطرف الأول
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'        => $data['first_association_user_id'] ?? null,
                        'model_type'      => \App\Models\User::class,
                        'party_name'      => $data['party_name']['first'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['first'] ?? null,
                        'party_phone'     => $data['party_phone']['first'] ?? 0000000,
                        'party_email'     => $data['party_email']['first'] ?? null,
                        'party_address'   => $data['party_address']['first'] ?? null,
                        'party_type'      => 'first',
                    ]);

                    // الطرف الثاني
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'        => $data['contract_party_two_id'] ?? null,
                        'model_type'      => \App\Models\ContractParty::class,
                        'party_name'      => $data['party_name']['second'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['second'] ?? null,
                        'party_phone'     => $data['party_phone']['second'] ?? 0000000,
                        'party_email'     => $data['party_email']['second'] ?? null,
                        'party_address'   => $data['party_address']['second'] ?? null,
                        'party_type'      => 'second',
                    ]);
                    break;

                default:
                    // النوع العام
                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'        => $data['contract_party_id'] ?? null,
                        'model_type'      => \App\Models\ContractParty::class,
                        'party_name'      => $data['party_name']['first'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['first'] ?? null,
                        'party_phone'     => $data['party_phone']['first'] ?? null,
                        'party_email'     => $data['party_email']['first'] ?? null,
                        'party_address'   => $data['party_address']['first'] ?? null,
                        'party_type'      => 'first',
                    ]);

                    $this->contractPartyDetail->create([
                        'contract_id'     => $contract->id,
                        'model_id'        => $data['contract_party_two_id'] ?? null,
                        'model_type'      => \App\Models\ContractParty::class,
                        'party_name'      => $data['party_name']['second'] ?? null,
                        'party_nation_id' => $data['party_nation_id']['second'] ?? null,
                        'party_phone'     => $data['party_phone']['second'] ?? null,
                        'party_email'     => $data['party_email']['second'] ?? null,
                        'party_address'   => $data['party_address']['second'] ?? null,
                        'party_type'      => 'second',
                    ]);
                    break;
            }

            $contract->save();

            DB::commit();

            return response()->json([
                'status'    => 200,
                'mymessage' => trns('Data updated successfully.'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'    => 500,
                'mymessage' => trns('Something went wrong.'),
                'error'     => $e->getMessage(),
            ], 500);
        }
    }


    public function getContractNames($typeId)
    {
        $locale = app()->getLocale();
        $names = $this->contractType->find($typeId)?->Names()
            ->get()
            ->map(function ($item) use ($locale) {
                return [
                    'id' => $item->id,
                    'name' => $item->getTranslation('name', $locale)
                ];
            });

        return response()->json($names);
    }



    public function exportExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $export = new DynamicModelExport(\App\Models\Contract::class);
        $fileName = 'contracts' . date('Y-m-d') . '.xlsx';
        return Excel::download($export, $fileName);
    }
    public function addExcel()
    {
        return view("{$this->folder}/parts/addExcel", [
            'storeExcelRoute' => route("{$this->route}.store.excel"),
        ]);
    }

    public function storeExcel(Request $request)
    {
        $request->validate([
            'contract_excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('contract_excel_file');

            // Step 1: Preview the rows
            $preview = new PreviewContractImport();
            Excel::import($preview, $file);
            $rows = $preview->rows;


            $errors = [];
            $contractsData = [];

            foreach ($rows as $index => $row) {

                // Columns to check (first 5)
                $firstFiveColumns = [
                    'contract_type',
                    'contract_name',
                    'contract_location',
                    'first_party_name',
                    'second_party_name',
                ];

                // Check if all first 5 columns are empty
                $allEmpty = true;
                foreach ($firstFiveColumns as $col) {
                    if ($row->get($col)) {
                        $allEmpty = false;
                        break;
                    }
                }

                if ($allEmpty) {
                    // Stop processing at this row (don't throw error, just break)
                    break;
                }

                // Lookup IDs from names
                $contractType = \App\Models\ContractType::where('title->ar', $row->get('contract_type'))
                    ->orWhere('title->en', $row->get('contract_type'))->first();

                $contractName = \App\Models\ContractName::where('name->ar', $row->get('contract_name'))
                    ->orWhere('name->en', $row->get('contract_name'))->first();

                $contractLocation = \App\Models\ContractLocation::where('title->ar', $row->get('contract_location'))
                    ->orWhere('title->en', $row->get('contract_location'))->first();

                $contractFirstId = \App\Models\ContractParty::where('title->ar', $row->get('contract_first_party_title'))
                    ->orWhere('title->en', $row->get('contract_first_party_title'))->first();

                $contractSecondId = \App\Models\ContractParty::where('title->ar', $row->get('contract_second_party_title'))
                    ->orWhere('title->en', $row->get('contract_second_party_title'))->first();

                $contractsData[] = [
                    'row' => $row,
                    'contract_type_id' => $contractType->id ?? null,
                    'contract_first_party_id' => $contractFirstId->id ?? null,
                    'contract_second_party_id' => $contractSecondId->id ?? null,
                    'contract_name_id' => $contractName->id ?? null,
                    'contract_location_id' => $contractLocation->id ?? null,
                ];
            }


            if (!empty($errors)) {
                return response()->json([
                    'status' => 422,
                    'message' => $errors
                ], 422);
            }

            // Step 2: Store contracts
            foreach ($contractsData as $data) {
                DB::beginTransaction();

                $row = $data['row'];

                // Create contract
                $contract = $this->objModel->create([
                    'contract_type_id' => $data['contract_type_id'],
                    'contract_name_id' => $data['contract_name_id'],
                    'contract_location_id' => $data['contract_location_id'],
                    'contract_first_party_id' => $data['contract_first_party_id'],
                    'contract_second_party_id' => $data['contract_second_party_id'],
                    'date' => $row['date'],
                    'introduction' => $row['introduction'] ?? null,
                    'contract_address' => $row['contract_address'] ?? null,
                ]);

                // Terms (comma-separated names)
                if (!empty($row['terms'])) {
                    $termNames = explode(',', $row['terms']);

                    $termIds = [];
                    foreach ($termNames as $termName) {
                        $term = \App\Models\ContractTerm::where('title->ar', $termName)
                            ->orWhere('title->en', $termName)
                            ->first();

                        if ($term) {
                            // Combine title + description like in export
                            $termIds[$term->id] = [
                                'term_text' => ($term->getTranslation('title', app()->getLocale()) ?? '-')
                                    . ' : ' . ($term->description ?? '')
                            ];
                        }
                    }

                    // Sync with pivot table (with extra field term_text)
                    $contract->contractTerms()->sync($termIds);
                }



                // First party
                $this->contractPartyDetail->create([
                    'contract_id' => $contract->id,
                    'party_name' => $row['first_party_name'] ?? null,
                    'party_nation_id' => $row['first_party_nation_id'] ?? null,
                    'party_phone' => $row['first_party_phone'] ?? null,
                    'party_email' => $row['first_party_email'] ?? null,
                    'party_address' => $row['first_party_address'] ?? null,
                    'party_type' => 'first',
                ]);

                // Second party
                $this->contractPartyDetail->create([
                    'contract_id' => $contract->id,
                    'party_name' => $row['second_party_name'] ?? null,
                    'party_nation_id' => $row['second_party_nation_id'] ?? null,
                    'party_phone' => $row['second_party_phone'] ?? null,
                    'party_email' => $row['second_party_email'] ?? null,
                    'party_address' => $row['second_party_address'] ?? null,
                    'party_type' => 'second',
                ]);

                DB::commit();
            }

            return response()->json([
                'status' => 200,
                'message' => __('Contracts imported successfully.')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => __('An error occurred during import.'),
                'error' => $e->getMessage()
            ]);
        }
    }

    public function download($id)
    {
        $contract = Contract::with([
            'contractType',
            'contractName',
            'contractLocation',
            'contractTerms',
            'firstParties',
            'secondParties'
        ])->findOrFail($id);

        return view('admin.contracts.parts.report', compact('contract'));
    }
}
