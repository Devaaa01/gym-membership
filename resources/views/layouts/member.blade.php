<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Portal') — FitLife Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ══════════════════════════════════════════
           THEME VARIABLES
        ══════════════════════════════════════════ */
        :root {
            --primary:        #e63946;
            --primary-dark:   #c1121f;
            --nav-bg:         #1a1a2e;

            --body-bg:        #f0f2f5;
            --card-bg:        #ffffff;
            --card-border:    #f0f2f5;
            --card-shadow:    rgba(0,0,0,.08);
            --text-primary:   #1a202c;
            --text-secondary: #718096;
            --text-label:     #374151;
            --input-bg:       #ffffff;
            --input-border:   #e2e8f0;
            --table-th:       #718096;
            --table-hover:    #f8fafc;
            --dropdown-bg:    #ffffff;
            --footer-border:  #e2e8f0;
            --toggle-bg:      rgba(255,255,255,.1);
            --toggle-border:  rgba(255,255,255,.15);
            --toggle-color:   rgba(255,255,255,.65);
        }

        [data-theme="dark"] {
            --body-bg:        #0f1117;
            --card-bg:        #1a1d27;
            --card-border:    #252836;
            --card-shadow:    rgba(0,0,0,.3);
            --text-primary:   #e8eaf0;
            --text-secondary: #8892a4;
            --text-label:     #9aa5b4;
            --input-bg:       #252836;
            --input-border:   #333650;
            --table-th:       #6b7a99;
            --table-hover:    #252836;
            --dropdown-bg:    #1a1d27;
            --footer-border:  #252836;
            --toggle-bg:      rgba(255,255,255,.08);
            --toggle-border:  rgba(255,255,255,.12);
            --toggle-color:   rgba(255,255,255,.5);
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background: var(--body-bg);
            color: var(--text-primary);
            transition: background .25s, color .25s;
        }

        /* ── Navbar (always dark) ── */
        .member-navbar {
            background: var(--nav-bg);
            padding: .75rem 0;
            position: sticky; top: 0; z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,.3);
        }
        .member-navbar .navbar-brand { font-weight: 800; color: #fff; font-size: 1.1rem; }
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
            border-radius: 8px; transition: all .2s;
        }
        .member-navbar .nav-link:hover,
        .member-navbar .nav-link.active { color: #fff !important; background: rgba(255,255,255,.1); }
        .member-navbar .nav-link.active { background: var(--primary) !important; }
        .member-navbar .nav-link i { margin-right: .35rem; }

        /* ── Theme toggle in navbar ── */
        .theme-toggle {
            width: 32px; height: 32px;
            background: var(--toggle-bg);
            border: 1.5px solid var(--toggle-border);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--toggle-color); font-size: .9rem;
            transition: background .25s, color .25s, transform .2s;
            flex-shrink: 0;
        }
        .theme-toggle:hover { transform: rotate(20deg); color: #fff; }

        /* ── Cards ── */
        .card {
            border: none; border-radius: 16px;
            background: var(--card-bg);
            box-shadow: 0 1px 3px var(--card-shadow);
            transition: background .25s;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--card-border);
            padding: 1.25rem 1.5rem;
            color: var(--text-primary);
        }
        .card-body  { color: var(--text-primary); }
        .card-footer { background: transparent; border-top: 1px solid var(--card-border); }

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

        [data-theme="dark"] .badge-active    { background: rgba(16,185,129,.2); color: #6ee7b7; }
        [data-theme="dark"] .badge-inactive  { background: rgba(239,68,68,.2);  color: #fca5a5; }
        [data-theme="dark"] .badge-pending   { background: rgba(245,158,11,.2); color: #fcd34d; }
        [data-theme="dark"] .badge-expired   { background: rgba(107,114,128,.2);color: #d1d5db; }
        [data-theme="dark"] .badge-cancelled { background: rgba(236,72,153,.2); color: #f9a8d4; }
        [data-theme="dark"] .badge-paid      { background: rgba(16,185,129,.2); color: #6ee7b7; }
        [data-theme="dark"] .badge-booked    { background: rgba(59,130,246,.2); color: #93c5fd; }
        [data-theme="dark"] .badge-attended  { background: rgba(16,185,129,.2); color: #6ee7b7; }
        [data-theme="dark"] .badge-no_show   { background: rgba(239,68,68,.2);  color: #fca5a5; }
        [data-theme="dark"] .badge-scheduled { background: rgba(59,130,246,.2); color: #93c5fd; }

        /* ── Buttons ── */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
        .btn-outline-secondary {
            color: var(--text-secondary); border-color: var(--input-border);
        }
        .btn-outline-secondary:hover {
            background: var(--input-border); color: var(--text-primary);
        }

        /* ── Table ── */
        .table {
            --bs-table-bg: transparent;
            --bs-table-hover-bg: var(--table-hover);
            --bs-table-color: var(--text-primary);
            --bs-table-striped-color: var(--text-primary);
            --bs-table-active-color: var(--text-primary);
            color: var(--text-primary);
        }
        .table th {
            font-size: .75rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: .05em; color: var(--table-th);
        }
        .table td { vertical-align: middle; font-size: .875rem; border-color: var(--card-border); color: var(--text-primary); }
        .table tbody tr { color: var(--text-primary); }
        .table thead th { border-color: var(--card-border); }

        /* ── Form ── */
        .form-label { font-weight: 500; font-size: .875rem; color: var(--text-label); }
        .form-control, .form-select {
            border-radius: 8px; border-color: var(--input-border);
            font-size: .875rem; background: var(--input-bg); color: var(--text-primary);
            transition: background .25s, border-color .2s, color .25s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(230,57,70,.15);
            background: var(--input-bg); color: var(--text-primary);
        }
        .form-control::placeholder { color: var(--text-secondary); opacity: .6; }

        /* ── Dropdown ── */
        .dropdown-menu {
            background: var(--dropdown-bg);
            border-color: var(--card-border);
        }
        .dropdown-item { color: var(--text-primary); }
        .dropdown-item:hover { background: var(--table-hover); color: var(--text-primary); }
        .dropdown-divider { border-color: var(--card-border); }

        /* ── Class card ── */
        .class-card { transition: transform .2s, box-shadow .2s; cursor: default; }
        .class-card:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(0,0,0,.15) !important; }
        .class-category-badge { font-size: .7rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; }

        /* ── Page header ── */
        .page-header { margin-bottom: 1.5rem; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-primary); }
        .page-header p  { color: var(--text-secondary); font-size: .875rem; }

        /* ── Text helpers ── */
        .text-muted { color: var(--text-secondary) !important; }

        /* ── Dark mode overrides for Bootstrap & hardcoded colors ── */
        [data-theme="dark"] .text-dark,
        [data-theme="dark"] .text-body { color: var(--text-primary) !important; }

        /* Input group text */
        [data-theme="dark"] .input-group-text {
            background: var(--input-bg);
            border-color: var(--input-border);
            color: var(--text-secondary);
        }

        /* Alerts */
        [data-theme="dark"] .alert-success {
            background: rgba(6,95,70,.2);
            border-color: rgba(6,95,70,.3);
            color: #6ee7b7;
        }
        [data-theme="dark"] .alert-danger {
            background: rgba(153,27,27,.2);
            border-color: rgba(153,27,27,.3);
            color: #fca5a5;
        }
        [data-theme="dark"] .alert-warning {
            background: rgba(146,64,14,.2);
            border-color: rgba(146,64,14,.3);
            color: #fcd34d;
        }
        [data-theme="dark"] .alert-warning .alert-link { color: #fbbf24; }

        /* Progress bar track */
        [data-theme="dark"] .progress { background: var(--input-border); }

        /* Pagination */
        [data-theme="dark"] .page-link {
            background: var(--card-bg);
            border-color: var(--card-border);
            color: var(--text-primary);
        }
        [data-theme="dark"] .page-link:hover {
            background: var(--table-hover);
            color: var(--text-primary);
        }
        [data-theme="dark"] .page-item.disabled .page-link {
            background: var(--card-bg);
            border-color: var(--card-border);
            color: var(--text-secondary);
        }
        [data-theme="dark"] .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Receipt / info boxes with hardcoded bg */
        [data-theme="dark"] [style*="background:#f8fafc"],
        [data-theme="dark"] [style*="background: #f8fafc"],
        [data-theme="dark"] [style*="background:#f7f8fc"],
        [data-theme="dark"] [style*="background: #f7f8fc"],
        [data-theme="dark"] [style*="background:#f0f2f5"],
        [data-theme="dark"] [style*="background: #f0f2f5"],
        [data-theme="dark"] [style*="background:#fff5f5"],
        [data-theme="dark"] [style*="background: #fff5f5"] {
            background: var(--input-bg) !important;
            border-color: var(--input-border) !important;
            color: var(--text-primary) !important;
        }

        /* White inline backgrounds */
        [data-theme="dark"] [style*="background:#fff"],
        [data-theme="dark"] [style*="background: #fff"],
        [data-theme="dark"] [style*="background:white"],
        [data-theme="dark"] [style*="background: white"] {
            background: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }

        /* Hardcoded dark text in inline styles */
        [data-theme="dark"] [style*="color:#1a202c"],
        [data-theme="dark"] [style*="color: #1a202c"],
        [data-theme="dark"] [style*="color:#2d3748"],
        [data-theme="dark"] [style*="color: #2d3748"],
        [data-theme="dark"] [style*="color:#374151"],
        [data-theme="dark"] [style*="color: #374151"],
        [data-theme="dark"] [style*="color:#4a5568"],
        [data-theme="dark"] [style*="color: #4a5568"] {
            color: var(--text-primary) !important;
        }

        [data-theme="dark"] [style*="color:#718096"],
        [data-theme="dark"] [style*="color: #718096"],
        [data-theme="dark"] [style*="color:#a0aec0"],
        [data-theme="dark"] [style*="color: #a0aec0"] {
            color: var(--text-secondary) !important;
        }

        /* Hardcoded border colors */
        [data-theme="dark"] [style*="border-top:1px solid #e2e8f0"],
        [data-theme="dark"] [style*="border-top: 1px solid #e2e8f0"],
        [data-theme="dark"] [style*="border:1px solid #e2e8f0"],
        [data-theme="dark"] [style*="border: 1px solid #e2e8f0"],
        [data-theme="dark"] [style*="border-bottom:1px solid #f0f2f5"],
        [data-theme="dark"] [style*="border-bottom: 1px solid #f0f2f5"] {
            border-color: var(--card-border) !important;
        }

        /* Dashed border on empty membership card */
        [data-theme="dark"] [style*="border:2px dashed #e2e8f0"],
        [data-theme="dark"] [style*="border: 2px dashed #e2e8f0"] {
            border-color: var(--input-border) !important;
            background: var(--card-bg) !important;
        }

        /* Payment success check circle */
        [data-theme="dark"] [style*="background:#d1fae5"] {
            background: rgba(6,95,70,.25) !important;
        }

        /* Order summary / receipt box */
        [data-theme="dark"] [style*="background:#f8fafc"][style*="border:1px dashed"] {
            background: var(--input-bg) !important;
            border-color: var(--input-border) !important;
        }

        /* Plan cards in payment form */
        [data-theme="dark"] .plan-card {
            background: var(--card-bg) !important;
            border-color: var(--card-border) !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .plan-card:hover {
            border-color: var(--primary) !important;
        }

        /* Membership option labels */
        [data-theme="dark"] .membership-option {
            border-color: var(--card-border) !important;
            color: var(--text-primary) !important;
        }

        /* Method option cards */
        [data-theme="dark"] .method-option {
            border-color: var(--card-border) !important;
            color: var(--text-primary) !important;
        }

        /* Class category badge */
        [data-theme="dark"] [style*="background:#fff5f5;color:#e63946"] {
            background: rgba(230,57,70,.15) !important;
            color: #f87171 !important;
        }

        /* Stat card date text in member dashboard */
        [data-theme="dark"] [style*="background:#f0f2f5"] {
            background: var(--input-bg) !important;
            color: var(--text-primary) !important;
        }

        /* ── HR divider ── */
        [data-theme="dark"] hr { border-color: var(--card-border); opacity: 1; }

        /* ── card-footer ── */
        [data-theme="dark"] .card-footer { border-color: var(--card-border); }

        /* ── form-text helper ── */
        [data-theme="dark"] .form-text { color: var(--text-secondary); }

        /* ── disabled / readonly inputs ── */
        [data-theme="dark"] .form-control:disabled,
        [data-theme="dark"] .form-control[readonly] {
            background: var(--table-hover);
            color: var(--text-secondary);
        }

        /* ── badge bg-light ── */
        [data-theme="dark"] .badge.bg-light {
            background: var(--input-border) !important;
            color: var(--text-primary) !important;
        }

        /* ── TABLE: force all cells to use theme color (overrides Bootstrap specificity) ── */
        [data-theme="dark"] .table > :not(caption) > * > * {
            color: var(--text-primary);
            background-color: transparent;
            border-bottom-color: var(--card-border);
        }
        [data-theme="dark"] .table-hover > tbody > tr:hover > * {
            color: var(--text-primary);
            background-color: var(--table-hover);
        }

        /* ── Footer ── */
        .site-footer {
            border-top: 1px solid var(--footer-border);
            color: var(--text-secondary);
            transition: border-color .25s;
        }
        .site-footer a { color: var(--text-secondary); }
        .site-footer a:hover { color: var(--primary); }
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
                    <a class="nav-link {{ request()->routeIs('member.payments*') ? 'active' : '' }}"
                       href="{{ route('member.payments') }}">
                        <i class="bi bi-credit-card"></i>Payments
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav align-items-center gap-2 mt-2 mt-lg-0">

                <!-- Dark / Light toggle -->
                <li class="nav-item">
                    <button class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
                        <i class="bi bi-moon-fill" id="themeIcon"></i>
                    </button>
                </li>

                <!-- User dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                       href="#" data-bs-toggle="dropdown">
                        @if(Auth::guard('member')->user()->photo)
                            <img src="{{ asset('storage/' . Auth::guard('member')->user()->photo) }}"
                                 alt="" class="rounded-circle object-fit-cover"
                                 style="width:28px;height:28px;object-fit:cover;min-width:28px">
                        @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                             style="width:28px;height:28px;background:#e63946;color:#fff;font-size:.75rem;min-width:28px">
                            {{ strtoupper(substr(Auth::guard('member')->user()->first_name, 0, 1)) }}
                        </div>
                        @endif
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

<footer class="site-footer text-center py-4 small mt-4">
    © {{ date('Y') }} FitLife Gym. All rights reserved.
    &nbsp;·&nbsp;
    <a href="{{ route('login') }}">Admin Panel</a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── Dark / Light mode ──
    const html      = document.documentElement;
    const btn       = document.getElementById('themeToggle');
    const icon      = document.getElementById('themeIcon');
    const STORE_KEY = 'fitlife_theme';

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        localStorage.setItem(STORE_KEY, theme);
    }

    applyTheme(localStorage.getItem(STORE_KEY) || 'light');

    btn.addEventListener('click', () => {
        applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });
</script>
@stack('scripts')
</body>
</html>
