@extends('layouts.admin')

@section('title', 'Add Library Update')
@section('page-title', 'Add Library Update')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">Add Library Update</h2>
            <p class="text-muted mb-0">Create a slideshow slide for the home page.</p>
        </div>

        <a href="{{ route('admin.library-updates.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.library-updates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.library-updates._form')
    </form>
</div>
@endsection
