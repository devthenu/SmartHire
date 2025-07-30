<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// --- START: ADD THESE USE STATEMENTS ---
use App\Models\User;
use App\Models\Company;
use App\Models\Application;
use App\Models\Skill;
// --- END: ADD THESE USE STATEMENTS ---

class Job extends Model
{
    use HasFactory;
        // --- START: ADD THESE RELATIONSHIP METHODS ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills')->withTimestamps();
    }

    // --- END: ADD THESE RELATIONSHIP METHODS ---
}
