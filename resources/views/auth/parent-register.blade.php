<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.parent_registration') }} - {{ __('messages.system_title') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="portal-login-body">
    <div class="portal-login-wrapper register-wrapper">
        <div class="portal-header-card">
            <div class="portal-header-left">
                <img src="{{ asset('assets/images/jata-negara.png') }}" alt="Jata Negara" class="portal-header-logo">
                <img src="{{ asset('assets/images/logo-sekolah.jpg') }}" alt="SKKB Logo" class="portal-header-logo">
            </div>
            <div class="portal-header-right">
                <h1>{{ __('messages.parent_registration') }}</h1>
                <p>{{ __('messages.parent_registration_help') }}</p>
            </div>
            <div class="portal-lang-switch">
                <select class="language-select" onchange="window.location.href=this.value">
                    <option value="{{ route('language.switch', 'en') }}" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('messages.english') }}</option>
                    <option value="{{ route('language.switch', 'ms') }}" {{ app()->getLocale() === 'ms' ? 'selected' : '' }}>{{ __('messages.malay') }}</option>
                </select>
            </div>
        </div>

        <div class="portal-register-card">
            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('parent.register.store') }}">
                @csrf

                <h2>{{ __('messages.parent_information') }}</h2>
                <div class="form-grid register-grid">
                    <div>
                        <label>{{ __('messages.full_name') }}</label>
                        <input class="input" type="text" name="full_name" value="{{ old('full_name') }}" required>
                    </div>
                    <div>
                        <label>{{ __('messages.identification_card_number') }}</label>
                        <input class="input" type="text" name="identification_card" value="{{ old('identification_card') }}" required>
                    </div>
                    <div>
                        <label>{{ __('messages.phone_number') }}</label>
                        <input class="input" type="text" name="phone" value="{{ old('phone') }}" required>
                    </div>
                    <div>
                        <label>{{ __('messages.email_address') }}</label>
                        <input class="input" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="full">
                        <label>{{ __('messages.home_address') }}</label>
                        <textarea class="input" name="address" required>{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label>{{ __('messages.password') }}</label>
                        <input class="input" type="password" name="password" required>
                    </div>
                    <div>
                        <label>{{ __('messages.confirm_password') }}</label>
                        <input class="input" type="password" name="password_confirmation" required>
                    </div>
                </div>

                <h2>{{ __('messages.student_information') }}</h2>
                <div class="form-grid register-grid">
                    <div>
                        <label>{{ __('messages.student_full_name') }}</label>
                        <input class="input" type="text" name="student_name" value="{{ old('student_name') }}" required>
                    </div>
                    <div>
                        <label>{{ __('messages.student_identification_card_number') }}</label>
                        <input class="input" type="text" name="student_ic" value="{{ old('student_ic') }}" required>
                    </div>
                </div>

                <div class="actions register-actions">
                    <button class="btn" type="submit">{{ __('messages.create_parent_account') }}</button>
                    <a class="btn btn-light" href="{{ route('login') }}">{{ __('messages.back_to_login') }}</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
