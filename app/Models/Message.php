<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Don't forget to add this!

class Message extends Model
{
    // --- START: ADD THESE RELATIONSHIP METHODS ---

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // --- END: ADD THESE RELATIONSHIP METHODS ---
}
