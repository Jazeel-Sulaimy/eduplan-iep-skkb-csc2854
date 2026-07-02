<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsentLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'parent_name',
        'parent_ic',
        'student_ic',
        'consent_date',
        'agreement_text',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'consent_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
