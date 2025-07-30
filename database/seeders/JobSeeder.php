<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User; // Make sure to use your User model
use App\Models\Company; // Make sure to use your Company model
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users who have the 'recruiter' role
        $recruiters = User::role('recruiter')->get();

        if ($recruiters->isEmpty()) {
            echo "Skipping JobSeeder: No recruiters found. Ensure UserSeeder runs first.\n";
            return;
        }

        foreach ($recruiters as $recruiter) {
            // Ensure the recruiter has a company before creating jobs for it.
            // This relies on the 'company()' relationship defined in your User model.
            // If a recruiter doesn't have a company, create one for them.
            $company = $recruiter->company;
            if (!$company) {
                echo "Warning: Recruiter ID {$recruiter->id} has no company. Creating one.\n";
                $company = Company::factory()->create(['user_id' => $recruiter->id]);
            }

            // Create 3 jobs for each recruiter's company
            Job::factory(3)->create([
                'user_id' => $recruiter->id,
                'company_id' => $company->id,
            ]);
        }

        // Create some additional jobs linked to random companies and recruiters
        $allCompanies = Company::all();
        $allRecruiters = User::role('recruiter')->get();

        if ($allCompanies->isNotEmpty() && $allRecruiters->isNotEmpty()) {
            Job::factory(10)->create([
                'company_id' => $allCompanies->random()->id,
                'user_id' => $allRecruiters->random()->id,
            ]);
        } else if ($allCompanies->isNotEmpty() && $allRecruiters->isEmpty()) {
            // Fallback if no recruiters but companies exist (less ideal but prevents error)
             Job::factory(5)->create([
                'company_id' => $allCompanies->random()->id,
             ]);
        } else {
            // If neither exist, factories will create new ones, which might not link to existing data
            Job::factory(5)->create();
        }
    }
}