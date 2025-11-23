<?php

namespace App\Imports;

use App\Models\Association;
use App\Models\RealState;
use App\Models\RealStateDetail;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DynamicModelImport implements ToCollection, WithValidation, WithHeadingRow
{
    protected $modelClass;
    protected $uniqueIdentifier;
    protected $requiredFields = [];
    protected $fieldRules = [];
    protected $fieldMapping = [];
    protected $customValidationMessages = [];

    public function __construct($modelClass, $uniqueIdentifier = null)
    {

        $this->modelClass = $modelClass;
        $this->uniqueIdentifier = $uniqueIdentifier ?? $this->getDefaultUniqueIdentifier();
        $this->initializeValidation();
    }

 public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new \Exception("No data found in the file");
        }
        $firstRow = $rows->first()->toArray();
        $availableColumns = array_keys($firstRow);
        $mappedColumns = $this->getMappedColumns($availableColumns);

        $this->validateRequiredColumns($mappedColumns);

        foreach ($rows as $index => $row) {
            if ($this->modelClass === Association::class) {
                $this->processAssociationRow($row, $mappedColumns, $index);
            } elseif ($this->modelClass === Unit::class) {
                $this->processUnitRow($row, $mappedColumns, $index);
            } elseif ($this->modelClass === RealState::class) {
                $this->processRealStateRow($row, $mappedColumns, $index);
            }
        }
    }


    protected function getDefaultUniqueIdentifier()
    {
        return [
            User::class => 'email',
            Association::class => 'unified_number',
            Unit::class => 'unit_number',
            RealState::class => 'real_state_number'
        ][$this->modelClass] ?? 'id';

    }

    protected function initializeValidation()
    {
        if ($this->modelClass == Association::class) {
            $this->setupAssociationValidation();


        } elseif ($this->modelClass === Unit::class) {
            $this->setupUnitValidation();
        } elseif ($this->modelClass === RealState::class) {
            $this->setupRealStateValidation();
        }
    }

    protected function setupAssociationValidation()
    {
        $this->requiredFields = [
            'name_ar',
            'name_en',
            'number',
            'unified_number',
            'establish_number',
            'establish_date',
            'due_date',
            'association_manager_email'
        ];

        $this->fieldRules = [
            'name_en' => 'required|max:255',
            'name_ar' => 'required|max:255',
            'number' => 'required|max:50',
            'unified_number' => 'required|max:50',
            'establish_number' => 'required|max:50',
            'establish_date' => 'required|date',
            'due_date' => 'required|date|after:establish_date',
            'approval_date' => 'nullable|date',
            'status' => 'required|boolean',
            'interception_reason' => 'nullable|max:255',
            'monthly_fees' => 'required|numeric|min:0',
            'is_commission' => 'required|boolean',
            'commission_name' => 'nullable|max:255',
            'commission_type' => 'nullable|boolean|required_if:is_commission,1',
            'commission_percentage' => 'nullable|numeric|between:0,100|required_if:is_commission,1',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'logo' => 'nullable|max:255',
            'association_manager_email' => 'required|email|exists:admins,email',
        ];

        $this->customValidationMessages = [
            'name_en.required' => trns('name_en_is_required'),
            'name_en.max' => trns('name_en_may_not_be_greater_than_255_characters'),
            'name_ar.required' => trns('name_ar_is_required'),
            'name_ar.max' => trns('name_ar_may_not_be_greater_than_255_characters'),
            'number.required' => trns('number_is_required'),
            'number.max' => trns('number_may_not_be_greater_than_50_characters'),
            'unified_number.required' => trns('unified_number_is_required'),
            'unified_number.max' => trns('unified_number_may_not_be_greater_than_50_characters'),
            'establish_number.required' => trns('establish_number_is_required'),
            'establish_number.max' => trns('establish_number_may_not_be_greater_than_50_characters'),
            'establish_date.required' => trns('establish_date_is_required'),
            'establish_date.date' => trns('establish_date_must_be_valid'),
            'due_date.required' => trns('due_date_is_required'),
            'due_date.date' => trns('due_date_must_be_valid'),
            'due_date.after' => trns('due_date_must_be_after_establish_date'),
            'approval_date.date' => trns('approval_date_must_be_valid'),
            'status.required' => trns('status_is_required'),
            'status.boolean' => trns('status_must_be_boolean'),
            'interception_reason.max' => trns('interception_reason_may_not_be_greater_than_255_characters'),
            'monthly_fees.required' => trns('monthly_fees_are_required'),
            'monthly_fees.numeric' => trns('monthly_fees_must_be_number'),
            'monthly_fees.min' => trns('monthly_fees_must_be_at_least_0'),
            'is_commission.required' => trns('is_commission_field_is_required'),
            'is_commission.boolean' => trns('is_commission_field_must_be_boolean'),
            'commission_name.max' => trns('commission_name_may_not_be_greater_than_255_characters'),
            'commission_type.boolean' => trns('commission_type_must_be_boolean'),
            'commission_percentage.numeric' => trns('commission_percentage_must_be_number'),
            'commission_percentage.between' => trns('commission_percentage_must_be_between_0_and_100'),
            'lat.required' => trns('latitude_is_required'),
            'lat.numeric' => trns('latitude_must_be_number'),
            'long.required' => trns('longitude_is_required'),
            'long.numeric' => trns('longitude_must_be_number'),
            'logo.max' => trns('logo_may_not_be_greater_than_255_characters'),
            'association_manager_email.required' => trns('association_manager_email_is_required'),
            'association_manager_email.email' => trns('association_manager_email_must_be_valid'),
            'association_manager_email.exists' => trns('specified_association_manager_email_does_not_exist')
        ];


    }

    protected function setupUnitValidation()
    {
        $this->requiredFields = [
            'unit_number',
            'real_state_id',
            'bathrooms_count',
            'bedrooms_count',
            'floor_count',
            'unit_code',
            'unified_code',
            'space',
            'northern_border',
            'southern_border',
            'eastern_border',
            'western_border',
            'stop_reason',
            'description',
            'status',
        ];

        $this->fieldRules = [
            'unit_number' => 'required|numeric',
            'real_state_id' => 'required|exists:real_state,id|numeric',
            'bathrooms_count' => 'required|numeric',
            'bedrooms_count' => 'required|numeric',
            'floor_count' => 'required|numeric',
            'unit_code' => 'required|numeric',
            'unified_code' => 'required|numeric',
            'space' => 'required',
            'northern_border' => 'required|numeric',
            'southern_border' => 'required|numeric',
            'eastern_border' => 'required|numeric',
            'western_border' => 'required|numeric',
            'stop_reason' => 'required',
            'description' => 'required',
            'status' => 'required|boolean',
        ];

        $this->customValidationMessages = [
            'unit_number.required' => trns('unit_number_is_required'),
            'unit_number.numeric' => trns('unit_number_must_be_numeric'),
            'real_state_id.required' => trns('real_state_id_is_required'),
            'real_state_id.exists' => trns('the_specified_real_state_does_not_exist'),
            'real_state_id.numeric' => trns('real_state_id_must_be_numeric'),
            'bathrooms_count.required' => trns('bathrooms_count_is_required'),
            'bathrooms_count.numeric' => trns('bathrooms_count_must_be_numeric'),
            'bedrooms_count.required' => trns('bedrooms_count_is_required'),
            'bedrooms_count.numeric' => trns('bedrooms_count_must_be_numeric'),
            'floor_count.required' => trns('floor_count_is_required'),
            'floor_count.numeric' => trns('floor_count_must_be_numeric'),
            'unit_code.required' => trns('unit_code_is_required'),
            'unit_code.numeric' => trns('unit_code_must_be_numeric'),
            'unified_code.required' => trns('unified_code_is_required'),
            'unified_code.numeric' => trns('unified_code_must_be_numeric'),
            'space.required' => trns('space_is_required'),
            'northern_border.required' => trns('northern_border_is_required'),
            'northern_border.numeric' => trns('northern_border_must_be_numeric'),
            'southern_border.required' => trns('southern_border_is_required'),
            'southern_border.numeric' => trns('southern_border_must_be_numeric'),
            'eastern_border.required' => trns('eastern_border_is_required'),
            'eastern_border.numeric' => trns('eastern_border_must_be_numeric'),
            'western_border.required' => trns('western_border_is_required'),
            'western_border.numeric' => trns('western_border_must_be_numeric'),
            'stop_reason.required' => trns('stop_reason_is_required'),
            'description.required' => trns('description_is_required'),
            'status.required' => trns('status_is_required'),
            'status.boolean' => trns('status_must_be_boolean')
        ];
    }

    protected function setupRealStateValidation()
    {

        $this->requiredFields = [
            'name_ar',
            'name_en',
            'association_id',
            'location'
        ];

        $this->fieldRules = [
            // RealState fields
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'real_state_number' => 'required|numeric|max:255',
            'association_id' => 'required|exists:associations,id',
            'admin_id' => 'required|exists:admins,id',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'stop_reason' => 'required',
            'status' => 'required|boolean',
            'construction_year' => 'nullable|date',



            // RealStateDetails fields
            'street' => 'required',
            'space' => 'required|numeric',
            'flat_space' => 'required|numeric',
            'part_number' => 'required|numeric',
            'bank_account_number' => 'required|numeric',
            'mint_number' => 'required|numeric',
            'mint_source' => 'required',
            'floor_count' => 'required|numeric',
            'elevator_count' => 'required|numeric',
            'electric_account_number' => 'required|numeric',
            'electric_meter_number' => 'required|numeric',
            'electric_subscription_number' => 'required|numeric',
            'water_account_number' => 'required|numeric',
            'water_meter_number' => 'required|numeric',
            'northern_border' => 'required|numeric',
            'southern_border' => 'required|numeric',
            'eastern_border' => 'required|numeric',
            'western_border' => 'required|numeric',
            'building_year' => 'required|date',
            'building_type' => 'required',
        ];

        $this->customValidationMessages = [
            // RealState fields
            'name_ar.required'               => trns('name_ar_is_required'),
            'name_ar.max'                    => trns('name_ar_may_not_be_greater_than_255_characters'),
            'name_en.required'               => trns('name_en_is_required'),
            'name_en.max'                    => trns('name_en_may_not_be_greater_than_255_characters'),
            'real_state_number.required'     => trns('real_state_number_is_required'),
            'real_state_number.numeric'      => trns('real_state_number_must_be_numeric'),
            'real_state_number.max'          => trns('real_state_number_may_not_be_greater_than_255'),
            'association_id.required'        => trns('association_id_is_required'),
            'association_id.exists'          => trns('the_specified_association_does_not_exist'),
            'admin_id.required'              => trns('admin_id_is_required'),
            'admin_id.exists'                => trns('the_specified_admin_does_not_exist'),
            'lat.required'                   => trns('lat_is_required'),
            'lat.numeric'                    => trns('lat_must_be_numeric'),
            'long.required'                  => trns('long_is_required'),
            'long.numeric'                   => trns('long_must_be_numeric'),
            'stop_reason.required'           => trns('The stop reason is required'),
            'status.required'                => trns('The status is required'),
            'status.boolean'                 => trns('The status must be a boolean'),
            'construction_year.date'         => trns('construction_year_must_be_a_valid_date'),

            // RealStateDetails fields
            'street.required'                       => trns('street_is_required'),
            'space.required'                        => trns('The space is required'),
            'space.numeric'                         => trns('space_must_be_numeric'),
            'flat_space.required'                   => trns('flat_space_is_required'),
            'flat_space.numeric'                    => trns('flat_space_must_be_numeric'),
            'part_number.required'                  => trns('part_number_is_required'),
            'part_number.numeric'                   => trns('part_number_must_be_numeric'),
            'bank_account_number.required'          => trns('bank_account_number_is_required'),
            'bank_account_number.numeric'           => trns('bank_account_number_must_be_numeric'),
            'mint_number.required'                  => trns('mint_number_is_required'),
            'mint_number.numeric'                   => trns('mint_number_must_be_numeric'),
            'mint_source.required'                  => trns('mint_source_is_required'),
            'floor_count.required'                  => trns('The floor count is required'),
            'floor_count.numeric'                   => trns('The floor count must be numeric'),
            'elevator_count.required'               => trns('elevator_count_is_required'),
            'elevator_count.numeric'                => trns('elevator_count_must_be_numeric'),
            'electric_account_number.required'      => trns('electric_account_number_is_required'),
            'electric_account_number.numeric'       => trns('electric_account_number_must_be_numeric'),
            'electric_meter_number.required'        => trns('electric_meter_number_is_required'),
            'electric_meter_number.numeric'         => trns('electric_meter_number_must_be_numeric'),
            'electric_subscription_number.required' => trns('electric_subscription_number_is_required'),
            'electric_subscription_number.numeric'  => trns('electric_subscription_number_must_be_numeric'),
            'water_account_number.required'         => trns('water_account_number_is_required'),
            'water_account_number.numeric'          => trns('water_account_number_must_be_numeric'),
            'water_meter_number.required'           => trns('water_meter_number_is_required'),
            'water_meter_number.numeric'            => trns('water_meter_number_must_be_numeric'),
            'northern_border.required'              => trns('The northern border is required'),
            'northern_border.numeric'               => trns('The northern border must be numeric'),
            'southern_border.required'              => trns('The southern border is required'),
            'southern_border.numeric'               => trns('The southern border must be numeric'),
            'eastern_border.required'               => trns('The eastern border is required'),
            'eastern_border.numeric'                => trns('The eastern border must be numeric'),
            'western_border.required'               => trns('The western border is required'),
            'western_border.numeric'                => trns('The western border must be numeric'),
            'building_year.required'                => trns('building_year_is_required'),
            'building_year.date'                    => trns('building_year_must_be_a_valid_date'),
            'building_type.required'                => trns('building_type_is_required'),
        ];
    }

    public function rules(): array
    {
        return $this->fieldRules;
    }

    public function customValidationMessages(): array
    {
        return $this->customValidationMessages;
    }



    protected function getMappedColumns(array $availableColumns): array
    {
        return array_map(function ($column) {
            return $this->fieldMapping[$column] ?? $column;
        }, $availableColumns);
    }

    protected function validateRequiredColumns(array $mappedColumns): void
    {
        $missingColumns = array_diff($this->requiredFields, $mappedColumns);

        if (!empty($missingColumns)) {
            throw new \Exception("Missing required columns: " . implode(', ', $missingColumns));
        }
    }

    protected function processAssociationRow($row, array $mappedColumns, int $index): void
    {
        try {
            $data = $this->mapAndValidateRow($row->toArray());
            $data = $this->handleAssociationManager($data, $mappedColumns);
            $data = $this->prepareMultilingualData($data);
            $data['admin_id'] = auth()->id();
            $data = $this->transformDataTypes($data);

            $this->modelClass::updateOrCreate(
                [$this->uniqueIdentifier => $data[$this->uniqueIdentifier]],
                $data
            );

        } catch (\Exception $e) {
            Log::error("Failed to process Association row " . ($index + 2) . ": " . $e->getMessage());
            throw new \Exception("Error in Association row " . ($index + 2) . ": " . $e->getMessage());
        }
    }

    protected function processUnitRow($row, array $mappedColumns, int $index): void
    {
        try {
            $data = $this->mapAndValidateRow($row->toArray());
            $data = $this->prepareUnitData($data);

            $this->modelClass::updateOrCreate(
                [$this->uniqueIdentifier => $data[$this->uniqueIdentifier]],
                $data
            );

        } catch (\Exception $e) {
            Log::error("Failed to process Unit row " . ($index + 2) . ": " . $e->getMessage());
            throw new \Exception("Error in Unit row " . ($index + 2) . ": " . $e->getMessage());
        }
    }


    protected function processRealStateRow($row, array $mappedColumns, int $index): void
    {
        try {
            $data = $this->mapAndValidateRow($row->toArray());
            $data = $this->prepareRealStateData($data);
            $data['admin_id'] = auth()->id();

            $splitData = $this->splitRealStateData($data);

            $realState = $this->modelClass::updateOrCreate(
                [$this->uniqueIdentifier => $data[$this->uniqueIdentifier]],
                $splitData['real_state']
            );

            $splitData['real_state_details']['real_state_id'] = $realState->id;

            RealStateDetail::updateOrCreate(
                ['real_state_id' => $realState->id],
                $splitData['real_state_details']
            );

        } catch (\Exception $e) {
            Log::error("Failed to process RealState row " . ($index + 2) . ": " . $e->getMessage());
            throw new \Exception("Error in RealState row " . ($index + 2) . ": " . $e->getMessage());
        }
    }



    protected function splitRealStateData(array $data): array
    {
        $realStateData = [
            'name' => $data['name'],
            'real_state_number' => $data['real_state_number'],
            'association_id' => $data['association_id'],
            'status' => $data['status'] ?? false,
            'lat' => $data['lat'],
            'long' => $data['long'],
            'stop_reason' => $data['stop_reason'] ?? null,
            'admin_id' => $data['admin_id'] ?? auth()->id(),
        ];

        $realStateDetailsData = [
            'street' => $data['street'] ?? null,
            'space' => $data['space'] ?? 0,
            'flat_space' => $data['flat_space'] ?? 0,
            'part_number' => $data['part_number'] ?? null,
            'bank_account_number' => $data['bank_account_number'] ?? null,
            'mint_number' => $data['mint_number'] ?? 0,
            'mint_source' => $data['mint_source'] ?? null,
            'floor_count' => $data['floor_count'] ?? 0,
            'elevator_count' => $data['elevator_count'] ?? 0,
            'electric_account_number' => $data['electric_account_number'] ?? null,
            'electric_meter_number' => $data['electric_meter_number'] ?? null,
            'electric_subscription_number' => $data['electric_subscription_number'] ?? null,
            'water_account_number' => $data['water_account_number'] ?? null,
            'water_meter_number' => $data['water_meter_number'] ?? null,
            'northern_border' => $data['northern_border'] ?? null,
            'southern_border' => $data['southern_border'] ?? null,
            'eastern_border' => $data['eastern_border'] ?? null,
            'western_border' => $data['western_border'] ?? null,
            'building_year' => $data['building_year'] ?? null,
            'building_type' => $data['building_type'] ?? null,
        ];

        return [
            'real_state' => $realStateData,
            'real_state_details' => $realStateDetailsData
        ];
    }

    protected function prepareUnitData(array $data): array
    {
        // Convert numeric fields
        foreach (['floor_number', 'area', 'rooms', 'bathrooms'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = (int)$data[$field];
            }
        }

        $data['status'] = (bool)$data['status'];

        return $data;
    }

    protected function prepareRealStateData(array $data): array
    {
        $data['name'] = [
            'ar' => $data['name_ar'] ?? '',
            'en' => $data['name_en'] ?? ''
        ];

        unset($data['name_ar'], $data['name_en']);

//        foreach ('construction_year'] as $field) {
//            if (isset($data[$field])) {
//                $data[$field] = (int)$data[$field];
//            }
//        }

        $data['status'] = (bool)$data['status'];

        return $data;
    }

    protected function mapAndValidateRow(array $rowData): array
    {
        $mappedData = [];

        foreach ($rowData as $key => $value) {
            $dbField = $this->fieldMapping[$key] ?? $key;
            $mappedData[$dbField] = $value === '' ? null : $value;
        }

        return $mappedData;
    }

    protected function handleAssociationManager(array $data, array $mappedColumns): array
    {
        if (in_array('association_manager_email', $mappedColumns) && isset($data['association_manager_email'])) {
            $user = User::where('email', $data['association_manager_email'])->first();
            if ($user) {
                $data['association_manager_id'] = $user->id;
            }
        }
        return $data;
    }

    protected function prepareMultilingualData(array $data): array
    {
        $data['name'] = [
            'ar' => $data['name_ar'] ?? '',
            'en' => $data['name_en'] ?? ''
        ];

        unset($data['name_ar'], $data['name_en']);

        return $data;
    }

    protected function transformDataTypes(array $data): array
    {
        foreach (['number', 'unified_number', 'establish_number'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = (string)$data[$field];
            }
        }

        foreach (['approval_date', 'establish_date', 'due_date'] as $field) {
            if (!empty($data[$field])) {
                try {
                    $data[$field] = Carbon::parse($data[$field])->format('Y-m-d');
                } catch (\Exception $e) {
                    throw new \Exception("Invalid date format for {$field}");
                }
            }
        }

        $data['status'] = (bool)$data['status'];
        $data['is_commission'] = (bool)$data['is_commission'];

        if (isset($data['commission_name']) && $data['commission_name'] === '-') {
            $data['commission_name'] = null;
        }

        return $data;
    }
}
