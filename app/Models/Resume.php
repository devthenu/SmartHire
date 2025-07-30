<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// --- START: ADD THESE USE STATEMENTS ---
use App\Models\User; // Don't forget to add this!
use App\Models\ResumeTemplate; // Don't forget to add this!
// --- END: ADD THESE USE STATEMENTS ---

class Resume extends Model
{
        // --- START: ADD THESE RELATIONSHIP METHODS ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resumeTemplate()
    {
        return $this->belongsTo(ResumeTemplate::class);
    }

    // --- END: ADD THESE RELATIONSHIP METHODS ---

}
