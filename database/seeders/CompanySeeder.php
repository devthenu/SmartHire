<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User; // Make sure to use your User model
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users who have the 'recruiter' role
        $recruiters = User::role('recruiter')->get();

        if ($recruiters->isEmpty()) {
            echo "Skipping CompanySeeder: No recruiters found. Ensure UserSeeder runs first and creates recruiters.\n";
            return;
        }

        // Create one company for each recruiter
        foreach ($recruiters as $recruiter) {
            Company::factory()->create([
                'user_id' => $recruiter->id,
                // You can add more specific company details here if you like,
                // otherwise the factory's definition() will provide defaults.
            ]);
        }

        // Optionally, create a few more random companies not directly linked
        // to a *seeded* recruiter, which will generate new users via their factory.
        // You might assign these new users roles manually later if needed.
        Company::factory(3)->create();
    }
}