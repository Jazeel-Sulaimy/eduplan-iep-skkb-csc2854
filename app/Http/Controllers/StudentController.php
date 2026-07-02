<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Support\StudentAccess;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = StudentAccess::queryFor(auth()->user())
            ->with(['teacher', 'counsellor', 'parentUser'])
            ->latest()
            ->get();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        $this->authorizeRegistrationManagement();

        return view('students.form', ['student' => new Student()]);
    }

    public function store(Request $request)
    {
        $this->authorizeRegistrationManagement();

        Student::create($this->validatedRegistration($request));

        return redirect()
            ->route('students.index')
            ->with('success', __('messages.student_registered_successfully'));
    }

    public function show(Student $student)
    {
        StudentAccess::authorizeView(auth()->user(), $student);

        $student->load([
            'teacher',
            'counsellor',
            'parentUser',
            'goals',
            'behaviours',
            'progressRecords',
            'consultations',
            'reviews',
            'consents',
        ]);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $this->authorizeRegistrationManagement();

        return view('students.form', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $this->authorizeRegistrationManagement();

        $student->update($this->validatedRegistration($request, $student->id));

        return redirect()
            ->route('students.index')
            ->with('success', __('messages.student_updated_successfully'));
    }

    public function destroy(Student $student)
    {
        $this->authorizeRegistrationManagement();

        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', __('messages.student_deleted_successfully'));
    }

    private function authorizeRegistrationManagement(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole('school_admin', 'system_admin'),
            403
        );
    }

    private function validatedRegistration(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'school_code' => ['nullable', 'string', 'max:50'],
            'school_name' => ['nullable', 'string', 'max:150'],
            'student_name' => ['required', 'string', 'max:150'],
            'student_ic' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('students', 'student_ic')->ignore($ignoreId),
            ],
            'class_name' => ['required', 'string', 'max:50'],
            'gender' => ['nullable', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'category' => ['nullable', 'string', 'max:100'],
            'programme_type' => ['nullable', 'string', 'max:150'],
            'diagnosis' => ['nullable', 'string', 'max:5000'],
            'existing_knowledge' => ['nullable', 'string', 'max:5000'],
            'student_ability' => ['nullable', 'string', 'max:5000'],
            'address' => ['nullable', 'string', 'max:2000'],
            'status' => [
                'required',
                Rule::in([
                    'Completed',
                    'Parent Consent',
                    'Counsellor Review',
                    'In Progress',
                    'Active',
                    'Inactive',
                ]),
            ],
        ]);
    }
}
