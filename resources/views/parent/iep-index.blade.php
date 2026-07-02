@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.iep_goals')])

    @forelse($students as $student)
        <div class="mockup-panel record-section">
            <h2>{{ $student->student_name }}</h2>
            @forelse($student->goals as $goal)
                <div class="record-card">
                    <p><strong>{{ __('messages.iep_focus') }}:</strong> {{ $goal->iep_focus ?: '-' }}</p>
                    <p><strong>{{ __('messages.long_term_goals') }}:</strong> {{ $goal->long_term_goals }}</p>
                    <p><strong>{{ __('messages.short_term_goals') }}:</strong> {{ $goal->short_term_goals }}</p>
                    <p><strong>{{ __('messages.status') }}:</strong> {{ $goal->status }}</p>
                </div>
            @empty
                <p>{{ __('messages.no_iep_records') }}</p>
            @endforelse
        </div>
    @empty
        <div class="mockup-panel"><p>{{ __('messages.no_student_connected') }}</p></div>
    @endforelse
</div>
@endsection
