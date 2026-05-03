@extends('layouts.app')
@section('title', $member->full_name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('members.index') }}">Members</a></li>
    <li class="breadcrumb-item active">{{ $member->full_name }}</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-person-circle me-2 text-danger"></i>{{ $member->full_name }}</h1>
        <p>Member profile and history</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('memberships.create', ['member_id' => $member->id]) }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>New Membership
        </a>
        <a href="{{ route('members.edit', $member) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="card text-center p-4">
            @if($member->photo)
                <img src="{{ asset('storage/'.$member->photo) }}" class="rounded-circle mx-auto mb-3"
                     style="width:100px;height:100px;object-fit:cover" alt="">
            @else
                <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                     style="width:100px;height:100px;background:#e63946;color:#fff;font-size:2.5rem;font-weight:700">
                    {{ strtoupper(substr($member->first_name,0,1)) }}
                </div>
            @endif
            <h5 class="fw-bold mb-1">{{ $member->full_name }}</h5>
            <p class="text-muted small mb-3">{{ $member->email }}</p>
            <span class="badge badge-{{ $member->status }} rounded-pill px-3 py-2 mb-4">{{ ucfirst($member->status) }}</span>

            <div class="text-start">
                @if($member->phone)
                <div class="d-flex align-items-center gap-2 mb-2 small">
                    <i class="bi bi-telephone text-muted"></i> {{ $member->phone }}
                </div>
                @endif
                @if($member->date_of_birth)
                <div class="d-flex align-items-center gap-2 mb-2 small">
                    <i class="bi bi-cake text-muted"></i> {{ $member->date_of_birth->format('d M Y') }}
                    ({{ $member->date_of_birth->age }} yrs)
                </div>
                @endif
                @if($member->gender)
                <div class="d-flex align-items-center gap-2 mb-2 small">
                    <i class="bi bi-gender-ambiguous text-muted"></i> {{ ucfirst($member->gender) }}
                </div>
                @endif
                @if($member->address)
                <div class="d-flex align-items-start gap-2 mb-2 small">
                    <i class="bi bi-geo-alt text-muted mt-1"></i> {{ $member->address }}
                </div>
                @endif
                @if($member->emergency_contact_name)
                <hr>
                <div class="small text-muted fw-semibold mb-1">Emergency Contact</div>
                <div class="small">{{ $member->emergency_contact_name }}</div>
                <div class="small text-muted">{{ $member->emergency_contact_phone }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Memberships -->
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-card-checklist me-2 text-danger"></i>Memberships</h6>
                <a href="{{ route('memberships.create', ['member_id' => $member->id]) }}" class="btn btn-sm btn-outline-primary">+ Add</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th class="ps-3">Plan</th><th>Start</th><th>End</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                    @forelse($member->memberships as $ms)
                    <tr>
                        <td class="ps-3 fw-semibold small">{{ $ms->plan->name }}</td>
                        <td class="small">{{ $ms->start_date->format('d M Y') }}</td>
                        <td class="small">{{ $ms->end_date->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $ms->status }} rounded-pill">{{ ucfirst($ms->status) }}</span></td>
                        <td><a href="{{ route('memberships.show', $ms) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-3 text-muted small">No memberships yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Class Bookings -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-bookmark-check me-2 text-danger"></i>Class Bookings</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th class="ps-3">Class</th><th>Schedule</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($member->classBookings as $booking)
                    <tr>
                        <td class="ps-3 fw-semibold small">{{ $booking->gymClass->name }}</td>
                        <td class="small">{{ $booking->gymClass->schedule->format('d M Y H:i') }}</td>
                        <td><span class="badge badge-{{ $booking->status }} rounded-pill">{{ ucfirst(str_replace('_',' ',$booking->status)) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center py-3 text-muted small">No bookings yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payments -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-credit-card me-2 text-danger"></i>Payment History</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th class="ps-3">Ref</th><th>Plan</th><th>Amount</th><th>Date</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($member->payments as $payment)
                    <tr>
                        <td class="ps-3 small text-muted">{{ $payment->reference_number }}</td>
                        <td class="small">{{ $payment->membership->plan->name ?? '—' }}</td>
                        <td class="small fw-semibold text-success">{{ $payment->formatted_amount }}</td>
                        <td class="small">{{ $payment->payment_date->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $payment->status }} rounded-pill">{{ ucfirst($payment->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-3 text-muted small">No payments yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
