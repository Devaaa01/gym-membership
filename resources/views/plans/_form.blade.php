@if($errors->any())
<div class="alert alert-danger rounded-3 mb-4">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Plan Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $plan->name ?? '') }}" placeholder="e.g. Gold, Silver, Basic" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"
                  placeholder="Describe what's included in this plan...">{{ old('description', $plan->description ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Price (Rp) <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price', $plan->price ?? '') }}" min="0" step="1000" required>
        </div>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Duration (Months) <span class="text-danger">*</span></label>
        <input type="number" name="duration_months" class="form-control @error('duration_months') is-invalid @enderror"
               value="{{ old('duration_months', $plan->duration_months ?? 1) }}" min="1" max="24" required>
        @error('duration_months')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Max Classes / Month</label>
        <input type="number" name="max_classes" class="form-control"
               value="{{ old('max_classes', $plan->max_classes ?? 0) }}" min="0">
        <div class="form-text">Set 0 for unlimited classes.</div>
    </div>
    <div class="col-md-6 d-flex flex-column justify-content-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="personal_trainer" id="personal_trainer" value="1"
                   {{ old('personal_trainer', $plan->personal_trainer ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="personal_trainer">Includes Personal Trainer</label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $plan->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Plan is Active</label>
        </div>
    </div>
</div>
