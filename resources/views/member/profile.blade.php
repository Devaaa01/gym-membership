@extends('layouts.member')
@section('title', 'My Profile')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-person-circle me-2 text-danger"></i>My Profile</h1>
    <p>Manage your personal information and password</p>
</div>

<div class="row g-4">
    <!-- Profile info -->
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-danger"></i>Personal Information</h6>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger rounded-3 border-0 mb-3">
                    <ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form method="POST" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- ── Profile photo upload ── --}}
                    <div class="mb-4 d-flex align-items-center gap-4">
                        <div class="position-relative" style="flex-shrink:0">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}"
                                     alt="Profile photo"
                                     id="photoPreview"
                                     class="rounded-circle object-fit-cover"
                                     style="width:80px;height:80px;object-fit:cover;border:3px solid #e63946">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                     id="photoInitial"
                                     style="width:80px;height:80px;background:#e63946;color:#fff;font-size:1.8rem;flex-shrink:0">
                                    {{ strtoupper(substr($member->first_name,0,1)) }}
                                </div>
                                <img src="" alt="" id="photoPreview"
                                     class="rounded-circle object-fit-cover d-none"
                                     style="width:80px;height:80px;object-fit:cover;border:3px solid #e63946">
                            @endif
                            <label for="photoInput"
                                   class="position-absolute bottom-0 end-0 d-flex align-items-center justify-content-center rounded-circle"
                                   style="width:26px;height:26px;background:#e63946;cursor:pointer;border:2px solid #fff"
                                   title="Change photo">
                                <i class="bi bi-camera-fill text-white" style="font-size:.65rem"></i>
                            </label>
                        </div>
                        <div>
                            <div class="fw-semibold small" style="color:var(--text-primary)">Profile Photo</div>
                            <div class="text-muted" style="font-size:.78rem">JPG, PNG or WebP · Max 2MB</div>
                            <label for="photoInput" class="btn btn-sm btn-outline-secondary mt-1" style="font-size:.78rem">
                                <i class="bi bi-upload me-1"></i>Upload Photo
                            </label>
                        </div>
                        <input type="file" name="photo" id="photoInput" accept="image/*" class="d-none">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ old('first_name', $member->first_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control"
                                   value="{{ old('last_name', $member->last_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $member->email }}" disabled>
                            <div class="form-text">Email cannot be changed. Contact staff.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $member->phone) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control"
                                   value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select</option>
                                @foreach(['male','female','other'] as $g)
                                <option value="{{ $g }}" {{ old('gender', $member->gender) == $g ? 'selected' : '' }}>
                                    {{ ucfirst($g) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $member->address) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Emergency Contact Name</label>
                            <input type="text" name="emergency_contact_name" class="form-control"
                                   value="{{ old('emergency_contact_name', $member->emergency_contact_name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Emergency Contact Phone</label>
                            <input type="text" name="emergency_contact_phone" class="form-control"
                                   value="{{ old('emergency_contact_phone', $member->emergency_contact_phone) }}">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right column -->
    <div class="col-lg-5">
        <!-- Member card -->
        <div class="card mb-4" style="background:linear-gradient(135deg,#1a1a2e,#16213e)">
            <div class="card-body p-4 text-center">
                @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}"
                         alt="{{ $member->full_name }}"
                         class="rounded-circle mx-auto mb-3 d-block object-fit-cover"
                         style="width:72px;height:72px;object-fit:cover;border:3px solid #e63946">
                @else
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold"
                         style="width:72px;height:72px;background:#e63946;color:#fff;font-size:1.8rem">
                        {{ strtoupper(substr($member->first_name,0,1)) }}
                    </div>
                @endif
                <div class="text-white fw-bold fs-5">{{ $member->full_name }}</div>
                <div class="text-white opacity-50 small mb-3">{{ $member->email }}</div>
                <span class="badge badge-{{ $member->status }} rounded-pill px-3 py-2">{{ ucfirst($member->status) }}</span>
                @if($member->activeMembership)
                <div class="mt-3 pt-3" style="border-top:1px solid rgba(255,255,255,.1)">
                    <div class="text-white small fw-semibold">{{ $member->activeMembership->plan->name }}</div>
                    <div class="text-white opacity-50" style="font-size:.75rem">
                        Expires {{ $member->activeMembership->end_date->format('d M Y') }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Change password -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-lock me-2 text-danger"></i>Change Password</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('member.password.update') }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               placeholder="••••••••" required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 8 characters" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" placeholder="Repeat new password" required>
                    </div>
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-shield-lock me-1"></i>Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Live preview when a photo is selected
    document.getElementById('photoInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const preview = document.getElementById('photoPreview');
        const initial = document.getElementById('photoInitial');
        const reader  = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (initial) initial.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
