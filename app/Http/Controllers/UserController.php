<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizeUserManagement();

        $users = User::query()
            ->when(
                auth()->user()->role === 'school_admin',
                fn ($query) => $query->whereIn('role', ['teacher', 'counsellor', 'parent'])
            )
            ->latest()
            ->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeUserManagement();

        return view('users.form', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $this->authorizeUserManagement();

        $data = $this->validated($request);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', __('messages.user_created_successfully'));
    }

    public function edit(User $user)
    {
        $this->authorizeUserManagement();
        $this->authorizeTargetUser($user);

        return view('users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeUserManagement();
        $this->authorizeTargetUser($user);

        $data = $this->validated($request, $user->id);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', __('messages.user_updated_successfully'));
    }

    public function destroy(User $user)
    {
        $this->authorizeUserManagement();
        $this->authorizeTargetUser($user);

        if (auth()->id() === $user->id) {
            return back()->withErrors([
                'delete' => __('messages.cannot_delete_own_account'),
            ]);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', __('messages.user_deleted_successfully'));
    }

    private function authorizeUserManagement(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->hasRole('school_admin', 'system_admin'),
            403
        );
    }

    private function authorizeTargetUser(User $user): void
    {
        if (
            auth()->user()->role === 'school_admin'
            && in_array($user->role, ['school_admin', 'system_admin'], true)
        ) {
            abort(403);
        }
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $allowedRoles = auth()->user()->role === 'system_admin'
            ? ['school_admin', 'teacher', 'counsellor', 'parent', 'system_admin']
            : ['teacher', 'counsellor', 'parent'];

        return $request->validate([
            'user_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'user_id')->ignore($ignoreId),
            ],
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($ignoreId),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'identification_card' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('users', 'identification_card')->ignore($ignoreId),
            ],
            'address' => ['nullable', 'string', 'max:1000'],
            'role' => ['required', Rule::in($allowedRoles)],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'password' => [
                $ignoreId ? 'nullable' : 'required',
                'string',
                'min:5',
                'max:255',
            ],
        ]);
    }
}
