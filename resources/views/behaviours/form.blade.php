@extends('layouts.app')

@section('content')
@php($isEdit = $behaviour->exists)

<div class="mockup-dashboard">
    @include('partials.mockup-header', ['title' => __('messages.behaviour_status')])

    <div class="mockup-panel">
        <h2>
            {{ $isEdit ? __('messages.edit') : __('messages.add_record') }}
            — {{ __('messages.behaviour_status') }}
        </h2>

        <div class="reward-auto-note">
            <strong>{{ __('messages.automated_reward_calculation') }}</strong>
            <span>{{ __('messages.reward_calculation_help') }}</span>
        </div>

        @if($students->isEmpty())
            <div class="empty-state">{{ __('messages.no_students_assigned') }}</div>
        @else
            <form
                method="POST"
                action="{{ $isEdit ? route('behaviours.update', $behaviour) : route('behaviours.store') }}"
            >
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <div>
                        <label for="student_id">{{ __('messages.student') }}</label>
                        <select class="select" id="student_id" name="student_id" required>
                            <option value="">{{ __('messages.select_student') }}</option>
                            @foreach($students as $student)
                                <option
                                    value="{{ $student->id }}"
                                    {{ (string) old('student_id', $behaviour->student_id ?: request('student_id')) === (string) $student->id ? 'selected' : '' }}
                                >
                                    {{ $student->student_name }} — {{ $student->class_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="record_date">{{ __('messages.record_date') }}</label>
                        <input
                            class="input"
                            type="date"
                            id="record_date"
                            name="record_date"
                            value="{{ old('record_date', optional($behaviour->record_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                            required
                        >
                        @error('record_date')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="full">
                        <label for="reward_rule">{{ __('messages.behaviour_reward_rule') }}</label>
                        <select class="select" id="reward_rule" name="reward_rule" required>
                            <option value="">{{ __('messages.select_behaviour_action') }}</option>
                            @foreach($rewardRules as $key => $rule)
                                <option
                                    value="{{ $key }}"
                                    data-type="{{ $rule['type'] }}"
                                    data-type-label="{{ __('messages.' . strtolower($rule['type'])) }}"
                                    data-points="{{ $rule['points'] }}"
                                    {{ $selectedRewardRule === $key ? 'selected' : '' }}
                                >
                                    {{ __($rule['label_key']) }}
                                    ({{ $rule['points'] > 0 ? '+' : '' }}{{ $rule['points'] }} {{ __('messages.points') }})
                                </option>
                            @endforeach
                        </select>
                        @error('reward_rule')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="calculated_behaviour_type">{{ __('messages.behaviour_type') }}</label>
                        <input
                            class="input reward-readonly"
                            type="text"
                            id="calculated_behaviour_type"
                            value=""
                            readonly
                            aria-readonly="true"
                        >
                    </div>

                    <div>
                        <label for="calculated_points">{{ __('messages.automatically_calculated_points') }}</label>
                        <input
                            class="input reward-readonly"
                            type="text"
                            id="calculated_points"
                            value=""
                            readonly
                            aria-readonly="true"
                        >
                    </div>

                    <div class="full">
                        <label for="description">{{ __('messages.description') }}</label>
                        <textarea
                            class="input"
                            id="description"
                            name="description"
                            required
                        >{{ old('description', $behaviour->description) }}</textarea>
                        @error('description')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="actions">
                    <button class="btn" type="submit">{{ __('messages.save') }}</button>
                    <a class="btn btn-light" href="{{ route('behaviours.index') }}">
                        {{ __('messages.cancel') }}
                    </a>
                </div>
            </form>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rewardSelect = document.getElementById('reward_rule');
    const typeField = document.getElementById('calculated_behaviour_type');
    const pointsField = document.getElementById('calculated_points');

    if (!rewardSelect || !typeField || !pointsField) {
        return;
    }

    function updateCalculatedReward() {
        const selected = rewardSelect.options[rewardSelect.selectedIndex];
        const points = Number(selected.dataset.points || 0);

        typeField.value = selected.dataset.typeLabel || '-';
        pointsField.value = selected.value
            ? `${points > 0 ? '+' : ''}${points} {{ __('messages.points') }}`
            : '-';
    }

    rewardSelect.addEventListener('change', updateCalculatedReward);
    updateCalculatedReward();
});
</script>
@endsection
