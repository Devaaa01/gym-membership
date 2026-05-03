@extends('layouts.app')
@section('title', 'Members')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Members</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-people-fill me-2 text-danger"></i>Members</h1>
        <p>Manage all gym members</p>
    </div>
    <a href="{{ route('members.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Member
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Name, email, phone..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active"    {{ request('status')=='active'    ? 'selected' : '' }}>Active</option>
                    <option value="inactive"  {{ request('status')=='inactive'  ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ request('status')=='suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a href="{{ route('members.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">#</th>
                    <th>Member</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($members as $member)
            <tr>
                <td class="ps-4 text-muted small">{{ $member->id }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        @if($member->photo)
                            <img src="{{ asset('storage/'.$member->photo) }}" class="avatar" alt="">
                        @else
                            <div class="avatar d-flex align-items-center justify-content-center" style="background:#e63946;color:#fff">
                                {{ strtoupper(substr($member->first_name,0,1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="fw-semibold small">{{ $member->full_name }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $member->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="small">{{ $member->phone ?? '—' }}</td>
                <td class="small">{{ $member->gender ? ucfirst($member->gender) : '—' }}</td>
                <td><span class="badge badge-{{ $member->status }} rounded-pill px-3">{{ ucfirst($member->status) }}</span></td>
                <td class="text-muted small">{{ $member->created_at->format('d M Y') }}</td>
                <td class="text-end pe-4">
                    <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-outline-secondary me-1" title="View"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this member?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-5 text-muted">No members found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($members->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $members->firstItem() }}–{{ $members->lastItem() }} of {{ $members->total() }}</small>
        {{ $members->links() }}
    </div>
    @endif
</div>
@endsection
