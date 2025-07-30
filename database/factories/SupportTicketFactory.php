<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Add this use statement

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SupportTicket>
 */
class SupportTicketFactory extends Factory
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
            'subject' => fake()->sentence(rand(3, 7)),
            'message' => fake()->paragraph(rand(2, 5)),
            'status' => fake()->randomElement(['open', 'in_progress', 'resolved']),
            'reply' => fake()->boolean(50) ? fake()->paragraph(rand(1, 3)) : null, // 50% chance of having a reply
        ];
    }
}