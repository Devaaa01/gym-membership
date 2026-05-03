@if($errors->any())
<div class="alert alert-danger rounded-3 mb-4">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Class Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $class->name ?? '') }}" placeholder="e.g. Morning Yoga Flow" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Category <span class="text-danger">*</span></label>
        <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
               value="{{ old('category', $class->category ?? '') }}" placeholder="e.g. Yoga, Cardio" required>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Trainer <span class="text-danger">*</span></label>
        <select name="trainer_id" class="form-select @error('trainer_id') is-invalid @enderror" required>
            <option value="">Select Trainer</option>
            @foreach($trainers as $t)
            <option value="{{ $t->id }}" {{ old('trainer_id', $class->trainer_id ?? '') == $t->id ? 'selected' : '' }}>
                {{ $t->full_name }} — {{ $t->specialization }}
            </option>
            @endforeach
        </select>
        @error('trainer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Room</label>
        <input type="text" name="room" class="form-control" value="{{ old('room', $class->room ?? '') }}" placeholder="e.g. Studio A">
    </div>
    <div class="col-md-4">
        <label class="form-label">Schedule <span class="text-danger">*</span></label>
        <input type="datetime-local" name="schedule" class="form-control @error('schedule') is-invalid @enderror"
               value="{{ old('schedule', isset($class->schedule) ? $class->schedule->format('Y-m-d\TH:i') : '') }}" required>
        @error('schedule')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Duration (minutes) <span class="text-danger">*</span></label>
        <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $class->duration_minutes ?? 60) }}" min="15" max="240" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Max Capacity <span class="text-danger">*</span></label>
        <input type="number" name="max_capacity" class="form-control" value="{{ old('max_capacity', $class->max_capacity ?? 20) }}" min="1" max="200" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
            @foreach(['scheduled','completed','cancelled'] as $s)
            <option value="{{ $s }}" {{ old('status', $class->status ?? 'scheduled') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="2">{{ old('description', $class->description ?? '') }}</textarea>
    </div>
</div>
