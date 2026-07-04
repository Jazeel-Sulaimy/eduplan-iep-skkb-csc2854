<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Automated Reward Rules (FR8)
    |--------------------------------------------------------------------------
    | The points are calculated by the server. Values submitted from the
    | browser are never trusted, so teachers cannot manually alter the score.
    */
    'rules' => [
        'completed_goal' => [
            'label_key' => 'messages.reward_completed_goal',
            'type' => 'Positive',
            'points' => 10,
        ],
        'active_participation' => [
            'label_key' => 'messages.reward_active_participation',
            'type' => 'Positive',
            'points' => 8,
        ],
        'helped_others' => [
            'label_key' => 'messages.reward_helped_others',
            'type' => 'Positive',
            'points' => 5,
        ],
        'followed_instruction' => [
            'label_key' => 'messages.reward_followed_instruction',
            'type' => 'Positive',
            'points' => 3,
        ],
        'neutral_observation' => [
            'label_key' => 'messages.reward_neutral_observation',
            'type' => 'Neutral',
            'points' => 0,
        ],
        'minor_disruption' => [
            'label_key' => 'messages.reward_minor_disruption',
            'type' => 'Negative',
            'points' => -2,
        ],
        'incomplete_task' => [
            'label_key' => 'messages.reward_incomplete_task',
            'type' => 'Negative',
            'points' => -3,
        ],
        'disrespectful_behaviour' => [
            'label_key' => 'messages.reward_disrespectful_behaviour',
            'type' => 'Negative',
            'points' => -5,
        ],
        'aggressive_behaviour' => [
            'label_key' => 'messages.reward_aggressive_behaviour',
            'type' => 'Negative',
            'points' => -10,
        ],
    ],

    'levels' => [
        ['minimum' => 50, 'key' => 'gold', 'label_key' => 'messages.reward_level_gold'],
        ['minimum' => 25, 'key' => 'silver', 'label_key' => 'messages.reward_level_silver'],
        ['minimum' => 10, 'key' => 'bronze', 'label_key' => 'messages.reward_level_bronze'],
        ['minimum' => PHP_INT_MIN, 'key' => 'starter', 'label_key' => 'messages.reward_level_starter'],
    ],
];
