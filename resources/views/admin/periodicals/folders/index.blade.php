@extends('layouts.admin')
@section('title', 'Periodical Folders')
@section('page-title', 'Periodical Folders')

@section('content')
<div class="container-fluid folder-page">

    <div class="folder-page-header">
        <div class="folder-heading">
            <div class="folder-heading-icon">
                <i class="bi bi-folder-fill"></i>
            </div>

            <div>
                <span>Collection Management</span>
                <h2>Periodical Folders</h2>
                <p>Manage folder links inside periodical programs.</p>
            </div>
        </div>

        <a href="{{ route('admin.periodical-folders.create') }}" class="btn add-folder-button">
            <i class="bi bi-plus-lg"></i>
            Add Folder
        </a>
    </div>

    <div class="folder-management-card">
        <form method="GET" action="{{ route('admin.periodical-folders.index') }}" class="folder-filters">
            <div class="folder-search">
                <i class="bi bi-search"></i>
                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search folders, accession no., programs"
                    aria-label="Search periodical folders">
            </div>

            <select
                name="program"
                class="form-select program-filter"
                aria-label="Filter by periodical program">
                <option value="">All periodical programs</option>
                @foreach ($programs ?? [] as $program)
                    <option value="{{ $program->id }}" @selected(request('program') == $program->id)>
                        {{ $program->title }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn filter-button">
                <i class="bi bi-funnel"></i>
                Filter
            </button>

            @if (request()->filled('search') || request()->filled('program'))
                <a href="{{ route('admin.periodical-folders.index') }}" class="btn clear-filter-button" title="Clear filters">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>

        <div class="folder-results-bar">
            <div>
                <strong>{{ $folders->total() }}</strong>
                {{ \Illuminate\Support\Str::plural('folder', $folders->total()) }}
            </div>

            @if (request()->filled('search') || request()->filled('program'))
                <span>Filtered results</span>
            @else
                <span>All folders</span>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table folder-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="number-column">#</th>
                        <th>Accession No.</th>
                        <th>Folder</th>
                        <th>Program</th>
                        <th>Category</th>
                        <th>Link</th>
                        <th class="text-end action-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($folders as $folder)
                    <tr>
                        <td class="number-column">{{ $folders->firstItem() + $loop->index }}</td>
                        <td>
                            @if($folder->category === 'journal_newspaper' && filled($folder->accession_number))
                                <span class="accession-badge">{{ $folder->accession_number }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="folder-information">
                                <div class="folder-row-icon">
                                    <i class="bi bi-folder-fill"></i>
                                </div>
                                <div class="folder-copy">
                                    <strong title="{{ $folder->title }}">{{ $folder->title }}</strong>
                                    <small>
                                        {{ $folder->description
                                            ? \Illuminate\Support\Str::limit($folder->description, 65)
                                            : 'No description provided' }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($folder->program)
                                <span class="program-name" title="{{ $folder->program->title }}">
                                    <i class="bi bi-mortarboard"></i>
                                    {{ $folder->program->title }}
                                </span>
                            @else
                                <span class="program-missing">
                                    <i class="bi bi-exclamation-circle"></i>
                                    Unavailable
                                </span>
                            @endif
                        </td>
                        <td class="description-cell">{{ $folder->categoryLabel() }}</td>
                        <td>
                            <a
                                href="{{ $folder->folder_link }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="drive-link">
                                <i class="bi bi-google"></i>
                                Open folder
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.periodical-folders.edit', $folder) }}" class="action-button edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.periodical-folders.destroy', $folder) }}" method="POST" onsubmit="return confirm('Delete this folder?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-button delete">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <span><i class="bi bi-folder2-open"></i></span>
                                <h5>No folders found</h5>
                                <p>Add a folder to begin linking periodical resources.</p>
                                <a href="{{ route('admin.periodical-folders.create') }}">Add Folder</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="panel-footer">
            <p>
                Showing {{ $folders->firstItem() ?? 0 }} to {{ $folders->lastItem() ?? 0 }} of {{ $folders->total() }} results
            </p>
            {{ $folders->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
    @include('admin.periodicals._styles')
@endpush
