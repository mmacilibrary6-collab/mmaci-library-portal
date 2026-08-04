@extends('layouts.admin')

@section('title', 'Add Donated Book')
@section('page-title', 'Add Donated Book')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">Add Donated Book</h2>
            <p class="text-muted mb-0">Upload the book cover and add a description.</p>
        </div>

        <a href="{{ route('admin.donated-books.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.donated-books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.donated-books._form')
    </form>
</div>
@endsection
