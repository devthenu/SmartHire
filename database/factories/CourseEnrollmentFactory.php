<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Add this use statement
use App\Models\TrainingCourse; // <-- Add this use statement

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseEnrollment>
 */
class CourseEnrollmentFactory extends Factory
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
            'training_course_id' => TrainingCourse::factory(), // Assign a training_course_id
            'completion_status' => fake()->randomElement(['enrolled', 'in_progress', 'completed']), // Added based on migration
            'enrolled_at' => fake()->dateTimeBetween('-1 year', 'now'), // Added based on migration
        ];
    }
}