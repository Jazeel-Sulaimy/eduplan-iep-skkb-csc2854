@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.student_profile')])

    <div class="mockup-panel">
        <h2>{{ $student->student_name }}</h2>
        <div class="detail-grid">
            <div class="card"><strong>{{ __('messages.student_ic') }}</strong><span>{{ $student->student_ic ?: '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.class') }}</strong><span>{{ $student->class_name }}</span></div>
            <div class="card"><strong>{{ __('messages.gender') }}</strong><span>{{ $student->gender ?: '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.status') }}</strong><span>{{ $student->status }}</span></div>
            <div class="card"><strong>{{ __('messages.assigned_teacher') }}</strong><span>{{ $student->teacher->name ?? '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.assigned_counsellor') }}</strong><span>{{ $student->counsellor->name ?? '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.parent_guardian') }}</strong><span>{{ $student->parentUser->name ?? $student->parent_name ?? '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.review_frequency') }}</strong><span>{{ $student->review_frequency ?: '-' }}</span></div>
        </div>

        <div class="actions" style="margin-top:18px">
            @if(auth()->user()->hasRole('school_admin', 'system_admin'))
                <a class="btn" href="{{ route('students.edit', $student) }}">{{ __('messages.edit_student') }}</a>
            @endif
            @if(auth()->user()->role === 'school_admin')
                <a class="btn btn-light" href="{{ route('assign.staff', ['student_id' => $student->id]) }}">{{ __('messages.assign_staff') }}</a>
            @endif
            <a class="btn btn-light" href="{{ auth()->user()->role === 'counsellor' ? route('counsellor.students.index') : route('students.index') }}">{{ __('messages.back') }}</a>
        </div>
    </div>
</div>
@endsection
