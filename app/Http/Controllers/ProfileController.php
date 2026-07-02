<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('profile_picture')) {
            $directory = public_path('uploads/profiles');
            File::ensureDirectoryExists($directory);

            $file = $request->file('profile_picture');
            $filename = Str::uuid() . '.' . strtolower($file->getClientOriginalExtension());
            $file->move($directory, $filename);

            $oldPath = $user->profile_picture
                ? public_path($user->profile_picture)
                : null;

            $data['profile_picture'] = 'uploads/profiles/' . $filename;

            if ($oldPath && File::isFile($oldPath)) {
                File::delete($oldPath);
            }
        }

        $user->update($data);

        return back()->with('success', __('messages.profile_updated_successfully'));
    }
}
