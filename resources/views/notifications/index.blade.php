@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.notifications')])

    <div class="mockup-panel">
        <h2>{{ __('messages.notifications') }}</h2>

        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.title') }}</th>
                        <th>{{ __('messages.message') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        <tr>
                            <td>{{ $notification->title }}</td>
                            <td>{{ $notification->message }}</td>
                            <td>
                                {{ $notification->is_read
                                    ? __('messages.read')
                                    : __('messages.unread') }}
                            </td>
                            <td>
                                @if(! $notification->is_read)
                                    <form
                                        method="POST"
                                        action="{{ route('notifications.read', $notification) }}"
                                    >
                                        @csrf
                                        <button class="btn" type="submit">
                                            {{ __('messages.mark_read') }}
                                        </button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">{{ __('messages.no_notifications') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
