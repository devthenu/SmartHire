<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    // --- START: ADD THIS RELATIONSHIP METHOD ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // --- END: ADD THIS RELATIONSHIP METHOD ---
}
