<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// --- START: ADD THESE USE STATEMENTS ---
use App\Models\User;
use App\Models\Job;
// --- END: ADD THESE USE STATEMENTS ---

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name','category'];
    // --- START: ADD THESE RELATIONSHIP METHODS ---

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills')->withTimestamps();
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_skills')->withTimestamps();
    }

    // --- END: ADD THESE RELATIONSHIP METHODS ---
}
