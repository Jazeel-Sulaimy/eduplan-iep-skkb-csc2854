<?php

namespace App\Support;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class StudentAccess
{
    public static function queryFor(User $user): Builder
    {
        $query = Student::query();

        return match ($user->role) {
            'school_admin', 'system_admin' => $query,
            'teacher' => $query->where('teacher_id', $user->id),
            'counsellor' => $query->where('counsellor_id', $user->id),
            'parent' => $query->where('parent_user_id', $user->id),
            default => $query->whereRaw('1 = 0'),
        };
    }

    public static function canView(User $user, Student $student): bool
    {
        return match ($user->role) {
            'school_admin', 'system_admin' => true,
            'teacher' => (int) $student->teacher_id === (int) $user->id,
            'counsellor' => (int) $student->counsellor_id === (int) $user->id,
            'parent' => (int) $student->parent_user_id === (int) $user->id,
            default => false,
        };
    }

    public static function authorizeView(User $user, Student $student): void
    {
        abort_unless(self::canView($user, $student), 403);
    }

    public static function authorizeTeacher(User $user, Student $student): void
    {
        $allowed = $user->role === 'school_admin'
            || ($user->role === 'teacher' && (int) $student->teacher_id === (int) $user->id);

        abort_unless($allowed, 403);
    }

    public static function authorizeCounsellor(User $user, Student $student): void
    {
        $allowed = $user->role === 'school_admin'
            || ($user->role === 'counsellor' && (int) $student->counsellor_id === (int) $user->id);

        abort_unless($allowed, 403);
    }

    public static function authorizeParent(User $user, Student $student): void
    {
        $allowed = $user->role === 'school_admin'
            || ($user->role === 'parent' && (int) $student->parent_user_id === (int) $user->id);

        abort_unless($allowed, 403);
    }
}
