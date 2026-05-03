@extends('layouts.app')
@section('title', 'Memberships')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Memberships</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-card-checklist me-2 text-danger"></i>Memberships</h1>
        <p>Manage member subscriptions</p>
    </div>
    <a href="{{ route('memberships.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>New Membership</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search Member</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Name or email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    @foreach(['active','expired','cancelled','pending'] as $s)
                    <option value="{{ $s }}" {{ request('status')==$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a href="{{ route('memberships.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th class="ps-4">Member</th>
                <th>Plan</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th class="text-end pe-4">Actions</th>
            </tr></thead>
            <tbody>
            @forelse($memberships as $ms)
            <tr>
                <td class="ps-4">
                    <div class="fw-semibold small">{{ $ms->member->full_name }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $ms->member->email }}</div>
                </td>
                <td class="small">{{ $ms->plan->name }}</td>
                <td class="small">{{ $ms->start_date->format('d M Y') }}</td>
                <td class="small {{ $ms->end_date->isPast() ? 'text-danger' : '' }}">{{ $ms->end_date->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $ms->status }} rounded-pill px-3">{{ ucfirst($ms->status) }}</span></td>
                <td class="text-end pe-4">
                    <a href="{{ route('memberships.show', $ms) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('memberships.edit', $ms) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('memberships.destroy', $ms) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this membership?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-5 text-muted">No memberships found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($memberships->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $memberships->firstItem() }}–{{ $memberships->lastItem() }} of {{ $memberships->total() }}</small>
        {{ $memberships->links() }}
    </div>
    @endif
</div>
@endsection
