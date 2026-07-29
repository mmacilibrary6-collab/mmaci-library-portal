@extends('layouts.admin')

@section('title', 'Calendar Events')
@section('page-title', 'Calendar Events')

@section('content')

<div class="container-fluid py-4">

    <div class="page-header mb-4">

        <div>
            <h2 class="page-title mb-1">
                Calendar Events
            </h2>

            <p class="text-muted mb-0">
                Create, update, publish, or remove library events.
            </p>
        </div>

        <a
            href="{{ route('admin.calendar.create') }}"
            class="btn btn-warning rounded-pill px-4 fw-semibold">

            <i class="bi bi-calendar-plus me-2"></i>
            Add Event

        </a>

    </div>

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show shadow-sm"
            role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    <div class="filter-card mb-4">

        <form
            method="GET"
            action="{{ route('admin.calendar.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-lg-7">

                    <label for="search" class="form-label">
                        Search Events
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search by title, description, or location">

                    </div>

                </div>

                <div class="col-lg-3">

                    <label for="status" class="form-label">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select">

                        <option value="">
                            All statuses
                        </option>

                        <option
                            value="published"
                            {{ request('status') === 'published' ? 'selected' : '' }}>
                            Published
                        </option>

                        <option
                            value="draft"
                            {{ request('status') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option
                            value="cancelled"
                            {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>

                </div>

                <div class="col-lg-2">

                    <button
                        type="submit"
                        class="btn btn-primary w-100">

                        Filter

                    </button>

                </div>

            </div>

            @if(request()->filled('search') || request()->filled('status'))

                <div class="mt-3">

                    <a
                        href="{{ route('admin.calendar.index') }}"
                        class="text-decoration-none small fw-semibold">

                        <i class="bi bi-x-circle me-1"></i>
                        Clear filters

                    </a>

                </div>

            @endif

        </form>

    </div>

    <div class="table-card">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>

                    <tr>
                        <th>Event</th>
                        <th>Date and Time</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($events as $event)

                        <tr>

                            <td>

                                <div class="event-details">

                                    <div class="event-icon">

                                        <i class="bi bi-calendar-event"></i>

                                    </div>

                                    <div>

                                        <h6 class="event-title mb-1">
                                            {{ $event->title }}
                                        </h6>

                                        <p class="event-description mb-0">

                                            {{ \Illuminate\Support\Str::limit(
                                                $event->description ?? 'No description provided.',
                                                75
                                            ) }}

                                        </p>

                                    </div>

                                </div>

                            </td>

                            <td>

                                <div class="fw-semibold text-dark">

                                    {{ optional($event->event_date)->format('M d, Y') }}

                                </div>

                                <small class="text-muted">

                                    @if($event->start_time)

                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}

                                        @if($event->end_time)

                                            –
                                            {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}

                                        @endif

                                    @else

                                        Time not specified

                                    @endif

                                </small>

                            </td>

                            <td>

                                @if($event->location)

                                    <i class="bi bi-geo-alt text-primary me-1"></i>

                                    {{ $event->location }}

                                @else

                                    <span class="text-muted">
                                        Not specified
                                    </span>

                                @endif

                            </td>

                            <td>

                                <span class="status-badge status-{{ $event->status }}">

                                    {{ ucfirst($event->status) }}

                                </span>

                            </td>

                            <td class="text-end">

                                <div class="dropdown">

                                    <button
                                        class="btn btn-light border action-button"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">

                                        <i class="bi bi-three-dots-vertical"></i>

                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                                        <li>

                                            <a
                                                href="{{ route('admin.calendar.edit', $event) }}"
                                                class="dropdown-item">

                                                <i class="bi bi-pencil-square me-2"></i>
                                                Edit Event

                                            </a>

                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteEventModal{{ $event->id }}">

                                                <i class="bi bi-trash3 me-2"></i>
                                                Delete Event

                                            </button>

                                        </li>

                                    </ul>

                                </div>

                                <div
                                    class="modal fade"
                                    id="deleteEventModal{{ $event->id }}"
                                    tabindex="-1"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content border-0 rounded-4">

                                            <div class="modal-body p-4 text-center">

                                                <div class="delete-icon mb-3">

                                                    <i class="bi bi-trash3"></i>

                                                </div>

                                                <h4 class="fw-bold text-dark">
                                                    Delete Event?
                                                </h4>

                                                <p class="text-muted">

                                                    You are about to delete
                                                    <strong>{{ $event->title }}</strong>.
                                                    This action cannot be undone.

                                                </p>

                                                <div class="d-flex justify-content-center gap-2 mt-4">

                                                    <button
                                                        type="button"
                                                        class="btn btn-light border rounded-pill px-4"
                                                        data-bs-dismiss="modal">

                                                        Cancel

                                                    </button>

                                                    <form
                                                        method="POST"
                                                        action="{{ route('admin.calendar.destroy', $event) }}">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger rounded-pill px-4">

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

                                    <i class="bi bi-calendar-x"></i>

                                    <h4>No calendar events found</h4>

                                    <p>

                                        Create your first event or adjust the current search filters.

                                    </p>

                                    <a
                                        href="{{ route('admin.calendar.create') }}"
                                        class="btn btn-warning rounded-pill px-4">

                                        <i class="bi bi-plus-lg me-2"></i>
                                        Add Event

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($events->hasPages())

            <div class="pagination-wrapper">

                {{ $events->links() }}

            </div>

        @endif

    </div>

</div>

<style>

.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.page-title {
    color: #0B2E59;
    font-weight: 800;
}

.filter-card,
.table-card {
    background: #ffffff;
    border: 1px solid #e9edf2;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(11, 46, 89, 0.07);
}

.filter-card {
    padding: 25px;
}

.form-label {
    color: #344054;
    font-size: 0.85rem;
    font-weight: 700;
}

.form-control,
.form-select,
.input-group-text {
    min-height: 48px;
    border-color: #d8dee8;
}

.form-control:focus,
.form-select:focus {
    border-color: #F4B400;
    box-shadow: 0 0 0 0.2rem rgba(244, 180, 0, 0.14);
}

.table-card {
    overflow: hidden;
}

.table thead th {
    padding: 17px 20px;
    color: #667085;
    background: #f8fafc;
    border-bottom: 1px solid #e9edf2;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    white-space: nowrap;
}

.table tbody td {
    padding: 18px 20px;
    border-color: #edf0f4;
    vertical-align: middle;
}

.event-details {
    min-width: 280px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.event-icon {
    width: 46px;
    height: 46px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    color: #0B2E59;
    background: #edf4fb;
    border-radius: 14px;
    font-size: 1.15rem;
}

.event-title {
    color: #1d2939;
    font-weight: 800;
}

.event-description {
    max-width: 380px;
    color: #667085;
    font-size: 0.8rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 11px;
    border-radius: 999px;
    font-size: 0.7rem;
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

.action-button {
    width: 38px;
    height: 38px;
    padding: 0;
    border-radius: 10px;
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

.empty-state {
    padding: 65px 20px;
    text-align: center;
}

.empty-state > i {
    display: block;
    color: #cbd5e1;
    font-size: 3.5rem;
    margin-bottom: 15px;
}

.empty-state h4 {
    color: #344054;
    font-weight: 800;
}

.empty-state p {
    color: #98a2b3;
}

.pagination-wrapper {
    padding: 20px 24px;
    border-top: 1px solid #edf0f4;
}

@media (max-width: 767.98px) {
    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .page-header .btn {
        width: 100%;
    }
}

</style>

@endsection