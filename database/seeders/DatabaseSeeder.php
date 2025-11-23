<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\RealState;
use App\Models\RealStateOwner;
use App\Models\UnitOwner;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SettingSeeder::class);

        // $this->call(AssociationModelSeeder::class);

        $this->call(Users::class);
        // $this->call(AssociationSeeder::class);
        // $this->call(UnitOwnerSeeder::class);
        // $this->call(RealStateSeeder::class);
        // $this->call(RealStateDetailSeeder::class);
        // $this->call(RealStateOwnerSeeder::class);
                // $this->call(UnitSeeder::class);

    }
}
