<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IEPReview extends Model
{
    use HasFactory;

    protected $table = 'iep_reviews';

    protected $fillable = [
        'student_id',
        'review_date',
        'review_status',
        'review_notes',
        'next_review_date',
        'reviewed_by',
    ];

    protected function casts(): array
    {
        return [
            'review_date' => 'date',
            'next_review_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
