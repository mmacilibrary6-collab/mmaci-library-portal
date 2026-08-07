@extends('layouts.admin')

@section('title', 'New Arrivals')
@section('page-title', 'New Arrivals')

@section('content')
<div class="container-fluid arrivals-page">
    <section class="arrivals-hero">
        <div class="hero-copy">
            <span class="hero-icon">
                <i class="bi bi-book-half"></i>
            </span>

            <div>
                <span class="hero-eyebrow">
                    Collection Management
                </span>

                <h2>New Arrivals</h2>

                <p>
                    Manage newly acquired printed library materials.
                </p>
            </div>
        </div>

        <a
            href="{{ route('admin.new-arrivals.create') }}"
            class="btn-add-arrival">

            <i class="bi bi-plus-lg"></i>
            Add New Arrival
        </a>
    </section>


    <section class="arrivals-panel">
        <div class="panel-toolbar">
            <div class="toolbar-title">
                <h5>Arrival Records</h5>

                <p>
                    {{ $arrivals->total() }}

                    {{ \Illuminate\Support\Str::plural(
                        'material',
                        $arrivals->total()
                    ) }}

                    found
                </p>
            </div>

            <form
                action="{{ route('admin.new-arrivals.index') }}"
                method="GET"
                class="filter-form">

                <div class="search-field">
                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search title, author or accession no..."
                        aria-label="Search by title, author, or accession number">
                </div>

                <select
                    name="availability_status"
                    aria-label="Availability">

                    <option value="">
                        All Statuses
                    </option>

                    <option
                        value="available"
                        @selected(
                            request('availability_status') === 'available'
                        )>

                        Available
                    </option>

                    <option
                        value="unavailable"
                        @selected(
                            request('availability_status') === 'unavailable'
                        )>

                        Unavailable
                    </option>
                </select>

                <button
                    type="submit"
                    class="filter-button">

                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

                @if(request()->hasAny([
                    'search',
                    'availability_status'
                ]))
                    <a
                        href="{{ route('admin.new-arrivals.index') }}"
                        class="reset-button"
                        title="Clear filters"
                        aria-label="Clear filters">

                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table arrivals-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="number-column">#</th>

                        <th>Accession No.</th>

                        <th>Material</th>

                        <th>Category</th>

                        <th class="text-center">
                            Availability
                        </th>

                        <th>Arrival Date</th>

                        <th class="text-end">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($arrivals as $arrival)
                        <tr>
                            <td class="row-number">
                                {{ ($arrivals->firstItem() ?? 1) + $loop->index }}
                            </td>

                            <td class="accession-cell">
                                <span class="accession-number">
                                    {{ $arrival->accession_number ?: 'Not assigned' }}
                                </span>
                            </td>

                            <td>
                                <div class="material-identity">
                                    <img
                                        src="{{ $arrival->image_url }}"
                                        alt="{{ $arrival->title }}"
                                        onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">

                                    <div>
                                        <strong>
                                            {{ $arrival->title }}
                                        </strong>

                                        <span>
                                            {{ filled($arrival->author)
                                                ? $arrival->author
                                                : 'No author specified' }}
                                        </span>

                                        @if(filled($arrival->description))
                                            <small>
                                                {{ \Illuminate\Support\Str::limit(
                                                    $arrival->description,
                                                    58
                                                ) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="category-cell">
                                {{ $arrival->category ?: 'Uncategorized' }}
                            </td>

                            <td class="text-center">
                                <span class="status-badge {{ $arrival->availability_status }}">
                                    <span></span>

                                    {{ $arrival->availability_status === 'available'
                                        ? 'Available'
                                        : 'Unavailable' }}
                                </span>
                            </td>

                            <td class="date-cell">
                                <i class="bi bi-calendar3"></i>

                                {{ filled($arrival->arrival_date)
                                    ? \Illuminate\Support\Carbon::parse(
                                        $arrival->arrival_date
                                    )->format('M d, Y')
                                    : 'Not specified' }}
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a
                                        href="{{ route(
                                            'admin.new-arrivals.edit',
                                            $arrival
                                        ) }}"
                                        class="action-button edit"
                                        title="Edit {{ $arrival->title }}"
                                        aria-label="Edit {{ $arrival->title }}">

                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form
                                        action="{{ route(
                                            'admin.new-arrivals.destroy',
                                            $arrival
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this new-arrival record? This cannot be undone.');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button delete"
                                            title="Delete {{ $arrival->title }}"
                                            aria-label="Delete {{ $arrival->title }}">

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
                                    <span>
                                        <i class="bi bi-journal-x"></i>
                                    </span>

                                    <h5>No arrivals found</h5>

                                    <p>
                                        @if(request()->hasAny([
                                            'search',
                                            'availability_status'
                                        ]))
                                            Try adjusting or clearing your filters.
                                        @else
                                            Add your first newly acquired material.
                                        @endif
                                    </p>

                                    <a
                                        href="{{ request()->hasAny([
                                            'search',
                                            'availability_status'
                                        ])
                                            ? route('admin.new-arrivals.index')
                                            : route('admin.new-arrivals.create') }}">

                                        <i class="bi {{ request()->hasAny([
                                            'search',
                                            'availability_status'
                                        ])
                                            ? 'bi-x-lg'
                                            : 'bi-plus-lg' }}"></i>

                                        {{ request()->hasAny([
                                            'search',
                                            'availability_status'
                                        ])
                                            ? 'Clear Filters'
                                            : 'Add New Arrival' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($arrivals->hasPages())
            <div class="panel-footer">
                <p>
                    Showing
                    {{ $arrivals->firstItem() }}–{{ $arrivals->lastItem() }}
                    of {{ $arrivals->total() }}
                </p>

                <div>
                    {{ $arrivals->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </section>
</div>
@endsection

@push('styles')
<style>
.arrivals-page {
    --navy: #0b2e59;
    --blue: #184b8c;
    --gold: #f4b400;
    --ink: #253851;
    --muted: #778599;
    --line: #e4eaf1;

    padding: 24px;
}

.arrivals-hero {
    position: relative;
    min-height: 150px;
    margin-bottom: 22px;
    padding: 28px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    overflow: hidden;
    color: #ffffff;
    background:
        radial-gradient(
            circle at 90% 10%,
            rgba(244, 180, 0, 0.20),
            transparent 28%
        ),
        linear-gradient(125deg, var(--navy), var(--blue));
    border-radius: 22px;
    box-shadow: 0 16px 36px rgba(11, 46, 89, 0.16);
}

.arrivals-hero::after {
    content: "";
    position: absolute;
    right: 12%;
    bottom: -70px;
    width: 180px;
    height: 180px;
    border: 28px solid rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

.hero-copy {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 18px;
}

.hero-icon {
    width: 62px;
    height: 62px;
    flex: 0 0 62px;
    display: grid;
    place-items: center;
    color: var(--navy);
    background: var(--gold);
    border-radius: 18px;
    font-size: 27px;
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.14);
}

.hero-eyebrow {
    display: block;
    margin-bottom: 4px;
    color: #ffd96d;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.arrivals-hero h2 {
    margin: 0 0 5px;
    font-size: clamp(24px, 3vw, 32px);
    font-weight: 800;
}

.arrivals-hero p {
    margin: 0;
    color: rgba(255, 255, 255, 0.72);
    font-size: 12px;
}

.btn-add-arrival {
    position: relative;
    z-index: 1;
    min-height: 46px;
    padding: 0 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    color: var(--navy);
    background: var(--gold);
    border-radius: 12px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 10px 22px rgba(0, 0, 0, 0.15);
    transition: 0.2s ease;
}

.btn-add-arrival:hover {
    color: var(--navy);
    background: #ffc62b;
    transform: translateY(-2px);
}

.arrivals-panel {
    overflow: hidden;
    background: #ffffff;
    border: 1px solid var(--line);
    border-radius: 20px;
    box-shadow: 0 12px 30px rgba(25, 50, 80, 0.07);
}

.panel-toolbar {
    padding: 20px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    border-bottom: 1px solid var(--line);
}

.toolbar-title {
    flex: 0 0 auto;
}

.toolbar-title h5 {
    margin: 0 0 3px;
    color: var(--navy);
    font-size: 16px;
    font-weight: 800;
}

.toolbar-title p {
    margin: 0;
    color: var(--muted);
    font-size: 10px;
}

.filter-form {
    flex: 1;
    display: flex;
    justify-content: flex-end;
    gap: 7px;
}

.search-field {
    position: relative;
    width: min(100%, 340px);
}

.search-field i {
    position: absolute;
    top: 50%;
    left: 13px;
    color: #95a1b1;
    transform: translateY(-50%);
}

.search-field input,
.filter-form select {
    height: 41px;
    color: var(--ink);
    background: #ffffff;
    border: 1px solid var(--line);
    border-radius: 10px;
    outline: none;
    font-size: 11px;
}

.search-field input {
    width: 100%;
    padding: 0 13px 0 38px;
}

.filter-form select {
    width: 145px;
    padding: 0 30px 0 11px;
}

.search-field input:focus,
.filter-form select:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(24, 75, 140, 0.09);
}

.filter-button,
.reset-button {
    height: 41px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 11px;
    text-decoration: none;
}

.filter-button {
    padding: 0 14px;
    gap: 6px;
    color: #ffffff;
    background: var(--navy);
    border: 0;
    font-weight: 700;
}

.filter-button:hover {
    background: var(--blue);
}

.reset-button {
    width: 41px;
    color: #7b8797;
    background: #ffffff;
    border: 1px solid var(--line);
}

.reset-button:hover {
    color: var(--navy);
    background: #f3f6f9;
}

.arrivals-table {
    min-width: 1030px;
}

.arrivals-table thead th {
    padding: 13px 17px;
    color: #7b8798;
    background: #f8fafc;
    border: 0;
    border-bottom: 1px solid var(--line);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    white-space: nowrap;
}

.arrivals-table tbody td {
    padding: 14px 17px;
    color: var(--ink);
    border-color: #edf0f4;
    font-size: 11px;
}

.arrivals-table tbody tr:hover {
    background: #fbfcfe;
}

.number-column,
.row-number {
    width: 54px;
    color: #99a5b4 !important;
    text-align: center;
}

.accession-cell {
    min-width: 145px;
}

.accession-number {
    display: inline-flex;
    align-items: center;
    padding: 7px 10px;
    color: var(--navy);
    background: #edf4fb;
    border: 1px solid #d8e4f2;
    border-radius: 9px;
    font-family:
        ui-monospace,
        SFMono-Regular,
        Menlo,
        Monaco,
        Consolas,
        "Liberation Mono",
        "Courier New",
        monospace;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.03em;
    white-space: nowrap;
}

.material-identity {
    min-width: 285px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.material-identity img {
    width: 50px;
    height: 68px;
    flex: 0 0 50px;
    object-fit: cover;
    background: #f4f6f8;
    border: 1px solid #e3e8ee;
    border-radius: 8px;
    box-shadow: 0 5px 12px rgba(28, 49, 72, 0.08);
}

.material-identity strong,
.material-identity span,
.material-identity small {
    display: block;
}

.material-identity strong {
    margin-bottom: 3px;
    color: var(--navy);
    font-size: 12px;
    font-weight: 800;
}

.material-identity span {
    color: #6f7e91;
    font-size: 10px;
}

.material-identity small {
    max-width: 300px;
    margin-top: 3px;
    color: #9aa5b3;
    font-size: 9px;
}

.category-cell {
    max-width: 165px;
    color: var(--muted) !important;
}

.status-badge {
    padding: 6px 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    border-radius: 20px;
    font-size: 9px;
    font-weight: 800;
    white-space: nowrap;
}

.status-badge > span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-badge.available {
    color: #1b7548;
    background: #eaf8f0;
}

.status-badge.available > span {
    background: #27a866;
}

.status-badge.unavailable {
    color: #687589;
    background: #f0f2f5;
}

.status-badge.unavailable > span {
    background: #8995a6;
}

.date-cell {
    color: #6f7e91 !important;
    white-space: nowrap;
}

.date-cell i {
    margin-right: 5px;
    color: #9aa5b3;
}

.table-actions {
    display: flex;
    justify-content: flex-end;
    gap: 7px;
}

.table-actions form {
    margin: 0;
}

.action-button {
    width: 34px;
    height: 34px;
    padding: 0;
    display: inline-grid;
    place-items: center;
    border: 1px solid transparent;
    border-radius: 9px;
    font-size: 12px;
    text-decoration: none;
    transition: 0.2s ease;
}

.action-button.edit {
    color: var(--blue);
    background: #f2f7fc;
    border-color: #d8e4f2;
}

.action-button.delete {
    color: #c53e3e;
    background: #fff5f5;
    border-color: #f3d8d8;
}

.action-button.edit:hover {
    color: #ffffff;
    background: var(--blue);
    transform: translateY(-1px);
}

.action-button.delete:hover {
    color: #ffffff;
    background: #d64a4a;
    transform: translateY(-1px);
}

.empty-state {
    padding: 58px 20px;
    text-align: center;
}

.empty-state > span {
    width: 62px;
    height: 62px;
    margin: 0 auto 14px;
    display: grid;
    place-items: center;
    color: var(--blue);
    background: #edf3f9;
    border-radius: 17px;
    font-size: 25px;
}

.empty-state h5 {
    margin-bottom: 5px;
    color: var(--navy);
    font-size: 15px;
    font-weight: 800;
}

.empty-state p {
    margin-bottom: 14px;
    color: var(--muted);
    font-size: 11px;
}

.empty-state a {
    min-height: 39px;
    padding: 0 13px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #ffffff;
    background: var(--navy);
    border-radius: 9px;
    font-size: 10px;
    font-weight: 700;
    text-decoration: none;
}

.panel-footer {
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    background: #fbfcfd;
    border-top: 1px solid var(--line);
}

.panel-footer p {
    margin: 0;
    color: var(--muted);
    font-size: 10px;
}

.panel-footer .pagination {
    margin: 0;
}

@media (max-width: 991.98px) {
    .panel-toolbar {
        align-items: flex-start;
        flex-direction: column;
    }

    .filter-form {
        width: 100%;
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    .search-field {
        width: 100%;
    }

    .filter-form select {
        flex: 1;
    }
}

@media (max-width: 767.98px) {
    .arrivals-page {
        padding: 16px 10px;
    }

    .arrivals-hero {
        padding: 24px 20px;
        align-items: flex-start;
        flex-direction: column;
    }

    .hero-icon {
        width: 52px;
        height: 52px;
        flex-basis: 52px;
        font-size: 22px;
    }

    .btn-add-arrival {
        width: 100%;
    }

    .panel-footer {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .hero-copy {
        align-items: flex-start;
    }

    .filter-form select,
    .filter-button {
        width: 100%;
        flex: 0 0 100%;
    }
}
</style>
@endpush