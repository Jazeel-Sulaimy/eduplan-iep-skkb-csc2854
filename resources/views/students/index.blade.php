@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.student_list')])

    <div class="mockup-panel">
        <div class="panel-heading-row">
            <h2>{{ __('messages.student_list') }}</h2>
            @if(auth()->user()->hasRole('school_admin', 'system_admin'))
                <a class="btn" href="{{ route('students.create') }}">{{ __('messages.register_student') }}</a>
            @endif
        </div>

        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.student_name') }}</th>
                        <th>{{ __('messages.student_ic') }}</th>
                        <th>{{ __('messages.class') }}</th>
                        <th>{{ __('messages.assigned_teacher') }}</th>
                        <th>{{ __('messages.assigned_counsellor') }}</th>
                        <th>{{ __('messages.parent_guardian') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->student_ic ?: '-' }}</td>
                            <td>{{ $student->class_name }}</td>
                            <td>{{ $student->teacher->name ?? '-' }}</td>
                            <td>{{ $student->counsellor->name ?? '-' }}</td>
                            <td>{{ $student->parentUser->name ?? '-' }}</td>
                            <td class="actions">
                                @php
                                    $studentShowRoute = auth()->user()->role === 'counsellor'
                                        ? route('counsellor.students.show', $student)
                                        : route('students.show', $student);
                                @endphp
                                <a href="{{ $studentShowRoute }}">{{ __('messages.view') }}</a>
                                @if(auth()->user()->hasRole('school_admin', 'system_admin'))
                                    <a href="{{ route('students.edit', $student) }}">{{ __('messages.edit') }}</a>
                                    <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('{{ __('messages.confirm_delete_student') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="table-link danger-link" type="submit">{{ __('messages.delete') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">{{ __('messages.no_students_available') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
