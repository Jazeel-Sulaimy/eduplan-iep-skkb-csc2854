<?php

namespace App\Http\Controllers;

use App\Support\StudentAccess;

class MockupPageController extends Controller
{
    public function roles()
    {
        return view('users.roles');
    }

    public function supportPlan()
    {
        return view('consultations.support', [
            'students' => StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get(),
        ]);
    }

    public function interventionPlan()
    {
        return view('goals.intervention');
    }

    public function systemSettings()
    {
        return view('system.settings');
    }
}
