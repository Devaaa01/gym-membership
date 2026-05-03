@extends('layouts.app')
@section('title', 'Booking Detail')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
    <li class="breadcrumb-item active">#{{ $booking->id }}</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <h1><i class="bi bi-bookmark-check-fill me-2 text-danger"></i>Booking #{{ $booking->id }}</h1>
    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
</div>
<div class="row justify-content-center"><div class="col-lg-6">
    <div class="card"><div class="card-body">
        <dl class="row small">
            <dt class="col-4 text-muted">Member</dt>
            <dd class="col-8 fw-semibold">{{ $booking->member->full_name }}</dd>
            <dt class="col-4 text-muted">Class</dt>
            <dd class="col-8">{{ $booking->gymClass->name }}</dd>
            <dt class="col-4 text-muted">Trainer</dt>
            <dd class="col-8">{{ $booking->gymClass->trainer->full_name }}</dd>
            <dt class="col-4 text-muted">Schedule</dt>
            <dd class="col-8">{{ $booking->gymClass->schedule->format('d M Y H:i') }}</dd>
            <dt class="col-4 text-muted">Status</dt>
            <dd class="col-8"><span class="badge badge-{{ $booking->status }} rounded-pill">{{ ucfirst(str_replace('_',' ',$booking->status)) }}</span></dd>
            @if($booking->notes)
            <dt class="col-4 text-muted">Notes</dt>
            <dd class="col-8">{{ $booking->notes }}</dd>
            @endif
        </dl>
    </div></div>
</div></div>
@endsection
