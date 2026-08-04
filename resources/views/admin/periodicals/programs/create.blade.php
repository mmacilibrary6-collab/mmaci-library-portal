@extends('layouts.admin')
@section('title', 'Add Periodical Program')
@section('page-title', 'Add Periodical Program')
@section('content')
<div class="container-fluid donated-book-form-page"><div class="create-page-container"><section class="create-header"><div class="header-content"><span class="header-icon"><i class="bi bi-newspaper"></i></span><div><span class="header-eyebrow">Collection Management</span><h2>Add Periodical Program</h2><p>Create a new program group for periodicals.</p></div></div><a href="{{ route('admin.periodical-programs.index') }}" class="back-button"><i class="bi bi-arrow-left"></i><span>Back to Programs</span></a></section><form action="{{ route('admin.periodical-programs.store') }}" method="POST" enctype="multipart/form-data" novalidate>@csrf @include('admin.periodicals.programs._form')</form></div></div>
@endsection

@push('styles')
    @include('admin.periodicals._styles')
@endpush
