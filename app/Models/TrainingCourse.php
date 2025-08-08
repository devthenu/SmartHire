<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// --- START: ADD THIS USE STATEMENT ---
use App\Models\CourseEnrollment;
// --- END: ADD THIS USE STATEMENT ---

class TrainingCourse extends Model
{
    use HasFactory;
    // --- START: ADD THIS RELATIONSHIP METHOD ---

    public function courseEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    // --- END: ADD THIS RELATIONSHIP METHOD ---

    // Allow mass assignment for these columns
    protected $fillable = [
        'title',
        'provider',
        'url',
        'price',
        'description',
        'skills_covered',
    ];

    // skills_covered is JSON in DB
    protected $casts = [
        'skills_covered' => 'array',
        'price' => 'decimal:2',
    ];

}
