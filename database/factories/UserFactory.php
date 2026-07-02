<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'user_id' => 'USER' . fake()->unique()->numerify('####'),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('01########'),
            'identification_card' => null,
            'address' => fake()->address(),
            'role' => 'teacher',
            'status' => 'Active',
            'password' => static::$password ??= Hash::make('password123'),
            'remember_token' => Str::random(10),
        ];
    }

    public function schoolAdmin(): static
    {
        return $this->state(fn () => ['role' => 'school_admin']);
    }

    public function teacher(): static
    {
        return $this->state(fn () => ['role' => 'teacher']);
    }

    public function counsellor(): static
    {
        return $this->state(fn () => ['role' => 'counsellor']);
    }

    public function parent(): static
    {
        return $this->state(fn () => ['role' => 'parent']);
    }

    public function systemAdmin(): static
    {
        return $this->state(fn () => ['role' => 'system_admin']);
    }
}
