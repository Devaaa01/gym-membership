<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FitLife Gym') — FitLife Gym Management</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:   #e63946;
            --primary-dark: #c1121f;
            --sidebar-bg: #1a1a2e;
            --sidebar-hover: #16213e;
            --sidebar-active: #e63946;
            --sidebar-text: #a8b2d8;
            --sidebar-width: 260px;
        }

        * { font-family: 'Inter', sans-serif; }

        body { background: #f0f2f5; min-height: 100vh; }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: transform .3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand .brand-icon {
            width: 40px; height: 40px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; color: #fff;
        }
        .sidebar-brand .brand-name {
            font-size: 1.1rem; font-weight: 700; color: #fff;
        }
        .sidebar-brand .brand-sub {
            font-size: .7rem; color: var(--sidebar-text); letter-spacing: .05em;
        }

        .sidebar-section-title {
            font-size: .65rem; font-weight: 600; letter-spacing: .1em;
            color: #4a5568; text-transform: uppercase;
            padding: .75rem 1.25rem .25rem;
        }

        .sidebar-nav .nav-link {
            color: var(--sidebar-text);
            padding: .6rem 1.25rem;
            border-radius: 8px;
            margin: 2px 8px;
            font-size: .875rem;
            font-weight: 500;
            display: flex; align-items: center; gap: .6rem;
            transition: all .2s;
        }
        .sidebar-nav .nav-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }
        .sidebar-nav .nav-link.active {
            background: var(--primary);
            color: #fff;
        }
        .sidebar-nav .nav-link i { font-size: 1rem; width: 20px; text-align: center; }

        /* ── Main content ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin .3s ease;
        }

        /* ── Topbar ── */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem;
            position: sticky; top: 0; z-index: 999;
        }

        /* ── Cards ── */
        .stat-card {
            border: none; border-radius: 16px;
            padding: 1.5rem;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,.1); }
        .stat-card .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-card .stat-value { font-size: 1.8rem; font-weight: 700; }
        .stat-card .stat-label { font-size: .8rem; color: #718096; font-weight: 500; }

        .card { border: none; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .card-header { background: transparent; border-bottom: 1px solid #f0f2f5; padding: 1.25rem 1.5rem; }

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

        /* ── Buttons ── */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); }

        /* ── Table ── */
        .table th { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #718096; border-top: none; }
        .table td { vertical-align: middle; font-size: .875rem; }
        .table-hover tbody tr:hover { background: #f8fafc; }

        /* ── Avatar ── */
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            object-fit: cover; background: #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: .875rem; color: #4a5568;
        }

        /* ── Page header ── */
        .page-header { margin-bottom: 1.5rem; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: #1a202c; }
        .page-header p  { color: #718096; font-size: .875rem; }

        /* ── Form ── */
        .form-label { font-weight: 500; font-size: .875rem; color: #374151; }
        .form-control, .form-select { border-radius: 8px; border-color: #e2e8f0; font-size: .875rem; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(230,57,70,.15); }

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
    </ul>

    <!-- Sidebar footer -->
    <div class="mt-auto p-3" style="border-top:1px solid rgba(255,255,255,.08);margin-top:auto">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                 style="width:34px;height:34px;background:#e63946;color:#fff;font-size:.85rem;min-width:34px">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="overflow:hidden">
                <div class="text-white small fw-semibold text-truncate">{{ Auth::user()->name }}</div>
                <div style="font-size:.7rem;color:#4a5568" class="text-truncate">{{ Auth::user()->email }}</div>
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

            <!-- User dropdown -->
            <div class="dropdown ms-2">
                <button class="btn btn-light btn-sm d-flex align-items-center gap-2 rounded-pill px-3"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                         style="width:28px;height:28px;background:#e63946;color:#fff;font-size:.75rem;min-width:28px">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="d-none d-md-inline small fw-semibold">{{ Auth::user()->name }}</span>
                    <i class="bi bi-chevron-down small text-muted"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-1" style="min-width:200px">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-semibold small">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ Auth::user()->email }}</div>
                    </li>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
