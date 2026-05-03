<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\MembershipPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $query = Membership::with(['member', 'plan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $memberships = $query->latest()->paginate(10)->withQueryString();

        return view('memberships.index', compact('memberships'));
    }

    public function create(Request $request)
    {
        $members = Member::where('status', 'active')->orderBy('first_name')->get();
        $plans   = MembershipPlan::where('is_active', true)->orderBy('name')->get();
        $selectedMember = $request->member_id ? Member::find($request->member_id) : null;

        return view('memberships.create', compact('members', 'plans', 'selectedMember'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'  => 'required|exists:members,id',
            'plan_id'    => 'required|exists:membership_plans,id',
            'start_date' => 'required|date',
            'status'     => 'required|in:active,expired,cancelled,pending',
            'notes'      => 'nullable|string|max:500',
        ]);

        $plan = MembershipPlan::findOrFail($validated['plan_id']);
        $validated['end_date'] = Carbon::parse($validated['start_date'])
            ->addMonths($plan->duration_months)
            ->subDay();

        Membership::create($validated);

        return redirect()->route('memberships.index')
            ->with('success', 'Membership created successfully!');
    }

    public function show(Membership $membership)
    {
        $membership->load(['member', 'plan', 'payments']);
        return view('memberships.show', compact('membership'));
    }

    public function edit(Membership $membership)
    {
        $members = Member::where('status', 'active')->orderBy('first_name')->get();
        $plans   = MembershipPlan::where('is_active', true)->orderBy('name')->get();
        return view('memberships.edit', compact('membership', 'members', 'plans'));
    }

    public function update(Request $request, Membership $membership)
    {
        $validated = $request->validate([
            'member_id'  => 'required|exists:members,id',
            'plan_id'    => 'required|exists:membership_plans,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'status'     => 'required|in:active,expired,cancelled,pending',
            'notes'      => 'nullable|string|max:500',
        ]);

        $membership->update($validated);

        return redirect()->route('memberships.show', $membership)
            ->with('success', 'Membership updated successfully!');
    }

    public function destroy(Membership $membership)
    {
        $membership->delete();

        return redirect()->route('memberships.index')
            ->with('success', 'Membership deleted successfully!');
    }
}
