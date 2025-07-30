<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resume_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('preview_image')->nullable();
            $table->text('description')->nullable();
            $table->longText('html_structure'); // Blade/HTML template string
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_templates');
    }
};
