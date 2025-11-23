<?php

namespace App\Imports;

use App\Models\RealState;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UnitImport implements ToModel, ToCollection, WithHeadingRow
{
    public array $userId = [];
    public array $percentage = [];
    public Collection $rows;



    public function collection(Collection $collection)
    {
        $this->rows = $collection;

        // push userIds
        foreach ($collection as $row) {
            $this->userId[] = $row['user_id'];
            $this->percentage[] = $row['percentage'];
        }
    }
    public function model(array $row)
    {
        $data = $row;

        $realStateNumber = isset($data['real_state_number']) ? trim($data['real_state_number']) : null;

        if (!$realStateNumber) {
            Log::error('real_state_number is missing in row: ' . json_encode($data));
            return null;
        }



        $realState = RealState::where('real_state_number', $realStateNumber)->first();

        if (!$realState) {
            Log::error('RealState not found for real_state_number: ' . $realStateNumber);
            return null;
        }

        $obj = Unit::updateOrCreate(
            [
                'unit_number' => $data['unit_number'],
            ],
            [
                'real_state_id'    => $realState->id,
                'unit_number'      => $data['unit_number'],
                'description'      => $data['description'] ?? null,
                'space'            => $data['space'],
                'unit_code'        => $data['unit_code'],
                'floor_count'      => $data['floor_count'],
                'bathrooms_count'  => $data['bathrooms_count'],
                'bedrooms_count'   => $data['bedrooms_count'],
                'northern_border'  => $data['northern_border'],
                'southern_border'  => $data['southern_border'],
                'eastern_border'   => $data['eastern_border'],
                'western_border'   => $data['western_border'],
                'stop_reason'      => $data['stop_reason'] ?? null,
                'admin_id'         => auth()->user()->id,
                'status'           => $data['status'],
            ]
        );


        if ($obj) {
            for ($i = 0; $i < count($this->userId); $i++) {
                $user = $this->userId[$i];
                $percentage = $this->percentage[$i];

                if ($user && $percentage !== null) {
                    $obj->unitOwners()->create([
                        'user_id'   => $user,
                        'percentage' => $percentage,
                    ]);
                }
            }
        }

        return null;
    }
}
