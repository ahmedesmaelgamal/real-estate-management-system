<?php

namespace App\Imports;

use App\Models\RealState;
use App\Models\RealStateDetail;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class RealStateImport implements ToModel, ToCollection, WithHeadingRow
{

    public Collection $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection;
    }
    public function model(array $row)
    {
        $data = $row;

        if (!empty($data['name_ar'])) {
            $obj = RealState::updateOrCreate(
                ['real_state_number' => $data['real_state_number']],
                [
                    'name' => [
                        'ar' => $data['name_ar'],
                        'en' => $data['name_en']
                    ],
                    'real_state_number' => $data['real_state_number'],
                    'association_id' => $data['association_id'],
                    'status' => $data['status'],
                    'lat' => $data['lat'],
                    'long' => $data['long'],
                    'stop_reason' => $data['status'] ? $data['stop_reason'] : null,
                    'legal_ownership_id' => $data['legal_ownership_id'] ?? null,
                    'legal_ownership_other' => $data['legal_ownership_other'] ?? null,
                    'admin_id' => auth()->id(),
                ]
            );
        }


        Log::info('RealStateImport: Processing RealState with ID: ' . ($obj->id ?? 'N/A'));

        if (!empty($data['street']) && !empty($data['name_ar']) && isset($obj)) {
            RealStateDetail::updateOrCreate(
                ['real_state_id' => $obj->id],
                [
                    'space' => $data['space'],
                    'street' => $data['street'],
                    'flat_space' => $data['flat_space'],
                    'part_number' => $data['part_number'],
                    'bank_account_number' => $data['bank_account_number'],
                    'mint_number' => $data['mint_number'],
                    'mint_source' => $data['mint_source'],
                    'floor_count' => $data['floor_count'],
                    'elevator_count' => $data['elevator_count'],
                    'northern_border' => $data['northern_border'],
                    'southern_border' => $data['southern_border'],
                    'eastern_border' => $data['eastern_border'],
                    'western_border' => $data['western_border'],
                    'building_year' => !empty($data['building_year'])
                        ? Carbon::parse($data['building_year'])->format('Y-m-d')
                        : null,
                    'building_type' => $data['building_type'],
                ]
            );
        }

        return null;
    }
}
