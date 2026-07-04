@extends('layouts.app')

@section('content')
<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.automated_reward_calculation')])

    <div class="reward-stat-grid">
        <div class="reward-stat-card">
            <span>{{ __('messages.students_monitored') }}</span>
            <strong>{{ $summary['students'] }}</strong>
        </div>
        <div class="reward-stat-card positive-card">
            <span>{{ __('messages.total_positive_points') }}</span>
            <strong>+{{ $summary['positive'] }}</strong>
        </div>
        <div class="reward-stat-card negative-card">
            <span>{{ __('messages.total_deductions') }}</span>
            <strong>-{{ $summary['deductions'] }}</strong>
        </div>
        <div class="reward-stat-card total-card">
            <span>{{ __('messages.overall_reward_points') }}</span>
            <strong>{{ $summary['total'] > 0 ? '+' : '' }}{{ $summary['total'] }}</strong>
        </div>
    </div>

    <div class="mockup-panel">
        <div class="panel-heading-row">
            <div>
                <h2>{{ __('messages.student_reward_summary') }}</h2>
                <p class="panel-subtitle">{{ __('messages.reward_summary_help') }}</p>
            </div>

            @if(auth()->user()->hasRole('teacher', 'school_admin'))
                <a class="btn" href="{{ route('behaviours.create') }}">
                    {{ __('messages.record_behaviour') }}
                </a>
            @endif
        </div>

        <div class="table-responsive">
            <table class="mockup-table reward-summary-table">
                <thead>
                    <tr>
                        <th>{{ __('messages.student') }}</th>
                        <th>{{ __('messages.class') }}</th>
                        <th>{{ __('messages.positive_points') }}</th>
                        <th>{{ __('messages.deductions') }}</th>
                        <th>{{ __('messages.total_points') }}</th>
                        <th>{{ __('messages.reward_level') }}</th>
                        <th>{{ __('messages.latest_behaviour') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php($latestBehaviour = $student->behaviours->first())
                        <tr>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->class_name }}</td>
                            <td><span class="reward-points positive">+{{ $student->reward_summary['positive'] }}</span></td>
                            <td><span class="reward-points negative">-{{ $student->reward_summary['deductions'] }}</span></td>
                            <td>
                                <strong class="reward-total {{ $student->reward_summary['total'] < 0 ? 'is-negative' : '' }}">
                                    {{ $student->reward_summary['total'] > 0 ? '+' : '' }}{{ $student->reward_summary['total'] }}
                                </strong>
                            </td>
                            <td>
                                <span class="reward-level reward-level-{{ $student->reward_summary['level_key'] }}">
                                    {{ $student->reward_summary['level_label'] }}
                                </span>
                            </td>
                            <td>
                                @if($latestBehaviour)
                                    {{ $latestBehaviour->rewardLabel() }}
                                    <small class="reward-date">{{ optional($latestBehaviour->record_date)->format('d/m/Y') }}</small>
                                @else
                                    {{ __('messages.no_record_yet') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">{{ __('messages.no_students_available') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mockup-panel reward-rules-panel">
        <h2>{{ __('messages.reward_calculation_rules') }}</h2>
        <p class="panel-subtitle">{{ __('messages.reward_rules_explanation') }}</p>

        <div class="reward-rule-grid">
            @foreach($rewardRules as $rule)
                <div class="reward-rule-card {{ strtolower($rule['type']) }}">
                    <div>
                        <strong>{{ __($rule['label_key']) }}</strong>
                        <small>{{ __('messages.' . strtolower($rule['type'])) }}</small>
                    </div>
                    <span>{{ $rule['points'] > 0 ? '+' : '' }}{{ $rule['points'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
