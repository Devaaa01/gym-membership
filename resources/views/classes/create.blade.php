@extends('layouts.app')
@section('title', 'Schedule Class')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
    <li class="breadcrumb-item active">Schedule</li>
@endsection
@section('content')
<div class="page-header"><h1><i class="bi bi-calendar-plus-fill me-2 text-danger"></i>Schedule New Class</h1></div>
<div class="row justify-content-center"><div class="col-lg-8">
    <div class="card"><div class="card-body p-4">
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            @include('classes._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Schedule Class</button>
                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div></div>
</div></div>
@endsection
