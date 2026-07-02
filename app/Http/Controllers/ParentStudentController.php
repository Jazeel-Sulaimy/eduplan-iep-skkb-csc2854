<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Support\StudentAccess;

class ParentStudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['teacher', 'counsellor'])
            ->where('parent_user_id', auth()->id())
            ->orderBy('student_name')
            ->get();

        return view('parent.students.index', compact('students'));
    }

    public function show(Student $student)
    {
        StudentAccess::authorizeParent(auth()->user(), $student);

        $student->load([
            'teacher',
            'counsellor',
            'goals',
            'progressRecords',
            'behaviours',
            'consents',
            'reviews',
        ]);

        return view('parent.students.show', compact('student'));
    }

    public function iep()
    {
        $students = Student::with('goals')
            ->where('parent_user_id', auth()->id())
            ->orderBy('student_name')
            ->get();

        return view('parent.iep-index', compact('students'));
    }

    public function progress()
    {
        $students = Student::with(['progressRecords' => fn ($query) => $query->latest('progress_date')])
            ->where('parent_user_id', auth()->id())
            ->orderBy('student_name')
            ->get();

        return view('parent.progress-index', compact('students'));
    }

    public function behaviour()
    {
        $students = Student::with(['behaviours' => fn ($query) => $query->latest('record_date')])
            ->where('parent_user_id', auth()->id())
            ->orderBy('student_name')
            ->get();

        return view('parent.behaviour-index', compact('students'));
    }
}
