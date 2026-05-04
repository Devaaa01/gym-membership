<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::latest()->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin account created successfully!');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        if (User::count() <= 1) {
            return back()->with('error', 'Cannot delete the last admin account.');
        }
        $admin->delete();
        return back()->with('success', 'Admin account deleted.');
    }

    public function edit(User $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $rules = [
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ];

        // Password hanya wajib jika diisi
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Password::min(8)->mixedCase()->numbers()];
        }

        $validated = $request->validate($rules);

        $admin->name  = $validated['name'];
        $admin->email = $validated['email'];

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin account updated successfully!');
    }

    // ── Profile ───────────────────────────────────────────────────────────
    public function editProfile()
    {
        return view('admin.profile', ['admin' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($admin->photo) {
                Storage::disk('public')->delete($admin->photo);
            }
            $admin->photo = $request->file('photo')->store('admins', 'public');
            $admin->save();
        }

        return back()->with('success', 'Profile photo updated!');
    }
}
