<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Portal') — FitLife Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e63946;
            --primary-dark: #c1121f;
            --nav-bg: #1a1a2e;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; }

        /* ── Top navbar ── */
        .member-navbar {
            background: var(--nav-bg);
            padding: .75rem 0;
            position: sticky; top: 0; z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,.3);
        }
        .member-navbar .navbar-brand {
            font-weight: 800; color: #fff; font-size: 1.1rem;
        }
        .member-navbar .brand-icon {
            width: 34px; height: 34px; background: var(--primary);
            border-radius: 8px; display: inline-flex;
            align-items: center; justify-content: center;
            font-size: .9rem; color: #fff; margin-right: .5rem;
        }
        .member-navbar .nav-link {
            color: rgba(255,255,255,.65) !important;
            font-size: .875rem; font-weight: 500;
            padding: .4rem .85rem !important;
            border-radius: 8px;
            transition: all .2s;
        }
        .member-navbar .nav-link:hover,
        .member-navbar .nav-link.active {
            color: #fff !important;
            background: rgba(255,255,255,.1);
        }
        .member-navbar .nav-link.active {
            background: var(--primary) !important;
        }
        .member-navbar .nav-link i { margin-right: .35rem; }

        /* ── Cards ── */
        .card { border: none; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .card-header { background: transparent; border-bottom: 1px solid #f0f2f5; padding: 1.25rem 1.5rem; }

        /* ── Stat cards ── */
        .stat-card { border-radius: 16px; padding: 1.5rem; border: none; transition: transform .2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }

        /* ── Badges ── */
        .badge-active    { background: #d1fae5; color: #065f46; }
        .badge-inactive  { background: #fee2e2; color: #991b1b; }
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-expired   { background: #e5e7eb; color: #374151; }
        .badge-cancelled { background: #fce7f3; color: #9d174d; }
        .badge-paid      { background: #d1fae5; color: #065f46; }
        .badge-booked    { background: #dbeafe; color: #1e40af; }
        .badge-attended  { background: #d1fae5; color: #065f46; }
        .badge-no_show   { background: #fee2e2; color: #991b1b; }
        .badge-scheduled { background: #dbeafe; color: #1e40af; }

        /* ── Buttons ── */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); color: #fff; }

        /* ── Table ── */
        .table th { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #718096; }
        .table td { vertical-align: middle; font-size: .875rem; }

        /* ── Form ── */
        .form-label { font-weight: 500; font-size: .875rem; color: #374151; }
        .form-control, .form-select { border-radius: 8px; border-color: #e2e8f0; font-size: .875rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(230,57,70,.15); }

        /* ── Class card ── */
        .class-card { transition: transform .2s, box-shadow .2s; cursor: default; }
        .class-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,.12) !important; }
        .class-category-badge { font-size: .7rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; }

        /* ── Page header ── */
        .page-header { margin-bottom: 1.5rem; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: #1a202c; }
        .page-header p  { color: #718096; font-size: .875rem; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Navbar -->
<nav class="member-navbar navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('member.dashboard') }}">
            <span class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></span>
            FitLife Gym
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#memberNav">
            <i class="bi bi-list text-white fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="memberNav">
            <ul class="navbar-nav me-auto gap-1 mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}"
                       href="{{ route('member.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('member.memberships') ? 'active' : '' }}"
                       href="{{ route('member.memberships') }}">
                        <i class="bi bi-card-checklist"></i>My Membership
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('member.classes') ? 'active' : '' }}"
                       href="{{ route('member.classes') }}">
                        <i class="bi bi-calendar3"></i>Classes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('member.payments') ? 'active' : '' }}"
                       href="{{ route('member.payments') }}">
                        <i class="bi bi-credit-card"></i>Payments
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav gap-1 mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                       href="#" data-bs-toggle="dropdown">
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                             style="width:28px;height:28px;background:#e63946;color:#fff;font-size:.75rem;min-width:28px">
                            {{ strtoupper(substr(Auth::guard('member')->user()->first_name, 0, 1)) }}
                        </div>
                        <span class="d-none d-lg-inline">{{ Auth::guard('member')->user()->first_name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-semibold small">{{ Auth::guard('member')->user()->full_name }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ Auth::guard('member')->user()->email }}</div>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('member.profile') }}">
                                <i class="bi bi-person me-2"></i>My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('member.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<footer class="text-center py-4 text-muted small mt-4" style="border-top:1px solid #e2e8f0">
    © {{ date('Y') }} FitLife Gym. All rights reserved.
    &nbsp;·&nbsp;
    <a href="{{ route('login') }}" class="text-muted">Admin Panel</a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
