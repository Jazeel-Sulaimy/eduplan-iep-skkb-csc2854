<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'case_title',
        'priority',
        'consultation_notes',
        'support_plan',
        'support_type',
        'review_date',
        'recorded_by',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'review_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
