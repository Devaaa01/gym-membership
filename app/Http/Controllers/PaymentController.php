<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['member', 'membership.plan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                  ->orWhereHas('member', function ($mq) use ($search) {
                      $mq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        $payments = $query->latest()->paginate(10)->withQueryString();

        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $members     = Member::where('status', 'active')->orderBy('first_name')->get();
        $memberships = Membership::with(['member', 'plan'])
            ->whereIn('status', ['active', 'pending'])
            ->get();

        $selectedMembership = $request->membership_id
            ? Membership::with(['member', 'plan'])->find($request->membership_id)
            : null;

        return view('payments.create', compact('members', 'memberships', 'selectedMembership'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id'      => 'required|exists:members,id',
            'membership_id'  => 'required|exists:memberships,id',
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,e_wallet',
            'status'         => 'required|in:paid,pending,failed,refunded',
            'payment_date'   => 'required|date',
            'notes'          => 'nullable|string|max:500',
        ]);

        $payment = Payment::create($validated);

        // Auto-activate membership when payment is paid
        if ($validated['status'] === 'paid') {
            $membership = Membership::find($validated['membership_id']);
            if ($membership && $membership->status === 'pending') {
                $membership->update(['status' => 'active']);
            }
        }

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load(['member', 'membership.plan']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $members     = Member::where('status', 'active')->orderBy('first_name')->get();
        $memberships = Membership::with(['member', 'plan'])->get();
        return view('payments.edit', compact('payment', 'members', 'memberships'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount'         => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,e_wallet',
            'status'         => 'required|in:paid,pending,failed,refunded',
            'payment_date'   => 'required|date',
            'notes'          => 'nullable|string|max:500',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment record deleted successfully!');
    }

    public function confirm(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Only pending payments can be confirmed.');
        }

        $payment->update([
            'status'       => 'paid',
            'payment_date' => $payment->payment_date ?? now()->toDateString(),
        ]);

        // Activate the membership
        if ($payment->membership && $payment->membership->status === 'pending') {
            $payment->membership->update(['status' => 'active']);
        }

        return back()->with('success', 'Payment confirmed and membership activated.');
    }

    public function reject(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Only pending payments can be rejected.');
        }

        $payment->update(['status' => 'failed']);

        return back()->with('success', 'Payment rejected.');
    }
}
