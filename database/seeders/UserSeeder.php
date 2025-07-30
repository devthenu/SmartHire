<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role; // IMPORTANT: Use Spatie's Role model for role assignment
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // For hashing passwords

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist before assigning them.
        // This assumes RolesTableSeeder has already been called.
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $supportRole = Role::firstOrCreate(['name' => 'support']);
        $jobSeekerRole = Role::firstOrCreate(['name' => 'job_seeker']);
        $recruiterRole = Role::firstOrCreate(['name' => 'recruiter']);

        // 1. Create an Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@smarthire.com'], // Check if user with this email already exists
            [
                'name' => 'SmartHire Admin',
                'password' => Hash::make('password'), // Default password for easy testing
            ]
        );
        $admin->assignRole('admin'); // Assign role using Spatie's method

        // 2. Create a Support user
        $support = User::firstOrCreate(
            ['email' => 'support@smarthire.com'],
            [
                'name' => 'Support Agent',
                'password' => Hash::make('password'),
            ]
        );
        $support->assignRole('support');

        // 3. Create Job Seekers (10 random users)
        User::factory(10)->create()->each(function ($user) use ($jobSeekerRole) {
            // Assign the 'job_seeker' role to each newly created user
            $user->assignRole('job_seeker');
        });

        // 4. Create Recruiters (5 random users)
        User::factory(5)->create()->each(function ($user) use ($recruiterRole) {
            // Assign the 'recruiter' role to each newly created user
            $user->assignRole('recruiter');
        });
    }
}