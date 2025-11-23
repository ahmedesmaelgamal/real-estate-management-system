<?php

namespace Database\Seeders;

use App\Models\UnitOwner;

use Illuminate\Database\Seeder;

class UnitOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnitOwner::factory(10)->create();

    }
}
