<?php

namespace App\Http\Controllers;

use App\Models\IEPGoal;
use App\Models\Student;
use App\Support\StudentAccess;
use Illuminate\Http\Request;

class IEPGoalController extends Controller
{
    public function index()
    {
        $studentIds = StudentAccess::queryFor(auth()->user())->pluck('id');
        $goals = IEPGoal::with('student')->whereIn('student_id', $studentIds)->latest()->get();

        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();
        $goal = new IEPGoal();

        return view('goals.form', compact('goal', 'students'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeTeacher(auth()->user(), $student);

        IEPGoal::create($data);

        return redirect()->route('goals.index')->with('success', __('messages.record_saved_successfully'));
    }

    public function show(IEPGoal $goal)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $goal->student);

        return redirect()->route('goals.edit', $goal);
    }

    public function edit(IEPGoal $goal)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $goal->student);
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();

        return view('goals.form', compact('goal', 'students'));
    }

    public function update(Request $request, IEPGoal $goal)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $goal->student);
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeTeacher(auth()->user(), $student);
        $goal->update($data);

        return redirect()->route('goals.index')->with('success', __('messages.record_updated_successfully'));
    }

    public function destroy(IEPGoal $goal)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $goal->student);
        $goal->delete();

        return redirect()->route('goals.index')->with('success', __('messages.record_deleted_successfully'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'curriculum_followed' => ['nullable', 'string', 'max:150'],
            'iep_focus' => ['nullable', 'string', 'max:100'],
            'main_challenges' => ['nullable', 'string'],
            'long_term_goals' => ['required', 'string'],
            'short_term_goals' => ['required', 'string'],
            'intervention_strategy' => ['nullable', 'string'],
            'achievement' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'review_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
        ]);
    }
}
