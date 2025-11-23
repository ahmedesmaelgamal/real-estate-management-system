<?php

namespace Database\Factories;

use App\Models\RealStateOwner;
use Illuminate\Database\Eloquent\Factories\Factory;

class RealStateOwnerFactory extends Factory
{
    protected $model = RealStateOwner::class;

    public function definition(): array
    {
        return [
            'real_state_id' => \App\Models\RealState::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
