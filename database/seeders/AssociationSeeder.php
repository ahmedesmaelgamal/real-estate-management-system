<?php

namespace Database\Seeders;

use App\Models\Association;
use Illuminate\Database\Seeder;

class AssociationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Association::factory(10)->create();

    }
}
