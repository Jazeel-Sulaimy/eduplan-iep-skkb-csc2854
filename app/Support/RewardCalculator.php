<?php

namespace App\Support;

use InvalidArgumentException;

class RewardCalculator
{
    public static function rules(): array
    {
        return config('rewards.rules', []);
    }

    public static function keys(): array
    {
        return array_keys(self::rules());
    }

    public static function calculate(string $ruleKey): array
    {
        $rule = self::rules()[$ruleKey] ?? null;

        if (!$rule) {
            throw new InvalidArgumentException('Invalid reward rule selected.');
        }

        return [
            'reward_rule' => $ruleKey,
            'behaviour_type' => $rule['type'],
            'points' => (int) $rule['points'],
        ];
    }

    public static function suggestedRule(?string $type, ?int $points): ?string
    {
        foreach (self::rules() as $key => $rule) {
            if ($rule['type'] === $type && (int) $rule['points'] === (int) $points) {
                return $key;
            }
        }

        return null;
    }

    public static function level(int $totalPoints): array
    {
        foreach (config('rewards.levels', []) as $level) {
            if ($totalPoints >= (int) $level['minimum']) {
                return $level;
            }
        }

        return [
            'key' => 'starter',
            'label_key' => 'messages.reward_level_starter',
        ];
    }

    public static function signedPoints(int $points): string
    {
        return $points > 0 ? '+' . $points : (string) $points;
    }
}
