@extends('layouts.app')
@section('title', 'Edit Booking')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="page-header"><h1><i class="bi bi-pencil-square me-2 text-danger"></i>Edit Booking</h1></div>
<div class="row justify-content-center"><div class="col-lg-7">
    <div class="card"><div class="card-body p-4">
        @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif

        <!-- Info -->
        <div class="alert alert-light border rounded-3 mb-4">
            <div class="small fw-semibold">{{ $booking->member->full_name }}</div>
            <div class="small text-muted">{{ $booking->gymClass->name }} — {{ $booking->gymClass->schedule->format('d M Y H:i') }}</div>
        </div>

        <form action="{{ route('bookings.update', $booking) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['booked','attended','cancelled','no_show'] as $s)
                        <option value="{{ $s }}" {{ old('status', $booking->status) == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $booking->notes) }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Update</button>
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div></div>
</div></div>
@endsection
