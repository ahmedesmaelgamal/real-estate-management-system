<?php

namespace Database\Factories;

use App\Models\UnitOwner;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitOwnerFactory extends Factory
{
    protected $model = UnitOwner::class;

    public function definition() : array
    {
        return [
            'unit_id' => \App\Models\Unit::factory(),
            'user_id' => \App\Models\User::factory(),
            'percentage'=> fake()->numberBetween('1','100')
        ];
    }
}
