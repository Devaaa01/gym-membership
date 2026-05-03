<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberAuthController extends Controller
{
    // ── Show login ────────────────────────────────────────────────────────
    public function showLogin()
    {
        return view('member.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Only allow active members to log in
        $member = Member::where('email', $credentials['email'])->first();

        if (!$member || !Hash::check($credentials['password'], $member->password)) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'These credentials do not match our records.']);
        }

        if ($member->status !== 'active') {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Your account is not active. Please contact the gym.']);
        }

        Auth::guard('member')->login($member, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('member.dashboard')
            ->with('success', 'Welcome back, ' . $member->first_name . '!');
    }

    // ── Show register ─────────────────────────────────────────────────────
    public function showRegister()
    {
        $plans = MembershipPlan::where('is_active', true)->orderBy('price')->get();
        return view('member.auth.register', compact('plans'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email|unique:members,email',
            'password'       => 'required|string|min:8|confirmed',
            'phone'          => 'nullable|string|max:20',
            'date_of_birth'  => 'nullable|date|before:today',
            'gender'         => 'nullable|in:male,female,other',
            'address'        => 'nullable|string|max:500',
            'plan_id'        => 'nullable|exists:membership_plans,id',
        ]);

        $member = Member::create([
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'phone'         => $validated['phone'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender'        => $validated['gender'] ?? null,
            'address'       => $validated['address'] ?? null,
            'status'        => 'active',
        ]);

        // If a plan was selected, create a pending membership
        if (!empty($validated['plan_id'])) {
            $plan = MembershipPlan::find($validated['plan_id']);
            $member->memberships()->create([
                'plan_id'    => $plan->id,
                'start_date' => now(),
                'end_date'   => now()->addMonths($plan->duration_months)->subDay(),
                'status'     => 'pending',
            ]);
        }

        Auth::guard('member')->login($member);
        $request->session()->regenerate();

        return redirect()->route('member.dashboard')
            ->with('success', 'Welcome to FitLife Gym, ' . $member->first_name . '! Your account has been created.');
    }

    // ── Logout ────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('member.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
