<?php

namespace Database\Seeders;

use App\Models\RealState;

use App\Models\RealStateOwner;
use Illuminate\Database\Seeder;

class RealStateOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RealStateOwner::factory(10)->create();

    }
}
