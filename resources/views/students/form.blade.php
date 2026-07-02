@extends('layouts.app')

@section('content')
@php($isEdit = $student->exists)

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => $isEdit ? __('messages.edit_student') : __('messages.register_student')])

    <div class="mockup-panel">
        <h2>{{ __('messages.student_profile_personal_information') }}</h2>

        <form method="POST" action="{{ $isEdit ? route('students.update', $student) : route('students.store') }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="form-grid">
                <div>
                    <label>{{ __('messages.school_code') }}</label>
                    <input class="input" type="text" name="school_code" value="{{ old('school_code', $student->school_code ?? 'TBA 5001') }}">
                </div>
                <div>
                    <label>{{ __('messages.school_name') }}</label>
                    <input class="input" type="text" name="school_name" value="{{ old('school_name', $student->school_name ?? 'Sekolah Kebangsaan Kuala Berang') }}">
                </div>
                <div>
                    <label>{{ __('messages.student_name') }}</label>
                    <input class="input" type="text" name="student_name" value="{{ old('student_name', $student->student_name) }}" required>
                </div>
                <div>
                    <label>{{ __('messages.student_identification_card_number') }}</label>
                    <input class="input" type="text" name="student_ic" value="{{ old('student_ic', $student->student_ic) }}">
                </div>
                <div>
                    <label>{{ __('messages.class') }}</label>
                    <input class="input" type="text" name="class_name" value="{{ old('class_name', $student->class_name) }}" required>
                </div>
                <div>
                    <label>{{ __('messages.gender') }}</label>
                    <select class="select" name="gender">
                        <option value="">{{ __('messages.select') }}</option>
                        <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>{{ __('messages.male') }}</option>
                        <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>{{ __('messages.female') }}</option>
                    </select>
                </div>
                <div>
                    <label>{{ __('messages.date_of_birth') }}</label>
                    <input class="input" type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}">
                </div>
                <div>
                    <label>{{ __('messages.status') }}</label>
                    <select class="select" name="status" required>
                        @foreach(['Completed', 'Parent Consent', 'Counsellor Review', 'In Progress', 'Active', 'Inactive'] as $status)
                            <option value="{{ $status }}" {{ old('status', $student->status ?? 'In Progress') === $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>{{ __('messages.category') }}</label>
                    <input class="input" type="text" name="category" value="{{ old('category', $student->category) }}">
                </div>
                <div>
                    <label>{{ __('messages.programme_type') }}</label>
                    <input class="input" type="text" name="programme_type" value="{{ old('programme_type', $student->programme_type) }}">
                </div>
                <div class="full">
                    <label>{{ __('messages.diagnosis') }}</label>
                    <textarea class="input" name="diagnosis">{{ old('diagnosis', $student->diagnosis) }}</textarea>
                </div>
                <div class="full">
                    <label>{{ __('messages.existing_knowledge') }}</label>
                    <textarea class="input" name="existing_knowledge">{{ old('existing_knowledge', $student->existing_knowledge) }}</textarea>
                </div>
                <div class="full">
                    <label>{{ __('messages.student_ability') }}</label>
                    <textarea class="input" name="student_ability">{{ old('student_ability', $student->student_ability) }}</textarea>
                </div>
                <div class="full">
                    <label>{{ __('messages.address') }}</label>
                    <textarea class="input" name="address">{{ old('address', $student->address) }}</textarea>
                </div>
            </div>

            <div class="assignment-note">
                {{ __('messages.assignment_managed_separately') }}
            </div>

            <div class="actions">
                <button class="btn" type="submit">{{ $isEdit ? __('messages.update_student') : __('messages.save_student') }}</button>
                <a class="btn btn-light" href="{{ route('students.index') }}">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
