<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// --- START: ADD THESE USE STATEMENTS ---
use App\Models\User;
use App\Models\Job;
// --- END: ADD THESE USE STATEMENTS ---

class Application extends Model
{
        // --- START: ADD THESE RELATIONSHIP METHODS ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // --- END: ADD THESE RELATIONSHIP METHODS ---
}
