@extends('layouts.admin')

@section('title', 'Gallery Management')
@section('page-title', 'Gallery Management')

@section('content')

<div class="container-fluid gallery-list-page">

    {{-- Header --}}
    <section class="gallery-page-header">

        <div class="gallery-page-heading">

            <span class="gallery-page-icon">
                <i class="bi bi-folder2-open"></i>
            </span>

            <div>
                <span class="gallery-page-eyebrow">
                    Website Content
                </span>

                <h2>Gallery Management</h2>

                <p>
                    Create folders and manage photos shown in the public gallery.
                </p>
            </div>

        </div>

        <a
            href="{{ route('admin.gallery.create') }}"
            class="gallery-add-folder">

            <i class="bi bi-folder-plus"></i>
            Add Gallery Folder

        </a>

    </section>

    

    <section class="gallery-list-card">

        {{-- Filters --}}
        <form
            action="{{ route('admin.gallery.index') }}"
            method="GET"
            class="gallery-filter-bar">

            <div class="gallery-search">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search gallery folders">

            </div>

            <select
                name="status"
                class="form-select gallery-status-select">

                <option value="">All visibility</option>

                <option
                    value="active"
                    @selected(request('status') === 'active')>
                    Active
                </option>

                <option
                    value="inactive"
                    @selected(request('status') === 'inactive')>
                    Inactive
                </option>

            </select>

            <button type="submit" class="gallery-filter-submit">
                <i class="bi bi-funnel-fill"></i>
                Filter
            </button>

            @if (request()->filled('search') || request()->filled('status'))

                <a
                    href="{{ route('admin.gallery.index') }}"
                    class="gallery-filter-reset"
                    title="Clear filters">

                    <i class="bi bi-arrow-clockwise"></i>

                </a>

            @endif

        </form>

        {{-- Result Header --}}
        <div class="gallery-result-header">

            <div>
                <h5>Gallery Folders</h5>
                <p>Manage folder covers, visibility, and photos.</p>
            </div>

            <span>
                {{ $galleries->total() }}
                {{ \Illuminate\Support\Str::plural(
                    'folder',
                    $galleries->total()
                ) }}
            </span>

        </div>

        {{-- Grid --}}
        <div class="gallery-card-grid">

            @forelse ($galleries as $gallery)

                @php
                    $photoCount = $gallery->images_count
                        ?? $gallery->images->count();
                @endphp

                <article class="gallery-folder-card">

                    <div class="gallery-folder-image">

                        <img
                            src="{{ $gallery->image_url }}"
                            alt="{{ $gallery->title }}"
                            loading="lazy"
                            onerror="this.onerror=null; this.src='{{ asset('images/image-fallback.svg') }}';">

                        <div class="gallery-image-shade"></div>

                        <div class="gallery-image-top">

                            <span class="gallery-photo-count">
                                <i class="bi bi-images"></i>

                                {{ $photoCount }}
                                {{ \Illuminate\Support\Str::plural(
                                    'photo',
                                    $photoCount
                                ) }}
                            </span>

                            <span class="gallery-folder-status {{ $gallery->is_active ? 'is-active' : 'is-inactive' }}">

                                <i class="bi bi-circle-fill"></i>

                                {{ $gallery->is_active
                                    ? 'Active'
                                    : 'Inactive'
                                }}

                            </span>

                        </div>

                        <span class="gallery-image-folder-icon">
                            <i class="bi bi-folder-fill"></i>
                        </span>

                    </div>

                    <div class="gallery-folder-body">

                        <h3 title="{{ $gallery->title }}">
                            {{ $gallery->title }}
                        </h3>

                        <div class="gallery-folder-details">

                            <span>
                                <i class="bi bi-calendar3"></i>

                                {{ $gallery->created_at
                                    ? $gallery->created_at->format('M d, Y')
                                    : 'Date unavailable'
                                }}
                            </span>

                            <span>
                                <i class="bi bi-images"></i>
                                {{ $photoCount }} items
                            </span>

                        </div>

                        <div class="gallery-folder-buttons">

                            <a
                                href="{{ route('admin.gallery.edit', $gallery) }}"
                                class="gallery-manage-button">

                                <i class="bi bi-pencil-square"></i>
                                Manage Folder

                            </a>

                            <form
                                action="{{ route('admin.gallery.destroy', $gallery) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this gallery folder and all of its photos?');">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="gallery-remove-button"
                                    title="Delete folder">

                                    <i class="bi bi-trash3"></i>

                                </button>

                            </form>

                        </div>

                    </div>

                </article>

            @empty

                <div class="gallery-empty">

                    <span>
                        <i class="bi bi-folder2-open"></i>
                    </span>

                    <h4>No gallery folders found</h4>

                    <p>
                        @if (request()->filled('search') || request()->filled('status'))
                            No folders match your current filters.
                        @else
                            Create your first folder to begin building the gallery.
                        @endif
                    </p>

                    @if (request()->filled('search') || request()->filled('status'))

                        <a href="{{ route('admin.gallery.index') }}">
                            <i class="bi bi-arrow-clockwise"></i>
                            Clear Filters
                        </a>

                    @else

                        <a href="{{ route('admin.gallery.create') }}">
                            <i class="bi bi-folder-plus"></i>
                            Add Gallery Folder
                        </a>

                    @endif

                </div>

            @endforelse

        </div>

        @if ($galleries->hasPages())

            <div class="gallery-pagination">
                {{ $galleries->withQueryString()->links() }}
            </div>

        @endif

    </section>

