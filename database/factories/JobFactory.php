<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Add this use statement
use App\Models\Company; // <-- Add this use statement

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Assign a user_id, will be overridden in seeder for recruiters
            'company_id' => Company::factory(), // Assign a company_id, will be overridden in seeder
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(rand(3, 7), true), // Generates multiple paragraphs
            'location' => fake()->city() . ', ' . fake()->stateAbbr(),
            'type' => fake()->randomElement(['full-time', 'part-time', 'contract']),
            'salary' => fake()->numberBetween(30000, 120000),
            'deadline' => now()->addDays(rand(10, 30)),
        ];
    }
}