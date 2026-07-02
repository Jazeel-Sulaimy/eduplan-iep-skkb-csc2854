<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'school_code' => 'TBA 5001',
            'school_name' => 'Sekolah Kebangsaan Kuala Berang',
            'student_name' => fake()->name(),
            'student_ic' => fake()->unique()->numerify('######-##-####'),
            'class_name' => fake()->randomElement(['1 Aktif', '2 Cemerlang', '2 Bestari']),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'date_of_birth' => fake()->dateTimeBetween('-12 years', '-7 years')->format('Y-m-d'),
            'category' => 'Masalah Pembelajaran',
            'programme_type' => 'Program Pendidikan Khas Integrasi',
            'diagnosis' => 'Learning support required',
            'existing_knowledge' => 'Can follow simple instructions.',
            'student_ability' => 'Can participate with guidance.',
            'status' => 'In Progress',
        ];
    }
}
