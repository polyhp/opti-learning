<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'email', 'password', 'first_name', 'last_name', 'phone',
        'gender', 'birth_date', 'birth_place', 'avatar', 'is_active','role', 'residence'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];
      // Méthode pour vérifier le rôle
    public function hasRole($role)
    {
        return $this->role === $role;
    }


    public function formateur()
    {
        return $this->hasOne(Formateur::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function completedLessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')->withPivot('completed_at')->withTimestamps();
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/avatars/'.$this->avatar) : 'https://ui-avatars.com/api/?background=0D2B42&color=FF6B35&bold=true&name='.urlencode($this->full_name);
    }
}