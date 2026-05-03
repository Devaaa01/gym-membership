@extends('layouts.app')
@section('title', 'New Booking')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection
@section('content')
<div class="page-header"><h1><i class="bi bi-bookmark-plus-fill me-2 text-danger"></i>New Class Booking</h1></div>
<div class="row justify-content-center"><div class="col-lg-7">
    <div class="card"><div class="card-body p-4">
        @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif
        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Member <span class="text-danger">*</span></label>
                    <select name="member_id" class="form-select" required>
                        <option value="">Select Member</option>
                        @foreach($members as $m)
                        <option value="{{ $m->id }}" {{ old('member_id', $selectedMember?->id) == $m->id ? 'selected' : '' }}>
                            {{ $m->full_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Class <span class="text-danger">*</span></label>
                    <select name="class_id" class="form-select" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ old('class_id', $selectedClass?->id) == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} — {{ $c->schedule->format('d M H:i') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['booked','attended','cancelled','no_show'] as $s)
                        <option value="{{ $s }}" {{ old('status','booked') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Book</button>
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div></div>
</div></div>
@endsection
