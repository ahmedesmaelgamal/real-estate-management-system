<?php

namespace Database\Seeders;

use App\Models\RealState;

use App\Models\RealStateDetail;
use Illuminate\Database\Seeder;

class RealStateDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RealStateDetail::factory(10)->create();

    }
}
