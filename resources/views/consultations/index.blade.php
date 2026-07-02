@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.student_case')])

    <div class="mockup-panel">
        <h2>{{ __('messages.student_case') }}</h2>
        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.student') }}</th>
                        <th>{{ __('messages.issue') }}</th>
                        <th>{{ __('messages.priority') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultations as $case)
                        <tr>
                            <td>{{ $case->student->student_name ?? '-' }}</td>
                            <td>{{ $case->case_title }}</td>
                            <td>{{ $case->priority }}</td>
                            <td><a href="{{ route('consultations.edit', $case) }}">{{ $case->priority === 'High' ? __('messages.follow_up') : __('messages.review') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4">{{ __('messages.no_students_assigned') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="actions" style="margin-top:18px">
            <a class="btn" href="{{ route('consultations.create') }}">{{ __('messages.notes') }}</a>
            <a class="btn btn-light" href="{{ route('support.plan') }}">{{ __('messages.support_plan') }}</a>
        </div>
    </div>
</div>
@endsection
