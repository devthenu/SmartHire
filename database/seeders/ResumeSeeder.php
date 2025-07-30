<?php

namespace Database\Seeders;

use App\Models\Resume;
use App\Models\User; // Make sure to use your User model
use App\Models\ResumeTemplate; // Make sure to use your ResumeTemplate model
use Illuminate\Database\Seeder;

class ResumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users who have the 'job_seeker' role
        $jobSeekers = User::role('job_seeker')->get();
        // Get a random resume template
        $resumeTemplate = ResumeTemplate::inRandomOrder()->first();

        // Check if essential data exists to prevent errors
        if ($jobSeekers->isEmpty()) {
            echo "Skipping ResumeSeeder: No job seekers found. Ensure UserSeeder runs first.\n";
            return;
        }

        if (!$resumeTemplate) {
            echo "Skipping ResumeSeeder: No resume templates found. Ensure ResumeTemplateSeeder runs first.\n";
            return;
        }

        // Create one resume for each job seeker, linking to the found template
        foreach ($jobSeekers as $user) {
            Resume::factory()->create([
                'user_id' => $user->id,
                'resume_template_id' => $resumeTemplate->id,
            ]);

            // Optionally, create a second resume for some job seekers (e.g., 50% chance)
            if (rand(0, 1) === 1) {
                Resume::factory()->create([
                    'user_id' => $user->id,
                    'resume_template_id' => ResumeTemplate::inRandomOrder()->first()->id ?? $resumeTemplate->id, // Get another random template or use the first one
                ]);
            }
        }

        // Create a few additional random resumes for existing job seekers
        Resume::factory(5)->create([
            'user_id' => $jobSeekers->random()->id,
            'resume_template_id' => $resumeTemplate->id,
        ]);
    }
}