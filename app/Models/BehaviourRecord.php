<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BehaviourRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'record_date',
        'behaviour_type',
        'description',
        'points',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'record_date' => 'date',
            'points' => 'integer',
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
