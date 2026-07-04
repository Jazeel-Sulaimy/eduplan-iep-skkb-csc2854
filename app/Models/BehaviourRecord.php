<?php

namespace App\Models;

use App\Support\RewardCalculator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BehaviourRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'record_date',
        'behaviour_type',
        'reward_rule',
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

    public function rewardLabel(): string
    {
        $rule = RewardCalculator::rules()[$this->reward_rule] ?? null;

        return $rule
            ? __($rule['label_key'])
            : __('messages.legacy_manual_record');
    }

    public function behaviourTypeLabel(): string
    {
        return match ($this->behaviour_type) {
            'Positive' => __('messages.positive'),
            'Negative' => __('messages.negative'),
            'Neutral' => __('messages.neutral'),
            default => $this->behaviour_type ?: '-',
        };
    }

    public function signedPoints(): string
    {
        return RewardCalculator::signedPoints((int) $this->points);
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
