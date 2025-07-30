<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Add this use statement
use App\Models\ResumeTemplate; // <-- Add this use statement

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resume>
 */
class ResumeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Assign a user_id, will be overridden in seeder for job seekers
            'resume_template_id' => ResumeTemplate::factory(), // Assign a template ID
            'summary' => fake()->paragraph(3),
            // Ensure JSON fields are encoded for storage
            'education' => json_encode([
                ['degree' => fake()->word() . ' Degree', 'university' => fake()->university(), 'year' => fake()->year()],
                ['degree' => fake()->word() . ' Diploma', 'university' => fake()->university(), 'year' => fake()->year()],
            ]),
            'experience' => json_encode([
                ['title' => fake()->jobTitle(), 'company' => fake()->company(), 'years' => rand(1, 5)],
                ['title' => fake()->jobTitle(), 'company' => fake()->company(), 'years' => rand(1, 5)],
            ]),
            'skills' => json_encode(fake()->words(rand(5, 10))), // Array of random skills
            'cv_pdf_path' => 'resumes/dummy_cv_' . fake()->uuid() . '.pdf', // Added based on your migration
        ];
    }
}