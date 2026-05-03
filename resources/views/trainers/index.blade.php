@extends('layouts.app')
@section('title', 'Trainers')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Trainers</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-person-badge-fill me-2 text-danger"></i>Trainers</h1>
        <p>Manage gym trainers and instructors</p>
    </div>
    <a href="{{ route('trainers.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Trainer</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Name or specialization..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="active"   {{ request('status')=='active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a href="{{ route('trainers.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
@forelse($trainers as $trainer)
<div class="col-md-6 col-xl-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                @if($trainer->photo)
                    <img src="{{ asset('storage/'.$trainer->photo) }}" class="rounded-circle" style="width:56px;height:56px;object-fit:cover" alt="">
                @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                         style="width:56px;height:56px;background:#e63946;color:#fff;font-size:1.3rem;min-width:56px">
                        {{ strtoupper(substr($trainer->first_name,0,1)) }}
                    </div>
                @endif
                <div>
                    <div class="fw-bold">{{ $trainer->full_name }}</div>
                    <div class="text-muted small">{{ $trainer->specialization }}</div>
                </div>
                <span class="badge ms-auto {{ $trainer->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                    {{ $trainer->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            @if($trainer->bio)
            <p class="text-muted small mb-3" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $trainer->bio }}</p>
            @endif
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i>{{ $trainer->classes_count }} classes</span>
                <div class="d-flex gap-1">
                    <a href="{{ route('trainers.show', $trainer) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('trainers.edit', $trainer) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('trainers.destroy', $trainer) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this trainer?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="card text-center py-5 text-muted">No trainers found.</div>
</div>
@endforelse
</div>

@if($trainers->hasPages())
<div class="mt-4 d-flex justify-content-center">{{ $trainers->links() }}</div>
@endif
@endsection
