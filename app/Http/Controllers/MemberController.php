<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $members = $query->latest()->paginate(10)->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'              => 'required|string|max:100',
            'last_name'               => 'required|string|max:100',
            'email'                   => 'required|email|unique:members,email',
            'phone'                   => 'nullable|string|max:20',
            'date_of_birth'           => 'nullable|date|before:today',
            'gender'                  => 'nullable|in:male,female,other',
            'address'                 => 'nullable|string|max:500',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'photo'                   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'                  => 'required|in:active,inactive,suspended',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('members', 'public');
        }

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', 'Member registered successfully!');
    }

    public function show(Member $member)
    {
        $member->load(['memberships.plan', 'classBookings.gymClass', 'payments.membership.plan']);
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name'              => 'required|string|max:100',
            'last_name'               => 'required|string|max:100',
            'email'                   => 'required|email|unique:members,email,' . $member->id,
            'phone'                   => 'nullable|string|max:20',
            'date_of_birth'           => 'nullable|date|before:today',
            'gender'                  => 'nullable|in:male,female,other',
            'address'                 => 'nullable|string|max:500',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'photo'                   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'                  => 'required|in:active,inactive,suspended',
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $validated['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member->update($validated);

        return redirect()->route('members.show', $member)
            ->with('success', 'Member updated successfully!');
    }

    public function destroy(Member $member)
    {
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully!');
    }
}
