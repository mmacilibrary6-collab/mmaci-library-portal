@extends('layouts.admin')

@section('title', 'Open Access Resources')
@section('page-title', 'Open Access Resources')

@section('content')

<div class="container-fluid resource-list-page">

    {{-- Header --}}
    <section class="resource-list-header">

        <div class="resource-list-heading">

            <span class="resource-list-icon">
                <i class="bi bi-globe-americas"></i>
            </span>

            <div>
                <span class="resource-list-eyebrow">
                    Digital Collection
                </span>

                <h2>Open Access Resources</h2>

                <p>
                    Manage educational websites, databases, and online resources.
                </p>
            </div>

        </div>

        <a
            href="{{ route('admin.open-access-resources.create') }}"
            class="resource-add-button">

            <i class="bi bi-plus-lg"></i>
            Add Resource

        </a>

    </section>

    {{-- Success Message --}}
    @if (session('success'))

        <div class="resource-success-alert alert alert-dismissible fade show">

            <span class="success-alert-icon">
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

    <section class="resource-management-card">

        {{-- Filters --}}
        <form
            action="{{ route('admin.open-access-resources.index') }}"
            method="GET"
            class="resource-filters">

            <div class="resource-search">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search resource titles"
                    aria-label="Search resources">

            </div>

            <select
                name="status"
                class="form-select resource-status-filter"
                aria-label="Filter by status">

                <option value="">All statuses</option>

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

            <button type="submit" class="resource-filter-button">
                <i class="bi bi-funnel-fill"></i>
                Filter
            </button>

            @if (request()->filled('search') || request()->filled('status'))

                <a
                    href="{{ route('admin.open-access-resources.index') }}"
                    class="resource-reset-button"
                    title="Clear filters">

                    <i class="bi bi-arrow-clockwise"></i>

                </a>

            @endif

        </form>

        {{-- Results Heading --}}
        <div class="resource-results-heading">

            <div>
                <h5>Available Resources</h5>
                <p>Manage external resources displayed on the website.</p>
            </div>

            <span class="resource-count">
                {{ $resources->total() }}
                {{ \Illuminate\Support\Str::plural(
                    'resource',
                    $resources->total()
                ) }}
            </span>

        </div>

        {{-- Resource Grid --}}
        <div class="resource-grid">

            @forelse ($resources as $resource)

                <article class="resource-card">

                    <div class="resource-card-image">

                        <img
                            src="{{ $resource->image_url }}"
                            alt="{{ $resource->title }}"
                            loading="lazy"
                            onerror="this.onerror=null; this.src='{{ asset('images/default-resource.png') }}';">

                        <div class="resource-card-badges">

                            <span class="resource-order">
                                <i class="bi bi-list-ol"></i>
                                {{ $resource->sort_order }}
                            </span>

                            <span class="resource-status {{ $resource->is_active ? 'active' : 'inactive' }}">

                                <span></span>

                                {{ $resource->is_active
                                    ? 'Active'
                                    : 'Inactive'
                                }}

                            </span>

                        </div>

                    </div>

                    <div class="resource-card-content">

                        <h3 title="{{ $resource->title }}">
                            {{ $resource->title }}
                        </h3>

                        <p>
                            {{ \Illuminate\Support\Str::limit(
                                $resource->description
                                    ?: 'No description was provided for this resource.',
                                115
                            ) }}
                        </p>

                        <a
                            href="{{ $resource->website_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="resource-website-link">

                            <i class="bi bi-box-arrow-up-right"></i>

                            <span>
                                Visit Website
                            </span>

                        </a>

                        <div class="resource-card-actions">

                            <a
                                href="{{ route(
                                    'admin.open-access-resources.edit',
                                    $resource
                                ) }}"
                                class="resource-edit-button">

                                <i class="bi bi-pencil-square"></i>
                                Edit

                            </a>

                            <form
                                action="{{ route(
                                    'admin.open-access-resources.destroy',
                                    $resource
                                ) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to permanently delete this resource?');">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="resource-delete-button">

                                    <i class="bi bi-trash3"></i>
                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                </article>

            @empty

                <div class="resource-empty-state">

                    <span class="resource-empty-icon">
                        <i class="bi bi-globe2"></i>
                    </span>

                    <h4>No resources found</h4>

                    <p>
                        @if (request()->filled('search') || request()->filled('status'))
                            No resources match your current filters.
                        @else
                            Add your first open access resource to get started.
                        @endif
                    </p>

                    @if (request()->filled('search') || request()->filled('status'))

                        <a
                            href="{{ route('admin.open-access-resources.index') }}"
                            class="empty-secondary-button">

                            <i class="bi bi-arrow-clockwise"></i>
                            Clear Filters

                        </a>

                    @else

                        <a
                            href="{{ route('admin.open-access-resources.create') }}"
                            class="empty-primary-button">

                            <i class="bi bi-plus-lg"></i>
                            Add Resource

                        </a>

                    @endif

                </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($resources->hasPages())

            <div class="resource-pagination">
                {{ $resources->withQueryString()->links() }}
            </div>

        @endif

    </section>

