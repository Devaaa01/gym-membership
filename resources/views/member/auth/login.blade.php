<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login — FitLife Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }

        /* ── Theme variables ── */
        :root {
            --bg:           #fff;
            --bg-input:     #f7f8fc;
            --border:       #e8ecf0;
            --text:         #1a202c;
            --text-sub:     #718096;
            --text-label:   #4a5568;
            --text-muted:   #a0aec0;
            --divider:      #edf2f7;
            --err-bg:       #fff5f5;
            --err-border:   #fed7d7;
            --err-text:     #c53030;
            --ok-bg:        #f0fff4;
            --ok-border:    #c6f6d5;
            --ok-text:      #276749;
            --toggle-bg:    #f0f2f5;
            --toggle-color: #718096;
        }
        [data-theme="dark"] {
            --bg:           #141720;
            --bg-input:     #1e2235;
            --border:       #2d3250;
            --text:         #f0f2f5;
            --text-sub:     #8892a4;
            --text-label:   #9aa5b4;
            --text-muted:   #5a6478;
            --divider:      #1e2235;
            --err-bg:       rgba(197,48,48,.12);
            --err-border:   rgba(197,48,48,.3);
            --err-text:     #fc8181;
            --ok-bg:        rgba(39,103,73,.15);
            --ok-border:    rgba(39,103,73,.3);
            --ok-text:      #68d391;
            --toggle-bg:    #1e2235;
            --toggle-color: #8892a4;
        }

        .page { display: flex; height: 100vh; min-height: 100vh; }

        /* ── Form side ── */
        .form-side {
            width: 480px; min-width: 480px;
            background: var(--bg);
            display: flex; flex-direction: column; justify-content: center;
            padding: 3rem 3.5rem; overflow-y: auto;
            transition: background .3s, color .3s;
            position: relative;
        }

        /* ── Theme toggle button ── */
        .theme-toggle {
            position: absolute; top: 1.5rem; right: 1.5rem;
            width: 36px; height: 36px;
            background: var(--toggle-bg);
            border: 1.5px solid var(--border);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--toggle-color); font-size: 1rem;
            transition: background .3s, border-color .3s, color .3s, transform .2s;
        }
        .theme-toggle:hover { transform: rotate(20deg); color: #e63946; }

        .brand { display: flex; align-items: center; gap: .75rem; margin-bottom: 2.5rem; }
        .brand-icon {
            width: 40px; height: 40px; background: #e63946;
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; color: #fff; font-size: 1.1rem;
        }
        .brand-name { font-size: 1.1rem; font-weight: 700; color: var(--text); }
        .brand-tag  { font-size: .72rem; color: var(--text-muted); font-weight: 500; }

        .form-heading { font-size: 1.6rem; font-weight: 800; color: var(--text); margin-bottom: .35rem; }
        .form-sub     { font-size: .875rem; color: var(--text-sub); margin-bottom: 2rem; }

        .form-label {
            font-size: .78rem; font-weight: 600; color: var(--text-label);
            letter-spacing: .03em; text-transform: uppercase;
            margin-bottom: .4rem; display: block;
        }
        .input-wrap { position: relative; margin-bottom: 1.25rem; }
        .input-icon {
            position: absolute; left: .9rem; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: .95rem; pointer-events: none;
        }
        .form-input {
            width: 100%;
            background: var(--bg-input);
            border: 1.5px solid var(--border);
            border-radius: 10px; color: var(--text);
            padding: .72rem 1rem .72rem 2.5rem;
            font-size: .9rem; font-family: 'Inter', sans-serif;
            transition: border-color .2s, box-shadow .2s, background .3s, color .3s;
            outline: none;
        }
        .form-input:focus {
            background: var(--bg);
            border-color: #e63946;
            box-shadow: 0 0 0 3px rgba(230,57,70,.12);
        }
        .form-input::placeholder { color: var(--text-muted); }
        .form-input.has-toggle { padding-right: 2.75rem; }

        .toggle-pw {
            position: absolute; right: .9rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--text-muted);
            cursor: pointer; padding: 0; font-size: .95rem; transition: color .2s;
        }
        .toggle-pw:hover { color: var(--text); }

        .row-between {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.75rem;
        }
        .check-label {
            display: flex; align-items: center; gap: .5rem;
            font-size: .85rem; color: var(--text-sub); cursor: pointer;
        }
        .check-label input[type=checkbox] { accent-color: #e63946; width: 15px; height: 15px; }

        .btn-submit {
            width: 100%; background: #e63946; border: none; border-radius: 10px;
            color: #fff; font-weight: 600; font-size: .95rem;
            font-family: 'Inter', sans-serif; padding: .8rem; cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 4px 14px rgba(230,57,70,.3);
        }
        .btn-submit:hover {
            background: #c1121f; transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(230,57,70,.4);
        }
        .btn-submit:active { transform: translateY(0); }

        .register-row {
            margin-top: 1.25rem; text-align: center;
            font-size: .85rem; color: var(--text-sub);
        }
        .register-row a { color: #e63946; font-weight: 600; text-decoration: none; }
        .register-row a:hover { text-decoration: underline; }

        .admin-link {
            margin-top: 1rem; font-size: .8rem;
            color: var(--text-muted); text-align: center;
        }
        .admin-link a { color: var(--text-muted); text-decoration: none; }
        .admin-link a:hover { color: var(--text-sub); }

        .alert-msg {
            border-radius: 10px; padding: .7rem 1rem; font-size: .85rem;
            margin-bottom: 1.25rem; display: flex; align-items: center; gap: .5rem;
        }
        .alert-error   { background: var(--err-bg); border: 1.5px solid var(--err-border); color: var(--err-text); }
        .alert-success { background: var(--ok-bg);  border: 1.5px solid var(--ok-border);  color: var(--ok-text); }

        /* ── Image side ── */
        .image-side {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=1400&q=80');
            background-size: cover; background-position: center; position: relative;
        }
        .image-side::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(160deg, rgba(0,0,0,.35) 0%, rgba(0,0,0,.15) 100%);
        }
        .image-overlay {
            position: absolute; bottom: 2.5rem; left: 2.5rem; right: 2.5rem; z-index: 1;
        }
        .image-quote {
            font-size: 1.5rem; font-weight: 700; color: #fff;
            line-height: 1.4; margin-bottom: .5rem;
        }
        .image-caption { font-size: .875rem; color: rgba(255,255,255,.65); }

        @media (max-width: 768px) {
            .image-side { display: none; }
            .form-side  { width: 100%; min-width: unset; padding: 2.5rem 1.75rem; }
        }
    </style>
</head>
<body>

<div class="page">

    <!-- Left: Form -->
    <div class="form-side">

        <!-- Theme toggle -->
        <button class="theme-toggle" id="themeToggle" title="Toggle dark/light mode" tabindex="-1">
            <i class="bi bi-moon-fill" id="themeIcon"></i>
        </button>

        <div class="brand">
            <div class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></div>
            <div>
                <div class="brand-name">FitLife Gym</div>
                <div class="brand-tag">MEMBER PORTAL</div>
            </div>
        </div>

        <div class="form-heading">Welcome back</div>
        <div class="form-sub">Sign in to your member account</div>

        @if(session('success'))
        <div class="alert-msg alert-success">
            <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert-msg alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>{{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert-msg alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('member.login.post') }}">
            @csrf

            <div>
                <label class="form-label">Email Address</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" class="form-input"
                           value="{{ old('email') }}"
                           placeholder="your@email.com"
                           autocomplete="email" autofocus required>
                </div>
            </div>

            <div>
                <label class="form-label">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="password" id="pw" class="form-input has-toggle"
                           placeholder="••••••••"
                           autocomplete="current-password" required>
                    <button type="button" class="toggle-pw" id="togglePw" tabindex="-1">
                        <i class="bi bi-eye" id="pwIcon"></i>
                    </button>
                </div>
            </div>

            <div class="row-between">
                <label class="check-label">
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

        <div class="register-row">
            Don't have an account? <a href="{{ route('member.register') }}">Register here</a>
        </div>

        <div class="admin-link">
            <a href="{{ route('login') }}"><i class="bi bi-shield-lock me-1"></i>Admin Panel</a>
        </div>

    </div>

    <!-- Right: Image -->
    <div class="image-side">
        <div class="image-overlay">
            <div class="image-quote">"Every rep counts.<br>Every session matters."</div>
            <div class="image-caption">FitLife Gym — Member Portal</div>
        </div>
    </div>

</div>

<script>
    // ── Password toggle ──
    document.getElementById('togglePw').addEventListener('click', function () {
        const input = document.getElementById('pw');
        const icon  = document.getElementById('pwIcon');
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    });

    // ── Dark / Light mode toggle ──
    const html      = document.documentElement;
    const btn       = document.getElementById('themeToggle');
    const icon      = document.getElementById('themeIcon');
    const STORE_KEY = 'fitlife_theme';

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        localStorage.setItem(STORE_KEY, theme);
    }

    // Load saved preference
    applyTheme(localStorage.getItem(STORE_KEY) || 'light');

    btn.addEventListener('click', function () {
        applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });
</script>
</body>
</html>
