<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Student;
use App\Support\StudentAccess;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $studentIds = StudentAccess::queryFor(auth()->user())->pluck('id');
        $consultations = Consultation::with('student')->whereIn('student_id', $studentIds)->latest()->get();

        return view('consultations.index', compact('consultations'));
    }

    public function create()
    {
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();
        $consultation = new Consultation();

        return view('consultations.form', compact('consultation', 'students'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeCounsellor(auth()->user(), $student);
        $data['recorded_by'] = auth()->id();
        Consultation::create($data);

        return redirect()->route('consultations.index')->with('success', __('messages.record_saved_successfully'));
    }

    public function show(Consultation $consultation)
    {
        StudentAccess::authorizeCounsellor(auth()->user(), $consultation->student);

        return redirect()->route('consultations.edit', $consultation);
    }

    public function edit(Consultation $consultation)
    {
        StudentAccess::authorizeCounsellor(auth()->user(), $consultation->student);
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();

        return view('consultations.form', compact('consultation', 'students'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        StudentAccess::authorizeCounsellor(auth()->user(), $consultation->student);
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeCounsellor(auth()->user(), $student);
        $consultation->update($data);

        return redirect()->route('consultations.index')->with('success', __('messages.record_updated_successfully'));
    }

    public function destroy(Consultation $consultation)
    {
        StudentAccess::authorizeCounsellor(auth()->user(), $consultation->student);
        $consultation->delete();

        return redirect()->route('consultations.index')->with('success', __('messages.record_deleted_successfully'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'case_title' => ['required', 'string', 'max:150'],
            'priority' => ['required', 'string', 'max:50'],
            'consultation_notes' => ['nullable', 'string'],
            'support_plan' => ['nullable', 'string'],
            'support_type' => ['nullable', 'string', 'max:100'],
            'review_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
        ]);
    }
}
