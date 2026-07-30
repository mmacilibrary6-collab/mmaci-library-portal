@extends('layouts.admin')

@section('title', 'E-Book Folders')
@section('page-title', 'E-Book Folders')

@section('content')

<div class="container-fluid folder-page">

    {{-- Page Header --}}
    <div class="folder-page-header">

        <div class="folder-heading">

            <div class="folder-heading-icon">
                <i class="bi bi-folder2-open"></i>
            </div>

            <div>
                <span>Digital Collection</span>
                <h2>E-Book Folders</h2>
                <p>Manage Google Drive folders assigned to academic programs.</p>
            </div>

        </div>

        <a
            href="{{ route('admin.ebook-folders.create') }}"
            class="btn add-folder-button">

            <i class="bi bi-plus-lg"></i>
            Add Folder

        </a>

    </div>

    <div class="folder-management-card">

        {{-- Filters --}}
        <form
            method="GET"
            action="{{ route('admin.ebook-folders.index') }}"
            class="folder-filters">

            <div class="folder-search">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search folders or programs"
                    aria-label="Search folders">

            </div>

            <select
                name="program"
                class="form-select program-filter"
                aria-label="Filter by academic program">

                <option value="">All academic programs</option>

                @foreach ($programs ?? [] as $program)

                    <option
                        value="{{ $program->id }}"
                        @selected(request('program') == $program->id)>

                        {{ $program->title }}

                    </option>

                @endforeach

            </select>

            <button type="submit" class="btn filter-button">
                <i class="bi bi-funnel"></i>
                Filter
            </button>

            @if (request()->filled('search') || request()->filled('program'))

                <a
                    href="{{ route('admin.ebook-folders.index') }}"
                    class="btn clear-filter-button"
                    title="Clear filters">

                    <i class="bi bi-x-lg"></i>

                </a>

            @endif

        </form>

        {{-- Results Summary --}}
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

        {{-- Folder Table --}}
        <div class="table-responsive">

            <table class="table folder-table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="number-column">#</th>
                        <th>Folder</th>
                        <th>Academic Program</th>
                        <th>Drive Access</th>
                        <th class="text-center status-column">Status</th>
                        <th class="text-end action-column">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($folders as $folder)

                        <tr>

                            <td class="number-column">
                                {{ $folders->firstItem() + $loop->index }}
                            </td>

                            {{-- Folder --}}
                            <td>

                                <div class="folder-information">

                                    <div class="folder-row-icon">
                                        <i class="bi bi-folder-fill"></i>
                                    </div>

                                    <div class="folder-copy">

                                        <strong title="{{ $folder->title }}">
                                            {{ $folder->title }}
                                        </strong>

                                        <small>
                                            {{ $folder->description
                                                ? \Illuminate\Support\Str::limit($folder->description, 65)
                                                : 'No description provided' }}
                                        </small>

                                    </div>

                                </div>

                            </td>

                            {{-- Program --}}
                            <td>

                                @if ($folder->program)

                                    <span
                                        class="program-name"
                                        title="{{ $folder->program->title }}">

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

                            {{-- Google Drive --}}
                            <td>

                                <a
                                    href="{{ $folder->drive_link }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="drive-link">

                                    <i class="bi bi-google"></i>
                                    Open folder
                                    <i class="bi bi-box-arrow-up-right"></i>

                                </a>

                            </td>

                            {{-- Status --}}
                            <td class="text-center">

                                @if ((int) $folder->status === 1)

                                    <span class="status-pill active">
                                        <span></span>
                                        Active
                                    </span>

                                @else

                                    <span class="status-pill hidden">
                                        <span></span>
                                        Hidden
                                    </span>

                                @endif

                            </td>

                            {{-- Actions --}}
                            <td>

                                <div class="folder-actions">

                                    <a
                                        href="{{ route('admin.ebook-folders.edit', $folder) }}"
                                        class="action-button edit"
                                        title="Edit folder"
                                        aria-label="Edit {{ $folder->title }}">

                                        <i class="bi bi-pencil"></i>

                                    </a>

                                    <a
                                        href="{{ $folder->drive_link }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="action-button open"
                                        title="Open Google Drive"
                                        aria-label="Open {{ $folder->title }} in Google Drive">

                                        <i class="bi bi-box-arrow-up-right"></i>

                                    </a>

                                    <form
                                        action="{{ route('admin.ebook-folders.destroy', $folder) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this e-book folder?');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button delete"
                                            title="Delete folder"
                                            aria-label="Delete {{ $folder->title }}">

                                            <i class="bi bi-trash3"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6">

                                <div class="folder-empty-state">

                                    <div class="empty-folder-icon">
                                        <i class="bi bi-folder-x"></i>
                                    </div>

                                    <h4>No e-book folders found</h4>

                                    <p>
                                        @if (request()->filled('search') || request()->filled('program'))
                                            Try changing or clearing your filters.
                                        @else
                                            Add a Google Drive folder and assign it to an academic program.
                                        @endif
                                    </p>

                                    @if (request()->filled('search') || request()->filled('program'))

                                        <a
                                            href="{{ route('admin.ebook-folders.index') }}"
                                            class="btn btn-light border">
                                            Clear Filters
                                        </a>

                                    @else

                                        

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if ($folders->hasPages())

            <div class="folder-pagination">

                <small>
                    Showing {{ $folders->firstItem() }}–{{ $folders->lastItem() }}
                    of {{ $folders->total() }}
                </small>

                {{ $folders->withQueryString()->links() }}

            </div>

        @endif

    </div>

