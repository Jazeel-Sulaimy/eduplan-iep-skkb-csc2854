<?php

namespace App\Http\Controllers;

use App\Models\BehaviourRecord;
use App\Models\Student;
use App\Support\RewardCalculator;
use App\Support\StudentAccess;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BehaviourRecordController extends Controller
{
    public function index()
    {
        $studentIds = StudentAccess::queryFor(auth()->user())->pluck('id');
        $behaviours = BehaviourRecord::with('student')
            ->whereIn('student_id', $studentIds)
            ->latest('record_date')
            ->latest('id')
            ->get();

        return view('behaviours.index', compact('behaviours'));
    }

    public function create()
    {
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();
        $behaviour = new BehaviourRecord();
        $rewardRules = RewardCalculator::rules();
        $selectedRewardRule = old('reward_rule');

        return view('behaviours.form', compact(
            'behaviour',
            'students',
            'rewardRules',
            'selectedRewardRule'
        ));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeTeacher(auth()->user(), $student);

        $data = array_merge($data, RewardCalculator::calculate($data['reward_rule']));
        $data['recorded_by'] = auth()->id();

        BehaviourRecord::create($data);

        return redirect()
            ->route('behaviours.index')
            ->with('success', __('messages.reward_calculated_successfully', [
                'points' => RewardCalculator::signedPoints($data['points']),
            ]));
    }

    public function show(BehaviourRecord $behaviour)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $behaviour->student);

        return redirect()->route('behaviours.edit', $behaviour);
    }

    public function edit(BehaviourRecord $behaviour)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $behaviour->student);
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();
        $rewardRules = RewardCalculator::rules();
        $selectedRewardRule = old(
            'reward_rule',
            $behaviour->reward_rule
                ?: RewardCalculator::suggestedRule($behaviour->behaviour_type, $behaviour->points)
        );

        return view('behaviours.form', compact(
            'behaviour',
            'students',
            'rewardRules',
            'selectedRewardRule'
        ));
    }

    public function update(Request $request, BehaviourRecord $behaviour)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $behaviour->student);
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeTeacher(auth()->user(), $student);

        $data = array_merge($data, RewardCalculator::calculate($data['reward_rule']));
        $behaviour->update($data);

        return redirect()
            ->route('behaviours.index')
            ->with('success', __('messages.reward_updated_successfully', [
                'points' => RewardCalculator::signedPoints($data['points']),
            ]));
    }

    public function destroy(BehaviourRecord $behaviour)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $behaviour->student);
        $behaviour->delete();

        return redirect()->route('behaviours.index')->with('success', __('messages.record_deleted_successfully'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'record_date' => ['required', 'date'],
            'reward_rule' => ['required', 'string', Rule::in(RewardCalculator::keys())],
            'description' => ['required', 'string', 'max:2000'],
        ]);
    }
}
