@php
    $currentRole = $roleLabel ?? (auth()->check() ? auth()->user()->roleLabel() : __('messages.user'));
@endphp

<div class="mockup-top">
    <div class="mockup-title-box">
        <h1>{{ $title ?? __('messages.dashboard') }}</h1>
    </div>

    <div class="mockup-role-box">
        <select class="mockup-select" onchange="window.location.href=this.value">
            <option value="{{ route('language.switch', 'en') }}" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>
                {{ __('messages.english') }}
            </option>
            <option value="{{ route('language.switch', 'ms') }}" {{ app()->getLocale() === 'ms' ? 'selected' : '' }}>
                {{ __('messages.malay') }}
            </option>
        </select>

        <div class="mockup-role">{{ $currentRole }}</div>
    </div>
</div>
