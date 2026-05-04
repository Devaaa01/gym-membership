<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Models\ClassBooking;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberPortalController extends Controller
{
    private function member()
    {
        return Auth::guard('member')->user();
    }

    // ── Dashboard ─────────────────────────────────────────────────────────
    public function dashboard()
    {
        $member = $this->member()->load([
            'activeMembership.plan',
            'memberships.plan',
            'classBookings.gymClass.trainer',
            'payments.membership.plan',
        ]);

        $upcomingBookings = $member->classBookings
            ->where('status', 'booked')
            ->filter(fn($b) => $b->gymClass->schedule->isFuture())
            ->sortBy('gymClass.schedule')
            ->take(5);

        $availableClasses = GymClass::with('trainer')
            ->where('status', 'scheduled')
            ->where('schedule', '>=', now())
            ->orderBy('schedule')
            ->take(6)
            ->get();

        $recentPayments = $member->payments()
            ->with('membership.plan')
            ->latest()
            ->take(5)
            ->get();

        $hasActiveMembership = $member->activeMembership !== null;

        return view('member.dashboard', compact(
            'member', 'upcomingBookings', 'availableClasses', 'recentPayments', 'hasActiveMembership'
        ));
    }

    // ── Profile ───────────────────────────────────────────────────────────
    public function profile()
    {
        $member = $this->member();
        return view('member.profile', compact('member'));
    }

    public function updateProfile(Request $request)
    {
        $member = $this->member();

        $validated = $request->validate([
            'first_name'              => 'required|string|max:100',
            'last_name'               => 'required|string|max:100',
            'phone'                   => 'nullable|string|max:20',
            'date_of_birth'           => 'nullable|date|before:today',
            'gender'                  => 'nullable|in:male,female,other',
            'address'                 => 'nullable|string|max:500',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'photo'                   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($member->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($member->photo);
            }
            $validated['photo'] = $request->file('photo')->store('members', 'public');
        } else {
            unset($validated['photo']);
        }

        $member->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $member = $this->member();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $member->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $member->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully!');
    }

    // ── Memberships ───────────────────────────────────────────────────────
    public function memberships()
    {
        $member      = $this->member();
        $memberships = $member->memberships()->with('plan')->latest()->get();
        $plans       = MembershipPlan::where('is_active', true)->orderBy('price')->get();

        return view('member.memberships', compact('member', 'memberships', 'plans'));
    }

    // ── Classes ───────────────────────────────────────────────────────────
    public function classes(Request $request)
    {
        $member = $this->member();

        $query = GymClass::with('trainer')
            ->where('status', 'scheduled')
            ->where('schedule', '>=', now());

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $classes    = $query->orderBy('schedule')->paginate(9)->withQueryString();
        $categories = GymClass::distinct()->pluck('category');

        // IDs of classes this member already booked
        $bookedIds = $member->classBookings()
            ->whereIn('status', ['booked', 'attended'])
            ->pluck('class_id')
            ->toArray();

        $hasActiveMembership = $member->activeMembership !== null;

        return view('member.classes', compact('classes', 'categories', 'bookedIds', 'hasActiveMembership'));
    }

    public function bookClass(Request $request, GymClass $class)
    {
        $member = $this->member();

        // Must have an active membership to book
        if (!$member->activeMembership) {
            return back()->with('error', 'You need an active membership to book classes. Please subscribe to a plan first.');
        }

        // Already booked?
        if (ClassBooking::where('member_id', $member->id)->where('class_id', $class->id)->exists()) {
            return back()->with('error', 'You have already booked this class.');
        }

        // Full?
        $booked = $class->bookings()->whereIn('status', ['booked', 'attended'])->count();
        if ($booked >= $class->max_capacity) {
            return back()->with('error', 'Sorry, this class is fully booked.');
        }

        ClassBooking::create([
            'member_id' => $member->id,
            'class_id'  => $class->id,
            'status'    => 'booked',
        ]);

        return back()->with('success', 'You have successfully booked "' . $class->name . '"!');
    }

    public function cancelBooking(ClassBooking $booking)
    {
        $member = $this->member();

        if ($booking->member_id !== $member->id) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }

    // ── Payments ──────────────────────────────────────────────────────────
    public function payments()
    {
        $member   = $this->member();
        $payments = $member->payments()->with('membership.plan')->latest()->paginate(10);

        return view('member.payments', compact('member', 'payments'));
    }

    // ── Pay for a membership (show form) ─────────────────────────────────
    public function showPaymentForm(Request $request)
    {
        $member = $this->member();

        // Pending memberships the member can pay for
        $pendingMemberships = $member->memberships()
            ->with('plan')
            ->where('status', 'pending')
            ->get();

        // All active plans (for subscribing to a new one)
        $plans = MembershipPlan::where('is_active', true)->orderBy('price')->get();

        $selectedMembership = $request->membership_id
            ? $member->memberships()->with('plan')->find($request->membership_id)
            : $pendingMemberships->first();

        return view('member.payment-form', compact(
            'member', 'pendingMemberships', 'plans', 'selectedMembership'
        ));
    }

    // ── Subscribe to a new plan (creates membership + processes payment) ──
    public function subscribePlan(Request $request)
    {
        $member = $this->member();

        $validated = $request->validate([
            'plan_id'        => 'required|exists:membership_plans,id',
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,e_wallet',
        ]);

        $plan = MembershipPlan::findOrFail($validated['plan_id']);

        // Create the pending membership
        $membership = $member->memberships()->create([
            'plan_id'    => $plan->id,
            'start_date' => now(),
            'end_date'   => now()->addMonths($plan->duration_months)->subDay(),
            'status'     => 'pending',
        ]);

        // Immediately record payment and activate
        $payment = Payment::create([
            'member_id'      => $member->id,
            'membership_id'  => $membership->id,
            'amount'         => $plan->price,
            'payment_method' => $validated['payment_method'],
            'status'         => 'paid',
            'payment_date'   => now()->toDateString(),
            'notes'          => 'Self-service payment by member.',
        ]);

        $membership->update(['status' => 'active']);

        return redirect()->route('member.payment.success', $payment)
            ->with('success', 'Payment successful! Your membership is now active.');
    }

    // ── Process payment ───────────────────────────────────────────────────
    public function processPayment(Request $request)
    {
        $member = $this->member();

        $validated = $request->validate([
            'membership_id'  => 'required|exists:memberships,id',
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,e_wallet',
        ]);

        // Make sure this membership belongs to the logged-in member
        $membership = $member->memberships()->with('plan')->find($validated['membership_id']);

        if (!$membership) {
            return back()->with('error', 'Membership not found.');
        }

        if ($membership->status !== 'pending') {
            return back()->with('error', 'This membership has already been paid or is not payable.');
        }

        // Create the payment record as paid
        $payment = Payment::create([
            'member_id'      => $member->id,
            'membership_id'  => $membership->id,
            'amount'         => $membership->plan->price,
            'payment_method' => $validated['payment_method'],
            'status'         => 'paid',
            'payment_date'   => now()->toDateString(),
            'notes'          => 'Self-service payment by member.',
        ]);

        // Activate the membership
        $membership->update(['status' => 'active']);

        return redirect()->route('member.payment.success', $payment)
            ->with('success', 'Payment successful! Your membership is now active.');
    }

    // ── Payment success page ──────────────────────────────────────────────
    public function paymentSuccess(Payment $payment)
    {
        $member = $this->member();

        // Security: only the owner can view
        if ($payment->member_id !== $member->id) {
            abort(403);
        }

        $payment->load('membership.plan');

        return view('member.payment-success', compact('payment'));
    }
}
