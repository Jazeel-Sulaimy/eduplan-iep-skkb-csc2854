<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ParentRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.parent-register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'identification_card' => ['required', 'string', 'max:30', Rule::unique('users', 'identification_card')],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'student_name' => ['required', 'string', 'max:150'],
            'student_ic' => ['required', 'string', 'max:30'],
        ]);

        $parent = DB::transaction(function () use ($data) {
            $student = Student::where('student_ic', $data['student_ic'])
                ->lockForUpdate()
                ->get()
                ->first(fn (Student $candidate) => strcasecmp(
                    trim($candidate->student_name),
                    trim($data['student_name'])
                ) === 0);

            if (! $student) {
                throw ValidationException::withMessages([
                    'student_name' => __('messages.invalid_student_information'),
                ]);
            }

            if ($student->parent_user_id) {
                throw ValidationException::withMessages([
                    'student_ic' => __('messages.student_already_linked'),
                ]);
            }

            $parent = User::create([
                'user_id' => $this->nextParentUserId(),
                'name' => $data['full_name'],
                'identification_card' => $data['identification_card'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'parent',
                'status' => 'Active',
            ]);

            $student->update([
                'parent_user_id' => $parent->id,
                'parent_name' => $parent->name,
                'parent_phone' => $parent->phone,
                'parent_email' => $parent->email,
            ]);

            return $parent;
        });

        return redirect()->route('login')->with(
            'success',
            __('messages.account_created_successfully', ['user_id' => $parent->user_id])
        );
    }

    private function nextParentUserId(): string
    {
        $numbers = User::where('user_id', 'like', 'PARENT%')
            ->pluck('user_id')
            ->map(function (string $userId): int {
                preg_match('/(\d+)$/', $userId, $matches);
                return isset($matches[1]) ? (int) $matches[1] : 0;
            });

        $number = ($numbers->max() ?? 0) + 1;

        do {
            $userId = 'PARENT' . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
            $number++;
        } while (User::where('user_id', $userId)->exists());

        return $userId;
    }
}
