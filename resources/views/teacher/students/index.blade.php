@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.my_students')])

    <div class="mockup-panel">
        <h2>{{ __('messages.my_students') }}</h2>
        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.student_name') }}</th>
                        <th>{{ __('messages.student_ic') }}</th>
                        <th>{{ __('messages.class') }}</th>
                        <th>{{ __('messages.gender') }}</th>
                        <th>{{ __('messages.iep_status') }}</th>
                        <th>{{ __('messages.parent_guardian') }}</th>
                        <th>{{ __('messages.assigned_counsellor') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->student_ic ?: '-' }}</td>
                            <td>{{ $student->class_name }}</td>
                            <td>{{ $student->gender ?: '-' }}</td>
                            <td>{{ $student->status }}</td>
                            <td>{{ $student->parentUser->name ?? $student->parent_name ?? '-' }}</td>
                            <td>{{ $student->counsellor->name ?? '-' }}</td>
                            <td class="actions teacher-actions">
                                <a href="{{ route('teacher.students.show', $student) }}">{{ __('messages.view_profile') }}</a>
                                <a href="{{ route('goals.create', ['student_id' => $student->id]) }}">{{ __('messages.iep_goals') }}</a>
                                <a href="{{ route('behaviours.create', ['student_id' => $student->id]) }}">{{ __('messages.record_behaviour') }}</a>
                                <a href="{{ route('progress.create', ['student_id' => $student->id]) }}">{{ __('messages.record_progress') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">{{ __('messages.no_students_assigned') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
