<?php

namespace Database\Seeders;

use App\Models\Skill; // Make sure to use your Skill model
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define a list of common skills with categories
        $predefinedSkills = [
            // Programming Languages
            ['name' => 'PHP', 'category' => 'Backend'],
            ['name' => 'JavaScript', 'category' => 'Frontend'],
            ['name' => 'Python', 'category' => 'Backend'],
            ['name' => 'Java', 'category' => 'Backend'],
            ['name' => 'C#', 'category' => 'Backend'],
            ['name' => 'TypeScript', 'category' => 'Frontend'],

            // Frameworks & Libraries
            ['name' => 'Laravel', 'category' => 'Framework'],
            ['name' => 'Vue.js', 'category' => 'Frontend Framework'],
            ['name' => 'React', 'category' => 'Frontend Framework'],
            ['name' => 'Angular', 'category' => 'Frontend Framework'],
            ['name' => 'Node.js', 'category' => 'Backend Runtime'],
            ['name' => 'Express.js', 'category' => 'Backend Framework'],

            // Databases
            ['name' => 'PostgreSQL', 'category' => 'Database'],
            ['name' => 'MySQL', 'category' => 'Database'],
            ['name' => 'MongoDB', 'category' => 'NoSQL Database'],

            // Frontend Technologies
            ['name' => 'HTML', 'category' => 'Frontend'],
            ['name' => 'CSS', 'category' => 'Frontend'],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend Framework'],

            // Cloud & DevOps
            ['name' => 'AWS', 'category' => 'Cloud'],
            ['name' => 'Docker', 'category' => 'DevOps'],
            ['name' => 'Git', 'category' => 'DevOps'],

            // Testing
            ['name' => 'PHPUnit', 'category' => 'Testing'],
            ['name' => 'Jest', 'category' => 'Testing'],

            // Soft Skills & Other
            ['name' => 'Communication', 'category' => 'Soft Skill'],
            ['name' => 'Problem Solving', 'category' => 'Soft Skill'],
            ['name' => 'Teamwork', 'category' => 'Soft Skill'],
            ['name' => 'Project Management', 'category' => 'Project Management'],
            ['name' => 'API Design', 'category' => 'General'],
        ];

        // Create predefined skills using firstOrCreate to avoid duplicates if run multiple times
        foreach ($predefinedSkills as $skillData) {
            Skill::firstOrCreate(['name' => $skillData['name']], $skillData);
        }

        // Create additional random skills using the factory
        Skill::factory(20)->create();
    }
}