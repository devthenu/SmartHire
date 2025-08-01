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

    // Add the $fillable property if you haven't already, for mass assignment
    protected $fillable = [
        'user_id',
        'company_id',
        'title',
        'description',
        'location',
        'type',
        'salary',
        'deadline', // Make sure 'deadline' is in your fillable array
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'datetime', // <-- THIS IS THE LINE YOU NEED TO ADD
        // 'created_at' => 'datetime', // These are default, but good to have for clarity
        // 'updated_at' => 'datetime',
    ];
    
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
