<?php

namespace App\Http\Controllers;

use App\Models\ConsentLetter;
use App\Models\IEPGoal;
use App\Models\IEPReview;
use App\Models\ProgressRecord;
use App\Support\StudentAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $studentQuery = StudentAccess::queryFor($user);
        $studentIds = (clone $studentQuery)->pluck('id');

        $students = (clone $studentQuery)
            ->with(['teacher', 'counsellor'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'students' => $students,
            'totalStudents' => $studentIds->count(),
            'completedIEP' => IEPGoal::whereIn('student_id', $studentIds)
                ->where('status', 'Completed')
                ->count(),
            'pendingReview' => IEPReview::whereIn('student_id', $studentIds)
                ->where('review_status', '!=', 'Completed')
                ->count(),
            'parentConsent' => ConsentLetter::whereIn('student_id', $studentIds)
                ->where('status', 'Approved')
                ->count(),
            'recentProgress' => ProgressRecord::whereIn('student_id', $studentIds)
                ->whereDate('progress_date', '>=', now()->subDays(30))
                ->count(),
        ]);
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        $user = auth()->user();
        $directory = public_path('uploads/profiles');
        File::ensureDirectoryExists($directory);

        $file = $request->file('profile_picture');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::uuid() . '.' . $extension;
        $file->move($directory, $filename);

        $oldPath = $user->profile_picture
            ? public_path($user->profile_picture)
            : null;

        $user->update([
            'profile_picture' => 'uploads/profiles/' . $filename,
        ]);

        if ($oldPath && File::isFile($oldPath)) {
            File::delete($oldPath);
        }

        return back()->with('success', __('messages.profile_picture_updated'));
    }
}