</div>

<style>

:root {
    --folder-navy: #0B2E59;
    --folder-blue: #184B8C;
    --folder-yellow: #F4B400;
    --folder-background: #F4F7FB;
    --folder-border: #E2E8F0;
    --folder-text: #526071;
}

.folder-page {
    padding-top: 24px;
    padding-bottom: 42px;
}

/* Header */

.folder-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 22px;
    padding: 23px 25px;
    background:
        radial-gradient(circle at 85% 0, rgba(244, 180, 0, 0.20), transparent 28%),
        linear-gradient(120deg, #08274D, var(--folder-blue));
    border-radius: 16px;
    box-shadow: 0 14px 34px rgba(11, 46, 89, 0.16);
}

.folder-heading {
    min-width: 0;
    display: flex;
    align-items: center;
    gap: 15px;
}

.folder-heading-icon {
    width: 51px;
    height: 51px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    color: var(--folder-navy);
    background: var(--folder-yellow);
    border-radius: 13px;
    font-size: 22px;
}

.folder-heading span {
    display: block;
    margin-bottom: 2px;
    color: #FFD968;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.11em;
    text-transform: uppercase;
}

.folder-heading h2 {
    margin: 0;
    color: #ffffff;
    font-size: 23px;
    font-weight: 800;
}

.folder-heading p {
    margin: 3px 0 0;
    color: rgba(255, 255, 255, 0.68);
    font-size: 12px;
}

.add-folder-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 16px;
    color: var(--folder-navy);
    background: var(--folder-yellow);
    border: 0;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 800;
}

.add-folder-button:hover {
    color: var(--folder-navy);
    background: #FFD043;
}

/* Main Card */

.folder-management-card {
    overflow: hidden;
    background: #ffffff;
    border: 1px solid var(--folder-border);
    border-radius: 15px;
    box-shadow: 0 8px 26px rgba(11, 46, 89, 0.07);
}

/* Filters */

.folder-filters {
    display: grid;
    grid-template-columns: minmax(240px, 1.4fr) minmax(210px, 1fr) auto auto;
    gap: 10px;
    padding: 16px;
    background: #F8FAFD;
    border-bottom: 1px solid var(--folder-border);
}

.folder-search {
    position: relative;
}

.folder-search > i {
    position: absolute;
    top: 50%;
    left: 14px;
    color: #8290A2;
    font-size: 14px;
    transform: translateY(-50%);
}

.folder-search input,
.program-filter {
    width: 100%;
    min-height: 42px;
    color: var(--folder-navy);
    background-color: #ffffff;
    border: 1px solid #D8E0EA;
    border-radius: 9px;
    outline: 0;
    font-size: 12px;
}

.folder-search input {
    padding: 9px 13px 9px 39px;
}

.program-filter {
    padding-right: 34px;
}

.folder-search input:focus,
.program-filter:focus {
    border-color: rgba(24, 75, 140, 0.65);
    box-shadow: 0 0 0 3px rgba(24, 75, 140, 0.08);
}

.filter-button,
.clear-filter-button {
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border-radius: 9px;
    font-size: 11px;
    font-weight: 800;
}

.filter-button {
    padding: 8px 15px;
    color: #ffffff;
    background: var(--folder-blue);
}

.filter-button:hover {
    color: #ffffff;
    background: var(--folder-navy);
}

.clear-filter-button {
    width: 42px;
    color: #6F7C8E;
    background: #ffffff;
    border: 1px solid #D8E0EA;
}

/* Results */

.folder-results-bar {
    display: flex;
    justify-content: space-between;
    padding: 11px 17px;
    color: #7B8797;
    background: #ffffff;
    border-bottom: 1px solid #EDF0F4;
    font-size: 10px;
}

.folder-results-bar strong {
    color: var(--folder-navy);
}

/* Table */

.folder-table {
    min-width: 940px;
}

.folder-table thead th {
    padding: 12px 14px;
    color: #6E7A8C;
    background: #F5F7FA;
    border: 0;
    border-bottom: 1px solid var(--folder-border);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    white-space: nowrap;
}

