@extends('layouts.app')
@section('title', $class->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item active">{{ $class->name }}</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-calendar3 me-2 text-danger"></i>{{ $class->name }}</h1>
        <p>{{ $class->category }} · {{ $class->trainer->full_name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('bookings.create', ['class_id' => $class->id]) }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Book Member</a>
        <a href="{{ route('classes.edit', $class) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-3 border-bottom pb-2">Class Details</h6>
                <dl class="row small mb-0">
                    <dt class="col-5 text-muted">Trainer</dt>
                    <dd class="col-7"><a href="{{ route('trainers.show', $class->trainer) }}">{{ $class->trainer->full_name }}</a></dd>
                    <dt class="col-5 text-muted">Category</dt>
                    <dd class="col-7">{{ $class->category }}</dd>
                    <dt class="col-5 text-muted">Schedule</dt>
                    <dd class="col-7">{{ $class->schedule->format('d M Y H:i') }}</dd>
                    <dt class="col-5 text-muted">Duration</dt>
                    <dd class="col-7">{{ $class->duration_minutes }} minutes</dd>
                    <dt class="col-5 text-muted">Room</dt>
                    <dd class="col-7">{{ $class->room ?? '—' }}</dd>
                    <dt class="col-5 text-muted">Capacity</dt>
                    <dd class="col-7">{{ $class->bookings->count() }} / {{ $class->max_capacity }}</dd>
                    <dt class="col-5 text-muted">Status</dt>
                    <dd class="col-7"><span class="badge badge-{{ $class->status }} rounded-pill">{{ ucfirst($class->status) }}</span></dd>
                </dl>
                @if($class->description)
                <hr>
                <p class="small text-muted mb-0">{{ $class->description }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-people me-2 text-danger"></i>Participants ({{ $class->bookings->count() }})</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th class="ps-3">Member</th><th>Status</th><th>Booked At</th><th></th></tr></thead>
                    <tbody>
                    @forelse($class->bookings as $booking)
                    <tr>
                        <td class="ps-3">
                            <div class="fw-semibold small">{{ $booking->member->full_name }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $booking->member->email }}</div>
                        </td>
                        <td><span class="badge badge-{{ $booking->status }} rounded-pill">{{ ucfirst(str_replace('_',' ',$booking->status)) }}</span></td>
                        <td class="small text-muted">{{ $booking->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted small">No bookings yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
