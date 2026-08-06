@extends('layouts.admin')

@section('title', 'Add Library Update')
@section('page-title', 'Add Library Update')

@section('content')
<div class="container-fluid library-updates-page">
    <section class="updates-hero">
        <div class="hero-copy">
            <span class="hero-icon">
                <i class="bi bi-megaphone-fill"></i>
            </span>

            <div>
                <span class="hero-eyebrow">Website Content</span>
                <h2>Add Library Update</h2>
                <p>Create a new slideshow slide for the home page.</p>
            </div>
        </div>

        <a
            href="{{ route('admin.library-updates.index') }}"
            class="btn-back-list">

            <i class="bi bi-arrow-left"></i>
            Back to List
        </a>
    </section>

    <section class="updates-panel">
        <form
            action="{{ route('admin.library-updates.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            @include('admin.library-updates._form')
        </form>
    </section>
</div>
@endsection