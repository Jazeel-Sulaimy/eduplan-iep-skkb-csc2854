@extends('layouts.app')

@section('content')
@php($isEdit = $consent->exists)

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.consent_letter')])

    <div class="mockup-panel consent-panel">
        <div class="card consent-card">
            <div class="consent-declaration">
                <h2>{{ __('messages.implementation_iep') }}</h2>
                <p><strong>{{ __('messages.consent_statement_1') }}</strong></p>
                <p><strong>{{ __('messages.consent_statement_2') }}</strong></p>
            </div>

            @if($students->isEmpty())
                <p>{{ __('messages.no_student_connected') }}</p>
            @else
                <form method="POST" action="{{ $isEdit ? route('consents.update', $consent) : route('consents.store') }}">
                    @csrf
                    @if($isEdit)
                        @method('PUT')
                    @endif

                    <div class="form-grid">
                        <div class="full">
                            <label>{{ __('messages.select_student') }}</label>
                            <select class="select" name="student_id" required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $consent->student_id ?: request('student_id')) == $student->id ? 'selected' : '' }}>
                                        {{ $student->student_name }} — {{ $student->student_ic }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>{{ __('messages.parent_guardian_full_name') }}</label>
                            <input class="input" type="text" value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div>
                            <label>{{ __('messages.identification_card_number') }}</label>
                            <input class="input" type="text" name="parent_ic" value="{{ old('parent_ic', $consent->parent_ic ?: auth()->user()->identification_card) }}" required>
                        </div>
                        <div>
                            <label>{{ __('messages.consent_date') }}</label>
                            <input class="input" type="date" name="consent_date" value="{{ old('consent_date', optional($consent->consent_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                        </div>
                        <div class="full">
                            <label>{{ __('messages.agreement_text') }}</label>
                            <textarea class="input" name="agreement_text">{{ old('agreement_text', $consent->agreement_text ?? __('messages.consent_statement_2')) }}</textarea>
                        </div>
                    </div>

                    <div class="actions">
                        <button class="btn" type="submit">{{ __('messages.submit') }}</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
