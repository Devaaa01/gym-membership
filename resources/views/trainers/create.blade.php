@extends('layouts.app')
@section('title', 'Add Trainer')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('trainers.index') }}">Trainers</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection
@section('content')
<div class="page-header"><h1><i class="bi bi-person-plus-fill me-2 text-danger"></i>Add Trainer</h1></div>
<div class="row justify-content-center"><div class="col-lg-7">
    <div class="card"><div class="card-body p-4">
        <form action="{{ route('trainers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('trainers._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Save Trainer</button>
                <a href="{{ route('trainers.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div></div>
</div></div>
@endsection
