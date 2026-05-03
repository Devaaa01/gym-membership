@if($errors->any())
<div class="alert alert-danger rounded-3 mb-4">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Member <span class="text-danger">*</span></label>
        <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
            <option value="">Select Member</option>
            @foreach($members as $m)
            <option value="{{ $m->id }}" {{ old('member_id', $membership->member_id ?? $selectedMember?->id) == $m->id ? 'selected' : '' }}>
                {{ $m->full_name }} — {{ $m->email }}
            </option>
            @endforeach
        </select>
        @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Plan <span class="text-danger">*</span></label>
        <select name="plan_id" class="form-select @error('plan_id') is-invalid @enderror" required>
            <option value="">Select Plan</option>
            @foreach($plans as $p)
            <option value="{{ $p->id }}" {{ old('plan_id', $membership->plan_id ?? '') == $p->id ? 'selected' : '' }}>
                {{ $p->name }} — {{ $p->formatted_price }} / {{ $p->duration_months }}mo
            </option>
            @endforeach
        </select>
        @error('plan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Start Date <span class="text-danger">*</span></label>
        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
               value="{{ old('start_date', isset($membership->start_date) ? $membership->start_date->format('Y-m-d') : date('Y-m-d')) }}" required>
        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @isset($membership)
    <div class="col-md-4">
        <label class="form-label">End Date <span class="text-danger">*</span></label>
        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
               value="{{ old('end_date', $membership->end_date->format('Y-m-d')) }}" required>
        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @endisset
    <div class="col-md-4">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
            @foreach(['pending','active','expired','cancelled'] as $s)
            <option value="{{ $s }}" {{ old('status', $membership->status ?? 'pending') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $membership->notes ?? '') }}</textarea>
    </div>
</div>
