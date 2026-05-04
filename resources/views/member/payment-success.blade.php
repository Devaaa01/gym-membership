@extends('layouts.member')
@section('title', 'Payment Successful')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        {{-- Success card --}}
        <div class="card text-center py-5 px-4 mb-4">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                     style="width:80px;height:80px;background:rgba(6,95,70,.15)">
                    <i class="bi bi-check-lg text-success" style="font-size:2.5rem"></i>
                </div>
                <h3 class="fw-bold mb-1">Payment Successful!</h3>
                <p class="text-muted">Your membership is now active. Welcome aboard!</p>
            </div>

            {{-- Receipt --}}
            <div class="rounded-3 p-4 mb-4 text-start" style="background:var(--input-bg);border:1px dashed var(--input-border)">
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Reference</span>
                    <span class="small font-monospace fw-semibold">{{ $payment->reference_number }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Plan</span>
                    <span class="small fw-semibold">{{ $payment->membership->plan->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Membership Period</span>
                    <span class="small fw-semibold">
                        {{ $payment->membership->start_date->format('d M Y') }}
                        — {{ $payment->membership->end_date->format('d M Y') }}
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Payment Method</span>
                    <span class="small fw-semibold">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Date</span>
                    <span class="small fw-semibold">{{ $payment->payment_date->format('d M Y') }}</span>
                </div>
                <hr class="my-3">
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Amount Paid</span>
                    <span class="fw-bold text-success fs-5">{{ $payment->formatted_amount }}</span>
                </div>
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
