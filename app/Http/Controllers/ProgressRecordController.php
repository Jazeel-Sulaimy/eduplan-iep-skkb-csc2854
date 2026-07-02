<?php

namespace App\Http\Controllers;

use App\Models\ProgressRecord;
use App\Models\Student;
use App\Support\StudentAccess;
use Illuminate\Http\Request;

class ProgressRecordController extends Controller
{
    public function index()
    {
        $studentIds = StudentAccess::queryFor(auth()->user())->pluck('id');
        $progress = ProgressRecord::with('student')->whereIn('student_id', $studentIds)->latest()->get();

        return view('progress.index', compact('progress'));
    }

    public function create()
    {
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();
        $progress = new ProgressRecord();

        return view('progress.form', compact('progress', 'students'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeTeacher(auth()->user(), $student);
        $data['recorded_by'] = auth()->id();
        ProgressRecord::create($data);

        return redirect()->route('progress.index')->with('success', __('messages.record_saved_successfully'));
    }

    public function show(ProgressRecord $progress)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $progress->student);

        return redirect()->route('progress.edit', $progress);
    }

    public function edit(ProgressRecord $progress)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $progress->student);
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();

        return view('progress.form', compact('progress', 'students'));
    }

    public function update(Request $request, ProgressRecord $progress)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $progress->student);
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeTeacher(auth()->user(), $student);
        $progress->update($data);

        return redirect()->route('progress.index')->with('success', __('messages.record_updated_successfully'));
    }

    public function destroy(ProgressRecord $progress)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $progress->student);
        $progress->delete();

        return redirect()->route('progress.index')->with('success', __('messages.record_deleted_successfully'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'progress_date' => ['required', 'date'],
            'progress_status' => ['required', 'string', 'max:50'],
            'progress_notes' => ['required', 'string'],
            'positive_updates' => ['nullable', 'integer'],
            'need_monitoring' => ['nullable', 'integer'],
        ]);
    }
}
