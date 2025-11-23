<?php

namespace Database\Factories;

use App\Models\RealState;
use Illuminate\Database\Eloquent\Factories\Factory;

class RealStateFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => [
                'ar' => $this->faker->words(2, true),
                'en' => $this->faker->words(2, true),
            ],
            'real_state_number' => $this->faker->numberBetween(1000, 10000),
            'association_id' => \App\Models\Association::factory(),
            'admin_id' => \App\Models\Admin::query()->inRandomOrder()->value('id') ?? 1,
            'status' => $this->faker->boolean(),
            'lat' => $this->faker->latitude(),
            'long' => $this->faker->longitude(),
            'stop_reason' => $this->faker->sentence(),
        ];
    }
}
