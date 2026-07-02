@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.consent_letter')])

    <div class="mockup-panel">
        <div class="panel-heading-row">
            <h2>{{ __('messages.parent_consent_records') }}</h2>
            <a class="btn" href="{{ route('consents.create') }}">{{ __('messages.submit_consent_letter') }}</a>
        </div>

        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.parent_guardian') }}</th>
                        <th>{{ __('messages.student') }}</th>
                        <th>{{ __('messages.consent_date') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consents as $consent)
                        <tr>
                            <td>{{ $consent->parent_name }}</td>
                            <td>{{ $consent->student->student_name ?? '-' }}</td>
                            <td>{{ $consent->consent_date }}</td>
                            <td>{{ $consent->status }}</td>
                            <td><a href="{{ route('consents.edit', $consent) }}">{{ __('messages.review') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5">{{ __('messages.no_consent_letter') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
