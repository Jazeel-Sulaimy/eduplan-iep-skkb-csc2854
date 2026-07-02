<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.iep_report') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <div class="content">
        <div class="print-header">
            <h2>{{ __('messages.system_title') }}</h2>
            <p>Sekolah Kebangsaan Kuala Berang</p>
        </div>

        <div class="card">
            <h1>{{ __('messages.iep_report') }}</h1>
            <p><strong>{{ __('messages.student_name') }}:</strong> {{ $student->student_name }}</p>
            <p><strong>{{ __('messages.class') }}:</strong> {{ $student->class_name }}</p>
            <p><strong>{{ __('messages.category') }}:</strong> {{ $student->category }}</p>
            <p><strong>{{ __('messages.diagnosis') }}:</strong> {{ $student->diagnosis }}</p>

            <h2>{{ __('messages.student_iep') }}</h2>
            @forelse($student->goals as $goal)
                <p><strong>{{ __('messages.iep_focus') }}:</strong> {{ $goal->iep_focus }}</p>
                <p><strong>{{ __('messages.main_goal') }}:</strong> {{ $goal->long_term_goals }}</p>
                <p><strong>{{ __('messages.intervention') }}:</strong> {{ $goal->intervention_strategy }}</p>
                <p><strong>{{ __('messages.achievement') }}:</strong> {{ $goal->achievement }}</p>
            @empty
                <p>-</p>
            @endforelse

            <h2>{{ __('messages.progress_summary') }}</h2>
            @forelse($student->progressRecords as $record)
                <p><strong>{{ $record->progress_date }}:</strong> {{ $record->progress_status }} - {{ $record->progress_notes }}</p>
            @empty
                <p>-</p>
            @endforelse

            <h2>{{ __('messages.counsellor_review') }}</h2>
            @forelse($student->consultations as $case)
                <p><strong>{{ $case->case_title }}:</strong> {{ $case->consultation_notes }}</p>
            @empty
                <p>-</p>
            @endforelse

            <h2>{{ __('messages.consent_letter') }}</h2>
            @php $consent = $student->consents->first(); @endphp
            @if($consent)
                <p><strong>{{ __('messages.parent_guardian_full_name') }}:</strong> {{ $consent->parent_name }}</p>
                <p><strong>{{ __('messages.identification_card_number') }}:</strong> {{ $consent->parent_ic }}</p>
                <p><strong>{{ __('messages.student_identification_card_number') }}:</strong> {{ $consent->student_ic }}</p>
                <p><strong>{{ __('messages.consent_date') }}:</strong> {{ $consent->consent_date }}</p>
                <p><strong>{{ __('messages.status') }}:</strong> {{ $consent->status }}</p>
                <p><strong>{{ __('messages.agreement_text') }}:</strong> {{ $consent->agreement_text }}</p>
            @else
                <p>{{ __('messages.no_consent_letter') }}</p>
            @endif
        </div>
    </div>

    <script>window.print();</script>
</body>
</html>
