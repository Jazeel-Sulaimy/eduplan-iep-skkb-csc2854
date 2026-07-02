@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.assign_staff')])

    <div class="mockup-panel">
        <h2>{{ __('messages.assign_staff') }}</h2>

        @if($students->isEmpty())
            <div class="empty-state">{{ __('messages.no_students_available') }}</div>
        @else
            <form method="GET" action="{{ route('assign.staff') }}" class="assignment-loader">
                <label>{{ __('messages.select_student') }}</label>
                <div class="assignment-select-row">
                    <select class="select" name="student_id" onchange="this.form.submit()">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ optional($selectedStudent)->id === $student->id ? 'selected' : '' }}>
                                {{ $student->student_name }} — {{ $student->class_name }}
                            </option>
                        @endforeach
                    </select>
                    <noscript><button class="btn" type="submit">{{ __('messages.load') }}</button></noscript>
                </div>
            </form>

            @if($selectedStudent)
                <div class="assignment-current card">
                    <h3>{{ __('messages.current_assignment') }}</h3>
                    <p><strong>{{ __('messages.student') }}:</strong> {{ $selectedStudent->student_name }}</p>
                    <p><strong>{{ __('messages.assigned_teacher') }}:</strong> {{ $selectedStudent->teacher->name ?? '-' }}</p>
                    <p><strong>{{ __('messages.assigned_counsellor') }}:</strong> {{ $selectedStudent->counsellor->name ?? '-' }}</p>
                    <p><strong>{{ __('messages.parent_guardian') }}:</strong> {{ $selectedStudent->parentUser->name ?? '-' }}</p>
                </div>

                <form method="POST" action="{{ route('assign.staff.store') }}">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $selectedStudent->id }}">

                    <div class="form-grid">
                        <div>
                            <label>{{ __('messages.assign_teacher') }}</label>
                            <select class="select" name="teacher_id">
                                <option value="">{{ __('messages.none') }}</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ (string) old('teacher_id', $selectedStudent->teacher_id) === (string) $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label>{{ __('messages.assign_counsellor') }}</label>
                            <select class="select" name="counsellor_id">
                                <option value="">{{ __('messages.none') }}</option>
                                @foreach($counsellors as $counsellor)
                                    <option value="{{ $counsellor->id }}" {{ (string) old('counsellor_id', $selectedStudent->counsellor_id) === (string) $counsellor->id ? 'selected' : '' }}>
                                        {{ $counsellor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label>{{ __('messages.assign_parent_guardian') }}</label>
                            <select class="select" name="parent_user_id">
                                <option value="">{{ __('messages.none') }}</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ (string) old('parent_user_id', $selectedStudent->parent_user_id) === (string) $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }} — {{ $parent->user_id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label>{{ __('messages.review_frequency') }}</label>
                            <select class="select" name="review_frequency">
                                <option value="">{{ __('messages.none') }}</option>
                                @foreach(['Weekly', 'Monthly', 'Quarterly', 'Yearly'] as $frequency)
                                    <option value="{{ $frequency }}" {{ old('review_frequency', $selectedStudent->review_frequency) === $frequency ? 'selected' : '' }}>
                                        {{ __('messages.' . strtolower($frequency)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="full">
                            <label>{{ __('messages.assignment_notes') }}</label>
                            <textarea class="input" name="assignment_notes">{{ old('assignment_notes', $selectedStudent->assignment_notes) }}</textarea>
                        </div>
                    </div>

                    <div class="actions">
                        <button class="btn" type="submit">{{ __('messages.save_assignment') }}</button>
                        <a class="btn btn-light" href="{{ route('assign.staff', ['student_id' => $selectedStudent->id]) }}">{{ __('messages.reset') }}</a>
                    </div>
                </form>
            @endif
        @endif
    </div>
</div>
@endsection
