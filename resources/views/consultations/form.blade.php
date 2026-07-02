@extends('layouts.app')

@section('content')
@php
    $isEdit = $consultation->exists;
@endphp

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => 'Counselling Notes'])

    <div class="mockup-panel">
        <h2>Counselling Notes</h2>
        <form method="POST" action="{{ $isEdit ? route('consultations.update', $consultation) : route('consultations.store') }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="form-grid">
                <div>
                    <label>Select Student</label>
                    <select class="select" name="student_id" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $consultation->student_id ?: request('student_id')) == $student->id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Review Date</label>
                    <input class="input" type="date" name="review_date" value="{{ old('review_date', $consultation->review_date) }}">
                </div>
                <div>
                    <label>Student Issue</label>
                    <input class="input" type="text" name="case_title" value="{{ old('case_title', $consultation->case_title ?? 'Low Participation') }}" required>
                </div>
                <div>
                    <label>Priority</label>
                    <select class="select" name="priority" required>
                        @foreach(['Low', 'Medium', 'High'] as $priority)
                            <option value="{{ $priority }}" {{ old('priority', $consultation->priority ?? 'Medium') == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="full">
                    <label>Counsellor Comments</label>
                    <textarea name="consultation_notes">{{ old('consultation_notes', $consultation->consultation_notes) }}</textarea>
                </div>
                <div class="full">
                    <input type="hidden" name="support_plan" value="{{ old('support_plan', $consultation->support_plan) }}">
                    <input type="hidden" name="support_type" value="{{ old('support_type', $consultation->support_type ?? 'Behaviour Support') }}">
                    <input type="hidden" name="status" value="{{ old('status', $consultation->status ?? 'Pending') }}">
                </div>
            </div>
            <div class="actions">
                <button class="btn" type="submit">Save Notes</button>
            </div>
        </form>
    </div>
</div>
@endsection
