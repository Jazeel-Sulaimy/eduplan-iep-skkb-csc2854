@extends('layouts.app')

@section('content')
    @php
        $isEdit = $user->exists;
        $loggedInRole = auth()->user()->role;

        /*
        |--------------------------------------------------------------------------
        | Role options
        |--------------------------------------------------------------------------
        | School administrators can create teacher, counsellor and parent accounts.
        | System administrators can create every type of account.
        */

        $roleOptions = [
            'teacher' => __('messages.role_teacher'),
            'counsellor' => __('messages.role_counsellor'),
            'parent' => __('messages.role_parent'),
        ];

        if ($loggedInRole === 'system_admin') {
            $roleOptions = [
                'school_admin' => __('messages.role_school_admin'),
                'teacher' => __('messages.role_teacher'),
                'counsellor' => __('messages.role_counsellor'),
                'parent' => __('messages.role_parent'),
                'system_admin' => __('messages.role_system_admin'),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Preserve existing role during editing
        |--------------------------------------------------------------------------
        | This prevents an existing user's role from disappearing from the
        | dropdown when the logged-in administrator cannot normally create it.
        */

        if (
            $isEdit &&
            !empty($user->role) &&
            !array_key_exists($user->role, $roleOptions)
        ) {
            $roleOptions[$user->role] = ucwords(
                str_replace('_', ' ', $user->role)
            );
        }
    @endphp

    <div class="mockup-dashboard">
        @include('partials.mockup-header', [
            'title' => __('messages.manage_users'),
            'roleLabel' => auth()->user()->roleLabel(),
        ])

        <div class="mockup-panel">
            <h2>
                {{ $isEdit
                    ? __('messages.edit_user')
                    : __('messages.create_user_account') }}
            </h2>

            <form
                method="POST"
                action="{{ $isEdit
                    ? route('users.update', $user)
                    : route('users.store') }}"
            >
                @csrf

                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-grid">
                    {{-- Full name --}}
                    <div>
                        <label for="name">
                            {{ __('messages.full_name') }}
                        </label>

                        <input
                            class="input"
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                        >

                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- User ID --}}
                    <div>
                        <label for="user_id">
                            {{ __('messages.user_id') }}
                        </label>

                        <input
                            class="input"
                            type="text"
                            id="user_id"
                            name="user_id"
                            value="{{ old('user_id', $user->user_id) }}"
                            required
                        >

                        @error('user_id')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email">
                            {{ __('messages.email_address') }}
                        </label>

                        <input
                            class="input"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                        >

                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone">
                            {{ __('messages.phone_number') }}
                        </label>

                        <input
                            class="input"
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                        >

                        @error('phone')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Identification card --}}
                    <div>
                        <label for="identification_card">
                            {{ __('messages.identification_card_number') }}
                        </label>

                        <input
                            class="input"
                            type="text"
                            id="identification_card"
                            name="identification_card"
                            value="{{ old(
                                'identification_card',
                                $user->identification_card
                            ) }}"
                        >

                        @error('identification_card')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role">
                            {{ __('messages.role') }}
                        </label>

                        <select
                            class="select"
                            id="role"
                            name="role"
                            required
                        >
                            @foreach($roleOptions as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old(
                                        'role',
                                        $user->role ?? 'teacher'
                                    ) === $value ? 'selected' : '' }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('role')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status">
                            {{ __('messages.status') }}
                        </label>

                        <select
                            class="select"
                            id="status"
                            name="status"
                            required
                        >
                            <option
                                value="Active"
                                {{ old(
                                    'status',
                                    $user->status ?? 'Active'
                                ) === 'Active' ? 'selected' : '' }}
                            >
                                {{ __('messages.active') }}
                            </option>

                            <option
                                value="Inactive"
                                {{ old(
                                    'status',
                                    $user->status ?? 'Active'
                                ) === 'Inactive' ? 'selected' : '' }}
                            >
                                {{ __('messages.inactive') }}
                            </option>
                        </select>

                        @error('status')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password">
                            {{ __('messages.password') }}
                        </label>

                        <input
                            class="input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="{{ $isEdit
                                ? __('messages.leave_password_blank')
                                : __('messages.enter_password') }}"
                            {{ $isEdit ? '' : 'required' }}
                        >

                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="full">
                        <label for="address">
                            {{ __('messages.address') }}
                        </label>

                        <textarea
                            class="input"
                            id="address"
                            name="address"
                        >{{ old('address', $user->address) }}</textarea>

                        @error('address')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="actions">
                    <button class="btn" type="submit">
                        {{ $isEdit
                            ? __('messages.update_user')
                            : __('messages.save_user') }}
                    </button>

                    <a
                        class="btn btn-light"
                        href="{{ route('users.index') }}"
                    >
                        {{ __('messages.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
