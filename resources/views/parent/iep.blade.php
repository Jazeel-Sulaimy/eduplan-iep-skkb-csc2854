@extends('layouts.app')

@section('content')
@php
    $student = $student ?? null;
    $goal = $student ? $student->goals->first() : null;
@endphp

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.student_iep_detail')])

    <div class="mockup-panel">
        <h2>{{ __('messages.student_iep') }}</h2>
        <div class="card">
            <p><strong>{{ __('messages.student_name') }} :</strong> {{ optional($student)->student_name ?? 'Sheikh Dinan' }}</p>
            <p><strong>{{ __('messages.class') }} :</strong> {{ optional($student)->class_name ?? '2 Cemerlang' }}</p>
            <p><strong>{{ __('messages.iep_focus') }} :</strong> {{ optional($goal)->iep_focus ?? 'Akademik' }}</p>
            <p><strong>{{ __('messages.main_goal') }} :</strong> {{ optional($goal)->long_term_goals ?? 'Improve classroom participation and communication skills' }}</p>
            <p><strong>{{ __('messages.intervention') }} :</strong> {{ optional($goal)->intervention_strategy ?? 'Structured classroom activity with teacher support' }}</p>
        </div>
    </div>
</div>
@endsection
