<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->role === 'school_admin', 403);

        $students = Student::with(['teacher', 'counsellor', 'parentUser'])
            ->orderBy('student_name')
            ->get();

        $selectedStudent = $request->filled('student_id')
            ? $students->firstWhere('id', (int) $request->student_id)
            : $students->first();

        return view('students.assign', [
            'students' => $students,
            'selectedStudent' => $selectedStudent,
            'teachers' => User::where('role', 'teacher')
                ->where('status', 'Active')
                ->orderBy('name')
                ->get(),
            'counsellors' => User::where('role', 'counsellor')
                ->where('status', 'Active')
                ->orderBy('name')
                ->get(),
            'parents' => User::where('role', 'parent')
                ->where('status', 'Active')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'school_admin', 403);

        $activeRoleExists = function (string $role) {
            return Rule::exists('users', 'id')->where(
                fn ($query) => $query
                    ->where('role', $role)
                    ->where('status', 'Active')
            );
        };

        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['nullable', $activeRoleExists('teacher')],
            'counsellor_id' => ['nullable', $activeRoleExists('counsellor')],
            'parent_user_id' => ['nullable', $activeRoleExists('parent')],
            'review_frequency' => [
                'nullable',
                Rule::in(['Weekly', 'Monthly', 'Quarterly', 'Yearly']),
            ],
            'assignment_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $student = DB::transaction(function () use ($data) {
            $student = Student::lockForUpdate()->findOrFail($data['student_id']);

            $update = [
                'teacher_id' => $data['teacher_id'] ?? null,
                'counsellor_id' => $data['counsellor_id'] ?? null,
                'parent_user_id' => $data['parent_user_id'] ?? null,
                'review_frequency' => $data['review_frequency'] ?? null,
                'assignment_notes' => $data['assignment_notes'] ?? null,
                'parent_name' => null,
                'parent_phone' => null,
                'parent_email' => null,
            ];

            if (! empty($data['parent_user_id'])) {
                $parent = User::where('role', 'parent')
                    ->where('status', 'Active')
                    ->findOrFail($data['parent_user_id']);

                $update['parent_name'] = $parent->name;
                $update['parent_phone'] = $parent->phone;
                $update['parent_email'] = $parent->email;
            }

            $student->update($update);

            return $student;
        });

        return redirect()
            ->route('assign.staff', ['student_id' => $student->id])
            ->with('success', __('messages.assignment_saved'));
    }
}
