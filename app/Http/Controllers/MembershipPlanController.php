<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class MembershipPlanController extends Controller
{
    public function index()
    {
        $plans = MembershipPlan::withCount('memberships')->latest()->get();
        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        return view('plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:100',
            'description'      => 'nullable|string|max:1000',
            'price'            => 'required|numeric|min:0',
            'duration_months'  => 'required|integer|min:1|max:24',
            'max_classes'      => 'required|integer|min:0',
            'personal_trainer' => 'boolean',
            'is_active'        => 'boolean',
        ]);

        $validated['personal_trainer'] = $request->boolean('personal_trainer');
        $validated['is_active']        = $request->boolean('is_active', true);

        MembershipPlan::create($validated);

        return redirect()->route('plans.index')
            ->with('success', 'Membership plan created successfully!');
    }

    public function show(MembershipPlan $plan)
    {
        $plan->load('memberships.member');
        return view('plans.show', compact('plan'));
    }

    public function edit(MembershipPlan $plan)
    {
        return view('plans.edit', compact('plan'));
    }

    public function update(Request $request, MembershipPlan $plan)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:100',
            'description'      => 'nullable|string|max:1000',
            'price'            => 'required|numeric|min:0',
            'duration_months'  => 'required|integer|min:1|max:24',
            'max_classes'      => 'required|integer|min:0',
            'personal_trainer' => 'boolean',
            'is_active'        => 'boolean',
        ]);

        $validated['personal_trainer'] = $request->boolean('personal_trainer');
        $validated['is_active']        = $request->boolean('is_active');

        $plan->update($validated);

        return redirect()->route('plans.index')
            ->with('success', 'Membership plan updated successfully!');
    }

    public function destroy(MembershipPlan $plan)
    {
        if ($plan->memberships()->exists()) {
            return back()->with('error', 'Cannot delete plan with existing memberships.');
        }

        $plan->delete();

        return redirect()->route('plans.index')
            ->with('success', 'Membership plan deleted successfully!');
    }
}
