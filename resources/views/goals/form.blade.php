@extends('layouts.app')

@section('content')
@php
    $isEdit = $goal->exists;
@endphp

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.iep_form')])

    <div class="mockup-panel">
        <h2>{{ __('messages.iep_form') }}</h2>
        <form method="POST" action="{{ $isEdit ? route('goals.update', $goal) : route('goals.store') }}">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="form-grid">
                <div>
                    <label>{{ __('messages.select_student') }}</label>
                    <select class="select" name="student_id" required>
                        <option value="">{{ __('messages.select_student') }}</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $goal->student_id ?: request('student_id')) == $student->id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>{{ __('messages.iep_focus') }}</label>
                    <select class="select" name="iep_focus">
                        @foreach(['Akademik', 'Komunikasi', 'Tingkah Laku', 'Sosial'] as $focus)
                            <option value="{{ $focus }}" {{ old('iep_focus', $goal->iep_focus ?? 'Akademik') == $focus ? 'selected' : '' }}>{{ $focus }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="full">
                    <label>{{ __('messages.curriculum_followed') }}</label>
                    <input class="input" type="text" name="curriculum_followed" value="{{ old('curriculum_followed', $goal->curriculum_followed ?? 'KSSRPK Tahun 3') }}" placeholder="KSSRPK Tahun 3">
                </div>
                <div class="full">
                    <label>{{ __('messages.main_challenges') }}</label>
                    <textarea name="main_challenges">{{ old('main_challenges', $goal->main_challenges) }}</textarea>
                </div>
                <div class="full">
                    <label>{{ __('messages.long_term_goals') }}</label>
                    <textarea name="long_term_goals" required>{{ old('long_term_goals', $goal->long_term_goals) }}</textarea>
                </div>
                <div class="full">
                    <label>{{ __('messages.short_term_goals') }}</label>
                    <textarea name="short_term_goals" required>{{ old('short_term_goals', $goal->short_term_goals) }}</textarea>
                </div>
                <div class="full">
                    <label>{{ __('messages.intervention_strategy') }}</label>
                    <textarea name="intervention_strategy">{{ old('intervention_strategy', $goal->intervention_strategy) }}</textarea>
                </div>
                <div class="full">
                    <label>{{ __('messages.achievement') }}</label>
                    <textarea name="achievement">{{ old('achievement', $goal->achievement) }}</textarea>
                </div>
                <div>
                    <label>{{ __('messages.start_date') }}</label>
                    <input class="input" type="date" name="start_date" value="{{ old('start_date', optional($goal->start_date)->format('Y-m-d')) }}">
                </div>
                <div>
                    <label>{{ __('messages.review_date') }}</label>
                    <input class="input" type="date" name="review_date" value="{{ old('review_date', optional($goal->review_date)->format('Y-m-d')) }}">
                </div>
                <div class="full">
                    <input type="hidden" name="status" value="In Progress">
                </div>
            </div>
            <div class="actions">
                <button class="btn" type="submit">{{ $isEdit ? __('messages.update_iep') : __('messages.save_iep') }}</button>
                <a class="btn btn-light" href="{{ auth()->user()->role === 'teacher' ? route('teacher.students.index') : route('dashboard') }}">{{ __('messages.back') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
