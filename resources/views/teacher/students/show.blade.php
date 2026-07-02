@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.view_child_profile')])

    <div class="mockup-panel">
        <h2>{{ $student->student_name }}</h2>
        <div class="detail-grid">
            <div class="card"><strong>{{ __('messages.student_ic') }}</strong><span>{{ $student->student_ic ?: '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.class') }}</strong><span>{{ $student->class_name }}</span></div>
            <div class="card"><strong>{{ __('messages.gender') }}</strong><span>{{ $student->gender ?: '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.status') }}</strong><span>{{ $student->status }}</span></div>
            <div class="card"><strong>{{ __('messages.parent_guardian') }}</strong><span>{{ $student->parentUser->name ?? $student->parent_name ?? '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.assigned_counsellor') }}</strong><span>{{ $student->counsellor->name ?? '-' }}</span></div>
        </div>

        <div class="actions" style="margin-top:18px">
            <a class="btn" href="{{ route('goals.create', ['student_id' => $student->id]) }}">{{ __('messages.iep_goals') }}</a>
            <a class="btn" href="{{ route('behaviours.create', ['student_id' => $student->id]) }}">{{ __('messages.record_behaviour') }}</a>
            <a class="btn" href="{{ route('progress.create', ['student_id' => $student->id]) }}">{{ __('messages.record_progress') }}</a>
            <a class="btn btn-light" href="{{ route('teacher.students.index') }}">{{ __('messages.back') }}</a>
        </div>
    </div>
</div>
@endsection
