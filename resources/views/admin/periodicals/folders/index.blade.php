@extends('layouts.admin')

@section('title', 'Periodical Folders')
@section('page-title', 'Periodical Folders')

@section('content')
<div class="container-fluid folder-page">

    {{-- =====================================================
        PAGE HEADER
    ====================================================== --}}
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

        <a
            href="{{ route('admin.periodical-folders.create') }}"
            class="btn add-folder-button"
        >
            <i class="bi bi-plus-lg"></i>
            <span>Add Folder</span>
        </a>

    </div>


    {{-- =====================================================
        MANAGEMENT PANEL
    ====================================================== --}}
    <div class="folder-management-card">

        {{-- =================================================
            FILTERS
        ================================================== --}}
        <div class="filters-section">

            <form
                method="GET"
                action="{{ route('admin.periodical-folders.index') }}"
                class="folder-filters"
            >

                {{-- Search --}}
                <div class="folder-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search folders, accession no., programs"
                        aria-label="Search periodical folders"
                        autocomplete="off"
                    >

                </div>


                {{-- Program Filter --}}
                <div class="filter-control">

                    <select
                        name="program"
                        class="form-select program-filter"
                        aria-label="Filter by periodical program"
                    >

                        <option value="">
                            All periodical programs
                        </option>

                        @foreach ($programs ?? [] as $program)

                            <option
                                value="{{ $program->id }}"
                                @selected(request('program') == $program->id)
                            >
                                {{ $program->title }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Category Filter --}}
                <div class="filter-control">

                    <select
                        name="category"
                        class="form-select category-filter"
                        aria-label="Filter by periodical category"
                    >

                        <option value="">
                            All categories
                        </option>

                        @foreach ($categories ?? [] as $folderCategory)

                            <option
                                value="{{ $folderCategory }}"
                                @selected(request('category') === $folderCategory)
                            >
                                {{ \App\Models\PeriodicalFolder::make([
                                    'category' => $folderCategory
                                ])->categoryLabel() }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Filter Button --}}
                <button
                    type="submit"
                    class="btn filter-button"
                >

                    <i class="bi bi-funnel"></i>
                    <span>Filter</span>

                </button>


                {{-- Clear Filters --}}
                @if (
                    request()->filled('search') ||
                    request()->filled('program') ||
                    request()->filled('category')
                )

                    <a
                        href="{{ route('admin.periodical-folders.index') }}"
                        class="btn clear-filter-button"
                        title="Clear filters"
                        aria-label="Clear filters"
                    >

                        <i class="bi bi-x-lg"></i>

                    </a>

                @else

                    <button
                        type="button"
                        class="btn clear-filter-button clear-filter-disabled"
                        aria-label="No filters to clear"
                        disabled
                    >

                        <i class="bi bi-x-lg"></i>

                    </button>

                @endif

            </form>

        </div>


        {{-- =================================================
            RESULT INFORMATION
        ================================================== --}}
        <div class="folder-results-bar">

            <div class="result-count">

                <strong>
                    {{ $folders->total() }}
                </strong>

                <span>
                    {{ \Illuminate\Support\Str::plural(
                        'folder',
                        $folders->total()
                    ) }}
                </span>

            </div>


            @if (
                request()->filled('search') ||
                request()->filled('program') ||
                request()->filled('category')
            )

                <span class="result-status">
                    Filtered results
                </span>

            @else

                <span class="result-status">
                    All folders
                </span>

            @endif

        </div>


        {{-- =================================================
            TABLE
        ================================================== --}}
        <div class="table-responsive">

            <table class="table folder-table align-middle mb-0">

                <thead>

                    <tr>

                        <th class="number-column">
                            #
                        </th>

                        <th>
                            Accession No.
                        </th>

                        <th>
                            Folder
                        </th>

                        <th>
                            Program
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Link
                        </th>

                        <th class="text-end action-column">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($folders as $folder)

                    <tr>

                        {{-- Number --}}
                        <td class="number-column">

                            {{ $folders->firstItem() + $loop->index }}

                        </td>


                        {{-- Accession Number --}}
                        <td>

                            @if(filled($folder->accession_number))

                                <span class="accession-badge">

                                    {{ $folder->accession_number }}

                                </span>

                            @else

                                <span class="text-muted">
                                    —
                                </span>

                            @endif

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
                                            ? \Illuminate\Support\Str::limit(
                                                $folder->description,
                                                65
                                            )
                                            : 'No description provided'
                                        }}

                                    </small>

                                </div>

                            </div>

                        </td>


                        {{-- Program --}}
                        <td>

                            @if ($folder->program)

                                <span
                                    class="program-name"
                                    title="{{ $folder->program->title }}"
                                >

                                    <i class="bi bi-mortarboard"></i>

                                    <span>
                                        {{ $folder->program->title }}
                                    </span>

                                </span>

                            @else

                                <span class="program-missing">

                                    <i class="bi bi-exclamation-circle"></i>

                                    Unavailable

                                </span>

                            @endif

                        </td>


                        {{-- Category --}}
                        <td class="description-cell">

                            {{ $folder->categoryLabel() }}

                        </td>


                        {{-- Folder Link --}}
                        <td>

                            @if(filled($folder->folder_link))

                                <a
                                    href="{{ $folder->folder_link }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="drive-link"
                                >

                                    <i class="bi bi-google"></i>

                                    <span>
                                        Open folder
                                    </span>

                                    <i class="bi bi-box-arrow-up-right"></i>

                                </a>

                            @else

                                <span class="text-muted">
                                    No link
                                </span>

                            @endif

                        </td>


                        {{-- Actions --}}
                        <td>

                            <div class="table-actions">

                                <a
                                    href="{{ route(
                                        'admin.periodical-folders.edit',
                                        $folder
                                    ) }}"
                                    class="action-button edit"
                                    title="Edit folder"
                                    aria-label="Edit folder"
                                >

                                    <i class="bi bi-pencil"></i>

                                </a>


                                <form
                                    action="{{ route(
                                        'admin.periodical-folders.destroy',
                                        $folder
                                    ) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this folder?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-button delete"
                                        title="Delete folder"
                                        aria-label="Delete folder"
                                    >

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

                                <span class="empty-state-icon">

                                    <i class="bi bi-folder2-open"></i>

                                </span>

                                <h5>
                                    No folders found
                                </h5>

                                @if (
                                    request()->filled('search') ||
                                    request()->filled('program') ||
                                    request()->filled('category')
                                )

                                    <p>
                                        Try changing or clearing the current filters.
                                    </p>

                                    <a
                                        href="{{ route(
                                            'admin.periodical-folders.index'
                                        ) }}"
                                        class="empty-state-action"
                                    >
                                        Clear Filters
                                    </a>

                                @else

                                    <p>
                                        Add a folder to begin linking periodical resources.
                                    </p>

                                    <a
                                        href="{{ route(
                                            'admin.periodical-folders.create'
                                        ) }}"
                                        class="empty-state-action"
                                    >
                                        Add Folder
                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
            PAGINATION
        ================================================== --}}
        <div class="panel-footer">

            <p>

                Showing
                {{ $folders->firstItem() ?? 0 }}
                to
                {{ $folders->lastItem() ?? 0 }}
                of
                {{ $folders->total() }}
                results

            </p>

            <div class="folder-pagination">

                {{ $folders->withQueryString()->links() }}

            </div>

        </div>

    </div>

