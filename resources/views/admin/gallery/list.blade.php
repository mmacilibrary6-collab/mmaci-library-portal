@extends('layouts.admin')

@section('title', 'Gallery Management')
@section('page-title', 'Gallery Management')

@section('content')

<div class="container-fluid gallery-list-page">

    {{-- Page Header --}}
    <section class="gallery-list-header">

        <div class="gallery-list-heading">

            <span class="gallery-list-icon">
                <i class="bi bi-folder2-open"></i>
            </span>

            <div>
                <span class="gallery-list-eyebrow">
                    Website Content
                </span>

                <h2>Gallery Management</h2>

                <p>
                    Create folders and manage photos displayed in the public gallery.
                </p>
            </div>

        </div>

        <a
            href="{{ route('admin.gallery.create') }}"
            class="gallery-add-button">

            <i class="bi bi-folder-plus"></i>
            Add Gallery Folder

        </a>

    </section>

    {{-- Success Message --}}
    @if (session('success'))

        <div
            class="gallery-success-alert alert alert-dismissible fade show"
            role="alert">

            <span class="gallery-success-icon">
                <i class="bi bi-check-lg"></i>
            </span>

            <div>
                <strong>Changes saved</strong>
                <p>{{ session('success') }}</p>
            </div>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
            </button>

        </div>

    @endif

    {{-- Management Card --}}
    <section class="gallery-management-card">

        {{-- Filters --}}
        <form
            action="{{ route('admin.gallery.index') }}"
            method="GET"
            class="gallery-filters">

            <div class="gallery-search">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search gallery folders"
                    aria-label="Search gallery folders">

            </div>

            <select
                name="status"
                class="form-select gallery-status-filter"
                aria-label="Filter gallery folders by visibility">

                <option value="">
                    All visibility
                </option>

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

            <button
                type="submit"
                class="gallery-filter-button">

                <i class="bi bi-funnel-fill"></i>
                Filter

            </button>

            @if (request()->filled('search') || request()->filled('status'))

                <a
                    href="{{ route('admin.gallery.index') }}"
                    class="gallery-reset-button"
                    title="Clear filters"
                    aria-label="Clear filters">

                    <i class="bi bi-arrow-clockwise"></i>

                </a>

            @endif

        </form>

        {{-- Results Heading --}}
        <div class="gallery-results-heading">

            <div>
                <h5>Gallery Folders</h5>

                <p>
                    Manage public folders and the photos inside each folder.
                </p>
            </div>

            <span class="gallery-result-count">

                {{ $galleries->total() }}

                {{ \Illuminate\Support\Str::plural(
                    'folder',
                    $galleries->total()
                ) }}

            </span>

        </div>

        {{-- Folder Grid --}}
        <div class="gallery-folder-grid">

            @forelse ($galleries as $gallery)

                @php
                    $photoCount = $gallery->images_count
                        ?? $gallery->images->count();
                @endphp

                <article class="gallery-folder-card">

                    {{-- Cover --}}
                    <div class="gallery-folder-cover">

                        <img
                            src="{{ $gallery->image_url }}"
                            alt="{{ $gallery->title }}"
                            loading="lazy"
                            onerror="this.onerror=null; this.src='{{ asset('images/readingarea.jpg') }}';">

                        <div class="gallery-cover-shade"></div>

                        <div class="gallery-cover-badges">

                            <span class="photo-count-badge">

                                <i class="bi bi-images"></i>

                                {{ $photoCount }}

                                {{ \Illuminate\Support\Str::plural(
                                    'photo',
                                    $photoCount
                                ) }}

                            </span>

                            <span class="gallery-status-badge {{ $gallery->is_active ? 'active' : 'inactive' }}">

                                <span class="status-dot"></span>

                                {{ $gallery->is_active
                                    ? 'Active'
                                    : 'Inactive'
                                }}

                            </span>

                        </div>

                        <span class="folder-cover-icon">
                            <i class="bi bi-folder-fill"></i>
                        </span>

                    </div>

                    {{-- Folder Information --}}
                    <div class="gallery-folder-content">

                        <h3 title="{{ $gallery->title }}">
                            {{ $gallery->title }}
                        </h3>

                        <div class="gallery-folder-meta">

                            <span>
                                <i class="bi bi-calendar3"></i>

                                {{ $gallery->created_at
                                    ? $gallery->created_at->format('M d, Y')
                                    : 'Date unavailable'
                                }}
                            </span>

                            <span>
                                <i class="bi bi-collection-fill"></i>

                                {{ $photoCount }}

                                {{ \Illuminate\Support\Str::plural(
                                    'item',
                                    $photoCount
                                ) }}

                            </span>

                        </div>

                        {{-- Actions --}}
                        <div class="gallery-folder-actions">

                            <a
                                href="{{ route('admin.gallery.edit', $gallery) }}"
                                class="gallery-edit-button">

                                <i class="bi bi-pencil-square"></i>
                                Manage Folder

                            </a>

                            <form
                                action="{{ route('admin.gallery.destroy', $gallery) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to permanently delete this gallery folder and all of its photos?');">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="gallery-delete-button"
                                    title="Delete folder"
                                    aria-label="Delete {{ $gallery->title }}">

                                    <i class="bi bi-trash3"></i>

                                </button>

                            </form>

                        </div>

                    </div>

                </article>

            @empty

                <div class="gallery-empty-state">

                    <span class="gallery-empty-icon">
                        <i class="bi bi-folder2-open"></i>
                    </span>

                    <h4>No gallery folders found</h4>

                    <p>
                        @if (request()->filled('search') || request()->filled('status'))
                            No gallery folders match your current filters.
                        @else
                            Create your first folder to begin building the public gallery.
                        @endif
                    </p>

                    @if (request()->filled('search') || request()->filled('status'))

                        <a
                            href="{{ route('admin.gallery.index') }}"
                            class="gallery-empty-secondary">

                            <i class="bi bi-arrow-clockwise"></i>
                            Clear Filters

                        </a>

                    @else

                        <a
                            href="{{ route('admin.gallery.create') }}"
                            class="gallery-empty-primary">

                            <i class="bi bi-folder-plus"></i>
                            Add Gallery Folder

                        </a>

                    @endif

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
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
        --gallery-navy: #0b2e59;
        --gallery-blue: #184b8c;
        --gallery-gold: #f4b400;
        padding: 24px;
    }

    /* Header */

    .gallery-list-header {
        position: relative;
        min-height: 142px;
        margin-bottom: 20px;
        padding: 27px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(244, 180, 0, .23),
                transparent 28%
            ),
            linear-gradient(
                125deg,
                var(--gallery-navy),
                var(--gallery-blue)
            );
        border-radius: 22px;
        box-shadow: 0 16px 36px rgba(11, 46, 89, .15);
    }

    .gallery-list-header::after {
        content: "";
        position: absolute;
        right: 16%;
        bottom: -86px;
        width: 180px;
        height: 180px;
        border: 27px solid rgba(255, 255, 255, .05);
        border-radius: 50%;
        pointer-events: none;
    }

    .gallery-list-heading {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .gallery-list-icon {
        width: 60px;
        height: 60px;
        flex: 0 0 60px;
        display: grid;
        place-items: center;
        color: var(--gallery-navy);
        background: var(--gallery-gold);
        border-radius: 17px;
        font-size: 25px;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .14);
    }

    .gallery-list-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .gallery-list-header h2 {
        margin: 0 0 5px;
        font-size: clamp(23px, 3vw, 30px);
        font-weight: 800;
    }

    .gallery-list-header p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
    }

    .gallery-add-button {
        position: relative;
        z-index: 1;
        min-height: 44px;
        padding: 0 17px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: var(--gallery-navy);
        background: var(--gallery-gold);
        border: 1px solid var(--gallery-gold);
        border-radius: 11px;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 9px 20px rgba(0, 0, 0, .13);
        transition: .2s ease;
    }

    .gallery-add-button:hover {
        color: var(--gallery-navy);
        background: #ffc928;
        border-color: #ffc928;
        transform: translateY(-2px);
    }

    /* Success Alert */

    .gallery-success-alert {
        position: relative;
        margin-bottom: 18px;
        padding: 13px 48px 13px 14px;
        display: flex;
        align-items: center;
        gap: 11px;
        color: #276749;
        background: #f0fff7;
        border: 1px solid #bee6ce;
        border-left: 4px solid #2f9e63;
        border-radius: 13px;
    }

    .gallery-success-icon {
        width: 35px;
        height: 35px;
        flex: 0 0 35px;
        display: grid;
        place-items: center;
        color: #fff;
        background: #2f9e63;
        border-radius: 10px;
    }

    .gallery-success-alert strong {
        display: block;
        margin-bottom: 1px;
        font-size: 12px;
    }

    .gallery-success-alert p {
        margin: 0;
        color: #52856a;
        font-size: 10px;
    }

    .gallery-success-alert .btn-close {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%) scale(.75);
    }

    /* Main Card */

    .gallery-management-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e0e6ee;
        border-radius: 20px;
        box-shadow: 0 13px 32px rgba(11, 46, 89, .08);
    }

    /* Filters */

    .gallery-filters {
        padding: 19px 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f9fbfd;
        border-bottom: 1px solid #e9edf3;
    }

    .gallery-search {
        position: relative;
        flex: 1;
        min-width: 220px;
    }

    .gallery-search i {
        position: absolute;
        top: 50%;
        left: 14px;
        color: #8591a1;
        font-size: 13px;
        transform: translateY(-50%);
    }

    .gallery-search input {
        width: 100%;
        height: 43px;
        padding: 0 14px 0 39px;
        color: #33465e;
        background: #fff;
        border: 1px solid #dbe2eb;
        border-radius: 10px;
        font-size: 11px;
        outline: none;
        transition: .2s ease;
    }

    .gallery-search input:focus {
        border-color: var(--gallery-blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .08);
    }

    .gallery-status-filter {
        width: 180px;
        height: 43px;
        color: #43546a;
        background-color: #fff;
        border-color: #dbe2eb;
        border-radius: 10px;
        font-size: 11px;
        box-shadow: none;
    }

    .gallery-status-filter:focus {
        border-color: var(--gallery-blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .08);
    }

    .gallery-filter-button,
    .gallery-reset-button {
        height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .gallery-filter-button {
        padding: 0 16px;
        gap: 7px;
        color: #fff;
        background: var(--gallery-navy);
        border: 1px solid var(--gallery-navy);
    }

    .gallery-filter-button:hover {
        background: var(--gallery-blue);
        border-color: var(--gallery-blue);
    }

    .gallery-reset-button {
        width: 43px;
        color: #657386;
        background: #fff;
        border: 1px solid #dbe2eb;
        text-decoration: none;
    }

    .gallery-reset-button:hover {
        color: var(--gallery-navy);
        border-color: #aab8c8;
    }

    /* Results Heading */

    .gallery-results-heading {
        padding: 20px 22px 17px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .gallery-results-heading h5 {
        margin: 0 0 3px;
        color: var(--gallery-navy);
        font-size: 15px;
        font-weight: 800;
    }

    .gallery-results-heading p {
        margin: 0;
        color: #8390a1;
        font-size: 10px;
    }

    .gallery-result-count {
        padding: 6px 10px;
        color: #68768a;
        background: #f0f3f7;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    /* Folder Grid */

    .gallery-folder-grid {
        padding: 0 22px 23px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
    }

    .gallery-folder-card {
        min-width: 0;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e0e6ed;
        border-radius: 15px;
        box-shadow: 0 7px 19px rgba(11, 46, 89, .06);
        transition: .25s ease;
    }

    .gallery-folder-card:hover {
        border-color: #c8d3df;
        box-shadow: 0 14px 28px rgba(11, 46, 89, .12);
        transform: translateY(-4px);
    }

    /* Folder Cover */

    .gallery-folder-cover {
        position: relative;
        height: 205px;
        overflow: hidden;
        background: #e9eef5;
    }

    .gallery-folder-cover > img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
        transition: transform .4s ease;
    }

    .gallery-folder-card:hover .gallery-folder-cover > img {
        transform: scale(1.045);
    }

    .gallery-cover-shade {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: linear-gradient(
            180deg,
            rgba(11, 46, 89, .20),
            transparent 48%,
            rgba(11, 46, 89, .58)
        );
    }

    .gallery-cover-badges {
        position: absolute;
        top: 11px;
        right: 11px;
        left: 11px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .photo-count-badge,
    .gallery-status-badge {
        min-height: 27px;
        padding: 0 9px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 800;
    }

    .photo-count-badge {
        color: var(--gallery-navy);
        background: var(--gallery-gold);
    }

    .gallery-status-badge {
        color: #fff;
    }

    .gallery-status-badge .status-dot {
        width: 6px;
        height: 6px;
        background: currentColor;
        border-radius: 50%;
    }

    .gallery-status-badge.active {
        background: rgba(25, 135, 84, .92);
    }

    .gallery-status-badge.inactive {
        background: rgba(108, 117, 125, .92);
    }

    .folder-cover-icon {
        position: absolute;
        right: 14px;
        bottom: 13px;
        color: rgba(255, 255, 255, .90);
        font-size: 25px;
    }

    /* Folder Content */

    .gallery-folder-content {
        padding: 17px;
    }

    .gallery-folder-content h3 {
        margin: 0 0 10px;
        overflow: hidden;
        color: var(--gallery-navy);
        font-size: 14px;
        font-weight: 800;
        line-height: 1.4;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .gallery-folder-meta {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        color: #7b8797;
        font-size: 9px;
    }

    .gallery-folder-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .gallery-folder-meta i {
        color: var(--gallery-blue);
    }

    /* Actions */

    .gallery-folder-actions {
        padding-top: 13px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) 40px;
        gap: 8px;
        border-top: 1px solid #edf0f4;
    }

    .gallery-folder-actions form {
        margin: 0;
    }

    .gallery-edit-button,
    .gallery-delete-button {
        width: 100%;
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .gallery-edit-button {
        color: var(--gallery-blue);
        background: #edf4fc;
        border: 1px solid #d5e4f6;
    }

    .gallery-edit-button:hover {
        color: #fff;
        background: var(--gallery-blue);
        border-color: var(--gallery-blue);
    }

    .gallery-delete-button {
        color: #c14343;
        background: #fff2f2;
        border: 1px solid #f0d4d4;
    }

    .gallery-delete-button:hover {
        color: #fff;
        background: #d84b4b;
        border-color: #d84b4b;
    }

    /* Empty State */

    .gallery-empty-state {
        grid-column: 1 / -1;
        padding: 65px 20px;
        text-align: center;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 15px;
    }

    .gallery-empty-icon {
        width: 66px;
        height: 66px;
        margin: 0 auto 15px;
        display: grid;
        place-items: center;
        color: var(--gallery-navy);
        background: #e9eff6;
        border-radius: 18px;
        font-size: 28px;
    }

    .gallery-empty-state h4 {
        margin: 0 0 6px;
        color: var(--gallery-navy);
        font-size: 16px;
        font-weight: 800;
    }

    .gallery-empty-state p {
        margin: 0 auto 17px;
        color: #7e8a9a;
        font-size: 11px;
    }

    .gallery-empty-primary,
    .gallery-empty-secondary {
        min-height: 40px;
        padding: 0 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
    }

    .gallery-empty-primary {
        color: #fff;
        background: var(--gallery-navy);
        border: 1px solid var(--gallery-navy);
    }

    .gallery-empty-primary:hover {
        color: var(--gallery-navy);
        background: var(--gallery-gold);
        border-color: var(--gallery-gold);
    }

    .gallery-empty-secondary {
        color: var(--gallery-navy);
        background: #fff;
        border: 1px solid #ccd5e0;
    }

    /* Pagination */

    .gallery-pagination {
        padding: 15px 22px;
        border-top: 1px solid #e9edf3;
    }

    .gallery-pagination nav {
        margin: 0;
    }

    /* Responsive */

    @media (max-width: 1199.98px) {
        .gallery-folder-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .gallery-list-page {
            padding: 16px 10px;
        }

        .gallery-list-header {
            padding: 23px 20px;
            align-items: flex-start;
            flex-direction: column;
            border-radius: 18px;
        }

        .gallery-list-icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
            font-size: 22px;
        }

        .gallery-add-button {
            width: 100%;
        }

        .gallery-filters {
            align-items: stretch;
            flex-direction: column;
        }

        .gallery-search,
        .gallery-status-filter,
        .gallery-filter-button,
        .gallery-reset-button {
            width: 100%;
            min-width: 0;
        }

        .gallery-folder-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 420px) {
        .gallery-list-heading {
            align-items: flex-start;
        }

        .gallery-results-heading,
        .gallery-folder-meta {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush