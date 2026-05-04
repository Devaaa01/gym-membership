@extends('layouts.member')
@section('title', 'Browse Classes')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-calendar3 me-2 text-danger"></i>Browse Classes</h1>
        <p>Find and book upcoming gym classes</p>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Filter by Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category')==$cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a href="{{ route('member.classes') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<!-- Class grid -->
@if(!$hasActiveMembership)
<div class="alert alert-warning rounded-3 border-0 shadow-sm mb-4">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    You don't have an active membership. <a href="{{ route('member.payment.form') }}" class="alert-link">Subscribe to a plan</a> to book classes.
</div>
@endif

<div class="row g-4">
@forelse($classes as $class)
@php
    $booked = $class->bookings()->whereIn('status',['booked','attended'])->count();
    $spots   = $class->max_capacity - $booked;
    $isBooked = in_array($class->id, $bookedIds);
@endphp
<div class="col-md-6 col-xl-4">
    <div class="card class-card h-100">
        <div class="card-body p-4">
            <!-- Category + status -->
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge class-category-badge rounded-pill px-3 py-2"
                      style="background:#fff5f5;color:#e63946">{{ $class->category }}</span>
                @if($isBooked)
                    <span class="badge bg-success rounded-pill"><i class="bi bi-check me-1"></i>Booked</span>
                @elseif($spots <= 0)
                    <span class="badge bg-secondary rounded-pill">Full</span>
                @elseif($spots <= 3)
                    <span class="badge bg-warning text-dark rounded-pill">{{ $spots }} left</span>
                @else
                    <span class="badge bg-light text-muted rounded-pill">{{ $spots }} spots</span>
                @endif
            </div>

            <h6 class="fw-bold mb-1">{{ $class->name }}</h6>
            @if($class->description)
            <p class="text-muted small mb-3" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                {{ $class->description }}
            </p>
            @endif

            <div class="d-flex flex-column gap-1 mb-3">
                <div class="small text-muted">
                    <i class="bi bi-person me-2 text-danger"></i>{{ $class->trainer->full_name }}
                </div>
                <div class="small text-muted">
                    <i class="bi bi-calendar me-2 text-danger"></i>{{ $class->schedule->format('D, d M Y') }}
                </div>
                <div class="small text-muted">
                    <i class="bi bi-clock me-2 text-danger"></i>{{ $class->schedule->format('H:i') }}
                    ({{ $class->duration_minutes }} min)
                </div>
                @if($class->room)
                <div class="small text-muted">
                    <i class="bi bi-geo-alt me-2 text-danger"></i>{{ $class->room }}
                </div>
                @endif
            </div>

            <!-- Capacity bar -->
            <div class="mb-3">
                <div class="d-flex justify-content-between small text-muted mb-1">
                    <span>Capacity</span>
                    <span>{{ $booked }}/{{ $class->max_capacity }}</span>
                </div>
                <div class="progress" style="height:6px;border-radius:10px">
                    <div class="progress-bar {{ $spots <= 0 ? 'bg-danger' : ($spots <= 3 ? 'bg-warning' : 'bg-success') }}"
                         style="width:{{ $class->max_capacity > 0 ? min(100, $booked/$class->max_capacity*100) : 0 }}%;border-radius:10px"></div>
                </div>
            </div>

            @if($isBooked)
                <button class="btn btn-outline-success w-100" disabled>
                    <i class="bi bi-check-circle me-1"></i>Already Booked
                </button>
            @elseif($spots <= 0)
                <button class="btn btn-outline-secondary w-100" disabled>Class Full</button>
            @elseif(!$hasActiveMembership)
                <a href="{{ route('member.payment.form') }}" class="btn btn-outline-warning w-100">
                    <i class="bi bi-lock me-1"></i>Active Membership Required
                </a>
            @else
                <form method="POST" action="{{ route('member.classes.book', $class) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-bookmark-plus me-1"></i>Book This Class
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="card text-center py-5">
        <div class="text-muted">
            <i class="bi bi-calendar-x fs-1 d-block mb-3 text-muted opacity-50"></i>
            No upcoming classes available.
        </div>
    </div>
</div>
@endforelse
</div>

@if($classes->hasPages())
<div class="mt-4 d-flex justify-content-center">{{ $classes->links() }}</div>
@endif
@endsection
