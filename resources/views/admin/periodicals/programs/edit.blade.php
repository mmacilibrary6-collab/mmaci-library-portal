@extends('layouts.admin')
@section('title', 'Edit Periodical Program')
@section('page-title', 'Edit Periodical Program')
@section('content')
<div class="container-fluid donated-book-form-page"><div class="create-page-container"><section class="create-header"><div class="header-content"><span class="header-icon"><i class="bi bi-pencil-square"></i></span><div><span class="header-eyebrow">Collection Management</span><h2>Edit Periodical Program</h2><p>Update the details for <strong>{{ $periodicalProgram->title }}</strong>.</p></div></div><a href="{{ route('admin.periodical-programs.index') }}" class="back-button"><i class="bi bi-arrow-left"></i><span>Back to Programs</span></a></section><form action="{{ route('admin.periodical-programs.update', $periodicalProgram) }}" method="POST" enctype="multipart/form-data" novalidate>@csrf @method('PUT') @include('admin.periodicals.programs._form', ['periodicalProgram' => $periodicalProgram])</form></div></div>
@endsection

@push('styles')
    @include('admin.periodicals._styles')
@endpush
