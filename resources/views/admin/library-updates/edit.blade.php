@extends('layouts.admin')

@section('title', 'Edit Library Update')
@section('page-title', 'Edit Library Update')

@section('content')
<div class="container-fluid library-update-form-page">
    <section class="updates-hero">
        <div class="hero-copy">
            <span class="hero-icon">
                <i class="bi bi-pencil-square"></i>
            </span>

            <div>
                <span class="hero-eyebrow">Website Content</span>
                <h2>Edit Library Update</h2>
                <p>Update the slideshow slide shown on the home page.</p>
            </div>
        </div>

        <a
            href="{{ route('admin.library-updates.index') }}"
            class="btn-back-list">

            <i class="bi bi-arrow-left"></i>
            Back to List
        </a>
    </section>

    <form
        action="{{ route('admin.library-updates.update', $libraryUpdate) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('admin.library-updates._form', [
            'libraryUpdate' => $libraryUpdate
        ])
    </form>
</div>
@endsection