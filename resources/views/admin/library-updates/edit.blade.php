@extends('layouts.admin')

@section('title', 'Edit Library Update')
@section('page-title', 'Edit Library Update')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">Edit Library Update</h2>
            <p class="text-muted mb-0">Update the slideshow slide shown on the home page.</p>
        </div>

        <a href="{{ route('admin.library-updates.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.library-updates.update', $libraryUpdate) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.library-updates._form', ['libraryUpdate' => $libraryUpdate])
    </form>
</div>
@endsection
