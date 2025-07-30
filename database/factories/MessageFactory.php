<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Add this use statement

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ensure sender and receiver are different users
        $sender = User::factory();
        $receiver = User::factory();

        return [
            'sender_id' => $sender,
            'receiver_id' => $receiver,
            'message' => fake()->sentence(rand(5, 15)),
            'read_at' => fake()->boolean(70) ? fake()->dateTimeBetween('-1 month', 'now') : null, // 70% chance of being read
            'sent_at' => fake()->dateTimeBetween('-1 month', 'now'), // Added based on migration
        ];
    }
}