<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IEPGoal extends Model
{
    use HasFactory;

    protected $table = 'iep_goals';

    protected $fillable = [
        'student_id',
        'curriculum_followed',
        'iep_focus',
        'main_challenges',
        'long_term_goals',
        'short_term_goals',
        'intervention_strategy',
        'achievement',
        'start_date',
        'review_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'review_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
