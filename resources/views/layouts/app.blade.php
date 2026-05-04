<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FitLife Gym') — FitLife Gym Management</title>
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
            --sidebar-bg:     #1a1a2e;
            --sidebar-hover:  #16213e;
            --sidebar-text:   #a8b2d8;
            --sidebar-width:  260px;

            --body-bg:        #f0f2f5;
            --topbar-bg:      #ffffff;
            --topbar-border:  #e2e8f0;
            --card-bg:        #ffffff;
            --card-border:    #f0f2f5;
            --card-shadow:    rgba(0,0,0,.08);
            --text-primary:   #1a202c;
            --text-secondary: #718096;
            --text-label:     #374151;
            --input-bg:       #ffffff;
            --input-border:   #e2e8f0;
            --table-hover:    #f8fafc;
            --table-th:       #718096;
            --dropdown-bg:    #ffffff;
            --toggle-bg:      #f0f2f5;
            --toggle-color:   #718096;
            --toggle-border:  #e2e8f0;
            --footer-border:  #e2e8f0;
            --alert-success-bg:     #d1fae5;
            --alert-success-color:  #065f46;
        }

        [data-theme="dark"] {
            --body-bg:        #0f1117;
            --topbar-bg:      #1a1d27;
            --topbar-border:  #252836;
            --card-bg:        #1a1d27;
            --card-border:    #252836;
            --card-shadow:    rgba(0,0,0,.3);
            --text-primary:   #e8eaf0;
            --text-secondary: #8892a4;
            --text-label:     #9aa5b4;
            --input-bg:       #252836;
            --input-border:   #333650;
            --table-hover:    #252836;
            --table-th:       #6b7a99;
            --dropdown-bg:    #1a1d27;
            --toggle-bg:      #252836;
            --toggle-color:   #8892a4;
            --toggle-border:  #333650;
            --footer-border:  #252836;
            --alert-success-bg:    rgba(6,95,70,.2);
            --alert-success-color: #6ee7b7;
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background: var(--body-bg);
            color: var(--text-primary);
            min-height: 100vh;
            transition: background .25s, color .25s;
        }

        /* ── Sidebar (always dark) ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0;
            z-index: 1000;
            transition: transform .3s ease;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand .brand-icon {
            width: 40px; height: 40px; background: var(--primary);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; font-size: 1.2rem; color: #fff;
        }
        .sidebar-brand .brand-name { font-size: 1.1rem; font-weight: 700; color: #fff; }
        .sidebar-brand .brand-sub  { font-size: .7rem; color: var(--sidebar-text); letter-spacing: .05em; }

        .sidebar-section-title {
            font-size: .65rem; font-weight: 600; letter-spacing: .1em;
            color: #4a5568; text-transform: uppercase;
            padding: .75rem 1.25rem .25rem;
        }
        .sidebar-nav .nav-link {
            color: var(--sidebar-text);
            padding: .6rem 1.25rem; border-radius: 8px;
            margin: 2px 8px; font-size: .875rem; font-weight: 500;
            display: flex; align-items: center; gap: .6rem;
            transition: all .2s;
        }
        .sidebar-nav .nav-link:hover  { background: var(--sidebar-hover); color: #fff; }
        .sidebar-nav .nav-link.active { background: var(--primary); color: #fff; }
        .sidebar-nav .nav-link i { font-size: 1rem; width: 20px; text-align: center; }

        /* ── Main content ── */
        #main-content { margin-left: var(--sidebar-width); min-height: 100vh; transition: margin .3s ease; }

        /* ── Topbar ── */
        .topbar {
            background: var(--topbar-bg);
            border-bottom: 1px solid var(--topbar-border);
            padding: .75rem 1.5rem;
            position: sticky; top: 0; z-index: 999;
            transition: background .25s, border-color .25s;
        }

        /* ── Theme toggle button ── */
        .theme-toggle {
            width: 34px; height: 34px;
            background: var(--toggle-bg);
            border: 1.5px solid var(--toggle-border);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--toggle-color); font-size: .95rem;
            transition: background .25s, border-color .25s, color .25s, transform .2s;
            flex-shrink: 0;
        }
        .theme-toggle:hover { transform: rotate(20deg); color: var(--primary); }

        /* ── Cards ── */
        .stat-card {
            border: none; border-radius: 16px; padding: 1.5rem;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,.15); }
        .stat-card .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
        }
        .stat-card .stat-value { font-size: 1.8rem; font-weight: 700; }
        .stat-card .stat-label { font-size: .8rem; font-weight: 500; opacity: .75; }

        .card {
            border: none; border-radius: 16px;
            background: var(--card-bg);
            box-shadow: 0 1px 3px var(--card-shadow);
            transition: background .25s, box-shadow .25s;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--card-border);
            padding: 1.25rem 1.5rem;
            color: var(--text-primary);
        }
        .card-body { color: var(--text-primary); }

        /* ── Badges ── */
        .badge-active    { background: #d1fae5; color: #065f46; }
        .badge-inactive  { background: #fee2e2; color: #991b1b; }
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-expired   { background: #e5e7eb; color: #374151; }
        .badge-cancelled { background: #fce7f3; color: #9d174d; }
        .badge-paid      { background: #d1fae5; color: #065f46; }
        .badge-failed    { background: #fee2e2; color: #991b1b; }
        .badge-booked    { background: #dbeafe; color: #1e40af; }
        .badge-attended  { background: #d1fae5; color: #065f46; }
        .badge-no_show   { background: #fee2e2; color: #991b1b; }
        .badge-scheduled { background: #dbeafe; color: #1e40af; }
        .badge-completed { background: #d1fae5; color: #065f46; }

        [data-theme="dark"] .badge-active    { background: rgba(16,185,129,.2); color: #6ee7b7; }
        [data-theme="dark"] .badge-inactive  { background: rgba(239,68,68,.2);  color: #fca5a5; }
        [data-theme="dark"] .badge-pending   { background: rgba(245,158,11,.2); color: #fcd34d; }
        [data-theme="dark"] .badge-expired   { background: rgba(107,114,128,.2);color: #d1d5db; }
        [data-theme="dark"] .badge-cancelled { background: rgba(236,72,153,.2); color: #f9a8d4; }
        [data-theme="dark"] .badge-paid      { background: rgba(16,185,129,.2); color: #6ee7b7; }
        [data-theme="dark"] .badge-failed    { background: rgba(239,68,68,.2);  color: #fca5a5; }
        [data-theme="dark"] .badge-booked    { background: rgba(59,130,246,.2); color: #93c5fd; }
        [data-theme="dark"] .badge-attended  { background: rgba(16,185,129,.2); color: #6ee7b7; }
        [data-theme="dark"] .badge-no_show   { background: rgba(239,68,68,.2);  color: #fca5a5; }
        [data-theme="dark"] .badge-scheduled { background: rgba(59,130,246,.2); color: #93c5fd; }
        [data-theme="dark"] .badge-completed { background: rgba(16,185,129,.2); color: #6ee7b7; }

        /* ── Buttons ── */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
        .btn-light {
            background: var(--toggle-bg); border-color: var(--toggle-border);
            color: var(--text-primary);
        }
        .btn-light:hover { background: var(--input-border); color: var(--text-primary); }

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
            letter-spacing: .05em; color: var(--table-th); border-top: none;
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
            color: var(--text-primary);
        }
        .dropdown-item { color: var(--text-primary); }
        .dropdown-item:hover { background: var(--table-hover); color: var(--text-primary); }
        .dropdown-divider { border-color: var(--card-border); }

        /* ── Avatar ── */
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: .875rem;
            background: var(--input-border); color: var(--text-secondary);
        }

        /* ── Page header ── */
        .page-header { margin-bottom: 1.5rem; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--text-primary); }
        .page-header p  { color: var(--text-secondary); font-size: .875rem; }

        /* ── Text helpers ── */
        .text-muted { color: var(--text-secondary) !important; }

        /* ── Dark mode overrides for Bootstrap & hardcoded colors ── */
        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3,
        [data-theme="dark"] h4,
        [data-theme="dark"] h5,
        [data-theme="dark"] h6,
        [data-theme="dark"] p,
        [data-theme="dark"] span,
        [data-theme="dark"] label,
        [data-theme="dark"] li,
        [data-theme="dark"] td,
        [data-theme="dark"] th,
        [data-theme="dark"] small,
        [data-theme="dark"] div { color: inherit; }

        [data-theme="dark"] .text-dark,
        [data-theme="dark"] .text-body { color: var(--text-primary) !important; }

        [data-theme="dark"] .fw-semibold,
        [data-theme="dark"] .fw-bold,
        [data-theme="dark"] .fw-medium { color: inherit; }

        /* Input group text (search icons etc.) */
        [data-theme="dark"] .input-group-text {
            background: var(--input-bg);
            border-color: var(--input-border);
            color: var(--text-secondary);
        }

        /* Breadcrumb */
        [data-theme="dark"] .breadcrumb-item,
        [data-theme="dark"] .breadcrumb-item a { color: var(--text-secondary); }
        [data-theme="dark"] .breadcrumb-item.active { color: var(--text-primary); }
        [data-theme="dark"] .breadcrumb-item + .breadcrumb-item::before { color: var(--text-secondary); }

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
        [data-theme="dark"] .alert-info {
            background: rgba(6,95,148,.2);
            border-color: rgba(6,95,148,.3);
            color: #7dd3fc;
        }

        /* Progress bar track */
        [data-theme="dark"] .progress {
            background: var(--input-border);
        }

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

        /* Inline style overrides — catch hardcoded colors in views */
        [data-theme="dark"] .card-body small,
        [data-theme="dark"] .card-body .small { color: inherit; }

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

        /* White card backgrounds set via inline style */
        [data-theme="dark"] [style*="background:#fff"],
        [data-theme="dark"] [style*="background: #fff"],
        [data-theme="dark"] [style*="background:white"],
        [data-theme="dark"] [style*="background: white"] {
            background: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }

        /* Hardcoded dark text colors in inline styles */
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

        /* Sidebar footer email color */
        [data-theme="dark"] #sidebar [style*="color:#4a5568"] {
            color: var(--sidebar-text) !important;
        }

        /* Border colors */
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

        /* Stat card hover text */
        [data-theme="dark"] .stat-card .stat-label { color: rgba(255,255,255,.75); }

        /* ── HR divider ── */
        [data-theme="dark"] hr { border-color: var(--card-border); opacity: 1; }

        /* ── Bootstrap card-footer ── */
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

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
    <div class="sidebar-brand d-flex align-items-center gap-3">
        <div class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></div>
        <div>
            <div class="brand-name">FitLife Gym</div>
            <div class="brand-sub">MANAGEMENT SYSTEM</div>
        </div>
    </div>

    <div class="sidebar-section-title">Main</div>
    <ul class="sidebar-nav nav flex-column">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
    </ul>

    <div class="sidebar-section-title">Members</div>
    <ul class="sidebar-nav nav flex-column">
        <li class="nav-item">
            <a href="{{ route('members.index') }}" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Members
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('memberships.index') }}" class="nav-link {{ request()->routeIs('memberships.*') ? 'active' : '' }}">
                <i class="bi bi-card-checklist"></i> Memberships
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('plans.index') }}" class="nav-link {{ request()->routeIs('plans.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i> Plans
            </a>
        </li>
    </ul>

    <div class="sidebar-section-title">Classes</div>
    <ul class="sidebar-nav nav flex-column">
        <li class="nav-item">
            <a href="{{ route('trainers.index') }}" class="nav-link {{ request()->routeIs('trainers.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i> Trainers
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('classes.index') }}" class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Classes
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bookings.index') }}" class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                <i class="bi bi-bookmark-check-fill"></i> Bookings
            </a>
        </li>
    </ul>

    <div class="sidebar-section-title">Finance</div>
    <ul class="sidebar-nav nav flex-column">
        <li class="nav-item">
            <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card-fill"></i> Payments
            </a>
        </li>
    </ul>

    <div class="sidebar-section-title">Settings</div>
    <ul class="sidebar-nav nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock-fill"></i> Admin Accounts
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> My Profile
            </a>
        </li>
    </ul>

    <div class="mt-auto p-3" style="border-top:1px solid rgba(255,255,255,.08);margin-top:auto">
        <div class="d-flex align-items-center gap-2 mb-2">
            @if(Auth::user()->photo)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                     class="rounded-circle object-fit-cover"
                     style="width:34px;height:34px;object-fit:cover;min-width:34px" alt="">
            @else
            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                 style="width:34px;height:34px;background:#e63946;color:#fff;font-size:.85rem;min-width:34px">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            @endif
            <div style="overflow:hidden">
                <div class="text-white small fw-semibold text-truncate">{{ Auth::user()->name }}</div>
                <div style="font-size:.7rem;color:var(--sidebar-text)" class="text-truncate">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm w-100 text-start"
                    style="background:rgba(230,57,70,.15);color:#e63946;border:1px solid rgba(230,57,70,.2);border-radius:8px">
                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
            </button>
        </form>
    </div>
</nav>

<!-- Main Content -->
<div id="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 d-none d-sm-inline-flex">
                <i class="bi bi-circle-fill me-1" style="font-size:.5rem"></i> System Online
            </span>

            <!-- Dark / Light toggle -->
            <button class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
                <i class="bi bi-moon-fill" id="themeIcon"></i>
            </button>

            <!-- User dropdown -->
            <div class="dropdown ms-1">
                <button class="btn btn-light btn-sm d-flex align-items-center gap-2 rounded-pill px-3"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                             class="rounded-circle object-fit-cover"
                             style="width:28px;height:28px;object-fit:cover;min-width:28px" alt="">
                    @else
                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                         style="width:28px;height:28px;background:#e63946;color:#fff;font-size:.75rem;min-width:28px">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    @endif
                    <span class="d-none d-md-inline small fw-semibold">{{ Auth::user()->name }}</span>
                    <i class="bi bi-chevron-down small text-muted"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-1" style="min-width:200px">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-semibold small">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ Auth::user()->email }}</div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person me-2"></i>My Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── Sidebar toggle (mobile) ──
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });

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
