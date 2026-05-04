@extends('layouts.app')
@section('title', 'Edit Admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Admin Accounts</a></li>
    <li class="breadcrumb-item active">Edit Admin</li>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-person-gear me-2 text-danger"></i>Edit Admin Account</h1>
    <p>Update name, email, or reset password</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">

                {{-- Avatar --}}
                <div class="d-flex align-items-center gap-3 mb-4 pb-4" style="border-bottom:1px solid var(--bs-border-color)">
                    @if($admin->photo)
                        <img src="{{ asset('storage/' . $admin->photo) }}"
                             class="rounded-circle"
                             style="width:52px;height:52px;object-fit:cover;border:2px solid #e63946" alt="">
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                             style="width:52px;height:52px;min-width:52px;background:#e63946;color:#fff;font-size:1.3rem">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="fw-semibold">{{ $admin->name }}</div>
                        <div class="text-muted small">{{ $admin->email }}</div>
                        @if($admin->id === auth()->id())
                            <span class="badge bg-danger-subtle text-danger rounded-pill mt-1" style="font-size:.65rem">You</span>
                        @endif
                    </div>
                </div>

                @if($errors->any())
                <div class="alert alert-danger rounded-3 border-0 mb-4">
                    <ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('admin.admins.update', $admin) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $admin->name) }}"
                               placeholder="e.g. John Smith" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $admin->email) }}"
                               placeholder="staff@fitlife.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Password section --}}
                    <div class="p-3 rounded-3 mb-4" style="border:1px solid var(--bs-border-color)">
                        <div class="small fw-semibold mb-3">
                            <i class="bi bi-lock me-1 text-danger"></i>Change Password
                            <span class="text-muted fw-normal ms-1">(leave blank to keep current)</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 chars, mixed case + numbers"
                                   autocomplete="new-password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Repeat new password"
                                   autocomplete="new-password">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Save Changes
                        </button>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
