@extends('layouts.app')
@section('title', 'Membership Detail')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('memberships.index') }}">Memberships</a></li>
    <li class="breadcrumb-item active">#{{ $membership->id }}</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-card-checklist me-2 text-danger"></i>Membership #{{ $membership->id }}</h1>
        <p>{{ $membership->member->full_name }} — {{ $membership->plan->name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('payments.create', ['membership_id' => $membership->id]) }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Record Payment
        </a>
        <a href="{{ route('memberships.edit', $membership) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-3 border-bottom pb-2">Membership Info</h6>
                <dl class="row small mb-0">
                    <dt class="col-5 text-muted">Member</dt>
                    <dd class="col-7"><a href="{{ route('members.show', $membership->member) }}">{{ $membership->member->full_name }}</a></dd>
                    <dt class="col-5 text-muted">Plan</dt>
                    <dd class="col-7 fw-semibold">{{ $membership->plan->name }}</dd>
                    <dt class="col-5 text-muted">Price</dt>
                    <dd class="col-7 text-success fw-bold">{{ $membership->plan->formatted_price }}</dd>
                    <dt class="col-5 text-muted">Start Date</dt>
                    <dd class="col-7">{{ $membership->start_date->format('d M Y') }}</dd>
                    <dt class="col-5 text-muted">End Date</dt>
                    <dd class="col-7 {{ $membership->end_date->isPast() ? 'text-danger' : '' }}">{{ $membership->end_date->format('d M Y') }}</dd>
                    <dt class="col-5 text-muted">Status</dt>
                    <dd class="col-7"><span class="badge badge-{{ $membership->status }} rounded-pill">{{ ucfirst($membership->status) }}</span></dd>
                    @if($membership->notes)
                    <dt class="col-5 text-muted">Notes</dt>
                    <dd class="col-7">{{ $membership->notes }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-credit-card me-2 text-danger"></i>Payments</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th class="ps-3">Ref</th><th>Amount</th><th>Method</th><th>Date</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($membership->payments as $payment)
                    <tr>
                        <td class="ps-3 small text-muted">{{ $payment->reference_number }}</td>
                        <td class="small fw-semibold text-success">{{ $payment->formatted_amount }}</td>
                        <td class="small">{{ ucwords(str_replace('_',' ',$payment->payment_method)) }}</td>
                        <td class="small">{{ $payment->payment_date->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $payment->status }} rounded-pill">{{ ucfirst($payment->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted small">No payments recorded.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
