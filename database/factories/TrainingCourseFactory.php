<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingCourse>
 */
class TrainingCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->catchPhrase() . ' Course',
            'description' => fake()->paragraph(),
            'provider' => fake()->company(), // Changed 'link' to 'provider' as per migration
            'url' => fake()->url(), // Added 'url' as per migration
            'price' => fake()->randomFloat(2, 0, 500), // Added 'price' as per migration
            'skills_covered' => json_encode(fake()->words(rand(3, 7))), // Added based on migration
        ];
    }
}