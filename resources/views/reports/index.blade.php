@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.generate_report')])

    <div class="mockup-panel">
        <h2>{{ __('messages.report') }}</h2>

        @if($students->isEmpty())
            <p>{{ auth()->user()->role === 'parent' ? __('messages.no_student_connected') : __('messages.no_students_assigned') }}</p>
        @else
            <form method="GET" action="{{ route('reports.print') }}" target="_blank">
                <div class="form-grid">
                    <div class="full">
                        <label>{{ __('messages.select_student') }}</label>
                        <select class="select" name="student_id" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ (string) request('student_id') === (string) $student->id ? 'selected' : '' }}>
                                    {{ $student->student_name }} — {{ $student->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="actions">
                    <button class="btn" type="submit">{{ __('messages.generate_iep_report') }}</button>
                    <button class="btn btn-gold" type="submit" formaction="{{ route('reports.consent.pdf') }}">{{ __('messages.generate_consent_pdf') }}</button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
