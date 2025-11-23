<?php

namespace Database\Factories;

use App\Models\Association;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssociationFactory extends Factory
{
    protected $model = Association::class;

    public function definition(): array
    {
        return [
            'name' => [
                'ar' => $this->faker->words(2, true),
                'en' => $this->faker->words(2, true),
            ],
            'association_model_id' => $this->faker->numberBetween(1, 2),
            'number' => $this->faker->unique()->numerify('##########'),
            // 'unit_count' => $this->faker->numberBetween(1, 100),
            // 'real_state_count' => $this->faker->numberBetween(1, 50),
            'approval_date' => $this->faker->date(),
            'establish_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'unified_number' => $this->faker->unique()->randomNumber(8),
            'establish_number' => $this->faker->unique()->randomNumber(6),
            'status' => $this->faker->boolean(),
            'interception_reason' => $this->faker->sentence(),
            'association_manager_id' => $this->faker->numberBetween(1, 2),
            'appointment_start_date' => $this->faker->date(),
            'appointment_end_date' => $this->faker->date(),
            'monthly_fees' => $this->faker->randomFloat(2, 100, 1000),
            'is_commission' => $this->faker->boolean(),
            'commission_name' => $this->faker->word(),
            'commission_type' => $this->faker->boolean(),
            'commission_percentage' => $this->faker->numberBetween(1, 100),
            'lat' => $this->faker->latitude(),
            'long' => $this->faker->longitude(),
            'logo' => $this->faker->imageUrl(),
        ];
    }
}
