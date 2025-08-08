<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\TrainingCourse::insert([
            [
                'title' => 'Laravel Fundamentals',
                'provider' => 'Laracasts',
                'url' => 'https://laracasts.com',
                'price' => 0,
                'description' => 'Learn Laravel from scratch.',
                'skills_covered' => json_encode(['laravel','php','mvc']),
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'title' => 'PostgreSQL for Developers',
                'provider' => 'Udemy',
                'url' => 'https://udemy.com',
                'price' => 2999,
                'description' => 'Indexes, constraints, stored procedures.',
                'skills_covered' => json_encode(['postgresql','sql','plpgsql']),
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }

}
