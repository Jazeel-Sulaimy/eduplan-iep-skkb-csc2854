@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.progress_summary')])

    @forelse($students as $student)
        <div class="mockup-panel record-section">
            <h2>{{ $student->student_name }}</h2>
            @forelse($student->progressRecords as $record)
                <div class="record-card">
                    <p><strong>{{ __('messages.progress_status') }}:</strong> {{ $record->progress_status }}</p>
                    <p>{{ $record->progress_notes }}</p>
                    <small>{{ $record->progress_date }}</small>
                </div>
            @empty
                <p>{{ __('messages.no_progress_records') }}</p>
            @endforelse
        </div>
    @empty
        <div class="mockup-panel"><p>{{ __('messages.no_student_connected') }}</p></div>
    @endforelse
</div>
@endsection
