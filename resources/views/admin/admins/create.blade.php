@extends('layouts.app')
@section('title', 'Add Admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">Admin Accounts</a></li>
    <li class="breadcrumb-item active">Add Admin</li>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-person-plus-fill me-2 text-danger"></i>Add Admin Account</h1>
    <p>Create a new staff or administrator account</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger rounded-3 border-0 mb-4">
                    <ul class="mb-0 ps-3 small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <form action="{{ route('admin.admins.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="e.g. John Smith" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="staff@fitlife.com" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 8 chars, mixed case + numbers" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Repeat password" required>
                    </div>

                    <div class="alert alert-info rounded-3 border-0 small mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Password must be at least 8 characters with mixed case and numbers.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i>Create Admin
                        </button>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
