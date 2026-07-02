@extends('layouts.app')

@section('content')
@php
    $isEdit = $progress->exists;
@endphp

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.progress_status')])

    <div class="mockup-panel">
        <h2>{{ __('messages.progress_status') }}</h2>
        <form method="POST" action="{{ $isEdit ? route('progress.update', $progress) : route('progress.store') }}">
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
                            <option value="{{ $student->id }}" {{ old('student_id', $progress->student_id ?: request('student_id')) == $student->id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>{{ __('messages.progress_status') }}</label>
                    <select class="select" name="progress_status" required>
                        @foreach(['Good', 'Improving', 'Need Monitoring', 'Weak'] as $status)
                            <option value="{{ $status }}" {{ old('progress_status', $progress->progress_status ?? 'Improving') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>{{ __('messages.progress_date') }}</label>
                    <input class="input" type="date" name="progress_date" value="{{ old('progress_date', optional($progress->progress_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label>{{ __('messages.positive_updates') }}</label>
                    <input class="input" type="number" name="positive_updates" value="{{ old('positive_updates', $progress->positive_updates ?? 15) }}">
                </div>
                <div>
                    <label>{{ __('messages.need_monitoring') }}</label>
                    <input class="input" type="number" name="need_monitoring" value="{{ old('need_monitoring', $progress->need_monitoring ?? 4) }}">
                </div>
                <div class="full">
                    <label>{{ __('messages.progress_notes') }}</label>
                    <textarea name="progress_notes" required>{{ old('progress_notes', $progress->progress_notes) }}</textarea>
                </div>
            </div>
            <div class="actions">
                <button class="btn" type="submit">{{ __('messages.save_progress') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
