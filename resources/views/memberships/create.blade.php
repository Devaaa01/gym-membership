@extends('layouts.app')
@section('title', 'New Membership')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('memberships.index') }}">Memberships</a></li>
    <li class="breadcrumb-item active">New</li>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-plus-circle-fill me-2 text-danger"></i>New Membership</h1>
</div>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('memberships.store') }}" method="POST">
                    @csrf
                    @include('memberships._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Create Membership</button>
                        <a href="{{ route('memberships.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
