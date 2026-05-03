@extends('layouts.app')
@section('title', 'Add Member')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('members.index') }}">Members</a></li>
    <li class="breadcrumb-item active">Add Member</li>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="bi bi-person-plus-fill me-2 text-danger"></i>Add New Member</h1>
    <p>Register a new gym member</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('members._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Save Member</button>
                        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
