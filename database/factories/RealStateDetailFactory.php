<?php

namespace Database\Factories;

use App\Models\RealStateDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class RealStateDetailFactory extends Factory
{
    protected $model = RealStateDetail::class;

    public function definition(): array
    {
        return [
            'real_state_id' => \App\Models\RealState::factory(),
            'street' => $this->faker->streetName(),
            'space' => $this->faker->numberBetween(50, 500),
            'flat_space' => $this->faker->numberBetween(20, 200),
            'part_number' => $this->faker->randomDigitNotNull(),
            'bank_account_number' => $this->faker->bankAccountNumber(),
            'mint_number' => $this->faker->randomNumber(5),
            'mint_source' => $this->faker->company(),
            'floor_count' => $this->faker->numberBetween(1, 20),
            'elevator_count' => $this->faker->numberBetween(0, 5),

            'water_account_number' => $this->faker->regexify('[A-Z0-9]{10}'),
            'water_meter_number' => $this->faker->regexify('[A-Z0-9]{8}'),
            'northern_border' => $this->faker->word(),
            'southern_border' => $this->faker->word(),
            'eastern_border' => $this->faker->word(),
            'western_border' => $this->faker->word(),
            'building_year' => $this->faker->date('Y-m-d', 'now'),
            'building_type' => $this->faker->randomElement(['Residential', 'Commercial', 'Industrial']),
        ];
    }
}
