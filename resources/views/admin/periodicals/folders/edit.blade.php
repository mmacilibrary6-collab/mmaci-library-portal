@extends('layouts.admin')
@section('title', 'Edit Periodical Folder')
@section('page-title', 'Edit Periodical Folder')
@section('content')
<div class="container-fluid donated-book-form-page"><div class="create-page-container"><section class="create-header"><div class="header-content"><span class="header-icon"><i class="bi bi-pencil-square"></i></span><div><span class="header-eyebrow">Collection Management</span><h2>Edit Periodical Folder</h2><p>Update the details for <strong>{{ $periodicalFolder->title }}</strong>.</p></div></div><a href="{{ route('admin.periodical-folders.index') }}" class="back-button"><i class="bi bi-arrow-left"></i><span>Back to Folders</span></a></section><form action="{{ route('admin.periodical-folders.update', $periodicalFolder) }}" method="POST" novalidate>@csrf @method('PUT') @include('admin.periodicals.folders._form', ['periodicalFolder' => $periodicalFolder])</form></div></div>
@endsection

@push('styles')
    @include('admin.periodicals._styles')
@endpush
