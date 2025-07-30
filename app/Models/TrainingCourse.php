<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// --- START: ADD THIS USE STATEMENT ---
use App\Models\CourseEnrollment;
// --- END: ADD THIS USE STATEMENT ---

class TrainingCourse extends Model
{
    // --- START: ADD THIS RELATIONSHIP METHOD ---

    public function courseEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    // --- END: ADD THIS RELATIONSHIP METHOD ---
}
