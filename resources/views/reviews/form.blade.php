@extends('layouts.app')

@section('content')
@php
    $isEdit = $review->exists;
@endphp

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => 'Review'])

    <div class="mockup-panel">
        <h2>IEP Review</h2>
        <form method="POST" action="{{ $isEdit ? route('reviews.update', $review) : route('reviews.store') }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="form-grid">
                <div>
                    <label>Student</label>
                    <select class="select" name="student_id" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $review->student_id ?: request('student_id')) == $student->id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>IEP Review Status</label>
                    <select class="select" name="review_status" required>
                        @foreach(['Submitted', 'Scheduled', 'Completed', 'Need Follow-up'] as $status)
                            <option value="{{ $status }}" {{ old('review_status', $review->review_status ?? 'Submitted') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Review Date</label>
                    <input class="input" type="date" name="review_date" value="{{ old('review_date', optional($review->review_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label>Next Review Date</label>
                    <input class="input" type="date" name="next_review_date" value="{{ old('next_review_date', optional($review->next_review_date)->format('Y-m-d')) }}">
                </div>
                <div class="full">
                    <label>Review Notes</label>
                    <textarea name="review_notes" required>{{ old('review_notes', $review->review_notes) }}</textarea>
                </div>
            </div>
            <div class="actions">
                <button class="btn" type="submit">Save Review</button>
            </div>
        </form>
    </div>
</div>
@endsection
