@extends('layouts.app')
@section('title', 'Payment Receipt')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
    <li class="breadcrumb-item active">{{ $payment->reference_number }}</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-receipt me-2 text-danger"></i>Payment Receipt</h1>
        <p class="font-monospace text-muted">{{ $payment->reference_number }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
        @if($payment->status === 'pending')
        <form action="{{ route('payments.confirm', $payment) }}" method="POST">
            @csrf
            <button class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Confirm Payment</button>
        </form>
        <form action="{{ route('payments.reject', $payment) }}" method="POST"
              onsubmit="return confirm('Reject this payment?')">
            @csrf
            <button class="btn btn-warning"><i class="bi bi-x-lg me-1"></i>Reject</button>
        </form>
        @endif
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                <!-- Receipt Header -->
                <div class="text-center mb-4 pb-3 border-bottom">
                    <div class="fw-bold fs-5 text-danger">FitLife Gym</div>
                    <div class="text-muted small">Payment Receipt</div>
                </div>

                <dl class="row small">
                    <dt class="col-5 text-muted">Reference</dt>
                    <dd class="col-7 font-monospace fw-semibold">{{ $payment->reference_number }}</dd>

                    <dt class="col-5 text-muted">Member</dt>
                    <dd class="col-7 fw-semibold">{{ $payment->member->full_name }}</dd>

                    <dt class="col-5 text-muted">Membership Plan</dt>
                    <dd class="col-7">{{ $payment->membership->plan->name ?? '—' }}</dd>

                    <dt class="col-5 text-muted">Period</dt>
                    <dd class="col-7">
                        {{ $payment->membership->start_date->format('d M Y') }} –
                        {{ $payment->membership->end_date->format('d M Y') }}
                    </dd>

                    <dt class="col-5 text-muted">Payment Method</dt>
                    <dd class="col-7">{{ ucwords(str_replace('_',' ',$payment->payment_method)) }}</dd>

                    <dt class="col-5 text-muted">Payment Date</dt>
                    <dd class="col-7">{{ $payment->payment_date->format('d M Y') }}</dd>

                    <dt class="col-5 text-muted">Status</dt>
                    <dd class="col-7"><span class="badge badge-{{ $payment->status }} rounded-pill">{{ ucfirst($payment->status) }}</span></dd>

                    @if($payment->notes)
                    <dt class="col-5 text-muted">Notes</dt>
                    <dd class="col-7">{{ $payment->notes }}</dd>
                    @endif
                </dl>

                <div class="border-top pt-3 mt-3 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Total Amount</span>
                    <span class="fw-bold fs-4 text-success">{{ $payment->formatted_amount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