</div>

@endsection

@push('styles')
<style>
    .gallery-list-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        width: 100%;
        padding: 24px;
    }

    /* Header */

    .gallery-page-header {
        position: relative;
        width: 100%;
        min-height: 140px;
        margin-bottom: 18px;
        padding: 26px 29px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(244, 180, 0, .22),
                transparent 28%
            ),
            linear-gradient(125deg, var(--navy), var(--blue));
        border-radius: 20px;
        box-shadow: 0 14px 32px rgba(11, 46, 89, .14);
    }

    .gallery-page-header::after {
        content: "";
        position: absolute;
        right: 16%;
        bottom: -86px;
        width: 180px;
        height: 180px;
        border: 27px solid rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .gallery-page-heading {
        position: relative;
        z-index: 1;
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .gallery-page-icon {
        width: 58px;
        height: 58px;
        flex: 0 0 58px;
        display: grid;
        place-items: center;
        color: var(--navy);
        background: var(--gold);
        border-radius: 16px;
        font-size: 24px;
    }

    .gallery-page-eyebrow {
        display: block;
        margin-bottom: 3px;
        color: #ffd96d;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .gallery-page-header h2 {
        margin: 0 0 4px;
        font-size: clamp(22px, 3vw, 29px);
        font-weight: 800;
    }

    .gallery-page-header p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 11px;
    }

    .gallery-add-folder {
        position: relative;
        z-index: 1;
        min-height: 43px;
        padding: 0 16px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        color: var(--navy);
        background: var(--gold);
        border: 1px solid var(--gold);
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none;
        transition: .2s ease;
    }

    .gallery-add-folder:hover {
        color: var(--navy);
        background: #ffc928;
        transform: translateY(-2px);
    }

    /* Success */

    .gallery-success {
        position: relative;
        margin-bottom: 16px;
        padding: 12px 46px 12px 13px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #276749;
        background: #f0fff7;
        border: 1px solid #bee6ce;
        border-left: 4px solid #2f9e63;
        border-radius: 12px;
    }

    .gallery-success-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: grid;
        place-items: center;
        color: #fff;
        background: #2f9e63;
        border-radius: 9px;
    }

    .gallery-success strong {
        display: block;
        font-size: 11px;
    }

    .gallery-success p {
        margin: 0;
        color: #52856a;
        font-size: 10px;
    }

    /* Main card */

    .gallery-list-card {
        width: 100%;
        overflow: hidden;
        background: #fff;
        border: 1px solid #dfe5ed;
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(11, 46, 89, .07);
    }

    /* Filters */

    .gallery-filter-bar {
        width: 100%;
        padding: 17px 20px;
        display: grid;
        grid-template-columns: minmax(200px, 1fr) 170px auto auto;
        gap: 9px;
        align-items: center;
        background: #f8fafc;
        border-bottom: 1px solid #e7ecf2;
    }

    .gallery-search {
        position: relative;
        min-width: 0;
    }

    .gallery-search i {
        position: absolute;
        top: 50%;
        left: 13px;
        color: #8792a1;
        font-size: 12px;
        transform: translateY(-50%);
    }

    .gallery-search input {
        width: 100%;
        height: 42px;
        padding: 0 13px 0 37px;
        color: #33465e;
        background: #fff;
        border: 1px solid #d9e1ea;
        border-radius: 9px;
        font-size: 11px;
        outline: none;
    }

    .gallery-search input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .08);
    }

    .gallery-status-select {
        width: 100%;
        height: 42px;
        color: #43546a;
        background-color: #fff;
        border-color: #d9e1ea;
        border-radius: 9px;
        font-size: 11px;
        box-shadow: none;
    }

    .gallery-filter-submit,
    .gallery-filter-reset {
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 700;
    }

    .gallery-filter-submit {
        padding: 0 15px;
        gap: 6px;
        color: #fff;
        background: var(--navy);
        border: 1px solid var(--navy);
    }

    .gallery-filter-reset {
        width: 42px;
        color: #647286;
        background: #fff;
        border: 1px solid #d9e1ea;
        text-decoration: none;
    }

    /* Result heading */

    .gallery-result-header {
        padding: 18px 20px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .gallery-result-header h5 {
        margin: 0 0 2px;
        color: var(--navy);
        font-size: 14px;
        font-weight: 800;
    }

    .gallery-result-header p {
        margin: 0;
        color: #8490a0;
        font-size: 9px;
    }

    .gallery-result-header > span {
        padding: 5px 9px;
        color: #68768a;
        background: #eef2f6;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* Grid */

    .gallery-card-grid {
        padding: 0 20px 21px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
    }

    .gallery-folder-card {
        min-width: 0;
        overflow: hidden;
        background: #fff;
        border: 1px solid #dfe5ed;
        border-radius: 14px;
        box-shadow: 0 6px 17px rgba(11, 46, 89, .06);
        transition: .22s ease;
    }

    .gallery-folder-card:hover {
        border-color: #c5d0dd;
        box-shadow: 0 12px 25px rgba(11, 46, 89, .11);
        transform: translateY(-3px);
    }

    .gallery-folder-image {
        position: relative;
        width: 100%;
        height: 190px;
        overflow: hidden;
        background: #e8edf3;
    }

    .gallery-folder-image > img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
        transition: transform .35s ease;
    }

    .gallery-folder-card:hover .gallery-folder-image > img {
        transform: scale(1.04);
    }

    .gallery-image-shade {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            180deg,
            rgba(11, 46, 89, .16),
            transparent 50%,
            rgba(11, 46, 89, .50)
        );
    }

    .gallery-image-top {
        position: absolute;
        top: 10px;
        right: 10px;
        left: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 7px;
    }

    .gallery-photo-count,
    .gallery-folder-status {
        min-height: 26px;
        padding: 0 8px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 999px;
        font-size: 8px;
        font-weight: 800;
    }

    .gallery-photo-count {
        color: var(--navy);
        background: var(--gold);
    }

    .gallery-folder-status {
        color: #fff;
    }

    .gallery-folder-status i {
        font-size: 5px;
    }

    .gallery-folder-status.is-active {
        background: rgba(25, 135, 84, .92);
    }

    .gallery-folder-status.is-inactive {
        background: rgba(108, 117, 125, .92);
    }

    .gallery-image-folder-icon {
        position: absolute;
        right: 13px;
        bottom: 11px;
        color: rgba(255, 255, 255, .90);
        font-size: 23px;
    }

    .gallery-folder-body {
        padding: 15px;
    }

    .gallery-folder-body h3 {
        margin: 0 0 9px;
        overflow: hidden;
        color: var(--navy);
        font-size: 13px;
        font-weight: 800;
        line-height: 1.4;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .gallery-folder-details {
        margin-bottom: 13px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 7px;
        color: #7b8797;
        font-size: 8px;
    }

    .gallery-folder-details span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .gallery-folder-details i {
        color: var(--blue);
    }

    .gallery-folder-buttons {
        padding-top: 12px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 38px;
        gap: 7px;
        border-top: 1px solid #ebeff4;
    }

    .gallery-folder-buttons form {
        margin: 0;
    }

    .gallery-manage-button,
    .gallery-remove-button {
        width: 100%;
        min-height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 700;
        text-decoration: none;
    }

    .gallery-manage-button {
        color: var(--blue);
        background: #edf4fc;
        border: 1px solid #d5e4f6;
    }

    .gallery-manage-button:hover {
        color: #fff;
        background: var(--blue);
        border-color: var(--blue);
    }

    .gallery-remove-button {
        color: #c14343;
        background: #fff2f2;
        border: 1px solid #f0d4d4;
    }

    .gallery-remove-button:hover {
        color: #fff;
        background: #d84b4b;
        border-color: #d84b4b;
    }

    /* Empty */

    .gallery-empty {
        grid-column: 1 / -1;
        padding: 55px 20px;
        text-align: center;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 13px;
    }

    .gallery-empty > span {
        width: 60px;
        height: 60px;
        margin: 0 auto 13px;
        display: grid;
        place-items: center;
        color: var(--navy);
        background: #e8eef5;
        border-radius: 16px;
        font-size: 25px;
    }

    .gallery-empty h4 {
        margin: 0 0 5px;
        color: var(--navy);
        font-size: 15px;
        font-weight: 800;
    }

    .gallery-empty p {
        margin: 0 0 15px;
        color: #7e8a9a;
        font-size: 10px;
    }

    .gallery-empty a {
        min-height: 38px;
        padding: 0 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        color: #fff;
        background: var(--navy);
        border-radius: 8px;
        font-size: 9px;
        font-weight: 700;
        text-decoration: none;
    }

    .gallery-pagination {
        padding: 14px 20px;
        border-top: 1px solid #e7ecf2;
    }

    /* Responsive */

    @media (max-width: 1199.98px) {
        .gallery-card-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .gallery-list-page {
            padding: 16px 10px;
        }

        .gallery-page-header {
            padding: 22px 19px;
            align-items: flex-start;
            flex-direction: column;
            border-radius: 17px;
        }

        .gallery-page-icon {
            width: 50px;
            height: 50px;
            flex-basis: 50px;
        }

        .gallery-add-folder {
            width: 100%;
        }

        .gallery-filter-bar {
            grid-template-columns: 1fr;
        }

        .gallery-filter-reset {
            width: 100%;
        }

        .gallery-card-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 420px) {
        .gallery-page-heading {
            align-items: flex-start;
        }

        .gallery-result-header,
        .gallery-folder-details {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush
