@extends('layouts.app')
@section('title', $trainer->full_name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('trainers.index') }}">Trainers</a></li>
    <li class="breadcrumb-item active">{{ $trainer->full_name }}</li>
@endsection
@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-person-badge-fill me-2 text-danger"></i>{{ $trainer->full_name }}</h1>
        <p>{{ $trainer->specialization }}</p>
    </div>
    <a href="{{ route('trainers.edit', $trainer) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i>Edit</a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center p-4">
            @if($trainer->photo)
                <img src="{{ asset('storage/'.$trainer->photo) }}" class="rounded-circle mx-auto mb-3"
                     style="width:100px;height:100px;object-fit:cover" alt="">
            @else
                <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold"
                     style="width:100px;height:100px;background:#e63946;color:#fff;font-size:2.5rem">
                    {{ strtoupper(substr($trainer->first_name,0,1)) }}
                </div>
            @endif
            <h5 class="fw-bold mb-1">{{ $trainer->full_name }}</h5>
            <p class="text-muted small mb-2">{{ $trainer->specialization }}</p>
            <span class="badge {{ $trainer->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2 mb-3">
                {{ $trainer->is_active ? 'Active' : 'Inactive' }}
            </span>
            @if($trainer->bio)<p class="text-muted small">{{ $trainer->bio }}</p>@endif
            <hr>
            <div class="text-start small">
                <div class="mb-1"><i class="bi bi-envelope text-muted me-2"></i>{{ $trainer->email }}</div>
                @if($trainer->phone)<div><i class="bi bi-telephone text-muted me-2"></i>{{ $trainer->phone }}</div>@endif
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-calendar3 me-2 text-danger"></i>Classes ({{ $trainer->classes->count() }})</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th class="ps-3">Class</th><th>Category</th><th>Schedule</th><th>Capacity</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($trainer->classes as $class)
                    <tr>
                        <td class="ps-3 fw-semibold small"><a href="{{ route('classes.show', $class) }}">{{ $class->name }}</a></td>
                        <td class="small">{{ $class->category }}</td>
                        <td class="small">{{ $class->schedule->format('d M Y H:i') }}</td>
                        <td class="small">{{ $class->bookings->count() }}/{{ $class->max_capacity }}</td>
                        <td><span class="badge badge-{{ $class->status }} rounded-pill">{{ ucfirst($class->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted small">No classes assigned.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
