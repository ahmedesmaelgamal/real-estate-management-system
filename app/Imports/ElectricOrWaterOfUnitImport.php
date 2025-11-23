<?php

namespace App\Imports;


use App\Models\Unit;
use App\Models\UnitElectric;
use App\Models\UnitWater;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


ini_set('max_execution_time', 300);
set_time_limit(300);

class ElectricOrWaterOfUnitImport implements ToModel, ToCollection, WithHeadingRow, WithChunkReading
{

    public function chunkSize(): int
    {
        return 500;
    }
    public Collection $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection;
    }
    public function model(array $row)
    {
        $data = $row;

        $obj = Unit::where('unit_number', $data['unit_number'])->first();
        if (!$obj) {
            Log::error('RealState not found for real_state_number: ' . $data['real_state_number']);
            return null;
        }
        $electric = UnitElectric::create([
            'unit_id' => $obj->id,
            'electric_name' => $data['electric_name'],
            'electric_account_number' => $data['electric_account_number'],
            'electric_meter_number' => $data['electric_meter_number'],
            'electric_subscription_number' => $data['electric_subscription_number'],
        ]);


        UnitWater::create([
            'unit_id' => $obj->id,
            'water_name' => $data['water_name'],
            'water_account_number' => $data['water_account_number'],
            'water_meter_number' => $data['water_meter_number'],
        ]);



        return null;
    }
}
