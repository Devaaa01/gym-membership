<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — FitLife Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; min-height: 100vh; padding: 2rem 0; }
        .register-card {
            background: #fff; border-radius: 20px;
            box-shadow: 0 4px 30px rgba(0,0,0,.1);
            overflow: hidden; max-width: 860px; margin: 0 auto;
        }
        .register-header {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 2rem 2.5rem;
        }
        .register-body { padding: 2.5rem; }
        .brand-icon {
            width: 44px; height: 44px; background: #e63946;
            border-radius: 12px; display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 1.2rem; color: #fff; margin-right: .75rem;
        }
        .section-title {
            font-size: .7rem; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: #718096;
            border-bottom: 2px solid #f0f2f5; padding-bottom: .5rem;
            margin-bottom: 1.25rem;
        }
        .plan-card {
            border: 2px solid #e2e8f0; border-radius: 12px;
            padding: 1.25rem; cursor: pointer; transition: all .2s;
            position: relative;
        }
        .plan-card:hover { border-color: #e63946; }
        .plan-card input[type=radio] { position: absolute; opacity: 0; }
        .plan-card.selected { border-color: #e63946; background: #fff5f5; }
        .plan-card .plan-name { font-weight: 700; font-size: .95rem; }
        .plan-card .plan-price { font-size: 1.2rem; font-weight: 800; color: #e63946; }
        .plan-card .plan-check {
            position: absolute; top: .75rem; right: .75rem;
            width: 22px; height: 22px; background: #e63946;
            border-radius: 50%; display: none;
            align-items: center; justify-content: center; color: #fff; font-size: .7rem;
        }
        .plan-card.selected .plan-check { display: flex; }
        .form-control, .form-select {
            border-radius: 10px; border-color: #e2e8f0;
            padding: .65rem 1rem; font-size: .875rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #e63946; box-shadow: 0 0 0 3px rgba(230,57,70,.15);
        }
        .btn-register {
            background: #e63946; border: none; border-radius: 10px;
            color: #fff; font-weight: 600; padding: .8rem 2rem;
            font-size: .95rem; transition: all .2s;
        }
        .btn-register:hover { background: #c1121f; color: #fff; transform: translateY(-1px); }
        .input-group-text { border-radius: 10px 0 0 10px; background: #f8fafc; border-color: #e2e8f0; }
        .input-group .form-control { border-radius: 0 10px 10px 0; border-left: none; }
        .toggle-pw {
            border: 1px solid #e2e8f0; border-left: none;
            border-radius: 0 10px 10px 0; background: #f8fafc;
            color: #718096; cursor: pointer; padding: 0 .875rem;
        }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { font-size: .8rem; }
    </style>
</head>
<body>
<div class="container">
    <div class="register-card">
        <!-- Header -->
        <div class="register-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <span class="brand-icon"><i class="bi bi-lightning-charge-fill"></i></span>
                <div>
                    <div class="text-white fw-bold">FitLife Gym</div>
                    <div style="color:rgba(255,255,255,.5);font-size:.75rem">Create your member account</div>
                </div>
            </div>
            <a href="{{ route('member.login') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i>Back to Login
            </a>
        </div>

        <!-- Body -->
        <div class="register-body">
            @if($errors->any())
            <div class="alert alert-danger rounded-3 border-0 mb-4">
                <i class="bi bi-exclamation-circle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $e)<li class="small">{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('member.register.post') }}">
                @csrf

                <!-- Personal Info -->
                <div class="section-title"><i class="bi bi-person me-2"></i>Personal Information</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name') }}" placeholder="John" required>
                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name') }}" placeholder="Doe" required>
                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="john@email.com" required>
                        </div>
                        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control"
                               value="{{ old('date_of_birth') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select</option>
                            <option value="male"   {{ old('gender')=='male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female</option>
                            <option value="other"  {{ old('gender')=='other'  ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        {{-- spacer --}}
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small">Address</label>
                        <textarea name="address" class="form-control" rows="2"
                                  placeholder="Your full address...">{{ old('address') }}</textarea>
                    </div>
                </div>

                <!-- Password -->
                <div class="section-title"><i class="bi bi-lock me-2"></i>Account Security</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" id="pw1"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 characters" required>
                            <button type="button" class="toggle-pw" onclick="togglePw('pw1','icon1')">
                                <i class="bi bi-eye" id="icon1"></i>
                            </button>
                        </div>
                        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill text-muted"></i></span>
                            <input type="password" name="password_confirmation" id="pw2"
                                   class="form-control" placeholder="Repeat password" required>
                            <button type="button" class="toggle-pw" onclick="togglePw('pw2','icon2')">
                                <i class="bi bi-eye" id="icon2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Choose Plan -->
                <div class="section-title"><i class="bi bi-tags me-2"></i>Choose a Membership Plan <span class="text-muted fw-normal">(optional)</span></div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <div class="plan-card" onclick="selectPlan(null)" id="plan-none">
                            <input type="radio" name="plan_id" value="" checked>
                            <div class="plan-name text-muted">No plan yet</div>
                            <div class="small text-muted mt-1">I'll choose a plan later</div>
                        </div>
                    </div>
                    @foreach($plans as $plan)
                    <div class="col-md-6">
                        <div class="plan-card" onclick="selectPlan({{ $plan->id }})" id="plan-{{ $plan->id }}">
                            <input type="radio" name="plan_id" value="{{ $plan->id }}"
                                   {{ old('plan_id') == $plan->id ? 'checked' : '' }}>
                            <div class="plan-check"><i class="bi bi-check"></i></div>
                            <div class="plan-name">{{ $plan->name }}</div>
                            <div class="plan-price mt-1">{{ $plan->formatted_price }}</div>
                            <div class="text-muted small mt-1">
                                {{ $plan->duration_months }} month{{ $plan->duration_months > 1 ? 's' : '' }}
                                · {{ $plan->max_classes == 0 ? 'Unlimited classes' : $plan->max_classes . ' classes/mo' }}
                                @if($plan->personal_trainer) · <i class="bi bi-person-check text-success"></i> PT @endif
                            </div>
                            <div class="small text-muted mt-1">{{ $plan->description }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-muted small">
                        Already have an account?
                        <a href="{{ route('member.login') }}" style="color:#e63946" class="fw-semibold">Sign in</a>
                    </div>
                    <button type="submit" class="btn-register">
                        <i class="bi bi-person-plus me-2"></i>Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePw(id, iconId) {
    const i = document.getElementById(id);
    const icon = document.getElementById(iconId);
    i.type = i.type === 'password' ? 'text' : 'password';
    icon.className = i.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

function selectPlan(planId) {
    // Remove selected from all
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
    if (planId === null) {
        document.getElementById('plan-none').classList.add('selected');
        document.querySelector('input[name=plan_id][value=""]').checked = true;
    } else {
        document.getElementById('plan-' + planId).classList.add('selected');
        document.querySelector('input[name=plan_id][value="' + planId + '"]').checked = true;
    }
}

// Restore selection on page load (e.g. after validation error)
const oldPlan = '{{ old('plan_id') }}';
if (oldPlan) selectPlan(parseInt(oldPlan));
else selectPlan(null);
</script>
</body>
</html>
