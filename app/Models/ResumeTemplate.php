<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Resume; // Don't forget to add this!

class ResumeTemplate extends Model
{
    // --- START: ADD THIS RELATIONSHIP METHOD ---

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    // --- END: ADD THIS RELATIONSHIP METHOD ---
}
