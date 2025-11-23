<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

ini_set('max_execution_time', 300);
set_time_limit(300);
class PreviewElectricOrWaterOfUnitimport implements ToCollection, WithHeadingRow,SkipsEmptyRows
{
    public Collection $rows;

    public function __construct()
    {
        $this->rows = new Collection();
    }

   public function collection(Collection $collection)
{
    foreach ($collection as $row) {
        if (empty($row['real_state_number'])
            && empty($row['electric_name'])
            && empty($row['water_name'])
            && empty($row['electric_account_number'])
            && empty($row['water_account_number'])
            && empty($row['electric_subscription_number'])
            && empty($row['electric_meter_number'])
            && empty($row['water_meter_number'])) {
            break;
        }
        $this->rows->push($row);
    }
}

}
