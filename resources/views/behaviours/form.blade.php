@extends('layouts.app')

@section('content')
@php($isEdit = $behaviour->exists)

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.behaviour_status')])

    <div class="mockup-panel">
        <h2>
            {{ $isEdit ? __('messages.edit') : __('messages.add_record') }}
            — {{ __('messages.behaviour_status') }}
        </h2>

        @if($students->isEmpty())
            <div class="empty-state">{{ __('messages.no_students_assigned') }}</div>
        @else
            <form
                method="POST"
                action="{{ $isEdit ? route('behaviours.update', $behaviour) : route('behaviours.store') }}"
            >
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <div>
                        <label for="student_id">{{ __('messages.student') }}</label>
                        <select class="select" id="student_id" name="student_id" required>
                            <option value="">{{ __('messages.select_student') }}</option>
                            @foreach($students as $student)
                                <option
                                    value="{{ $student->id }}"
                                    {{ (string) old('student_id', $behaviour->student_id ?: request('student_id')) === (string) $student->id ? 'selected' : '' }}
                                >
                                    {{ $student->student_name }} — {{ $student->class_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="record_date">{{ __('messages.record_date') }}</label>
                        <input
                            class="input"
                            type="date"
                            id="record_date"
                            name="record_date"
                            value="{{ old('record_date', optional($behaviour->record_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                            required
                        >
                        @error('record_date')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="behaviour_type">{{ __('messages.behaviour_type') }}</label>
                        <select class="select" id="behaviour_type" name="behaviour_type" required>
                            @foreach([
                                'Positive' => __('messages.positive'),
                                'Negative' => __('messages.negative'),
                                'Neutral' => __('messages.neutral'),
                            ] as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old('behaviour_type', $behaviour->behaviour_type ?? 'Positive') === $value ? 'selected' : '' }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('behaviour_type')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="points">{{ __('messages.points') }}</label>
                        <input
                            class="input"
                            type="number"
                            id="points"
                            name="points"
                            value="{{ old('points', $behaviour->points ?? 0) }}"
                            required
                        >
                        @error('points')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="full">
                        <label for="description">{{ __('messages.description') }}</label>
                        <textarea
                            class="input"
                            id="description"
                            name="description"
                            required
                        >{{ old('description', $behaviour->description) }}</textarea>
                        @error('description')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="actions">
                    <button class="btn" type="submit">{{ __('messages.save') }}</button>
                    <a class="btn btn-light" href="{{ route('behaviours.index') }}">
                        {{ __('messages.cancel') }}
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
