@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.iep_goals')])

    <div class="mockup-panel">
        <div class="panel-heading-row">
            <h2>{{ __('messages.iep_goals') }}</h2>
            <a class="btn" href="{{ route('goals.create') }}">{{ __('messages.iep_form') }}</a>
        </div>

        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.student') }}</th>
                        <th>{{ __('messages.iep_focus') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.review_date') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($goals as $goal)
                        <tr>
                            <td>{{ $goal->student->student_name ?? '-' }}</td>
                            <td>{{ $goal->iep_focus ?: '-' }}</td>
                            <td>{{ $goal->status }}</td>
                            <td>{{ $goal->review_date ?: '-' }}</td>
                            <td><a href="{{ route('goals.edit', $goal) }}">{{ __('messages.edit') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5">{{ __('messages.no_iep_records') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
