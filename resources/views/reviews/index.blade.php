@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.review')])

    <div class="mockup-panel">
        <h2>{{ __('messages.iep_status') }}</h2>
        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.student') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.review_date') }}</th>
                        <th>{{ __('messages.next_review_date') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->student->student_name ?? '-' }}</td>
                            <td>{{ $review->review_status }}</td>
                            <td>{{ $review->review_date }}</td>
                            <td>{{ $review->next_review_date ?: '-' }}</td>
                            <td><a href="{{ route('reviews.edit', $review) }}">{{ __('messages.review') }}</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5">{{ __('messages.no_students_assigned') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="actions" style="margin-top:18px">
            <a class="btn" href="{{ route('reviews.create') }}">{{ __('messages.add_review') }}</a>
        </div>
    </div>
</div>
@endsection
