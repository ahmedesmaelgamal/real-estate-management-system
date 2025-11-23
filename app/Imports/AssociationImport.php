<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Admin;
use App\Models\Association;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssociationImport implements ToModel, ToCollection, WithHeadingRow
{
    public Collection $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection;
    }
    public function model(array $row)
    {
        Log::info($row);

        $manager = Admin::where('email', $row['association_manager_email'])->first();


        $associationManagerId = $manager->id;














        Log::info('Importing association', [
            'unified_number' => $row['unified_number'],
            'manager_id' => $associationManagerId,
        ]);


        return Association::updateOrCreate(
            ['unified_number' => $row['unified_number']],
            [
                'name' => [
                    'ar' => $row['name_ar'],
                    'en' => $row['name_en'],
                ],
                'number' => $row['number'],
                'establish_number' => $row['establish_number'],
                'establish_date' => $row['establish_date'],
                'due_date' => $row['due_date'],
                'approval_date' => $row['approval_date'],
                'status' => $row['status'] ?? 1,
                'interception_reason' => $row['interception_reason'] ?? null,
                'association_manager_id' => $associationManagerId,
                'appointment_start_date' => $row['appointment_start_date'],
                'appointment_end_date' => $row['appointment_end_date'],
                'association_model_id' => $row['association_model_id'] ?? null,
                'monthly_fees' => $row['monthly_fees'] ?? null,
                'is_commission' => $row['is_commission'] ?? 0,
                'commission_name' => $row['commission_name'] ?? null,
                'commission_type' => $row['commission_type'] ?? null,
                'commission_percentage' => $row['commission_percentage'] ?? null,
                'lat' => $row['lat'] ?? null,
                'long' => $row['long'] ?? null,
                'admin_id' => Auth::guard('admin')->id(),
            ]
        );


        return null;
    }
}
