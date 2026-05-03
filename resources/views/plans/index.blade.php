@extends('layouts.app')
@section('title', 'Membership Plans')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Plans</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-tags-fill me-2 text-danger"></i>Membership Plans</h1>
        <p>Manage gym membership packages</p>
    </div>
    <a href="{{ route('plans.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Plan
    </a>
</div>

<div class="row g-4">
@forelse($plans as $plan)
<div class="col-md-6 col-xl-3">
    <div class="card h-100 {{ !$plan->is_active ? 'opacity-75' : '' }}">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                    {{ $plan->is_active ? 'Active' : 'Inactive' }}
                </span>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('plans.show', $plan) }}"><i class="bi bi-eye me-2"></i>View</a></li>
                        <li><a class="dropdown-item" href="{{ route('plans.edit', $plan) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Delete this plan?')">
                                @csrf @method('DELETE')
                                <button class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Delete</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <h5 class="fw-bold mb-1">{{ $plan->name }}</h5>
            <div class="text-danger fw-bold fs-4 mb-1">{{ $plan->formatted_price }}</div>
            <div class="text-muted small mb-3">per {{ $plan->duration_months }} month{{ $plan->duration_months > 1 ? 's' : '' }}</div>
            <p class="text-muted small mb-3">{{ $plan->description }}</p>
            <ul class="list-unstyled small mb-3">
                <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>
                    {{ $plan->max_classes == 0 ? 'Unlimited classes' : $plan->max_classes . ' classes/month' }}
                </li>
                <li class="mb-1">
                    <i class="bi bi-{{ $plan->personal_trainer ? 'check-circle-fill text-success' : 'x-circle-fill text-muted' }} me-2"></i>
                    Personal Trainer
                </li>
            </ul>
            <div class="text-muted small">
                <i class="bi bi-people me-1"></i>{{ $plan->memberships_count }} memberships
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="card text-center py-5">
        <div class="text-muted">No plans found. <a href="{{ route('plans.create') }}">Create one</a>.</div>
    </div>
</div>
@endforelse
</div>
@endsection
