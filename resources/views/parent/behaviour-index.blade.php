@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.behaviour_summary')])

    @forelse($students as $student)
        <div class="mockup-panel record-section">
            <h2>{{ $student->student_name }}</h2>
            @forelse($student->behaviours as $record)
                <div class="record-card">
                    <p><strong>{{ $record->behaviour_type }}</strong> — {{ $record->points }} {{ __('messages.points') }}</p>
                    <p>{{ $record->description }}</p>
                    <small>{{ $record->record_date }}</small>
                </div>
            @empty
                <p>{{ __('messages.no_behaviour_records') }}</p>
            @endforelse
        </div>
    @empty
        <div class="mockup-panel"><p>{{ __('messages.no_student_connected') }}</p></div>
    @endforelse
</div>
@endsection
