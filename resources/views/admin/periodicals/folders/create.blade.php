@extends('layouts.admin')
@section('title', 'Add Periodical Folder')
@section('page-title', 'Add Periodical Folder')
@section('content')
<div class="container-fluid donated-book-form-page"><div class="create-page-container"><section class="create-header"><div class="header-content"><span class="header-icon"><i class="bi bi-folder-plus"></i></span><div><span class="header-eyebrow">Collection Management</span><h2>Add Periodical Folder</h2><p>Create a new folder link inside a periodical program.</p></div></div><a href="{{ route('admin.periodical-folders.index') }}" class="back-button"><i class="bi bi-arrow-left"></i><span>Back to Folders</span></a></section><form action="{{ route('admin.periodical-folders.store') }}" method="POST" novalidate>@csrf @include('admin.periodicals.folders._form')</form></div></div>
@endsection

@push('styles')
    @include('admin.periodicals._styles')
@endpush
