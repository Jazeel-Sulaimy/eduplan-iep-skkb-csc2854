@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.backup_database')])

    <div class="mockup-panel">
        <div class="panel-heading-row">
            <h2>{{ __('messages.backup_database') }}</h2>

            <form method="POST" action="{{ route('backup.store') }}">
                @csrf
                <button class="btn" type="submit">
                    {{ __('messages.backup_now') }}
                </button>
            </form>
        </div>

        @php($last = $backups->first())
        <p>
            <strong>{{ __('messages.last_backup') }}:</strong>
            {{ $last
                ? optional($last->backup_date)->format('d/m/Y h:i A') . ' — ' . $last->backup_name
                : __('messages.no_backup_record') }}
        </p>

        <div class="table-responsive">
            <table class="mockup-table" style="margin-top: 18px;">
                <thead>
                    <tr>
                        <th>{{ __('messages.backup_name') }}</th>
                        <th>{{ __('messages.backup_date') }}</th>
                        <th>{{ __('messages.notes') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $backup)
                        <tr>
                            <td>{{ $backup->backup_name }}</td>
                            <td>{{ optional($backup->backup_date)->format('d/m/Y h:i A') }}</td>
                            <td>{{ $backup->notes }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">{{ __('messages.no_backup_record') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
