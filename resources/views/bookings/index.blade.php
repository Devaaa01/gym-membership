@extends('layouts.app')
@section('title', 'Class Bookings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Bookings</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-bookmark-check-fill me-2 text-danger"></i>Class Bookings</h1>
        <p>Manage class reservations</p>
    </div>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>New Booking</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search Member</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Member name..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    @foreach(['booked','attended','cancelled','no_show'] as $s)
                    <option value="{{ $s }}" {{ request('status')==$s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th class="ps-4">Member</th>
                <th>Class</th>
                <th>Trainer</th>
                <th>Schedule</th>
                <th>Status</th>
                <th class="text-end pe-4">Actions</th>
            </tr></thead>
            <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td class="ps-4">
                    <div class="fw-semibold small">{{ $booking->member->full_name }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $booking->member->email }}</div>
                </td>
                <td class="small fw-semibold">{{ $booking->gymClass->name }}</td>
                <td class="small">{{ $booking->gymClass->trainer->full_name }}</td>
                <td class="small">{{ $booking->gymClass->schedule->format('d M Y H:i') }}</td>
                <td><span class="badge badge-{{ $booking->status }} rounded-pill px-3">{{ ucfirst(str_replace('_',' ',$booking->status)) }}</span></td>
                <td class="text-end pe-4">
                    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this booking?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-5 text-muted">No bookings found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $bookings->firstItem() }}–{{ $bookings->lastItem() }} of {{ $bookings->total() }}</small>
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
