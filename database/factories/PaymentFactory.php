<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Add this use statement

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'amount' => fake()->randomFloat(2, 5, 500), // Random float for currency
            'status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'payment_method' => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer']), // Updated options
            'payment_for' => fake()->randomElement(['job_promotion', 'resume_review', 'premium_subscription']), // Added based on migration
            'reference' => fake()->uuid(), // Unique reference ID
            'paid_at' => fake()->boolean(80) ? fake()->dateTimeBetween('-1 year', 'now') : null, // 80% chance of being paid
        ];
    }
}