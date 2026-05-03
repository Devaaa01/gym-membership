@extends('layouts.app')
@section('title', 'Edit Plan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Plans</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-pencil-square me-2 text-danger"></i>Edit Plan: {{ $plan->name }}</h1>
</div>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('plans.update', $plan) }}" method="POST">
                    @csrf @method('PUT')
                    @include('plans._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Update Plan</button>
                        <a href="{{ route('plans.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
