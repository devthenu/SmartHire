<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// --- START: ADD THESE USE STATEMENTS ---
use App\Models\User; // Don't forget to add this!
use App\Models\ResumeTemplate; // Don't forget to add this!
// --- END: ADD THESE USE STATEMENTS ---

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'resume_template_id', // ✅ Add this
        'full_name', 'email', 'phone', 'address',
        'summary', 'education', 'experience', 'skills',
    ];


    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'skills' => 'array',
    ];
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
