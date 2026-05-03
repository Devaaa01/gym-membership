@extends('layouts.app')
@section('title', 'Admin Accounts')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Admin Accounts</li>
@endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h1><i class="bi bi-shield-lock-fill me-2 text-danger"></i>Admin Accounts</h1>
        <p>Manage staff and administrator access</p>
    </div>
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Admin
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th class="ps-4">Admin</th>
                <th>Email</th>
                <th>Created</th>
                <th class="text-end pe-4">Actions</th>
            </tr></thead>
            <tbody>
            @foreach($admins as $admin)
            <tr>
                <td class="ps-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                             style="width:36px;height:36px;background:{{ $admin->id === auth()->id() ? '#e63946' : '#6366f1' }};color:#fff;font-size:.875rem;min-width:36px">
                            {{ strtoupper(substr($admin->name,0,1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold small">{{ $admin->name }}</div>
                            @if($admin->id === auth()->id())
                            <span class="badge bg-danger-subtle text-danger rounded-pill" style="font-size:.65rem">You</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="small text-muted">{{ $admin->email }}</td>
                <td class="small text-muted">{{ $admin->created_at->format('d M Y') }}</td>
                <td class="text-end pe-4">
                    @if($admin->id !== auth()->id())
                    <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete admin account for {{ $admin->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                    @else
                    <span class="text-muted small">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
