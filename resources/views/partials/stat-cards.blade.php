@php
    $cards = $cards ?? [
        ['title' => __('messages.total_students'), 'value' => $totalStudents ?? 40, 'subtitle' => __('messages.registered_students')],
        ['title' => __('messages.completed_iep'), 'value' => $completedIEP ?? 15, 'subtitle' => __('messages.submitted_documents')],
        ['title' => __('messages.pending_review'), 'value' => $pendingReview ?? 7, 'subtitle' => __('messages.need_action')],
        ['title' => __('messages.parent_consent'), 'value' => $parentConsent ?? 22, 'subtitle' => __('messages.approved_letter')],
    ];
@endphp

<div class="mockup-cards">
    @foreach($cards as $card)
        <div class="mockup-card">
            <h3>{{ $card['title'] }}</h3>
            <h2>{{ $card['value'] }}</h2>
            <p>{{ $card['subtitle'] }}</p>
        </div>
    @endforeach
</div>
