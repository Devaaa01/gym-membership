<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login — FitLife Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            min-height: 100vh; background: #f0f2f5;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-wrapper { width: 100%; max-width: 960px; padding: 1rem; }
        .auth-left {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            border-radius: 20px 0 0 20px;
            padding: 3rem 2.5rem;
            display: flex; flex-direction: column; justify-content: center;
            position: relative; overflow: hidden;
        }
        .auth-left::before {
            content: '';
            position: absolute; width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(230,57,70,.3), transparent);
            top: -100px; right: -100px; border-radius: 50%;
        }
        .auth-left::after {
            content: '';
            position: absolute; width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(67,97,238,.3), transparent);
            bottom: -50px; left: -50px; border-radius: 50%;
        }
        .auth-right {
            background: #fff;
            border-radius: 0 20px 20px 0;
            padding: 3rem 2.5rem;
        }
        .brand-icon {
            width: 52px; height: 52px; background: #e63946;
            border-radius: 14px; display: flex; align-items: center;
            justify-content: center; font-size: 1.4rem; color: #fff;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 20px rgba(230,57,70,.4);
        }
        .feature-item { display: flex; align-items: center; gap: .75rem; margin-bottom: 1rem; }
        .feature-icon {
            width: 36px; height: 36px; background: rgba(255,255,255,.1);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; color: #e63946; font-size: 1rem; flex-shrink: 0;
        }
        .form-control, .form-select {
            border-radius: 10px; border-color: #e2e8f0;
            padding: .7rem 1rem; font-size: .9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #e63946; box-shadow: 0 0 0 3px rgba(230,57,70,.15);
        }
        .btn-primary {
            background: #e63946; border-color: #e63946;
            border-radius: 10px; padding: .75rem; font-weight: 600;
        }
        .btn-primary:hover { background: #c1121f; border-color: #c1121f; }
        .input-group-text { border-radius: 10px 0 0 10px; background: #f8fafc; border-color: #e2e8f0; }
        .input-group .form-control { border-radius: 0 10px 10px 0; border-left: none; }
        .toggle-pw {
            border: 1px solid #e2e8f0; border-left: none;
            border-radius: 0 10px 10px 0; background: #f8fafc;
            color: #718096; cursor: pointer; padding: 0 .875rem;
        }
        .toggle-pw:hover { color: #1a202c; }
        @media (max-width: 767px) {
            .auth-left { border-radius: 20px 20px 0 0; }
            .auth-right { border-radius: 0 0 20px 20px; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="row g-0 shadow-lg" style="border-radius:20px;overflow:hidden">

        <!-- Left panel -->
        <div class="col-md-5 auth-left">
            <div class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></div>
            <h2 class="text-white fw-bold mb-1">FitLife Gym</h2>
            <p class="mb-4" style="color:rgba(255,255,255,.6);font-size:.9rem">Member Portal</p>

            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-card-checklist"></i></div>
                <div>
                    <div class="text-white small fw-semibold">Track Your Membership</div>
                    <div style="color:rgba(255,255,255,.5);font-size:.75rem">View status, plan details & expiry</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-calendar3"></i></div>
                <div>
                    <div class="text-white small fw-semibold">Book Classes Online</div>
                    <div style="color:rgba(255,255,255,.5);font-size:.75rem">Reserve your spot in any class</div>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="bi bi-credit-card"></i></div>
                <div>
                    <div class="text-white small fw-semibold">Payment History</div>
                    <div style="color:rgba(255,255,255,.5);font-size:.75rem">View all your transactions</div>
                </div>
            </div>

            <div class="mt-4 pt-3" style="border-top:1px solid rgba(255,255,255,.1)">
                <p style="color:rgba(255,255,255,.4);font-size:.75rem">
                    Are you staff? <a href="{{ route('login') }}" style="color:#e63946">Admin Panel →</a>
                </p>
            </div>
        </div>

        <!-- Right panel -->
        <div class="col-md-7 auth-right">
            <h4 class="fw-bold mb-1">Welcome back!</h4>
            <p class="text-muted small mb-4">Sign in to your member account</p>

            @if(session('success'))
            <div class="alert alert-success rounded-3 border-0 small py-2 mb-3">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger rounded-3 border-0 small py-2 mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger rounded-3 border-0 small py-2 mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('member.login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" placeholder="your@email.com"
                               autocomplete="email" autofocus required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" id="pw" class="form-control"
                               placeholder="••••••••" autocomplete="current-password" required>
                        <button type="button" class="toggle-pw" onclick="togglePw()">
                            <i class="bi bi-eye" id="pwIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Remember me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>

            <div class="text-center">
                <span class="text-muted small">Don't have an account?</span>
                <a href="{{ route('member.register') }}" class="small fw-semibold ms-1" style="color:#e63946">
                    Register here
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePw() {
    const i = document.getElementById('pw');
    const icon = document.getElementById('pwIcon');
    i.type = i.type === 'password' ? 'text' : 'password';
    icon.className = i.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
