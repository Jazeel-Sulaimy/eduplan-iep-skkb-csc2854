<?php

namespace App\Http\Controllers;

use App\Support\RewardCalculator;
use App\Support\StudentAccess;

class RewardController extends Controller
{
    public function index()
    {
        $students = StudentAccess::queryFor(auth()->user())
            ->with(['behaviours' => fn ($query) => $query->latest('record_date')])
            ->orderBy('student_name')
            ->get()
            ->map(function ($student) {
                $positivePoints = $student->behaviours
                    ->where('points', '>', 0)
                    ->sum('points');

                $deductionPoints = abs($student->behaviours
                    ->where('points', '<', 0)
                    ->sum('points'));

                $totalPoints = (int) $student->behaviours->sum('points');
                $level = RewardCalculator::level($totalPoints);

                $student->reward_summary = [
                    'positive' => (int) $positivePoints,
                    'deductions' => (int) $deductionPoints,
                    'total' => $totalPoints,
                    'level_key' => $level['key'],
                    'level_label' => __($level['label_key']),
                ];

                return $student;
            });

        $summary = [
            'students' => $students->count(),
            'positive' => $students->sum(fn ($student) => $student->reward_summary['positive']),
            'deductions' => $students->sum(fn ($student) => $student->reward_summary['deductions']),
            'total' => $students->sum(fn ($student) => $student->reward_summary['total']),
        ];

        $rewardRules = RewardCalculator::rules();

        return view('rewards.index', compact('students', 'summary', 'rewardRules'));
    }
}
