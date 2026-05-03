@extends('layouts.app')
@section('title', 'Edit Payment')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="page-header"><h1><i class="bi bi-pencil-square me-2 text-danger"></i>Edit Payment</h1></div>
<div class="row justify-content-center"><div class="col-lg-8">
    <div class="card"><div class="card-body p-4">
        <form action="{{ route('payments.update', $payment) }}" method="POST">
            @csrf @method('PUT')
            @php $selectedMembership = null; @endphp
            @include('payments._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Update Payment</button>
                <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div></div>
</div></div>
@endsection
