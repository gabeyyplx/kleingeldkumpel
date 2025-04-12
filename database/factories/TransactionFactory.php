<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'value' => fake()->randomFloat(2, 1, 1000),
            'type' => fake()->randomElement(['expense', 'income']),
            'category_id' => fake()->numberBetween(1, 10),
            'account_id' => 1,
            'date' => now()
        ];
    }
}
