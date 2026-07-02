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
            <div class="card"><strong>{{ __('messages.iep_status') }}</strong><span>{{ $student->status }}</span></div>
            <div class="card"><strong>{{ __('messages.assigned_teacher') }}</strong><span>{{ $student->teacher->name ?? '-' }}</span></div>
            <div class="card"><strong>{{ __('messages.assigned_counsellor') }}</strong><span>{{ $student->counsellor->name ?? '-' }}</span></div>
        </div>

        <div class="record-section">
            <h3>{{ __('messages.iep_goals') }}</h3>
            @forelse($student->goals as $goal)
                <div class="record-card">
                    <strong>{{ $goal->iep_focus ?: __('messages.iep') }}</strong>
                    <p>{{ $goal->long_term_goals }}</p>
                    <small>{{ $goal->status }}</small>
                </div>
            @empty
                <p>{{ __('messages.no_iep_records') }}</p>
            @endforelse
        </div>

        <div class="record-section">
            <h3>{{ __('messages.progress_summary') }}</h3>
            @forelse($student->progressRecords as $record)
                <div class="record-card">
                    <strong>{{ $record->progress_status }}</strong>
                    <p>{{ $record->progress_notes }}</p>
                    <small>{{ $record->progress_date }}</small>
                </div>
            @empty
                <p>{{ __('messages.no_progress_records') }}</p>
            @endforelse
        </div>

        <div class="record-section">
            <h3>{{ __('messages.behaviour_summary') }}</h3>
            @forelse($student->behaviours as $record)
                <div class="record-card">
                    <strong>{{ $record->behaviour_type }} ({{ $record->points }} {{ __('messages.points') }})</strong>
                    <p>{{ $record->description }}</p>
                    <small>{{ $record->record_date }}</small>
                </div>
            @empty
                <p>{{ __('messages.no_behaviour_records') }}</p>
            @endforelse
        </div>

        <div class="actions" style="margin-top:18px">
            <a class="btn" href="{{ route('consents.index') }}">{{ __('messages.consent_letter') }}</a>
            <a class="btn" href="{{ route('reports.index', ['student_id' => $student->id]) }}">{{ __('messages.view_iep_report') }}</a>
            <a class="btn btn-light" href="{{ route('parent.students.index') }}">{{ __('messages.back') }}</a>
        </div>
    </div>
</div>
@endsection
