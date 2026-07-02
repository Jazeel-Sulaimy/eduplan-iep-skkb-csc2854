<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'progress_date',
        'progress_status',
        'progress_notes',
        'positive_updates',
        'need_monitoring',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'progress_date' => 'date',
            'positive_updates' => 'integer',
            'need_monitoring' => 'integer',
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
