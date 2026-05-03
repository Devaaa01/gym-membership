@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-speedometer2 me-2 text-danger"></i>Dashboard</h1>
    <p>Welcome back! Here's what's happening at FitLife Gym today.</p>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#667eea,#764ba2)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-value text-white">{{ $totalMembers }}</div>
                    <div class="stat-label text-white opacity-75">Total Members</div>
                </div>
                <div class="stat-icon" style="background:rgba(255,255,255,.2)">
                    <i class="bi bi-people-fill text-white"></i>
                </div>
            </div>
            <div class="mt-3 text-white opacity-75 small">
                <i class="bi bi-check-circle me-1"></i>{{ $activeMembers }} active
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#f093fb,#f5576c)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-value text-white">{{ $activeMemberships }}</div>
                    <div class="stat-label text-white opacity-75">Active Memberships</div>
                </div>
                <div class="stat-icon" style="background:rgba(255,255,255,.2)">
                    <i class="bi bi-card-checklist text-white"></i>
                </div>
            </div>
            <div class="mt-3 text-white opacity-75 small">
                <i class="bi bi-clock me-1"></i>{{ $expiringThisMonth }} expiring this month
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#4facfe,#00f2fe)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-value text-white">Rp {{ number_format($monthlyRevenue/1000,0) }}K</div>
                    <div class="stat-label text-white opacity-75">Monthly Revenue</div>
                </div>
                <div class="stat-icon" style="background:rgba(255,255,255,.2)">
                    <i class="bi bi-graph-up-arrow text-white"></i>
                </div>
            </div>
            <div class="mt-3 text-white opacity-75 small">
                <i class="bi bi-calendar me-1"></i>{{ now()->format('F Y') }}
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card card h-100" style="background:linear-gradient(135deg,#43e97b,#38f9d7)">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="stat-value text-white">Rp {{ number_format($totalRevenue/1000000,1) }}M</div>
                    <div class="stat-label text-white opacity-75">Total Revenue</div>
                </div>
                <div class="stat-icon" style="background:rgba(255,255,255,.2)">
                    <i class="bi bi-currency-dollar text-white"></i>
                </div>
            </div>
            <div class="mt-3 text-white opacity-75 small">
                <i class="bi bi-bar-chart me-1"></i>All time
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Revenue Chart -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-bar-chart-fill me-2 text-danger"></i>Revenue (Last 6 Months)</h6>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Upcoming Classes -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-calendar3 me-2 text-danger"></i>Upcoming Classes</h6>
                <a href="{{ route('classes.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingClasses as $class)
                <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="text-center" style="min-width:45px">
                        <div class="fw-bold text-danger" style="font-size:.9rem">{{ $class->schedule->format('d') }}</div>
                        <div class="text-muted" style="font-size:.7rem">{{ $class->schedule->format('M') }}</div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $class->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">
                            <i class="bi bi-person me-1"></i>{{ $class->trainer->full_name }}
                            &nbsp;·&nbsp;
                            <i class="bi bi-clock me-1"></i>{{ $class->schedule->format('H:i') }}
                        </div>
                    </div>
                    <span class="badge badge-scheduled rounded-pill">{{ $class->bookings->count() }}/{{ $class->max_capacity }}</span>
                </div>
                @empty
                <div class="p-4 text-center text-muted small">No upcoming classes</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Members -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-plus-fill me-2 text-danger"></i>Recent Members</h6>
                <a href="{{ route('members.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr>
                        <th class="ps-3">Member</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr></thead>
                    <tbody>
                    @foreach($recentMembers as $member)
                    <tr>
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar" style="background:#e63946;color:#fff;min-width:36px">
                                    {{ strtoupper(substr($member->first_name,0,1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $member->full_name }}</div>
                                    <div class="text-muted" style="font-size:.75rem">{{ $member->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-{{ $member->status }} rounded-pill">{{ ucfirst($member->status) }}</span></td>
                        <td class="text-muted small">{{ $member->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-credit-card-fill me-2 text-danger"></i>Recent Payments</h6>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr>
                        <th class="ps-3">Member</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr></thead>
                    <tbody>
                    @foreach($recentPayments as $payment)
                    <tr>
                        <td class="ps-3">
                            <div class="fw-semibold small">{{ $payment->member->full_name }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $payment->membership->plan->name ?? '—' }}</div>
                        </td>
                        <td class="fw-semibold small text-success">{{ $payment->formatted_amount }}</td>
                        <td><span class="badge badge-{{ $payment->status }} rounded-pill">{{ ucfirst($payment->status) }}</span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($revenueChart, 'month')) !!},
        datasets: [{
            label: 'Revenue (Rp)',
            data: {!! json_encode(array_column($revenueChart, 'revenue')) !!},
            backgroundColor: 'rgba(230,57,70,.8)',
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K'
                },
                grid: { color: '#f0f2f5' }
            },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
