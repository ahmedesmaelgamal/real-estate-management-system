<?php

namespace Database\Seeders;

use App\Models\RealState;

use Illuminate\Database\Seeder;

class RealStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RealState::factory(10)->create();

    }
}
