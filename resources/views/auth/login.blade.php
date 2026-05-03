<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — FitLife Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            background: #0f0f1a;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background blobs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .35;
            animation: float 8s ease-in-out infinite;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #e63946, #c1121f);
            top: -150px; left: -150px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #4361ee, #3a0ca3);
            bottom: -100px; right: -100px;
            animation-delay: -4s;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50%       { transform: translate(30px, 20px) scale(1.05); }
        }

        .login-card {
            background: rgba(255,255,255,.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 50px rgba(0,0,0,.5);
        }

        .brand-logo {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #e63946, #c1121f);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: #fff;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 20px rgba(230,57,70,.4);
        }

        .login-title {
            font-size: 1.6rem; font-weight: 800;
            color: #fff; text-align: center; margin-bottom: .25rem;
        }
        .login-subtitle {
            color: rgba(255,255,255,.5); text-align: center;
            font-size: .875rem; margin-bottom: 2rem;
        }

        .form-label {
            color: rgba(255,255,255,.7);
            font-size: .8rem; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase;
        }

        .form-control {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 10px;
            color: #fff;
            padding: .75rem 1rem;
            font-size: .9rem;
            transition: all .2s;
        }
        .form-control:focus {
            background: rgba(255,255,255,.1);
            border-color: #e63946;
            box-shadow: 0 0 0 3px rgba(230,57,70,.2);
            color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,.3); }
        .form-control.is-invalid {
            border-color: #f87171;
            background: rgba(248,113,113,.08);
        }
        .invalid-feedback { color: #f87171; font-size: .8rem; }

        .input-group-text {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            border-right: none;
            color: rgba(255,255,255,.4);
            border-radius: 10px 0 0 10px;
        }
        .input-group .form-control { border-left: none; border-radius: 0 10px 10px 0; }
        .input-group .form-control:focus { border-left: none; }

        .btn-login {
            background: linear-gradient(135deg, #e63946, #c1121f);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 600;
            padding: .8rem;
            font-size: .95rem;
            width: 100%;
            transition: all .2s;
            box-shadow: 0 4px 15px rgba(230,57,70,.35);
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(230,57,70,.5);
            color: #fff;
        }
        .btn-login:active { transform: translateY(0); }

        .form-check-input {
            background-color: rgba(255,255,255,.1);
            border-color: rgba(255,255,255,.2);
        }
        .form-check-input:checked {
            background-color: #e63946;
            border-color: #e63946;
        }
        .form-check-label { color: rgba(255,255,255,.6); font-size: .85rem; }

        .divider {
            display: flex; align-items: center; gap: 1rem;
            color: rgba(255,255,255,.2); font-size: .75rem; margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: rgba(255,255,255,.1);
        }

        .demo-box {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px;
            padding: .875rem 1rem;
            font-size: .8rem;
            color: rgba(255,255,255,.5);
        }
        .demo-box strong { color: rgba(255,255,255,.8); }

        .alert-danger-dark {
            background: rgba(248,113,113,.12);
            border: 1px solid rgba(248,113,113,.25);
            border-radius: 10px;
            color: #f87171;
            padding: .75rem 1rem;
            font-size: .85rem;
            margin-bottom: 1.25rem;
        }

        .alert-success-dark {
            background: rgba(52,211,153,.12);
            border: 1px solid rgba(52,211,153,.25);
            border-radius: 10px;
            color: #34d399;
            padding: .75rem 1rem;
            font-size: .85rem;
            margin-bottom: 1.25rem;
        }

        /* Toggle password visibility */
        .toggle-pw {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            border-left: none;
            color: rgba(255,255,255,.4);
            border-radius: 0 10px 10px 0;
            cursor: pointer;
            padding: 0 .875rem;
            transition: color .2s;
        }
        .toggle-pw:hover { color: rgba(255,255,255,.8); }
    </style>
</head>
<body>

<div class="login-card">
    <!-- Brand -->
    <div class="brand-logo">
        <i class="bi bi-lightning-charge-fill"></i>
    </div>
    <div class="login-title">FitLife Gym</div>
    <div class="login-subtitle">Management System — Admin Portal</div>

    <!-- Flash messages -->
    @if(session('success'))
    <div class="alert-success-dark">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-danger-dark">
        <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
    </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="admin@fitlife.com"
                       autocomplete="email" autofocus required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="passwordInput"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••"
                       autocomplete="current-password" required>
                <button type="button" class="toggle-pw" id="togglePw" tabindex="-1">
                    <i class="bi bi-eye" id="togglePwIcon"></i>
                </button>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>
    </form>

    <div class="divider">Demo Credentials</div>

    <div class="demo-box">
        <div class="mb-1"><i class="bi bi-person-circle me-2"></i><strong>Email:</strong> admin@fitlife.com</div>
        <div><i class="bi bi-key me-2"></i><strong>Password:</strong> password</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle password visibility
    document.getElementById('togglePw').addEventListener('click', function () {
        const input = document.getElementById('passwordInput');
        const icon  = document.getElementById('togglePwIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    });
</script>
</body>
</html>
