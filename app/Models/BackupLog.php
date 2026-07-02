<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'backup_date',
        'backup_name',
        'performed_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'backup_date' => 'datetime',
        ];
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
