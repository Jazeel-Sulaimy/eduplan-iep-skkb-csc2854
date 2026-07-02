<?php

namespace App\Http\Controllers;

use App\Models\BehaviourRecord;
use App\Models\Student;
use App\Support\StudentAccess;
use Illuminate\Http\Request;

class BehaviourRecordController extends Controller
{
    public function index()
    {
        $studentIds = StudentAccess::queryFor(auth()->user())->pluck('id');
        $behaviours = BehaviourRecord::with('student')->whereIn('student_id', $studentIds)->latest()->get();

        return view('behaviours.index', compact('behaviours'));
    }

    public function create()
    {
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();
        $behaviour = new BehaviourRecord();

        return view('behaviours.form', compact('behaviour', 'students'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeTeacher(auth()->user(), $student);
        $data['recorded_by'] = auth()->id();
        BehaviourRecord::create($data);

        return redirect()->route('behaviours.index')->with('success', __('messages.record_saved_successfully'));
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

        return view('behaviours.form', compact('behaviour', 'students'));
    }

    public function update(Request $request, BehaviourRecord $behaviour)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $behaviour->student);
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeTeacher(auth()->user(), $student);
        $behaviour->update($data);

        return redirect()->route('behaviours.index')->with('success', __('messages.record_updated_successfully'));
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
            'behaviour_type' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'points' => ['required', 'integer'],
        ]);
    }
}
