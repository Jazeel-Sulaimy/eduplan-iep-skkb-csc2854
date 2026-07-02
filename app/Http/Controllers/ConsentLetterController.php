<?php

namespace App\Http\Controllers;

use App\Models\ConsentLetter;
use App\Models\Student;
use App\Support\StudentAccess;
use Illuminate\Http\Request;

class ConsentLetterController extends Controller
{
    public function index()
    {
        $studentIds = StudentAccess::queryFor(auth()->user())->pluck('id');
        $consents = ConsentLetter::with('student')->whereIn('student_id', $studentIds)->latest()->get();

        return view('consents.index', compact('consents'));
    }

    public function create()
    {
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();
        $consent = new ConsentLetter();

        return view('consents.form', compact('consent', 'students'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeParent(auth()->user(), $student);

        $data['parent_name'] = auth()->user()->name;
        $data['parent_ic'] = auth()->user()->identification_card ?: $data['parent_ic'];
        $data['student_ic'] = $student->student_ic;
        $data['status'] = 'Approved';
        ConsentLetter::create($data);

        return redirect()->route('consents.index')->with('success', __('messages.record_saved_successfully'));
    }

    public function show(ConsentLetter $consent)
    {
        StudentAccess::authorizeParent(auth()->user(), $consent->student);

        return redirect()->route('consents.edit', $consent);
    }

    public function edit(ConsentLetter $consent)
    {
        StudentAccess::authorizeParent(auth()->user(), $consent->student);
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();

        return view('consents.form', compact('consent', 'students'));
    }

    public function update(Request $request, ConsentLetter $consent)
    {
        StudentAccess::authorizeParent(auth()->user(), $consent->student);
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeParent(auth()->user(), $student);

        $data['parent_name'] = auth()->user()->name;
        $data['parent_ic'] = auth()->user()->identification_card ?: $data['parent_ic'];
        $data['student_ic'] = $student->student_ic;
        $data['status'] = 'Approved';
        $consent->update($data);

        return redirect()->route('consents.index')->with('success', __('messages.record_updated_successfully'));
    }

    public function destroy(ConsentLetter $consent)
    {
        StudentAccess::authorizeParent(auth()->user(), $consent->student);
        $consent->delete();

        return redirect()->route('consents.index')->with('success', __('messages.record_deleted_successfully'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'parent_ic' => ['required', 'string', 'max:30'],
            'consent_date' => ['required', 'date'],
            'agreement_text' => ['nullable', 'string'],
        ]);
    }
}
