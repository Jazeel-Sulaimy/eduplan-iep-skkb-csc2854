<div class="mockup-panel">
    <h2>{{ __('messages.iep_status') }}</h2>

    <table class="mockup-table">
        <thead>
            <tr>
                <th>{{ __('messages.student') }}</th>
                <th>{{ __('messages.class') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                @php
                    $showRoute = match(auth()->user()->role) {
                        'teacher' => route('teacher.students.show', $student),
                        'parent' => route('parent.students.show', $student),
                        'counsellor' => route('counsellor.students.show', $student),
                        default => route('students.show', $student),
                    };
                @endphp
                <tr>
                    <td>{{ $student->student_name }}</td>
                    <td>{{ $student->class_name }}</td>
                    <td>{{ $student->status }}</td>
                    <td><a href="{{ $showRoute }}">{{ __('messages.view') }}</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        {{ auth()->user()->role === 'parent' ? __('messages.no_student_connected') : __('messages.no_students_assigned') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
