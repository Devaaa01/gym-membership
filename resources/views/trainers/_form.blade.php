@if($errors->any())
<div class="alert alert-danger rounded-3 mb-4">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
               value="{{ old('first_name', $trainer->first_name ?? '') }}" required>
        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Last Name <span class="text-danger">*</span></label>
        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
               value="{{ old('last_name', $trainer->last_name ?? '') }}" required>
        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $trainer->email ?? '') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $trainer->phone ?? '') }}">
    </div>
    <div class="col-md-8">
        <label class="form-label">Specialization <span class="text-danger">*</span></label>
        <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror"
               value="{{ old('specialization', $trainer->specialization ?? '') }}"
               placeholder="e.g. Yoga, Strength & Conditioning, HIIT" required>
        @error('specialization')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $trainer->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active Trainer</label>
        </div>
    </div>
    <div class="col-12">
        <label class="form-label">Bio</label>
        <textarea name="bio" class="form-control" rows="3"
                  placeholder="Brief description of trainer's background and expertise...">{{ old('bio', $trainer->bio ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Photo</label>
        <input type="file" name="photo" class="form-control" accept="image/*">
        <div class="form-text">JPG, PNG. Max 2MB.</div>
    </div>
    @if(isset($trainer) && $trainer->photo)
    <div class="col-md-6 d-flex align-items-center">
        <img src="{{ asset('storage/'.$trainer->photo) }}" class="rounded-3" style="height:80px;width:80px;object-fit:cover" alt="">
        <span class="ms-3 text-muted small">Current photo</span>
    </div>
    @endif
</div>
