@extends('layouts.admin')

@section('title', 'Edit Donated Book')
@section('page-title', 'Edit Donated Book')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">Edit Donated Book</h2>
            <p class="text-muted mb-0">Update the cover image and description.</p>
        </div>

        <a href="{{ route('admin.donated-books.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.donated-books.update', $donatedBook) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.donated-books._form', ['donatedBook' => $donatedBook])
    </form>
</div>
@endsection