.folder-table tbody td {
    padding: 13px 14px;
    color: var(--folder-text);
    border-color: #EDF1F5;
    font-size: 11px;
    vertical-align: middle;
}

.folder-table tbody tr:hover {
    background: #FAFBFD;
}

.number-column {
    width: 54px;
    padding-left: 18px !important;
    color: #95A0AF !important;
    text-align: center;
}

.status-column {
    width: 95px;
}

.action-column {
    width: 130px;
    padding-right: 18px !important;
}

/* Folder Information */

.folder-information {
    min-width: 220px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.folder-row-icon {
    width: 38px;
    height: 38px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    color: var(--folder-navy);
    background: rgba(244, 180, 0, 0.16);
    border-radius: 9px;
    font-size: 16px;
}

.folder-copy {
    min-width: 0;
}

.folder-copy strong {
    max-width: 260px;
    display: block;
    overflow: hidden;
    color: #263A52;
    font-size: 12px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.folder-copy small {
    max-width: 280px;
    display: block;
    margin-top: 2px;
    overflow: hidden;
    color: #8A95A5;
    font-size: 10px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Program and Link */

.program-name,
.program-missing {
    max-width: 230px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    overflow: hidden;
    padding: 6px 9px;
    border-radius: 7px;
    font-size: 10px;
    font-weight: 700;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.program-name {
    color: var(--folder-blue);
    background: #EDF4FC;
}

.program-missing {
    color: #B42318;
    background: #FEF0EF;
}

.drive-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--folder-blue);
    font-size: 10px;
    font-weight: 750;
    text-decoration: none;
    white-space: nowrap;
}

.drive-link:hover {
    color: var(--folder-navy);
}

/* Status */

.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 8px;
    border-radius: 999px;
    font-size: 9px;
    font-weight: 800;
}

.status-pill > span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-pill.active {
    color: #087451;
    background: #EAF8F2;
}

.status-pill.active > span {
    background: #18A675;
}

.status-pill.hidden {
    color: #687386;
    background: #EEF1F5;
}

.status-pill.hidden > span {
    background: #98A2B3;
}

/* Actions */

.folder-actions {
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}

.folder-actions form {
    margin: 0;
}

.action-button {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    background: #ffffff;
    border: 1px solid #DDE4ED;
    border-radius: 7px;
    font-size: 12px;
    transition: 0.2s ease;
}

.action-button.edit {
    color: #9B6B00;
}

.action-button.open {
    color: var(--folder-blue);
}

.action-button.delete {
    color: #C53F3F;
}

.action-button:hover {
    color: #ffffff;
    transform: translateY(-1px);
}

.action-button.edit:hover {
    background: #D99F00;
    border-color: #D99F00;
}

.action-button.open:hover {
    background: var(--folder-blue);
    border-color: var(--folder-blue);
}

.action-button.delete:hover {
    background: #C53F3F;
    border-color: #C53F3F;
}

/* Empty and Pagination */

.folder-empty-state {
    padding: 55px 20px;
    text-align: center;
}

.empty-folder-icon {
    width: 62px;
    height: 62px;
    display: grid;
    place-items: center;
    margin: 0 auto 14px;
    color: var(--folder-navy);
    background: rgba(244, 180, 0, 0.16);
    border-radius: 16px;
    font-size: 27px;
}

.folder-empty-state h4 {
    margin-bottom: 6px;
    color: var(--folder-navy);
    font-size: 16px;
    font-weight: 800;
}

.folder-empty-state p {
    margin-bottom: 18px;
    color: #7C8898;
    font-size: 11px;
}

.folder-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 13px 17px;
    border-top: 1px solid var(--folder-border);
}

.folder-pagination small {
    color: #7C8898;
    font-size: 10px;
}

.folder-pagination nav {
    margin-left: auto;
}

.folder-pagination .pagination {
    margin: 0;
    flex-wrap: wrap;
    gap: 6px;
}

.folder-pagination .pagination .page-link {
    min-width: 36px;
    min-height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 7px 10px;
    border-radius: 10px;
}

@media (max-width: 991.98px) {

    .folder-filters {
        grid-template-columns: 1fr 1fr;
    }

    .filter-button {
        width: 100%;
    }

}

@media (max-width: 767.98px) {

    .folder-page {
        padding-top: 16px;
    }

    .folder-page-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 20px;
    }

    .folder-heading p {
        display: none;
    }

    .folder-page-header .add-folder-button {
        width: 100%;
    }

    .folder-filters {
        grid-template-columns: 1fr;
    }

    .clear-filter-button {
        width: 100%;
    }

    .folder-pagination {
        align-items: flex-start;
        flex-direction: column;
    }

    .folder-pagination nav {
        width: 100%;
        margin-left: 0;
        overflow-x: auto;
    }

    .folder-pagination .pagination {
        justify-content: flex-start;
    }

}

</style>

@endsection
