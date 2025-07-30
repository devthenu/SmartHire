<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;  // Needed for pivot table logic
use App\Models\Job;   // Needed for pivot table logic
use App\Models\Skill; // Needed for pivot table logic

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Core Setup Seeders (Order is CRITICAL!) ---
        // These must run first to establish foundational data and roles.
        $this->call([
            RoleSeeder::class,        // Spatie roles MUST be created first
            UserSeeder::class,              // Users (including specific roles) need to exist
        ]);

        // --- Dependent Seeders ---
        // These depend on users and other core entities existing.
        $this->call([
            CompanySeeder::class,           // Companies need recruiters (users)
            ResumeTemplateSeeder::class,    // Resume templates need to exist before resumes
            SkillSeeder::class,             // Skills need to exist before being attached to users/jobs
            TrainingCourseSeeder::class,    // Training courses need to exist before enrollments
        ]);

        // --- Further Dependent Seeders ---
        // These depend on the above data being present.
        $this->call([
            JobSeeder::class,               // Jobs need recruiters (users) and companies
            ResumeSeeder::class,            // Resumes need job seekers (users) and templates
            CourseEnrollmentSeeder::class,  // Course enrollments need users and training courses
            ApplicationSeeder::class,       // Applications need job seekers (users) and jobs
        ]);

        // --- General Data Seeders (Order less critical, but good to run after main entities) ---
        $this->call([
            MessageSeeder::class,
            SupportTicketSeeder::class,
            NotificationSeeder::class,
            PaymentSeeder::class,
        ]);

        // --- Pivot Table Logic (user_skills, job_skills) ---
        // This runs AFTER all individual models are populated because it links them.
        $this->seedPivotTables();
    }

    /**
     * Seeds the pivot tables (user_skills, job_skills).
     */
    protected function seedPivotTables(): void
    {
        $skills = Skill::all();
        $jobSeekerUsers = User::role('job_seeker')->get();
        $jobs = Job::all();

        // Check if essential data exists before attempting to attach pivot data
        if ($skills->isEmpty() || $jobSeekerUsers->isEmpty() || $jobs->isEmpty()) {
            echo "Skipping pivot table seeding: Ensure Skills, Job Seekers, and Jobs are seeded first.\n";
            return;
        }

        // Attach skills to job seekers (user_skills pivot table)
        foreach ($jobSeekerUsers as $user) {
            // Attach 2 to 5 random skills to each job seeker
            // min() is used to prevent trying to select more skills than exist
            $user->skills()->attach(
                $skills->random(rand(2, min(5, $skills->count())))->pluck('id')->toArray(),
                ['proficiency_level' => fake()->randomElement(['beginner', 'intermediate', 'advanced'])]
            );
        }

        // Attach skills to jobs (job_skills pivot table)
        foreach ($jobs as $job) {
            // Attach 3 to 7 random skills to each job
            // min() is used to prevent trying to select more skills than exist
            $job->skills()->attach(
                $skills->random(rand(3, min(7, $skills->count())))->pluck('id')->toArray()
            );
        }
    }
}