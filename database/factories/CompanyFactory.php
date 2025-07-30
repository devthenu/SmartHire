<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Add this use statement if Company has a user_id foreign key

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Assign a user_id, will be overridden in seeder for specific recruiters
            'name' => fake()->company(),
            'industry' => fake()->jobTitle(), // You can make this more specific later, e.g., fake()->randomElement(['Tech', 'Finance'])
            'website' => fake()->url(),
            'location' => fake()->city() . ', ' . fake()->stateAbbr(), // Added based on your migration
            'logo' => fake()->imageUrl(640, 480, 'companies', true), // Added based on your migration
        ];
    }
}