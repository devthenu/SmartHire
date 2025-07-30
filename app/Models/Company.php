<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Don't forget to add this!
use App\Models\Job; // Don't forget to add this!
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{   
    use HasFactory;
    // --- START: ADD THESE RELATIONSHIP METHODS ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    // --- END: ADD THESE RELATIONSHIP METHODS ---
}
