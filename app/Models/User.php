<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'identification_card',
        'address',
        'role',
        'password',
        'profile_picture',
        'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'school_admin' => __('messages.role_school_admin'),
            'teacher' => __('messages.role_teacher'),
            'counsellor' => __('messages.role_counsellor'),
            'parent' => __('messages.role_parent'),
            'system_admin' => __('messages.role_system_admin'),
            default => __('messages.user'),
        };
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function teacherStudents()
    {
        return $this->hasMany(Student::class, 'teacher_id');
    }

    public function counsellorStudents()
    {
        return $this->hasMany(Student::class, 'counsellor_id');
    }

    public function parentStudents()
    {
        return $this->hasMany(Student::class, 'parent_user_id');
    }
}