</div>

@endsection

@push('styles')
<style>
    .resource-list-page {
        --resource-navy: #0b2e59;
        --resource-blue: #184b8c;
        --resource-gold: #f4b400;
        padding: 24px;
    }

    .resource-list-header {
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
                var(--resource-navy),
                var(--resource-blue)
            );
        border-radius: 22px;
        box-shadow: 0 16px 36px rgba(11, 46, 89, .15);
    }

    .resource-list-header::after {
        content: "";
        position: absolute;
        right: 16%;
        bottom: -86px;
        width: 180px;
        height: 180px;
        border: 27px solid rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .resource-list-heading {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .resource-list-icon {
        width: 60px;
        height: 60px;
        flex: 0 0 60px;
        display: grid;
        place-items: center;
        color: var(--resource-navy);
        background: var(--resource-gold);
        border-radius: 17px;
        font-size: 25px;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .14);
    }

    .resource-list-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .resource-list-header h2 {
        margin: 0 0 5px;
        font-size: clamp(23px, 3vw, 30px);
        font-weight: 800;
    }

    .resource-list-header p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
    }

    .resource-add-button {
        position: relative;
        z-index: 1;
        min-height: 44px;
        padding: 0 17px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: var(--resource-navy);
        background: var(--resource-gold);
        border: 1px solid var(--resource-gold);
        border-radius: 11px;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 9px 20px rgba(0, 0, 0, .13);
        transition: .2s ease;
    }

    .resource-add-button:hover {
        color: var(--resource-navy);
        background: #ffc928;
        border-color: #ffc928;
        transform: translateY(-2px);
    }

    .resource-success-alert {
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

    .success-alert-icon {
        width: 35px;
        height: 35px;
        flex: 0 0 35px;
        display: grid;
        place-items: center;
        color: #fff;
        background: #2f9e63;
        border-radius: 10px;
    }

    .resource-success-alert strong {
        display: block;
        margin-bottom: 1px;
        font-size: 12px;
    }

    .resource-success-alert p {
        margin: 0;
        color: #52856a;
        font-size: 10px;
    }

    .resource-success-alert .btn-close {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%) scale(.75);
    }

    .resource-management-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e0e6ee;
        border-radius: 20px;
        box-shadow: 0 13px 32px rgba(11, 46, 89, .08);
    }

    .resource-filters {
        padding: 19px 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f9fbfd;
        border-bottom: 1px solid #e9edf3;
    }

    .resource-search {
        position: relative;
        flex: 1;
        min-width: 220px;
    }

    .resource-search i {
        position: absolute;
        top: 50%;
        left: 14px;
        color: #8591a1;
        font-size: 13px;
        transform: translateY(-50%);
    }

    .resource-search input {
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

    .resource-search input:focus {
        border-color: var(--resource-blue);
        box-shadow: 0 0 0 4px rgba(24, 75, 140, .08);
    }

    .resource-status-filter {
        width: 180px;
        height: 43px;
        color: #43546a;
        background-color: #fff;
        border-color: #dbe2eb;
        border-radius: 10px;
        font-size: 11px;
        box-shadow: none;
    }

    .resource-filter-button,
    .resource-reset-button {
        height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 700;
        transition: .2s ease;
    }

    .resource-filter-button {
        padding: 0 16px;
        gap: 7px;
        color: #fff;
        background: var(--resource-navy);
        border: 1px solid var(--resource-navy);
    }

    .resource-filter-button:hover {
        background: var(--resource-blue);
        border-color: var(--resource-blue);
    }

    .resource-reset-button {
        width: 43px;
        color: #657386;
        background: #fff;
        border: 1px solid #dbe2eb;
        text-decoration: none;
    }

    .resource-reset-button:hover {
        color: var(--resource-navy);
        border-color: #aab8c8;
    }

    .resource-results-heading {
        padding: 20px 22px 17px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .resource-results-heading h5 {
        margin: 0 0 3px;
        color: var(--resource-navy);
        font-size: 15px;
        font-weight: 800;
    }

    .resource-results-heading p {
        margin: 0;
        color: #8390a1;
        font-size: 10px;
    }

    .resource-count {
        padding: 6px 10px;
        color: #68768a;
        background: #f0f3f7;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
    }

    .resource-grid {
        padding: 0 22px 23px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
    }

    .resource-card {
        min-width: 0;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e0e6ed;
        border-radius: 15px;
        box-shadow: 0 7px 19px rgba(11, 46, 89, .06);
        transition: .25s ease;
    }

    .resource-card:hover {
        border-color: #c8d3df;
        box-shadow: 0 14px 28px rgba(11, 46, 89, .12);
        transform: translateY(-4px);
    }

    .resource-card-image {
        position: relative;
        height: 190px;
        padding: 27px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f3f6fa;
    }

    .resource-card-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
        transition: transform .35s ease;
    }

    .resource-card:hover .resource-card-image img {
        transform: scale(1.04);
    }

    .resource-card-badges {
        position: absolute;
        top: 11px;
        right: 11px;
        left: 11px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .resource-order,
    .resource-status {
        min-height: 27px;
        padding: 0 9px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 800;
    }

    .resource-order {
        color: var(--resource-navy);
        background: var(--resource-gold);
    }

    .resource-status {
        color: #fff;
    }

    .resource-status > span {
        width: 6px;
        height: 6px;
        background: currentColor;
        border-radius: 50%;
    }

    .resource-status.active {
        background: #198754;
    }

    .resource-status.inactive {
        background: #6c757d;
    }

    .resource-card-content {
        padding: 17px;
    }

    .resource-card-content h3 {
        margin: 0 0 8px;
        overflow: hidden;
        color: var(--resource-navy);
        font-size: 14px;
        font-weight: 800;
        line-height: 1.4;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .resource-card-content > p {
        min-height: 50px;
        margin: 0 0 10px;
        color: #758194;
        font-size: 10px;
        line-height: 1.65;
    }

    .resource-website-link {
        max-width: 100%;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--resource-blue);
        font-size: 10px;
        font-weight: 700;
        text-decoration: none;
    }

    .resource-website-link:hover {
        color: var(--resource-navy);
        text-decoration: underline;
    }

    .resource-card-actions {
        margin-top: 14px;
        padding-top: 13px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        border-top: 1px solid #edf0f4;
    }

    .resource-card-actions form {
        margin: 0;
    }

    .resource-edit-button,
    .resource-delete-button {
        width: 100%;
        min-height: 37px;
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

    .resource-edit-button {
        color: var(--resource-blue);
        background: #edf4fc;
        border: 1px solid #d5e4f6;
    }

    .resource-edit-button:hover {
        color: #fff;
        background: var(--resource-blue);
        border-color: var(--resource-blue);
    }

    .resource-delete-button {
        color: #c14343;
        background: #fff2f2;
        border: 1px solid #f0d4d4;
    }

    .resource-delete-button:hover {
        color: #fff;
        background: #d84b4b;
        border-color: #d84b4b;
    }

    .resource-empty-state {
        grid-column: 1 / -1;
        padding: 65px 20px;
        text-align: center;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 15px;
    }

    .resource-empty-icon {
        width: 66px;
        height: 66px;
        margin: 0 auto 15px;
        display: grid;
        place-items: center;
        color: var(--resource-navy);
        background: #e9eff6;
        border-radius: 18px;
        font-size: 28px;
    }

    .resource-empty-state h4 {
        margin: 0 0 6px;
        color: var(--resource-navy);
        font-size: 16px;
        font-weight: 800;
    }

    .resource-empty-state p {
        margin: 0 auto 17px;
        color: #7e8a9a;
        font-size: 11px;
    }

    .empty-primary-button,
    .empty-secondary-button {
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

    .empty-primary-button {
        color: #fff;
        background: var(--resource-navy);
    }

    .empty-secondary-button {
        color: var(--resource-navy);
        background: #fff;
        border: 1px solid #ccd5e0;
    }

    .resource-pagination {
        padding: 15px 22px;
        border-top: 1px solid #e9edf3;
    }

    @media (max-width: 1199.98px) {
        .resource-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .resource-list-page {
            padding: 16px 10px;
        }

        .resource-list-header {
            padding: 23px 20px;
            align-items: flex-start;
            flex-direction: column;
            border-radius: 18px;
        }

        .resource-list-icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
            font-size: 22px;
        }

        .resource-add-button {
            width: 100%;
        }

        .resource-filters {
            align-items: stretch;
            flex-direction: column;
        }

        .resource-search,
        .resource-status-filter,
        .resource-filter-button,
        .resource-reset-button {
            width: 100%;
            min-width: 0;
        }

        .resource-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 420px) {
        .resource-list-heading {
            align-items: flex-start;
        }

        .resource-results-heading {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush