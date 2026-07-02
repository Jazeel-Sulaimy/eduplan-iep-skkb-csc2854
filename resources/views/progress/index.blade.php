@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.progress_summary')])

    <div class="mockup-panel">
        <div class="panel-heading-row">
            <h2>{{ __('messages.progress_records') }}</h2>
            <a class="btn" href="{{ route('progress.create') }}">{{ __('messages.record_progress') }}</a>
        </div>
        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.student') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.positive_updates') }}</th>
                        <th>{{ __('messages.need_monitoring') }}</th>
                        <th>{{ __('messages.date') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($progress as $record)
                        <tr>
                            <td>{{ $record->student->student_name ?? '-' }}</td>
                            <td>{{ $record->progress_status }}</td>
                            <td>{{ $record->positive_updates }}</td>
                            <td>{{ $record->need_monitoring }}</td>
                            <td>{{ $record->progress_date }}</td>
                            <td><a href="{{ route('progress.edit', $record) }}">{{ __('messages.edit') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6">{{ __('messages.no_progress_records') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
