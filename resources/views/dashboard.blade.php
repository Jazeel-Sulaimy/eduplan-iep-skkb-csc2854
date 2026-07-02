@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', [
        'title' => __('messages.dashboard'),
        'roleLabel' => auth()->user()->roleLabel(),
    ])

    @include('partials.stat-cards')

    @include('partials.iep-status-table', ['students' => $students])
</div>
@endsection