</div>
@endsection



{{-- =========================================================
    PAGE STYLES
========================================================= --}}
@push('styles')

<style>

    /* =====================================================
       PAGE
    ====================================================== */

    .folder-page {
        padding: 38px 40px;
        max-width: 1450px;
        margin: 0 auto;
    }


    /* =====================================================
       HEADER
    ====================================================== */

    .folder-page-header {
        min-height: 170px;
        padding: 36px 36px;
        border-radius: 26px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;

        background:
            radial-gradient(
                circle at 82% 90%,
                rgba(255, 255, 255, 0.08) 0,
                rgba(255, 255, 255, 0.08) 85px,
                transparent 86px
            ),
            linear-gradient(
                110deg,
                #0c376c 0%,
                #12477f 60%,
                #35647d 100%
            );

        box-shadow:
            0 18px 45px rgba(12, 55, 108, 0.10);
    }


    .folder-heading {
        display: flex;
        align-items: center;
        gap: 22px;
        min-width: 0;
    }


    .folder-heading-icon {
        width: 74px;
        height: 74px;
        flex: 0 0 74px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 22px;

        background: #ffbd00;
        color: #07356b;

        font-size: 32px;
    }


    .folder-heading span {
        display: block;

        margin-bottom: 5px;

        color: #ffca28;

        font-size: 13px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: 1.4px;
    }


    .folder-heading h2 {
        margin: 0 0 7px;

        color: #ffffff;

        font-size: 38px;
        font-weight: 800;

        line-height: 1.1;
    }


    .folder-heading p {
        margin: 0;

        color: rgba(255, 255, 255, 0.86);

        font-size: 16px;
    }


    .add-folder-button {
        min-height: 54px;
        padding: 0 24px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;

        border: 0;
        border-radius: 15px;

        background: #ffb800;
        color: #07356b;

        font-weight: 800;

        white-space: nowrap;

        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease,
            background 0.15s ease;
    }


    .add-folder-button:hover {
        background: #ffc41f;
        color: #07356b;

        transform: translateY(-1px);

        box-shadow:
            0 8px 20px rgba(255, 184, 0, 0.25);
    }


    /* =====================================================
       MANAGEMENT CARD
    ====================================================== */

    .folder-management-card {
        margin-top: 28px;

        overflow: hidden;

        border: 1px solid #e2eaf3;
        border-radius: 24px;

        background: #ffffff;

        box-shadow:
            0 16px 42px rgba(29, 64, 104, 0.05);
    }


    /* =====================================================
       FILTER AREA
    ====================================================== */

    .filters-section {
        padding: 22px 24px;
    }


    .folder-filters {
        width: 100%;

        display: grid;

        grid-template-columns:
            minmax(260px, 1.15fr)
            minmax(250px, 1fr)
            minmax(220px, 0.95fr)
            auto
            54px;

        align-items: center;

        gap: 14px;
    }


    /* =====================================================
       SEARCH
    ====================================================== */

    .folder-search {
        position: relative;

        min-width: 0;
        height: 52px;

        display: flex;
        align-items: center;
    }


    .folder-search > i {
        position: absolute;

        left: 16px;
        top: 50%;

        transform: translateY(-50%);

        z-index: 2;

        color: #8aa0bb;

        font-size: 18px;

        pointer-events: none;
    }


    .folder-search input {
        width: 100%;
        height: 52px;

        padding: 0 16px 0 47px;

        border: 1px solid #dce5ef;
        border-radius: 14px;

        background: #ffffff;

        color: #1e3150;

        font-size: 15px;

        outline: none;

        transition:
            border-color 0.15s ease,
            box-shadow 0.15s ease;
    }


    .folder-search input::placeholder {
        color: #8999ad;
    }


    .folder-search input:focus {
        border-color: #175a9d;

        box-shadow:
            0 0 0 3px rgba(23, 90, 157, 0.10);
    }


    /* =====================================================
       SELECTS
    ====================================================== */

    .filter-control {
        min-width: 0;
    }


    .program-filter,
    .category-filter {
        width: 100%;
        height: 52px;

        padding-left: 15px;
        padding-right: 42px;

        border: 1px solid #dce5ef;
        border-radius: 14px;

        background-color: #ffffff;

        color: #1d2f4d;

        font-size: 15px;

        box-shadow: none;

        cursor: pointer;
    }


    .program-filter:focus,
    .category-filter:focus {
        border-color: #175a9d;

        box-shadow:
            0 0 0 3px rgba(23, 90, 157, 0.10);
    }


    /* =====================================================
       FILTER BUTTON
    ====================================================== */

    .filter-button {
        height: 52px;

        padding: 0 20px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        border: 1px solid #07356b;
        border-radius: 14px;

        background: #07356b;
        color: #ffffff;

        font-weight: 700;

        white-space: nowrap;

        transition:
            background 0.15s ease,
            border-color 0.15s ease,
            transform 0.15s ease;
    }


    .filter-button:hover {
        background: #0d477f;
        border-color: #0d477f;

        color: #ffffff;

        transform: translateY(-1px);
    }


    /* =====================================================
       CLEAR BUTTON
    ====================================================== */

    .clear-filter-button {
        width: 54px;
        min-width: 54px;
        height: 52px;

        padding: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #dce5ef;
        border-radius: 14px;

        background: #ffffff;
        color: #7b8da5;

        font-size: 19px;

        transition:
            background 0.15s ease,
            border-color 0.15s ease,
            color 0.15s ease;
    }


    .clear-filter-button:hover {
        border-color: #c7d5e5;

        background: #f7f9fc;
        color: #07356b;
    }


    .clear-filter-disabled {
        opacity: 0.45;

        cursor: default;
        pointer-events: none;
    }


    /* =====================================================
       RESULTS BAR
    ====================================================== */

    .folder-results-bar {
        min-height: 56px;

        padding: 0 25px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        border-top: 1px solid #edf1f6;
        border-bottom: 1px solid #edf1f6;

        background: #fbfcfe;

        color: #8492a6;

        font-size: 14px;
    }


    .result-count {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }


    .result-count strong {
        color: #07356b;

        font-size: 15px;
        font-weight: 800;
    }


    .result-status {
        color: #8492a6;
    }


    /* =====================================================
       TABLE
    ====================================================== */

    .folder-table {
        width: 100%;

        table-layout: auto;

        background: #ffffff;
    }


    .folder-table thead th {
        padding: 18px 18px;

        border-bottom: 1px solid #e7edf4;

        background: #fbfcfe;

        color: #75869d;

        font-size: 12px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: 0.7px;

        white-space: nowrap;
    }


    .folder-table tbody td {
        padding: 19px 18px;

        border-bottom: 1px solid #e9eff5;

        color: #42536b;

        vertical-align: middle;
    }


    .folder-table tbody tr:last-child td {
        border-bottom: 0;
    }


    .folder-table tbody tr:hover {
        background: #fcfdff;
    }


    .number-column {
        width: 55px;

        color: #93a0b2 !important;
    }


    .action-column {
        width: 120px;
    }


    /* =====================================================
       ACCESSION
    ====================================================== */

    .accession-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 34px;

        padding: 0 13px;

        border: 1px solid #cfe0f2;
        border-radius: 10px;

        background: #f7fbff;
        color: #07356b;

        font-size: 12px;
        font-weight: 800;

        white-space: nowrap;
    }


    /* =====================================================
       FOLDER INFORMATION
    ====================================================== */

    .folder-information {
        min-width: 220px;

        display: flex;
        align-items: center;

        gap: 14px;
    }


    .folder-row-icon {
        width: 52px;
        height: 52px;
        flex: 0 0 52px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 15px;

        background: #fff1bb;
        color: #07356b;

        font-size: 22px;
    }


    .folder-copy {
        min-width: 0;

        display: flex;
        flex-direction: column;

        gap: 3px;
    }


    .folder-copy strong {
        max-width: 270px;

        overflow: hidden;

        color: #092f60;

        font-size: 16px;
        font-weight: 800;

        text-overflow: ellipsis;
    }


    .folder-copy small {
        color: #94a0b1;

        font-size: 13px;
    }


    /* =====================================================
       PROGRAM
    ====================================================== */

    .program-name {
        max-width: 240px;

        padding: 12px 15px;

        display: inline-flex;
        align-items: center;

        gap: 8px;

        border-radius: 12px;

        background: #edf5ff;
        color: #0b376a;

        font-size: 14px;
        font-weight: 700;

        line-height: 1.35;
    }


    .program-name i {
        flex-shrink: 0;
    }


    .program-missing {
        display: inline-flex;
        align-items: center;

        gap: 6px;

        color: #b75b5b;

        font-size: 13px;
        font-weight: 600;
    }


    .description-cell {
        max-width: 190px;

        color: #77879d !important;

        line-height: 1.4;
    }


    /* =====================================================
       LINK
    ====================================================== */

    .drive-link {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        color: #0a4380;

        font-size: 14px;
        font-weight: 700;

        text-decoration: none;
    }


    .drive-link:hover {
        color: #0c5fae;
    }


    .drive-link .bi-box-arrow-up-right {
        margin-left: 3px;

        font-size: 13px;
    }


    /* =====================================================
       ACTIONS
    ====================================================== */

    .table-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;

        gap: 8px;
    }


    .table-actions form {
        margin: 0;
    }


    .action-button {
        width: 42px;
        height: 42px;

        padding: 0;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background: transparent;

        font-size: 15px;

        text-decoration: none;

        transition:
            background 0.15s ease,
            border-color 0.15s ease,
            transform 0.15s ease;
    }


    .action-button:hover {
        transform: translateY(-1px);
    }


    .action-button.edit {
        border: 1px solid #d4e5f5;

        background: #f4f9ff;
        color: #1764a7;
    }


    .action-button.edit:hover {
        background: #e9f4ff;
    }


    .action-button.delete {
        border: 1px solid #f2d3d7;

        background: #fff7f7;
        color: #e1535b;
    }


    .action-button.delete:hover {
        background: #ffeded;
    }


    /* =====================================================
       EMPTY STATE
    ====================================================== */

    .empty-state {
        min-height: 310px;

        padding: 55px 20px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        text-align: center;
    }


    .empty-state-icon {
        width: 72px;
        height: 72px;

        margin-bottom: 16px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 20px;

        background: #edf4fb;
        color: #1760a0;

        font-size: 30px;
    }


    .empty-state h5 {
        margin: 0 0 6px;

        color: #07356b;

        font-size: 23px;
        font-weight: 800;
    }


    .empty-state p {
        margin: 0 0 18px;

        color: #8290a4;
    }


    .empty-state-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 42px;

        padding: 0 18px;

        border-radius: 11px;

        background: #07356b;
        color: #ffffff;

        font-size: 14px;
        font-weight: 700;

        text-decoration: none;
    }


    .empty-state-action:hover {
        background: #104b86;
        color: #ffffff;
    }


    /* =====================================================
       FOOTER / PAGINATION
    ====================================================== */

    .panel-footer {
        min-height: 74px;

        padding: 15px 24px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        border-top: 1px solid #edf1f6;

        background: #ffffff;
    }


    .panel-footer p {
        margin: 0;

        color: #7b899c;

        font-size: 14px;
    }


    .folder-pagination nav {
        margin: 0;
    }


    /* =====================================================
       LARGE TABLET
    ====================================================== */

    @media (max-width: 1250px) {

        .folder-page {
            padding-left: 28px;
            padding-right: 28px;
        }


        .folder-filters {
            grid-template-columns:
                minmax(250px, 1fr)
                minmax(220px, 1fr)
                minmax(200px, 1fr)
                auto
                54px;
        }


        .folder-heading h2 {
            font-size: 34px;
        }

    }


    /* =====================================================
       TABLET
    ====================================================== */

    @media (max-width: 1050px) {

        .folder-filters {
            grid-template-columns:
                minmax(240px, 1fr)
                minmax(220px, 1fr)
                minmax(200px, 1fr);

            gap: 12px;
        }


        .filter-button {
            width: 100%;
        }


        .clear-filter-button {
            width: 100%;
        }

    }


    /* =====================================================
       SMALL TABLET
    ====================================================== */

    @media (max-width: 820px) {

        .folder-page {
            padding: 22px 16px;
        }


        .folder-page-header {
            padding: 27px 24px;

            align-items: flex-start;
        }


        .folder-heading-icon {
            width: 62px;
            height: 62px;
            flex-basis: 62px;

            font-size: 26px;
        }


        .folder-heading h2 {
            font-size: 29px;
        }


        .folder-heading p {
            font-size: 14px;
        }


        .folder-filters {
            grid-template-columns: 1fr 1fr;
        }


        .folder-search {
            grid-column: 1 / -1;
        }


        .filter-button {
            width: 100%;
        }


        .clear-filter-button {
            width: 100%;
        }


        .folder-results-bar {
            padding-left: 18px;
            padding-right: 18px;
        }


        .panel-footer {
            align-items: flex-start;
            flex-direction: column;
        }

    }


    /* =====================================================
       MOBILE
    ====================================================== */

    @media (max-width: 600px) {

        .folder-page-header {
            flex-direction: column;
        }


        .folder-heading {
            align-items: flex-start;
        }


        .folder-heading h2 {
            font-size: 25px;
        }


        .add-folder-button {
            width: 100%;
        }


        .filters-section {
            padding: 16px;
        }


        .folder-filters {
            grid-template-columns: 1fr;
        }


        .folder-search,
        .filter-control,
        .filter-button,
        .clear-filter-button {
            width: 100%;
        }


        .folder-search {
            grid-column: auto;
        }


        .folder-results-bar {
            min-height: 64px;

            align-items: flex-start;
            flex-direction: column;
            justify-content: center;

            gap: 3px;
        }


        .folder-table {
            min-width: 980px;
        }

    }

</style>

@endpush