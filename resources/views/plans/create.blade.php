@extends('layouts.app')
@section('title', 'Create Plan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Plans</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-plus-circle-fill me-2 text-danger"></i>Create Membership Plan</h1>
</div>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('plans.store') }}" method="POST">
                    @csrf
                    @include('plans._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Create Plan</button>
                        <a href="{{ route('plans.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
