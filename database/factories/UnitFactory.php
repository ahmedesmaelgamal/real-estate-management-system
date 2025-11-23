<?php

namespace Database\Factories;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'real_state_id' => \App\Models\RealState::factory(),
            //            'real_state_id' => $this->faker->unique()->numberBetween(1, 10),
            'unit_number' => $this->faker->unique()->numberBetween(100, 999),
            'description' => $this->faker->paragraph,
            'space' => $this->faker->numberBetween(50, 300),
            'unit_code' => $this->faker->unique()->numberBetween(1000, 9999),
            'unified_code' => $this->faker->unique()->numberBetween(1000, 9999),
            'floor_count' => $this->faker->numberBetween(1, 3),
            'bathrooms_count' => $this->faker->numberBetween(1, 4),
            'bedrooms_count' => $this->faker->numberBetween(1, 5),
            'northern_border' => $this->faker->numberBetween(1, 100),
            'southern_border' => $this->faker->numberBetween(1, 100),
            'eastern_border' => $this->faker->numberBetween(1, 100),
            'western_border' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->boolean,
            'stop_reason' => $this->faker->optional()->sentence,
        ];
    }
}
