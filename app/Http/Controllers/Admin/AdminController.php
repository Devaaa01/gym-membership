<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        // Prevent deleting yourself
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting the last admin
        if (User::count() <= 1) {
            return back()->with('error', 'Cannot delete the last admin account.');
        }

        $admin->delete();

        return back()->with('success', 'Admin account deleted.');
    }
}
