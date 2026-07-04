@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.behaviour_status')])

    <div class="mockup-panel">
        <div class="panel-heading-row">
            <div>
                <h2>{{ __('messages.behaviour_status') }}</h2>
                <p class="panel-subtitle">{{ __('messages.reward_points_server_calculated') }}</p>
            </div>
            <div class="actions">
                <a class="btn btn-light" href="{{ route('rewards.index') }}">
                    {{ __('messages.reward_summary') }}
                </a>
                <a class="btn" href="{{ route('behaviours.create') }}">
                    {{ __('messages.add_record') }}
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="mockup-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.student') }}</th>
                        <th>{{ __('messages.behaviour_action') }}</th>
                        <th>{{ __('messages.behaviour_type') }}</th>
                        <th>{{ __('messages.description') }}</th>
                        <th>{{ __('messages.points') }}</th>
                        <th>{{ __('messages.record_date') }}</th>
                        <th>{{ __('messages.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($behaviours as $behaviour)
                        <tr>
                            <td>{{ $behaviour->student->student_name ?? '-' }}</td>
                            <td>{{ $behaviour->rewardLabel() }}</td>
                            <td>{{ $behaviour->behaviourTypeLabel() }}</td>
                            <td>{{ $behaviour->description }}</td>
                            <td>
                                <span class="reward-points {{ $behaviour->points > 0 ? 'positive' : ($behaviour->points < 0 ? 'negative' : 'neutral') }}">
                                    {{ $behaviour->signedPoints() }}
                                </span>
                            </td>
                            <td>{{ optional($behaviour->record_date)->format('d/m/Y') ?: '-' }}</td>
                            <td class="actions">
                                <a href="{{ route('behaviours.edit', $behaviour) }}">
                                    {{ __('messages.edit') }}
                                </a>
                                <form
                                    method="POST"
                                    action="{{ route('behaviours.destroy', $behaviour) }}"
                                    onsubmit="return confirm('{{ __('messages.confirm_delete_record') }}')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="table-link danger-link" type="submit">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">{{ __('messages.no_record_yet') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
