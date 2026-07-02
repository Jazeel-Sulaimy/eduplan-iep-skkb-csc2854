<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.system_title') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="portal-login-body">
    <div class="portal-login-wrapper">
        <div class="portal-header-card">
            <div class="portal-header-left">
                <img src="{{ asset('assets/images/jata-negara.png') }}" alt="Jata Negara" class="portal-header-logo" onerror="this.style.display='none'">
                <img src="{{ asset('assets/images/logo-sekolah.jpg') }}" alt="SKKB Logo" class="portal-header-logo" onerror="this.style.display='none'">
            </div>

            <div class="portal-header-right">
                <h1>{{ __('messages.education_management_system') }}</h1>
                <p>{{ __('messages.ministry_tagline') }}</p>
            </div>

            <div class="portal-lang-switch">
                <select class="language-select" onchange="window.location.href=this.value">
                    <option value="{{ route('language.switch', 'en') }}" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                    <option value="{{ route('language.switch', 'ms') }}" {{ app()->getLocale() === 'ms' ? 'selected' : '' }}>{{ __('messages.malay') }}</option>
                </select>
            </div>
        </div>

        <div class="portal-main-card">
            <div class="portal-login-panel">
                <h3>{{ __('messages.epkb') }}</h3>
                <h2>{{ __('messages.system_title') }}</h2>

                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="error-box">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="portal-form-group">
                        <label>{{ __('messages.user_id_or_email') }}</label>
                        <input type="text" name="login" class="portal-input" placeholder="{{ __('messages.user_id_or_email') }}" value="{{ old('login') }}" required autofocus>
                    </div>

                    <div class="portal-form-group">
                        <label>{{ __('messages.password') }}</label>
                        <div class="portal-password-box">
                            <input type="password" id="password" name="password" class="portal-input" placeholder="{{ __('messages.enter_password') }}" required>
                            <button type="button" class="portal-eye-btn" onclick="document.getElementById('password').type = document.getElementById('password').type === 'password' ? 'text' : 'password'">👁</button>
                        </div>
                    </div>

                    <p class="portal-help-text">{{ __('messages.enter_id_password') }}</p>

                    <div class="portal-button-row">
                        <button type="submit" class="portal-btn-primary">{{ __('messages.login') }}</button>
                        <button type="reset" class="portal-btn-secondary">{{ __('messages.reset') }}</button>
                    </div>
                </form>

                <div class="portal-divider"><span>{{ __('messages.or') }}</span></div>

                <a class="portal-register-link" href="{{ route('parent.register') }}">
                    {{ __('messages.register_as_parent') }}
                </a>
            </div>

            <div class="portal-announcement-panel">
                <h2>{{ __('messages.welcome') }}</h2>
                <div class="portal-announcement-box">
                    <h3>{{ __('messages.system_title') }}</h3>
                    <p>{{ __('messages.system_intro') }}</p>
                </div>
            </div>
        </div>

        <div class="portal-footer">
            <p>{{ __('messages.system_title') }}</p>
            <small>{{ __('messages.footer_brand') }}</small>
        </div>
    </div>
    @include('partials.auto-translator')
</body>
</html>
