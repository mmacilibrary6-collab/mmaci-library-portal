@extends('layouts.admin')
@section('title', 'Periodical Folders')
@section('page-title', 'Periodical Folders')
@section('content')
<div class="container-fluid donated-books-page">
    <section class="programs-hero">
        <div class="hero-copy"><span class="hero-icon"><i class="bi bi-folder-fill"></i></span><div><span class="hero-eyebrow">Collection Management</span><h2>Periodical Folders</h2><p>Manage folder links inside periodical programs.</p></div></div>
        <a href="{{ route('admin.periodical-folders.create') }}" class="btn-add-program"><i class="bi bi-plus-lg"></i><span>Add Folder</span></a>
    </section>
    @include('partials.flash-messages')
    <section class="programs-panel">
        <div class="panel-toolbar"><div><h5>Folder List</h5><p>{{ $folders->total() }} {{ \Illuminate\Support\Str::plural('folder', $folders->total()) }} found</p></div></div>
        <div class="table-responsive">
            <table class="table programs-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="number-column">#</th>
                        <th>Folder</th>
                        <th>Program</th>
                        <th>Category</th>
                        <th>Link</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($folders as $folder)
                    <tr>
                        <td class="row-number">{{ ($folders->firstItem() ?? 1) + $loop->index }}</td>
                        <td>
                            <div class="program-identity">
                                <div class="program-thumbnail"><i class="bi bi-folder-fill"></i></div>
                                <div>
                                    <strong>{{ $folder->title }}</strong>
                                    <small>{{ $folder->description ?: 'No description provided' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="description-cell">{{ $folder->program?->title ?? 'No program' }}</td>
                        <td class="description-cell">{{ $folder->categoryLabel() }}</td>
                        <td class="description-cell"><a href="{{ $folder->folder_link }}" target="_blank" rel="noopener noreferrer">Open folder</a></td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.periodical-folders.edit', $folder) }}" class="action-button edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.periodical-folders.destroy', $folder) }}" method="POST" onsubmit="return confirm('Delete this folder?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-button delete"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><span><i class="bi bi-folder2-open"></i></span><h5>No folders found</h5><p>Add a folder to begin linking periodical resources.</p><a href="{{ route('admin.periodical-folders.create') }}">Add Folder</a></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('styles')
    @include('admin.periodicals._styles')
@endpush
