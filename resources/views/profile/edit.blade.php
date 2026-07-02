@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.my_profile')])

    <div class="mockup-panel">
        <h2>{{ __('messages.my_profile') }}</h2>

        <form
            method="POST"
            action="{{ route('profile.update') }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div>
                    <label for="name">{{ __('messages.full_name') }}</label>
                    <input
                        class="input"
                        id="name"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                    >
                    @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="email">{{ __('messages.email_address') }}</label>
                    <input
                        class="input"
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                    >
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="phone">{{ __('messages.phone_number') }}</label>
                    <input
                        class="input"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', auth()->user()->phone) }}"
                    >
                    @error('phone')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label for="profile_picture">{{ __('messages.profile_picture') }}</label>
                    <input
                        class="input"
                        type="file"
                        id="profile_picture"
                        name="profile_picture"
                        accept="image/png,image/jpeg"
                    >
                    @error('profile_picture')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="actions">
                <button class="btn" type="submit">
                    {{ __('messages.update_profile') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
