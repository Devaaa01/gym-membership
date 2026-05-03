@if($errors->any())
<div class="alert alert-danger rounded-3 mb-4">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Member <span class="text-danger">*</span></label>
        <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required
                {{ isset($payment) ? 'disabled' : '' }}>
            <option value="">Select Member</option>
            @foreach($members as $m)
            <option value="{{ $m->id }}" {{ old('member_id', $payment->member_id ?? $selectedMembership?->member_id) == $m->id ? 'selected' : '' }}>
                {{ $m->full_name }}
            </option>
            @endforeach
        </select>
        @isset($payment)<input type="hidden" name="member_id" value="{{ $payment->member_id }}">@endisset
        @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Membership <span class="text-danger">*</span></label>
        <select name="membership_id" class="form-select @error('membership_id') is-invalid @enderror" required
                {{ isset($payment) ? 'disabled' : '' }}>
            <option value="">Select Membership</option>
            @foreach($memberships as $ms)
            <option value="{{ $ms->id }}" {{ old('membership_id', $payment->membership_id ?? $selectedMembership?->id) == $ms->id ? 'selected' : '' }}>
                {{ $ms->member->full_name }} — {{ $ms->plan->name }} ({{ $ms->start_date->format('M Y') }})
            </option>
            @endforeach
        </select>
        @isset($payment)<input type="hidden" name="membership_id" value="{{ $payment->membership_id }}">@endisset
        @error('membership_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Amount (Rp) <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                   value="{{ old('amount', $payment->amount ?? $selectedMembership?->plan->price ?? '') }}" min="0" step="1000" required>
        </div>
        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Payment Method <span class="text-danger">*</span></label>
        <select name="payment_method" class="form-select" required>
            @foreach(['cash','credit_card','debit_card','bank_transfer','e_wallet'] as $m)
            <option value="{{ $m }}" {{ old('payment_method', $payment->payment_method ?? 'cash') == $m ? 'selected' : '' }}>
                {{ ucwords(str_replace('_',' ',$m)) }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Payment Date <span class="text-danger">*</span></label>
        <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror"
               value="{{ old('payment_date', isset($payment->payment_date) ? $payment->payment_date->format('Y-m-d') : date('Y-m-d')) }}" required>
        @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
            @foreach(['paid','pending','failed','refunded'] as $s)
            <option value="{{ $s }}" {{ old('status', $payment->status ?? 'paid') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $payment->notes ?? '') }}</textarea>
    </div>
</div>
