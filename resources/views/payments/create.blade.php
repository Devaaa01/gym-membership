@extends('layouts.app')
@section('title', 'Record Payment')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
    <li class="breadcrumb-item active">Record</li>
@endsection
@section('content')
<div class="page-header"><h1><i class="bi bi-plus-circle-fill me-2 text-danger"></i>Record Payment</h1></div>
<div class="row justify-content-center"><div class="col-lg-8">
    <div class="card"><div class="card-body p-4">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            @include('payments._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Record Payment</button>
                <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div></div>
</div></div>
@endsection
