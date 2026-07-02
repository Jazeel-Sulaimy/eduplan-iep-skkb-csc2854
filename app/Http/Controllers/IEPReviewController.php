<?php

namespace App\Http\Controllers;

use App\Models\IEPReview;
use App\Models\Student;
use App\Support\StudentAccess;
use Illuminate\Http\Request;

class IEPReviewController extends Controller
{
    public function index()
    {
        $studentIds = StudentAccess::queryFor(auth()->user())->pluck('id');
        $reviews = IEPReview::with('student')->whereIn('student_id', $studentIds)->latest()->get();

        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();
        $review = new IEPReview();

        return view('reviews.form', compact('review', 'students'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeCounsellor(auth()->user(), $student);
        $data['reviewed_by'] = auth()->id();
        IEPReview::create($data);

        return redirect()->route('reviews.index')->with('success', __('messages.record_saved_successfully'));
    }

    public function show(IEPReview $review)
    {
        StudentAccess::authorizeCounsellor(auth()->user(), $review->student);

        return redirect()->route('reviews.edit', $review);
    }

    public function edit(IEPReview $review)
    {
        StudentAccess::authorizeCounsellor(auth()->user(), $review->student);
        $students = StudentAccess::queryFor(auth()->user())->orderBy('student_name')->get();

        return view('reviews.form', compact('review', 'students'));
    }

    public function update(Request $request, IEPReview $review)
    {
        StudentAccess::authorizeCounsellor(auth()->user(), $review->student);
        $data = $this->validated($request);
        $student = Student::findOrFail($data['student_id']);
        StudentAccess::authorizeCounsellor(auth()->user(), $student);
        $review->update($data);

        return redirect()->route('reviews.index')->with('success', __('messages.record_updated_successfully'));
    }

    public function destroy(IEPReview $review)
    {
        StudentAccess::authorizeCounsellor(auth()->user(), $review->student);
        $review->delete();

        return redirect()->route('reviews.index')->with('success', __('messages.record_deleted_successfully'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'review_date' => ['required', 'date'],
            'review_status' => ['required', 'string', 'max:50'],
            'review_notes' => ['required', 'string'],
            'next_review_date' => ['nullable', 'date'],
        ]);
    }
}
