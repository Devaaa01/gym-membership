@extends('layouts.member')
@section('title', 'My Payments')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-credit-card me-2 text-danger"></i>Payment History</h1>
    <p>All your membership payment records</p>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th class="ps-4">Reference</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
                <th>Status</th>
            </tr></thead>
            <tbody>
            @forelse($payments as $payment)
            <tr>
                <td class="ps-4 small font-monospace text-muted">{{ $payment->reference_number }}</td>
                <td class="small fw-semibold">{{ $payment->membership->plan->name ?? '—' }}</td>
                <td class="small fw-bold text-success">{{ $payment->formatted_amount }}</td>
                <td class="small">{{ ucwords(str_replace('_',' ',$payment->payment_method)) }}</td>
                <td class="small">{{ $payment->payment_date->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $payment->status }} rounded-pill px-3">{{ ucfirst($payment->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-5 text-muted">No payment records found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }}</small>
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
