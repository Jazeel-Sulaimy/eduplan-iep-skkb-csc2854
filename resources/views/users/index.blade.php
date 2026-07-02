@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.system_users')])

    <div class="mockup-panel">
        <div class="panel-heading-row">
            <h2>{{ __('messages.system_users') }}</h2>
            <a class="btn" href="{{ route('users.create') }}">
                {{ __('messages.create_user_account') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.full_name') }}</th>
                        <th>{{ __('messages.user_id') }}</th>
                        <th>{{ __('messages.email_address') }}</th>
                        <th>{{ __('messages.role') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->email ?: '-' }}</td>
                            <td>{{ $user->roleLabel() }}</td>
                            <td>{{ $user->status }}</td>
                            <td class="actions">
                                <a href="{{ route('users.edit', $user) }}">
                                    {{ __('messages.edit') }}
                                </a>

                                @if(auth()->id() !== $user->id)
                                    <form
                                        method="POST"
                                        action="{{ route('users.destroy', $user) }}"
                                        onsubmit="return confirm('{{ __('messages.confirm_delete_user') }}')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="table-link danger-link" type="submit">
                                            {{ __('messages.delete') }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">{{ __('messages.no_user_record') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(auth()->user()->role === 'system_admin')
            <div class="actions" style="margin-top:18px">
                <a class="btn btn-light" href="{{ route('roles.index') }}">
                    {{ __('messages.roles') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
