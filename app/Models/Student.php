<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_code',
        'school_name',
        'student_name',
        'student_ic',
        'class_name',
        'gender',
        'date_of_birth',
        'category',
        'programme_type',
        'diagnosis',
        'existing_knowledge',
        'student_ability',
        'address',
        'parent_name',
        'parent_phone',
        'parent_email',
        'parent_user_id',
        'teacher_id',
        'counsellor_id',
        'review_frequency',
        'assignment_notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function parentUser()
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function counsellor()
    {
        return $this->belongsTo(User::class, 'counsellor_id');
    }

    public function goals()
    {
        return $this->hasMany(IEPGoal::class);
    }

    public function behaviours()
    {
        return $this->hasMany(BehaviourRecord::class);
    }

    public function progressRecords()
    {
        return $this->hasMany(ProgressRecord::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function reviews()
    {
        return $this->hasMany(IEPReview::class);
    }

    public function consents()
    {
        return $this->hasMany(ConsentLetter::class);
    }
}
