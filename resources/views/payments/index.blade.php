@extends('layouts.app')
@section('title', 'Payments')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Payments</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-credit-card-fill me-2 text-danger"></i>Payments</h1>
        <p>Track all membership payments</p>
    </div>
    <a href="{{ route('payments.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Record Payment</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Member name or reference..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    @foreach(['paid','pending','failed','refunded'] as $s)
                    <option value="{{ $s }}" {{ request('status')==$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Method</label>
                <select name="method" class="form-select">
                    <option value="">All</option>
                    @foreach(['cash','credit_card','debit_card','bank_transfer','e_wallet'] as $m)
                    <option value="{{ $m }}" {{ request('method')==$m ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$m)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th class="ps-4">Reference</th>
                <th>Member</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
                <th>Status</th>
                <th class="text-end pe-4">Actions</th>
            </tr></thead>
            <tbody>
            @forelse($payments as $payment)
            <tr>
                <td class="ps-4 small text-muted font-monospace">{{ $payment->reference_number }}</td>
                <td class="small fw-semibold">{{ $payment->member->full_name }}</td>
                <td class="small">{{ $payment->membership->plan->name ?? '—' }}</td>
                <td class="small fw-bold text-success">{{ $payment->formatted_amount }}</td>
                <td class="small">{{ ucwords(str_replace('_',' ',$payment->payment_method)) }}</td>
                <td class="small">{{ $payment->payment_date->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $payment->status }} rounded-pill px-3">{{ ucfirst($payment->status) }}</span></td>
                <td class="text-end pe-4">
                    <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this payment record?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-5 text-muted">No payments found.</td></tr>
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
