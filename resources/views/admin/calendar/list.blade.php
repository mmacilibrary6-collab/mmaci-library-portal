@extends('layouts.admin')

@section('title', 'Calendar Events')
@section('page-title', 'Calendar Events')

@section('content')
<div class="container-fluid calendar-page">
    <section class="calendar-hero">
        <div class="hero-copy">
            <span class="hero-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <rect x="3.5" y="5" width="17" height="15.5" rx="3.2" ry="3.2" fill="none" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M7 3.75v3.5M17 3.75v3.5M3.5 9.25h17" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    <rect x="7" y="11" width="2.5" height="2.5" rx="0.45" fill="currentColor"/>
                    <rect x="11" y="11" width="2.5" height="2.5" rx="0.45" fill="currentColor"/>
                    <rect x="15" y="11" width="2.5" height="2.5" rx="0.45" fill="currentColor"/>
                </svg>
            </span>

            <div>
                <span class="hero-eyebrow">Website Content</span>
                <h2>Calendar Events</h2>
                <p>Create, update, publish, or remove library events.</p>
            </div>
        </div>

        <a href="{{ route('admin.calendar.create') }}" class="btn-add-calendar">
            <i class="bi bi-calendar-plus"></i>
            Add Event
        </a>
    </section>

    <section class="calendar-panel">
        <div class="panel-toolbar">
            <div class="toolbar-title">
                <h5>Event Records</h5>
                <p>
                    {{ $events->total() }}
                    {{ \Illuminate\Support\Str::plural('event', $events->total()) }}
                    found
                </p>
            </div>

            <form method="GET" action="{{ route('admin.calendar.index') }}" class="filter-form">
                <div class="search-field">
                    <i class="bi bi-search"></i>
                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search by title, description, or location"
                        aria-label="Search calendar events">
                </div>

                <select id="status" name="status" aria-label="Event status">
                    <option value="">All Statuses</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                </select>

                <button type="submit" class="filter-button">
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.calendar.index') }}" class="reset-button" title="Clear filters" aria-label="Clear filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table calendar-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date &amp; Time</th>
                        <th>Location</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>
                                <div class="event-identity">
                                    <span class="event-icon"><i class="bi bi-calendar3"></i></span>

                                    <div>
                                        <strong>{{ $event->title }}</strong>
                                        <span>{{ \Illuminate\Support\Str::limit($event->description ?? 'No description provided.', 68) }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="time-cell">
                                @php
                                    $start = $event->event_date;
                                    $end = $event->event_end_date;
                                @endphp

                                <strong>
                                    @if($end && $start && $end > $start)
                                        {{ $start->format('M d') }} &mdash; {{ $end->format('M d, Y') }}
                                    @else
                                        {{ $start->format('M d, Y') }}
                                    @endif
                                </strong>

                                <span>
                                    @if($event->start_time)
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                        @if($event->end_time)
                                            &mdash; {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                        @endif
                                    @else
                                        Time not specified
                                    @endif
                                </span>
                            </td>

                            <td class="location-cell">
                                @if($event->location)
                                    <i class="bi bi-geo-alt"></i>
                                    <span>{{ $event->location }}</span>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="status-badge status-{{ $event->status }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="table-actions justify-content-end">
                                    <a
                                        href="{{ route('admin.calendar.edit', $event) }}"
                                        class="action-button edit"
                                        title="Edit {{ $event->title }}"
                                        aria-label="Edit {{ $event->title }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button
                                        type="button"
                                        class="action-button delete"
                                        title="Delete {{ $event->title }}"
                                        aria-label="Delete {{ $event->title }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteEventModal{{ $event->id }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>

                                <div class="modal fade" id="deleteEventModal{{ $event->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4">
                                            <div class="modal-body p-4 text-center">
                                                <div class="delete-icon mb-3">
                                                    <i class="bi bi-trash3"></i>
                                                </div>
                                                <h4 class="fw-bold text-dark">Delete Event?</h4>
                                                <p class="text-muted">
                                                    You are about to delete <strong>{{ $event->title }}</strong>.
                                                    This action cannot be undone.
                                                </p>
                                                <div class="d-flex justify-content-center gap-2 mt-4">
                                                    <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.calendar.destroy', $event) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <span><i class="bi bi-calendar-x"></i></span>
                                    <h5>No calendar events found</h5>
                                    <p>
                                        @if(request()->filled('search') || request()->filled('status'))
                                            Try adjusting or clearing your filters.
                                        @else
                                            Create your first event to show on the public website.
                                        @endif
                                    </p>

                                    <a href="{{ request()->filled('search') || request()->filled('status') ? route('admin.calendar.index') : route('admin.calendar.create') }}">
                                        <i class="bi {{ request()->filled('search') || request()->filled('status') ? 'bi-x-lg' : 'bi-plus-lg' }}"></i>
                                        {{ request()->filled('search') || request()->filled('status') ? 'Clear Filters' : 'Add Event' }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="panel-footer">
                <p>
                    Showing {{ $events->firstItem() }}â€“{{ $events->lastItem() }}
                    of {{ $events->total() }}
                </p>

                <div>{{ $events->withQueryString()->links() }}</div>
            </div>
        @endif
    </section>
</div>
@endsection

@push('styles')
<style>
    .calendar-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        --ink: #253851;
        --muted: #778599;
        --line: #e4eaf1;
        padding: 24px;
    }

    .calendar-hero {
        position: relative;
        overflow: hidden;
        min-height: 150px;
        margin-bottom: 22px;
        padding: 28px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        border-radius: 22px;
        background:
            radial-gradient(circle at 90% 10%, rgba(244, 180, 0, .2), transparent 28%),
            linear-gradient(125deg, var(--navy), var(--blue));
        color: #fff;
        box-shadow: 0 16px 36px rgba(11, 46, 89, .16);
    }

    .calendar-hero::after {
        content: "";
        position: absolute;
        right: 12%;
        bottom: -70px;
        width: 180px;
        height: 180px;
        border: 28px solid rgba(255, 255, 255, .05);
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
        border-radius: 18px;
        background: linear-gradient(145deg, #FFD65E, #F4B400);
        color: #0B2E59;
        font-size: 27px;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .14);
    }

    .hero-icon svg,
    .event-icon svg {
        width: 70%;
        height: 70%;
        display: block;
        color: currentColor;
        fill: none;
        stroke: currentColor;
    }

    .hero-icon svg {
        width: 62%;
        height: 62%;
    }

    .hero-icon i {
        display: none;
    }

    .hero-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .calendar-hero h2 {
        margin: 0 0 5px;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 800;
    }

    .calendar-hero p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
    }

    .btn-add-calendar {
        position: relative;
        z-index: 1;
        min-height: 46px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        border-radius: 12px;
        background: var(--gold);
        color: var(--navy);
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 22px rgba(0, 0, 0, .15);
        transition: .2s ease;
    }

    .btn-add-calendar:hover {
        background: #ffc62b;
        color: var(--navy);
        transform: translateY(-2px);
    }

    .page-alert {
        position: relative;
        margin-bottom: 18px;
        padding: 13px 48px 13px 14px;
        display: flex;
        align-items: center;
        gap: 11px;
        border-radius: 13px;
    }

    .page-alert > span {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: grid;
        place-items: center;
        border-radius: 9px;
    }

    .page-alert strong,
    .page-alert small {
        display: block;
    }

    .page-alert strong {
        font-size: 12px;
    }

    .page-alert small {
        font-size: 10px;
    }

    .page-alert.success {
        border: 1px solid #bde7d0;
        background: #f0fbf5;
        color: #17643b;
    }

    .page-alert.success > span {
        background: #d8f4e4;
    }

    .calendar-panel {
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 12px 30px rgba(25, 50, 80, .07);
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
        width: min(100%, 290px);
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
        border: 1px solid var(--line);
        border-radius: 10px;
        outline: none;
        background: #fff;
        color: var(--ink);
        font-size: 11px;
    }

    .search-field input {
        width: 100%;
        padding: 0 13px 0 38px;
    }

    .filter-form select {
        width: 125px;
        padding: 0 30px 0 11px;
    }

    .search-field input:focus,
    .filter-form select:focus {
        border-color: rgba(244, 180, 0, .7);
        box-shadow: 0 0 0 .14rem rgba(244, 180, 0, .12);
    }

    .filter-button,
    .reset-button {
        height: 41px;
        border: 0;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 11px;
        font-weight: 800;
    }

    .filter-button {
        padding: 0 16px;
        gap: 8px;
        background: var(--gold);
        color: var(--navy);
        box-shadow: 0 8px 18px rgba(244, 180, 0, .18);
    }

    .filter-button:hover {
        background: #ffc62b;
        color: var(--navy);
    }

    .reset-button {
        width: 41px;
        background: #edf3fb;
        color: var(--navy);
    }

    .calendar-table thead th {
        padding: 17px 18px;
        color: #667085;
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        font-size: .75rem;
        font-weight: 800;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .calendar-table tbody td {
        padding: 18px 18px;
        border-color: #edf0f4;
        vertical-align: middle;
    }

    .event-identity {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 280px;
    }

    .event-icon {
        width: 62px;
        height: 62px;
        flex-shrink: 0;
        position: relative;
        display: block;
        align-items: center;
        justify-content: center;
        color: #FFD65E;
        background: linear-gradient(145deg, #3474B8, #2B65AE);
        border: 0;
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(11, 46, 89, .14);
    }

    .event-icon i {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        display: block;
        color: #FFD65E;
        font-size: 1.35rem;
        line-height: 1;
    }

    .calendar-table tbody td:nth-child(1) {
        vertical-align: top;
    }

    .calendar-table tbody td:nth-child(2),
    .calendar-table tbody td:nth-child(3),
    .calendar-table tbody td:nth-child(4),
    .calendar-table tbody td:nth-child(5) {
        vertical-align: middle;
    }

    .event-identity,
    .time-cell,
    .location-cell,
    .status-badge,
    .table-actions {
        margin-top: 2px;
    }

    .event-identity {
        align-items: flex-start;
    }

    .event-icon {
        margin-top: 2px;
    }

    .event-identity strong {
        display: block;
        color: #1d2939;
        font-weight: 800;
    }

    .event-identity span {
        display: block;
        max-width: 380px;
        color: #667085;
        font-size: .8rem;
    }

    .time-cell strong {
        display: block;
        color: #1d2939;
        font-weight: 800;
    }

    .time-cell span,
    .location-cell {
        color: #667085;
        font-size: .85rem;
    }

    .location-cell {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 86px;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 800;
    }

    .status-published {
        color: #067647;
        background: #ecfdf3;
    }

    .status-draft {
        color: #6941c6;
        background: #f4f3ff;
    }

    .status-cancelled {
        color: #b42318;
        background: #fef3f2;
    }

    .table-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-button {
        width: 38px;
        height: 38px;
        border: 0;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: .2s ease;
    }

    .action-button.edit {
        background: #edf4fb;
        color: var(--navy);
    }

    .action-button.delete {
        background: #fef3f2;
        color: #b42318;
    }

    .action-button:hover {
        transform: translateY(-1px);
    }

    .empty-state {
        padding: 70px 20px;
        text-align: center;
    }

    .empty-state > span {
        width: 78px;
        height: 78px;
        margin: 0 auto 15px;
        display: grid;
        place-items: center;
        border-radius: 24px;
        color: #cbd5e1;
        background: #f8fafc;
        font-size: 2rem;
    }

    .empty-state h5 {
        margin: 0 0 8px;
        color: #344054;
        font-size: 1.35rem;
        font-weight: 800;
    }

    .empty-state p {
        margin: 0 0 18px;
        color: #98a2b3;
    }

    .empty-state a {
        min-height: 42px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 12px;
        background: var(--navy);
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    .empty-state a:hover {
        color: #fff;
        background: #123b71;
    }

    .delete-icon {
        width: 70px;
        height: 70px;
        display: grid;
        place-items: center;
        margin: 0 auto;
        color: #b42318;
        background: #fef3f2;
        border-radius: 50%;
        font-size: 1.8rem;
    }

    .panel-footer {
        padding: 18px 22px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        border-top: 1px solid var(--line);
    }

    .panel-footer p {
        margin: 0;
        color: var(--muted);
        font-size: 11px;
    }

    @media (max-width: 991.98px) {
        .panel-toolbar,
        .filter-form,
        .calendar-hero {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-form {
            justify-content: flex-start;
        }

        .search-field,
        .filter-form select,
        .filter-button {
            width: 100%;
        }

        .btn-add-calendar {
            width: 100%;
        }
    }

    @media (max-width: 767.98px) {
        .calendar-page {
            padding: 18px;
        }

        .calendar-hero {
            padding: 22px;
        }

        .calendar-panel {
            border-radius: 18px;
        }

        .panel-toolbar {
            padding: 18px;
        }

        .event-identity {
            min-width: unset;
        }

        .event-identity span {
            max-width: unset;
        }

        .calendar-table tbody td,
        .calendar-table thead th {
            white-space: normal;
        }

        .panel-footer {
            padding: 16px 18px 18px;
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

