@extends('layouts.member')
@section('title', 'My Membership')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-card-checklist me-2 text-danger"></i>My Membership</h1>
    <p>Your current and past membership plans</p>
</div>

<!-- Active membership banner -->
@if($member->activeMembership)
@php $active = $member->activeMembership; $daysLeft = now()->diffInDays($active->end_date, false); @endphp
<div class="card mb-4" style="background:linear-gradient(135deg,#e63946,#c1121f);border:none">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="text-white opacity-75 small fw-semibold mb-1">ACTIVE PLAN</div>
                <h3 class="text-white fw-bold mb-1">{{ $active->plan->name }}</h3>
                <div class="text-white opacity-75 small">
                    <i class="bi bi-calendar me-1"></i>
                    {{ $active->start_date->format('d M Y') }} — {{ $active->end_date->format('d M Y') }}
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="text-white fw-bold" style="font-size:2rem">{{ max(0, $daysLeft) }}</div>
                <div class="text-white opacity-75 small">days remaining</div>
                @if($daysLeft <= 7 && $daysLeft >= 0)
                <span class="badge bg-warning text-dark mt-1">Expiring soon!</span>
                @endif
            </div>
        </div>
        <div class="mt-3 pt-3" style="border-top:1px solid rgba(255,255,255,.2)">
            <div class="row g-3">
                <div class="col-4 text-center">
                    <div class="text-white fw-bold">{{ $active->plan->formatted_price }}</div>
                    <div class="text-white opacity-60 small">Plan Price</div>
                </div>
                <div class="col-4 text-center">
                    <div class="text-white fw-bold">
                        {{ $active->plan->max_classes == 0 ? '∞' : $active->plan->max_classes }}
                    </div>
                    <div class="text-white opacity-60 small">Classes/Month</div>
                </div>
                <div class="col-4 text-center">
                    <div class="text-white fw-bold">
                        {{ $active->plan->personal_trainer ? 'Yes' : 'No' }}
                    </div>
                    <div class="text-white opacity-60 small">Personal Trainer</div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning rounded-3 border-0 mb-4">
    <i class="bi bi-exclamation-triangle me-2"></i>
    You don't have an active membership. Choose a plan below or contact the gym.
</div>
@endif

<!-- Available plans -->
<h5 class="fw-bold mb-3">Available Plans</h5>
<div class="row g-4 mb-5">
    @foreach($plans as $plan)
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 {{ $member->activeMembership?->plan_id == $plan->id ? 'border-danger' : '' }}"
             style="{{ $member->activeMembership?->plan_id == $plan->id ? 'border:2px solid #e63946' : '' }}">
            <div class="card-body p-4">
                @if($member->activeMembership?->plan_id == $plan->id)
                <span class="badge bg-danger rounded-pill mb-2">Current Plan</span>
                @endif
                <h5 class="fw-bold mb-1">{{ $plan->name }}</h5>
                <div class="text-danger fw-bold fs-4 mb-1">{{ $plan->formatted_price }}</div>
                <div class="text-muted small mb-3">/ {{ $plan->duration_months }} month{{ $plan->duration_months > 1 ? 's' : '' }}</div>
                <p class="text-muted small mb-3">{{ $plan->description }}</p>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-1"><i class="bi bi-check-circle-fill text-success me-2"></i>
                        {{ $plan->max_classes == 0 ? 'Unlimited classes' : $plan->max_classes . ' classes/month' }}
                    </li>
                    <li>
                        <i class="bi bi-{{ $plan->personal_trainer ? 'check-circle-fill text-success' : 'x-circle-fill text-muted' }} me-2"></i>
                        Personal Trainer
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Membership history -->
<h5 class="fw-bold mb-3">Membership History</h5>
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th class="ps-4">Plan</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
            </tr></thead>
            <tbody>
            @forelse($memberships as $ms)
            <tr>
                <td class="ps-4 fw-semibold small">{{ $ms->plan->name }}</td>
                <td class="small">{{ $ms->start_date->format('d M Y') }}</td>
                <td class="small {{ $ms->end_date->isPast() && $ms->status !== 'active' ? 'text-muted' : '' }}">
                    {{ $ms->end_date->format('d M Y') }}
                </td>
                <td><span class="badge badge-{{ $ms->status }} rounded-pill">{{ ucfirst($ms->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-4 text-muted small">No membership history.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
