<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin1 = Admin::create([
            'name' => 'admin',
            // 'user_name' => 'admin',
            'code' => Str::random(11),
            'phone' => 966123456789,
            'email' => 'admin@edrat.com',
            'national_id' => '22222222222222',
            'password' => Hash::make('admin'),
        ]);


        $admin1->assignRole([1]);
    }
}
