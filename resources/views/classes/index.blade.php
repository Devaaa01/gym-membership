@extends('layouts.app')
@section('title', 'Classes')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Classes</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-calendar3 me-2 text-danger"></i>Classes</h1>
        <p>Schedule and manage gym classes</p>
    </div>
    <a href="{{ route('classes.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Schedule Class</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Class name..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category')==$cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    @foreach(['scheduled','completed','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status')==$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th class="ps-4">Class</th>
                <th>Trainer</th>
                <th>Schedule</th>
                <th>Duration</th>
                <th>Capacity</th>
                <th>Status</th>
                <th class="text-end pe-4">Actions</th>
            </tr></thead>
            <tbody>
            @forelse($classes as $class)
            <tr>
                <td class="ps-4">
                    <div class="fw-semibold small">{{ $class->name }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $class->category }} · {{ $class->room }}</div>
                </td>
                <td class="small">{{ $class->trainer->full_name }}</td>
                <td class="small">{{ $class->schedule->format('d M Y') }}<br><span class="text-muted">{{ $class->schedule->format('H:i') }}</span></td>
                <td class="small">{{ $class->duration_minutes }} min</td>
                <td>
                    @php $booked = $class->bookings->count(); @endphp
                    <div class="d-flex align-items-center gap-2">
                        <div class="progress flex-grow-1" style="height:6px;width:60px">
                            <div class="progress-bar {{ $booked >= $class->max_capacity ? 'bg-danger' : 'bg-success' }}"
                                 style="width:{{ $class->max_capacity > 0 ? min(100, $booked/$class->max_capacity*100) : 0 }}%"></div>
                        </div>
                        <span class="small text-muted">{{ $booked }}/{{ $class->max_capacity }}</span>
                    </div>
                </td>
                <td><span class="badge badge-{{ $class->status }} rounded-pill px-3">{{ ucfirst($class->status) }}</span></td>
                <td class="text-end pe-4">
                    <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this class?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-5 text-muted">No classes found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($classes->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $classes->firstItem() }}–{{ $classes->lastItem() }} of {{ $classes->total() }}</small>
        {{ $classes->links() }}
    </div>
    @endif
</div>
@endsection
