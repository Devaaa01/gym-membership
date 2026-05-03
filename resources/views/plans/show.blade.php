@extends('layouts.app')
@section('title', $plan->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Plans</a></li>
    <li class="breadcrumb-item active">{{ $plan->name }}</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-tag-fill me-2 text-danger"></i>{{ $plan->name }}</h1>
        <p>Plan details and subscribers</p>
    </div>
    <a href="{{ route('plans.edit', $plan) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center p-4">
            <div class="text-danger fw-bold" style="font-size:2.5rem">{{ $plan->formatted_price }}</div>
            <div class="text-muted mb-3">per {{ $plan->duration_months }} month{{ $plan->duration_months > 1 ? 's' : '' }}</div>
            <span class="badge {{ $plan->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2 mb-4">
                {{ $plan->is_active ? 'Active' : 'Inactive' }}
            </span>
            <p class="text-muted small">{{ $plan->description }}</p>
            <hr>
            <ul class="list-unstyled text-start small">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>
                    {{ $plan->max_classes == 0 ? 'Unlimited classes' : $plan->max_classes . ' classes/month' }}
                </li>
                <li class="mb-2">
                    <i class="bi bi-{{ $plan->personal_trainer ? 'check-circle-fill text-success' : 'x-circle-fill text-muted' }} me-2"></i>
                    Personal Trainer
                </li>
            </ul>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-people me-2 text-danger"></i>Subscribers ({{ $plan->memberships->count() }})</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th class="ps-3">Member</th><th>Start</th><th>End</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($plan->memberships as $ms)
                    <tr>
                        <td class="ps-3 fw-semibold small">{{ $ms->member->full_name }}</td>
                        <td class="small">{{ $ms->start_date->format('d M Y') }}</td>
                        <td class="small">{{ $ms->end_date->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $ms->status }} rounded-pill">{{ ucfirst($ms->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted small">No subscribers yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
