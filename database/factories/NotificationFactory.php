<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Add this use statement

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Assign a user_id
            'title' => fake()->sentence(rand(3, 6)), // Added based on migration
            'message' => fake()->paragraph(rand(1, 3)),
            'read_at' => fake()->boolean(60) ? fake()->dateTimeBetween('-1 week', 'now') : null, // Added based on migration, 60% chance of being read
        ];
    }
}