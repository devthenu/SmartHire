<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
// --- START: ADD THESE USE STATEMENTS ---
use App\Models\Resume;
use App\Models\Company;
use App\Models\Application;
use App\Models\Skill;
use App\Models\CourseEnrollment;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\Message;
use App\Models\AuditLog;
use App\Models\SupportTicket;
// --- END: ADD THESE USE STATEMENTS ---

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- START: ADD THESE RELATIONSHIP METHODS ---

    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills')->withTimestamps();
    }

    public function courseEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // --- END: ADD THESE RELATIONSHIP METHODS ---

    // Don't forget to add the Role relationship if you have a separate App\Models\Role
    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }
}
