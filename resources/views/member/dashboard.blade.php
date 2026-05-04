@extends('layouts.member')
@section('title', 'My Dashboard')

@section('content')
<div class="page-header">
    <h1>👋 Welcome, {{ $member->first_name }}!</h1>
    <p>Here's a summary of your gym activity.</p>
</div>

<!-- Stat cards -->
<div class="row g-4 mb-4">
    <!-- Membership status -->
    <div class="col-sm-6 col-xl-3">
        @if($member->activeMembership)
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#e05c8a,#d4527f)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold text-white" style="font-size:1.1rem">{{ $member->activeMembership->plan->name }}</div>
                    <div class="text-white opacity-75 small">Active Membership</div>
                </div>
                <div class="stat-icon" style="background:rgba(255,255,255,.2)">
                    <i class="bi bi-card-checklist text-white"></i>
                </div>
            </div>
            <div class="mt-3 text-white opacity-75 small">
                <i class="bi bi-calendar me-1"></i>Expires {{ $member->activeMembership->end_date->format('d M Y') }}
            </div>
        </div>
        @else
        <div class="stat-card card h-100 border-2" style="border:2px dashed #e2e8f0 !important;background:#fff">
            <div class="text-center py-2">
                <i class="bi bi-card-checklist text-muted fs-3 mb-2 d-block"></i>
                <div class="small text-muted">No active membership</div>
                <a href="{{ route('member.memberships') }}" class="btn btn-sm btn-primary mt-2">Get a Plan</a>
            </div>
        </div>
        @endif
    </div>

    <!-- Upcoming bookings -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#3a9bd5,#3090cc)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold text-white" style="font-size:1.8rem">{{ $upcomingBookings->count() }}</div>
                    <div class="text-white opacity-75 small">Upcoming Classes</div>
                </div>
                <div class="stat-icon" style="background:rgba(255,255,255,.2)">
                    <i class="bi bi-bookmark-check text-white"></i>
                </div>
            </div>
            <div class="mt-3 text-white opacity-75 small">
                <i class="bi bi-calendar3 me-1"></i>Booked & confirmed
            </div>
        </div>
    </div>

    <!-- Total classes attended -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#2eaa72,#27996a)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold text-white" style="font-size:1.8rem">
                        {{ $member->classBookings->where('status','attended')->count() }}
                    </div>
                    <div class="text-white opacity-75 small">Classes Attended</div>
                </div>
                <div class="stat-icon" style="background:rgba(255,255,255,.2)">
                    <i class="bi bi-trophy text-white"></i>
                </div>
            </div>
            <div class="mt-3 text-white opacity-75 small">
                <i class="bi bi-check-circle me-1"></i>All time
            </div>
        </div>
    </div>

    <!-- Total paid -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#4f6ef7,#6a85f5)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold text-white" style="font-size:1.1rem">
                        Rp {{ number_format($member->payments->where('status','paid')->sum('amount')/1000,0) }}K
                    </div>
                    <div class="text-white opacity-75 small">Total Paid</div>
                </div>
                <div class="stat-icon" style="background:rgba(255,255,255,.2)">
                    <i class="bi bi-credit-card text-white"></i>
                </div>
            </div>
            <div class="mt-3 text-white opacity-75 small">
                <i class="bi bi-receipt me-1"></i>{{ $member->payments->where('status','paid')->count() }} payments
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Upcoming bookings list -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-bookmark-check-fill me-2 text-danger"></i>My Upcoming Classes</h6>
                <a href="{{ route('member.classes') }}" class="btn btn-sm btn-outline-primary">Browse All</a>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingBookings as $booking)
                <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="text-center rounded-3 p-2" style="background:rgba(230,57,70,.08);min-width:50px">
                        <div class="fw-bold text-danger" style="font-size:.9rem">{{ $booking->gymClass->schedule->format('d') }}</div>
                        <div class="text-muted" style="font-size:.65rem">{{ $booking->gymClass->schedule->format('M') }}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $booking->gymClass->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">
                            <i class="bi bi-person me-1"></i>{{ $booking->gymClass->trainer->full_name }}
                            &nbsp;·&nbsp;
                            <i class="bi bi-clock me-1"></i>{{ $booking->gymClass->schedule->format('H:i') }}
                        </div>
                    </div>
                    <form method="POST" action="{{ route('member.bookings.cancel', $booking) }}"
                          onsubmit="return confirm('Cancel this booking?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Cancel">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                </div>
                @empty
                <div class="p-4 text-center text-muted small">
                    No upcoming classes booked.
                    <a href="{{ route('member.classes') }}" class="d-block mt-2 text-danger fw-semibold">Browse classes →</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Available classes -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-calendar3 me-2 text-danger"></i>Available Classes</h6>
                <a href="{{ route('member.classes') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @foreach($availableClasses as $class)
                @php $spots = $class->max_capacity - $class->bookings()->whereIn('status',['booked','attended'])->count(); @endphp
                <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="text-center rounded-3 p-2" style="background:var(--input-bg);min-width:50px">
                        <div class="fw-bold" style="font-size:.9rem">{{ $class->schedule->format('d') }}</div>
                        <div class="text-muted" style="font-size:.65rem">{{ $class->schedule->format('M') }}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $class->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">
                            {{ $class->category }} · {{ $class->schedule->format('H:i') }}
                            · <span class="{{ $spots <= 3 ? 'text-danger' : 'text-success' }}">{{ $spots }} spots left</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('member.classes.book', $class) }}">
                        @csrf
                        <button class="btn btn-sm btn-primary" {{ ($spots <= 0 || !$hasActiveMembership) ? 'disabled' : '' }}>
                            {{ $spots <= 0 ? 'Full' : ($hasActiveMembership ? 'Book' : 'No Plan') }}
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
