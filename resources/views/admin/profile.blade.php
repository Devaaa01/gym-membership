@extends('layouts.app')
@section('title', 'My Profile')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">My Profile</li>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-person-circle me-2 text-danger"></i>My Profile</h1>
    <p>Update your profile photo</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body p-4">

                {{-- Current photo --}}
                <div class="text-center mb-4">
                    @if($admin->photo)
                        <img src="{{ asset('storage/' . $admin->photo) }}"
                             alt="{{ $admin->name }}"
                             id="photoPreview"
                             class="rounded-circle object-fit-cover mb-3"
                             style="width:100px;height:100px;object-fit:cover;border:3px solid #e63946">
                    @else
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold"
                             id="photoInitial"
                             style="width:100px;height:100px;background:#e63946;color:#fff;font-size:2.2rem">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                        <img src="" alt="" id="photoPreview"
                             class="rounded-circle d-none mx-auto mb-3"
                             style="width:100px;height:100px;object-fit:cover;border:3px solid #e63946;display:none!important">
                    @endif
                    <div class="fw-semibold">{{ $admin->name }}</div>
                    <div class="text-muted small">{{ $admin->email }}</div>
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    @if(session('success'))
                    <div class="alert alert-success rounded-3 border-0 mb-3 small">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 mb-3 small">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" name="photo" id="photoInput"
                               class="form-control" accept="image/*">
                        <div class="form-text">JPG, PNG or WebP · Max 2MB</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-upload me-2"></i>Save Photo
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('photoInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const preview = document.getElementById('photoPreview');
        const initial = document.getElementById('photoInitial');
        const reader  = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            preview.classList.remove('d-none');
            if (initial) initial.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
