<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResumeTemplate;

class ResumeTemplateSeeder extends Seeder
{
    public function run(): void
    {
        ResumeTemplate::insert([
            [
                'name' => 'Simple Modern',
                'html_structure' => '<h1>{{ $name }}</h1><p>{{ $summary }}</p>',
            ],
            [
                'name' => 'Elegant Minimal',
                'html_structure' => '<div><strong>{{ $name }}</strong><br>{{ $email }}</div>',
            ],
            [
                'name' => 'Creative Professional',
                'html_structure' => '<section><header>{{ $name }}</header><article>{{ $experience }}</article></section>',
            ],
        ]);
    }
}
