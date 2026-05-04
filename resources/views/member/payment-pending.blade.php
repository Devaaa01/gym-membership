@extends('layouts.member')
@section('title', 'Payment Submitted')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        <div class="card text-center py-5 px-4 mb-4">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                     style="width:80px;height:80px;background:rgba(234,179,8,.15)">
                    <i class="bi bi-hourglass-split text-warning" style="font-size:2.5rem"></i>
                </div>
                <h3 class="fw-bold mb-1">Payment Submitted!</h3>
                <p class="text-muted">Your payment is awaiting confirmation from our staff.<br>Your membership will be activated once confirmed.</p>
            </div>

            {{-- Receipt --}}
            <div class="rounded-3 p-4 mb-4 text-start" style="background:var(--input-bg);border:1px dashed var(--input-border)">
                <div class="d-flex justify-content-between mb-2">
                    <span class="small" style="color:var(--text-secondary)">Reference</span>
                    <span class="small font-monospace fw-semibold" style="color:var(--text-primary)">{{ $payment->reference_number }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small" style="color:var(--text-secondary)">Plan</span>
                    <span class="small fw-semibold" style="color:var(--text-primary)">{{ $payment->membership->plan->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small" style="color:var(--text-secondary)">Membership Period</span>
                    <span class="small fw-semibold" style="color:var(--text-primary)">
                        {{ $payment->membership->start_date->format('d M Y') }}
                        — {{ $payment->membership->end_date->format('d M Y') }}
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small" style="color:var(--text-secondary)">Payment Method</span>
                    <span class="small fw-semibold" style="color:var(--text-primary)">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small" style="color:var(--text-secondary)">Date Submitted</span>
                    <span class="small fw-semibold" style="color:var(--text-primary)">{{ $payment->payment_date->format('d M Y') }}</span>
                </div>
                <hr class="my-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold" style="color:var(--text-primary)">Amount</span>
                    <span class="fw-bold fs-5" style="color:var(--text-primary)">{{ $payment->formatted_amount }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="fw-bold" style="color:var(--text-primary)">Status</span>
                    <span class="badge bg-warning text-dark rounded-pill px-3">Pending Confirmation</span>
                </div>
            </div>

            <div class="alert alert-info rounded-3 border-0 text-start small mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                Please complete your payment via the selected method and show proof to our staff. They will confirm your payment and activate your membership.
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('member.dashboard') }}" class="btn btn-primary py-2 fw-semibold">
                    <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                </a>
                <a href="{{ route('member.payments') }}" class="btn btn-outline-secondary py-2">
                    <i class="bi bi-clock-history me-2"></i>View Payment History
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
