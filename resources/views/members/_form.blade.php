@if($errors->any())
<div class="alert alert-danger rounded-3 mb-4">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<h6 class="fw-semibold text-muted mb-3 border-bottom pb-2">Personal Information</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
               value="{{ old('first_name', $member->first_name ?? '') }}" required>
        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Last Name <span class="text-danger">*</span></label>
        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
               value="{{ old('last_name', $member->last_name ?? '') }}" required>
        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $member->email ?? '') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $member->phone ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control"
               value="{{ old('date_of_birth', isset($member->date_of_birth) ? $member->date_of_birth->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="male"   {{ old('gender', $member->gender ?? '') == 'male'   ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender', $member->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other"  {{ old('gender', $member->gender ?? '') == 'other'  ? 'selected' : '' }}>Other</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="active"    {{ old('status', $member->status ?? 'active') == 'active'    ? 'selected' : '' }}>Active</option>
            <option value="inactive"  {{ old('status', $member->status ?? '') == 'inactive'  ? 'selected' : '' }}>Inactive</option>
            <option value="suspended" {{ old('status', $member->status ?? '') == 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="2">{{ old('address', $member->address ?? '') }}</textarea>
    </div>
</div>

<h6 class="fw-semibold text-muted mb-3 border-bottom pb-2">Emergency Contact</h6>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label class="form-label">Contact Name</label>
        <input type="text" name="emergency_contact_name" class="form-control"
               value="{{ old('emergency_contact_name', $member->emergency_contact_name ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Contact Phone</label>
        <input type="text" name="emergency_contact_phone" class="form-control"
               value="{{ old('emergency_contact_phone', $member->emergency_contact_phone ?? '') }}">
    </div>
</div>

<h6 class="fw-semibold text-muted mb-3 border-bottom pb-2">Photo</h6>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Profile Photo</label>
        <input type="file" name="photo" class="form-control" accept="image/*">
        <div class="form-text">JPG, PNG. Max 2MB.</div>
    </div>
    @if(isset($member) && $member->photo)
    <div class="col-md-6 d-flex align-items-center">
        <img src="{{ asset('storage/'.$member->photo) }}" alt="Current photo"
             class="rounded-3" style="height:80px;width:80px;object-fit:cover">
        <span class="ms-3 text-muted small">Current photo</span>
    </div>
    @endif
</div>
