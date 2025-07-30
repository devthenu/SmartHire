<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResumeTemplate>
 */
class ResumeTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word() . ' Template',
            'description' => fake()->sentence(),
            'preview_image' => fake()->imageUrl(640, 480, 'templates', true), // Added based on your migration
            'html_structure' => '<div class="template-'.fake()->word().'"><h1 style="color:blue;">{{ $name }}</h1><p>{{ $summary }}</p></div>', // Added based on your migration
        ];
    }
}