<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Support\StudentAccess;

class TeacherStudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['counsellor', 'parentUser', 'goals'])
            ->where('teacher_id', auth()->id())
            ->orderBy('student_name')
            ->get();

        return view('teacher.students.index', compact('students'));
    }

    public function show(Student $student)
    {
        StudentAccess::authorizeTeacher(auth()->user(), $student);

        $student->load([
            'teacher',
            'counsellor',
            'parentUser',
            'goals',
            'progressRecords',
            'behaviours',
            'consultations',
            'reviews',
        ]);

        return view('teacher.students.show', compact('student'));
    }
}
