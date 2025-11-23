<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, ToCollection, WithHeadingRow
{
    public Collection $rows;

    public function collection(Collection $collection)
    {
        $this->rows = $collection;
    }
    public function model(array $row)
    {




        return User::updateOrCreate(
            ['email' => $row['email']],
            [
                'name' => $row['name'],
                'email' => $row['email'],
                'national_id' => $row['national_id'],
                'phone' => $row['phone'],
                'status' => $row['status'] ?? 'active',

            ]
        );


        return null;
    }
}
