@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}
    <div class="dashboard-header mb-4">

        <div>
            <p class="dashboard-eyebrow mb-1">
                Administration Panel
            </p>

            <h1 class="dashboard-title mb-1">
                Dashboard
            </h1>

            <p class="dashboard-subtitle mb-0">
                Welcome back. Here is the latest overview of the MMACI Library Services Office.
            </p>
        </div>

        <div class="dashboard-date">

            <i class="bi bi-calendar3 me-2"></i>

            {{ now()->format('F d, Y') }}

        </div>

    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif

    {{-- STATISTIC CARDS --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon icon-blue">

                    <i class="bi bi-calendar-event"></i>

                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Calendar Events
                    </span>

                    <h2 class="stat-number">
                        {{ $totalEvents ?? 0 }}
                    </h2>

                    <a
                        href="{{ route('admin.calendar.index') }}"
                        class="stat-link">

                        Manage events

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon icon-yellow">

                    <i class="bi bi-book"></i>

                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        New Arrivals
                    </span>

                    <h2 class="stat-number">
                        {{ $totalBooks ?? 0 }}
                    </h2>

                    <a
                        href="{{ route('admin.new-arrivals.index') }}"
                        class="stat-link">

                        Manage collection

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon icon-purple">

                    <i class="bi bi-tablet"></i>

                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        E-Books
                    </span>

                    <h2 class="stat-number">
                        {{ $totalEbooks ?? 0 }}
                    </h2>

                    <a
                        href="{{ route('admin.new-arrivals.index') }}"
                        class="stat-link">

                        View resources

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon icon-green">

                    <i class="bi bi-images"></i>

                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        Gallery Items
                    </span>

                    <h2 class="stat-number">
                        {{ $totalGallery ?? 0 }}
                    </h2>

                    <a
                        href="{{ route('admin.gallery.index') }}"
                        class="stat-link">

                        Manage gallery

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

    {{-- LATEST EVENTS AND ARRIVALS --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-6">

            <div class="dashboard-panel h-100">

                <div class="panel-header">

                    <div>

                        <p class="panel-eyebrow mb-1">
                            Schedule
                        </p>

                        <h3 class="panel-title mb-0">
                            Latest Calendar Events
                        </h3>

                    </div>

                    <a
                        href="{{ route('admin.calendar.index') }}"
                        class="btn btn-sm btn-outline-primary rounded-pill px-3">

                        View all

                    </a>

                </div>

                <div class="panel-body">

                    @forelse($latestEvents ?? [] as $event)

                        <div class="activity-item">

                            <div class="activity-icon">

                                <i class="bi bi-calendar3"></i>

                            </div>

                            <div class="activity-details">

                                <h6 class="activity-title">
                                    {{ $event->title ?? 'Untitled Event' }}
                                </h6>

                                <p class="activity-meta mb-0">

                                    <i class="bi bi-clock me-1"></i>

                                    @if(!empty($event->event_date))
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    @elseif(!empty($event->start_date))
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('F d, Y') }}
                                    @else
                                        Date not specified
                                    @endif

                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state">

                            <i class="bi bi-calendar-x"></i>

                            <h5>No calendar events yet</h5>

                            <p>
                                Create an event to display it on the dashboard.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="col-xl-6">

            <div class="dashboard-panel h-100">

                <div class="panel-header">

                    <div>

                        <p class="panel-eyebrow mb-1">
                            Collection
                        </p>

                        <h3 class="panel-title mb-0">
                            Latest New Arrivals
                        </h3>

                    </div>

                    <a
                        href="{{ route('admin.new-arrivals.index') }}"
                        class="btn btn-sm btn-outline-primary rounded-pill px-3">

                        View all

                    </a>

                </div>

                <div class="panel-body">

                    @forelse($latestBooks ?? [] as $book)

                        <div class="activity-item">

                            <div class="activity-icon">

                                @if(($book->resource_type ?? '') === 'ebook')

                                    <i class="bi bi-tablet"></i>

                                @else

                                    <i class="bi bi-book"></i>

                                @endif

                            </div>

                            <div class="activity-details">

                                <h6 class="activity-title">
                                    {{ $book->title ?? 'Untitled Resource' }}
                                </h6>

                                <p class="activity-meta mb-0">

                                    {{ $book->author ?? 'Unknown author' }}

                                    @if(!empty($book->resource_type))

                                        · {{ ucfirst($book->resource_type) }}

                                    @endif

                                </p>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state">

                            <i class="bi bi-journal-x"></i>

                            <h5>No new arrivals yet</h5>

                            <p>
                                Add books or e-books to display them here.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.dashboard-header {

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
    background: linear-gradient(
        135deg,
        #0B2E59,
        #164D89
    );
    padding: 30px;
    border-radius: 22px;
    color: #ffffff;
    box-shadow: 0 15px 40px rgba(11, 46, 89, 0.18);

}

.dashboard-eyebrow {

    color: #F4B400;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 1.4px;
    text-transform: uppercase;

}

.dashboard-title {

    font-size: 2rem;
    font-weight: 800;

}

.dashboard-subtitle {

    color: rgba(255, 255, 255, 0.78);
    font-size: 0.95rem;

}

.dashboard-date {

    flex-shrink: 0;
    padding: 12px 18px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.16);
    border-radius: 14px;
    font-size: 0.9rem;
    font-weight: 600;

}

.stat-card {

    height: 100%;
    display: flex;
    align-items: center;
    gap: 18px;
    background: #ffffff;
    padding: 24px;
    border: 1px solid #edf0f4;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(20, 40, 70, 0.07);
    transition: 0.25s ease;

}

.stat-card:hover {

    transform: translateY(-4px);
    box-shadow: 0 18px 40px rgba(20, 40, 70, 0.12);

}

.stat-icon {

    width: 62px;
    height: 62px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    border-radius: 18px;
    font-size: 1.6rem;

}

.icon-blue {

    color: #155EEF;
    background: #EAF1FF;

}

.icon-yellow {

    color: #B47B00;
    background: #FFF4CE;

}

.icon-purple {

    color: #7A42D8;
    background: #F2EAFE;

}

.icon-green {

    color: #16875A;
    background: #E6F7EF;

}

.icon-red {

    color: #D64545;
    background: #FDEBEB;

}

.icon-cyan {

    color: #0E8294;
    background: #E7F7FA;

}

.icon-dark {

    color: #344054;
    background: #EAECF0;

}

.icon-orange {

    color: #D06000;
    background: #FFF0E2;

}

.stat-content {

    min-width: 0;

}

.stat-label {

    display: block;
    color: #667085;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 3px;

}

.stat-number {

    color: #0B2E59;
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 2px;

}

.stat-extra {

    color: #98A2B3;
    font-size: 0.8rem;

}

.stat-link {

    color: #0B2E59;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;

}

.stat-link:hover {

    color: #F4B400;

}

.dashboard-panel {

    background: #ffffff;
    border: 1px solid #edf0f4;
    border-radius: 22px;
    box-shadow: 0 10px 30px rgba(20, 40, 70, 0.07);
    overflow: hidden;

}

.panel-header {

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 24px 26px;
    border-bottom: 1px solid #edf0f4;

}

.panel-eyebrow {

    color: #F4B400;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 1.2px;
    text-transform: uppercase;

}

.panel-title {

    color: #0B2E59;
    font-size: 1.1rem;
    font-weight: 800;

}

.panel-body {

    padding: 10px 24px 20px;

}

.activity-item {

    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px 0;
    border-bottom: 1px solid #f0f2f5;

}

.activity-item:last-child {

    border-bottom: 0;

}

.activity-icon,
.activity-avatar {

    width: 46px;
    height: 46px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    border-radius: 14px;
    background: #EEF4FB;
    color: #0B2E59;
    font-weight: 800;

}

.activity-details {

    min-width: 0;
    flex: 1;

}

.activity-title {

    color: #1D2939;
    font-size: 0.92rem;
    font-weight: 700;

}

.activity-meta {

    color: #667085;
    font-size: 0.8rem;

}

.status-badge {

    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: 0.68rem;
    font-weight: 800;
    text-transform: capitalize;

}

.status-pending {

    color: #946200;
    background: #FFF4CE;

}

.status-answered,
.status-approved {

    color: #067647;
    background: #ECFDF3;

}

.status-rejected {

    color: #B42318;
    background: #FEF3F2;

}

.empty-state {

    padding: 45px 20px;
    text-align: center;
    color: #98A2B3;

}

.empty-state i {

    display: block;
    color: #CBD5E1;
    font-size: 2.5rem;
    margin-bottom: 12px;

}

.empty-state h5 {

    color: #475467;
    font-weight: 700;

}

.empty-state p {

    margin-bottom: 0;
    font-size: 0.86rem;

}

@media (max-width: 767.98px) {

    .dashboard-header {

        align-items: flex-start;
        flex-direction: column;
        padding: 24px;

    }

    .dashboard-date {

        width: 100%;

    }

    .panel-header {

        align-items: flex-start;
        flex-direction: column;

    }

}

/* =========================================================
   CLEAN MODERN ADMIN DASHBOARD
========================================================= */

:root {
    --admin-navy: #0B2E59;
    --admin-blue: #184B8C;
    --admin-yellow: #F4B400;
    --admin-bg: #F5F7FB;
    --admin-border: #E5EAF1;
    --admin-muted: #697586;
}

.container-fluid {
    max-width: 1560px;
}

.dashboard-header {
    position: relative;
    overflow: hidden;
    padding: 30px 32px;
    color: var(--admin-navy);
    background: #ffffff;
    border: 1px solid var(--admin-border);
    border-radius: 16px;
    box-shadow: 0 8px 28px rgba(11, 46, 89, 0.07);
}

.dashboard-header::before {
    content: "";
    position: absolute;
    inset: 0 auto 0 0;
    width: 5px;
    background: var(--admin-yellow);
}

.dashboard-header::after {
    content: "";
    position: absolute;
    top: -90px;
    right: 15%;
    width: 220px;
    height: 220px;
    border: 38px solid rgba(24, 75, 140, 0.035);
    border-radius: 50%;
    pointer-events: none;
}

.dashboard-header > * {
    position: relative;
    z-index: 1;
}

.dashboard-eyebrow {
    color: var(--admin-blue);
    font-size: 0.7rem;
    letter-spacing: 0.13em;
}

.dashboard-title {
    color: var(--admin-navy);
    font-size: clamp(1.75rem, 3vw, 2.25rem);
    letter-spacing: -0.035em;
}

.dashboard-subtitle {
    max-width: 720px;
    color: var(--admin-muted);
    font-size: 0.9rem;
}

.dashboard-date {
    padding: 11px 16px;
    color: var(--admin-navy);
    background: var(--admin-bg);
    border: 1px solid var(--admin-border);
    border-radius: 10px;
    font-size: 0.82rem;
}

.alert {
    border: 0;
    border-radius: 12px;
}

.stat-card {
    position: relative;
    min-height: 150px;
    align-items: flex-start;
    padding: 22px;
    border: 1px solid var(--admin-border);
    border-radius: 14px;
    box-shadow: 0 5px 18px rgba(11, 46, 89, 0.05);
    transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    border-color: rgba(24, 75, 140, 0.22);
    box-shadow: 0 12px 28px rgba(11, 46, 89, 0.09);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 11px;
    font-size: 1.2rem;
}

.icon-blue,
.icon-purple,
.icon-cyan,
.icon-dark {
    color: var(--admin-blue);
    background: rgba(24, 75, 140, 0.09);
}

.icon-yellow,
.icon-orange {
    color: #9B6B00;
    background: rgba(244, 180, 0, 0.15);
}

.icon-green {
    color: #137A59;
    background: #EAF7F2;
}

.icon-red {
    color: #B5473D;
    background: #FCEFED;
}

.stat-content {
    display: flex;
    min-height: 103px;
    flex: 1;
    flex-direction: column;
}

.stat-label {
    margin: 1px 0 7px;
    color: var(--admin-muted);
    font-size: 0.78rem;
}

.stat-number {
    margin: 0;
    font-size: 1.9rem;
    line-height: 1;
    letter-spacing: -0.04em;
}

.stat-link,
.stat-extra {
    margin-top: auto;
    padding-top: 12px;
    font-size: 0.75rem;
}

.stat-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--admin-blue);
}

.stat-link i {
    font-size: 0.7rem;
    transition: transform 0.2s ease;
}

.stat-link:hover {
    color: var(--admin-navy);
}

.stat-link:hover i {
    transform: translateX(3px);
}

.dashboard-secondary-stats .stat-card {
    min-height: 118px;
    align-items: center;
    padding: 18px 20px;
    background: #FBFCFE;
}

.dashboard-secondary-stats .stat-icon {
    width: 43px;
    height: 43px;
    border-radius: 10px;
    font-size: 1.05rem;
}

.dashboard-secondary-stats .stat-content {
    min-height: 82px;
}

.dashboard-secondary-stats .stat-label {
    margin-bottom: 3px;
}

.dashboard-secondary-stats .stat-number {
    font-size: 1.55rem;
}

.dashboard-secondary-stats .stat-link,
.dashboard-secondary-stats .stat-extra {
    padding-top: 7px;
}

.dashboard-panel {
    border: 1px solid var(--admin-border);
    border-radius: 14px;
    box-shadow: 0 6px 22px rgba(11, 46, 89, 0.055);
}

.panel-header {
    min-height: 78px;
    padding: 19px 22px;
    background: #ffffff;
    border-bottom: 1px solid var(--admin-border);
}

.panel-eyebrow {
    color: var(--admin-blue);
    font-size: 0.64rem;
    letter-spacing: 0.12em;
}

.panel-title {
    font-size: 1rem;
    letter-spacing: -0.012em;
}

.panel-header .btn {
    padding: 7px 13px !important;
    color: var(--admin-blue);
    background: #ffffff;
    border-color: #D5DDE8;
    border-radius: 8px !important;
    font-size: 0.72rem;
    font-weight: 700;
}

.panel-header .btn:hover {
    color: #ffffff;
    background: var(--admin-blue);
    border-color: var(--admin-blue);
}

.panel-body {
    padding: 5px 22px 12px;
}

.activity-item {
    gap: 13px;
    padding: 15px 0;
    border-bottom-color: #EDF0F4;
}

.activity-icon,
.activity-avatar {
    width: 40px;
    height: 40px;
    color: var(--admin-blue);
    background: #F0F4F9;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    font-size: 0.85rem;
}

.activity-avatar {
    color: var(--admin-navy);
    background: rgba(244, 180, 0, 0.14);
    border-color: rgba(244, 180, 0, 0.18);
}

.activity-title {
    margin-bottom: 4px;
    color: #24364B;
    font-size: 0.85rem;
}

.activity-meta {
    color: #7A8595;
    font-size: 0.75rem;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.6rem;
    letter-spacing: 0.02em;
}

.empty-state {
    padding: 40px 20px;
}

.empty-state i {
    color: #C9D2DE;
    font-size: 2rem;
}

.empty-state h5 {
    color: #415168;
    font-size: 0.92rem;
}

.empty-state p {
    color: #8792A2;
    font-size: 0.78rem;
}

@media (max-width: 991.98px) {
    .stat-card,
    .dashboard-secondary-stats .stat-card {
        min-height: 125px;
    }
}

@media (max-width: 767.98px) {
    .container-fluid {
        padding-right: 16px;
        padding-left: 16px;
    }

    .dashboard-header {
        padding: 24px 22px;
    }

    .dashboard-header::after {
        display: none;
    }

    .dashboard-date {
        width: auto;
    }

    .panel-header {
        align-items: center;
        flex-direction: row;
    }
}

@media (max-width: 480px) {
    .stat-card {
        gap: 14px;
        padding: 18px;
    }

    .panel-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .panel-header .btn {
        width: 100%;
    }
}

/* =========================================================
   POLISHED VISUAL LAYER
========================================================= */

.dashboard-header {
    color: #ffffff;
    background:
        radial-gradient(circle at 76% 20%, rgba(255, 255, 255, 0.12), transparent 22%),
        linear-gradient(125deg, #08274D 0%, #0B2E59 50%, #1D5B9F 100%);
    border: 0;
    box-shadow: 0 18px 42px rgba(11, 46, 89, 0.20);
}

.dashboard-header::before {
    width: 6px;
}

.dashboard-header::after {
    top: -110px;
    right: 6%;
    width: 270px;
    height: 270px;
    border: 44px solid rgba(244, 180, 0, 0.10);
}

.dashboard-eyebrow {
    color: #FFD45A;
}

.dashboard-title {
    color: #ffffff;
}

.dashboard-subtitle {
    color: rgba(255, 255, 255, 0.76);
}

.dashboard-date {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.11);
    border-color: rgba(255, 255, 255, 0.17);
    box-shadow: inset 0 1px rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
}

.stat-card {
    overflow: hidden;
    background:
        radial-gradient(circle at 110% -20%, rgba(24, 75, 140, 0.08), transparent 42%),
        #ffffff;
}

.stat-card::before {
    content: "";
    position: absolute;
    top: 0;
    right: 22px;
    left: 22px;
    height: 3px;
    background: linear-gradient(90deg, var(--admin-yellow), var(--admin-blue));
    border-radius: 0 0 8px 8px;
    opacity: 0.8;
}

.stat-card::after {
    content: "";
    position: absolute;
    right: -38px;
    bottom: -50px;
    width: 110px;
    height: 110px;
    border: 20px solid rgba(24, 75, 140, 0.035);
    border-radius: 50%;
    pointer-events: none;
}

.stat-icon {
    position: relative;
    z-index: 1;
    box-shadow: 0 9px 20px rgba(11, 46, 89, 0.10);
}

.icon-blue {
    color: #ffffff;
    background: linear-gradient(145deg, #2765A8, var(--admin-blue));
}

.icon-yellow {
    color: var(--admin-navy);
    background: linear-gradient(145deg, #FFD45A, var(--admin-yellow));
}

.icon-purple {
    color: #ffffff;
    background: linear-gradient(145deg, #3B6FA8, #274E7C);
}

.icon-green {
    color: #ffffff;
    background: linear-gradient(145deg, #29936E, #176B52);
}

.dashboard-secondary-stats .stat-card {
    background:
        linear-gradient(135deg, rgba(24, 75, 140, 0.035), transparent 55%),
        #ffffff;
}

.dashboard-secondary-stats .stat-card::before {
    right: auto;
    bottom: 18px;
    left: 0;
    width: 3px;
    height: auto;
    background: var(--admin-yellow);
    border-radius: 0 6px 6px 0;
}

.dashboard-secondary-stats .stat-card::after {
    display: none;
}

.icon-red {
    color: #ffffff;
    background: linear-gradient(145deg, #D65B52, #B5473D);
}

.icon-cyan {
    color: #ffffff;
    background: linear-gradient(145deg, #3377B4, #1C5A91);
}

.icon-dark {
    color: #ffffff;
    background: linear-gradient(145deg, #50667E, #34495E);
}

.icon-orange {
    color: var(--admin-navy);
    background: linear-gradient(145deg, #FFD45A, #E7A800);
}

.dashboard-panel {
    position: relative;
    background:
        linear-gradient(180deg, rgba(24, 75, 140, 0.018), transparent 25%),
        #ffffff;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.dashboard-panel:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 34px rgba(11, 46, 89, 0.095);
}

.panel-header {
    background:
        linear-gradient(90deg, rgba(24, 75, 140, 0.055), rgba(244, 180, 0, 0.025)),
        #ffffff;
}

.panel-header::before {
    content: "";
    align-self: stretch;
    width: 4px;
    margin-right: -5px;
    background: var(--admin-yellow);
    border-radius: 6px;
}

.panel-title {
    font-size: 1.03rem;
}

.activity-item {
    position: relative;
    margin: 0 -10px;
    padding: 15px 10px;
    border-radius: 10px;
    transition: background 0.2s ease;
}

.activity-item:hover {
    background: #F7F9FC;
}

.activity-icon {
    color: #ffffff;
    background: linear-gradient(145deg, #2864A3, var(--admin-blue));
    border: 0;
    box-shadow: 0 7px 16px rgba(24, 75, 140, 0.18);
}

.activity-avatar {
    color: var(--admin-navy);
    background: linear-gradient(145deg, #FFE48E, #F4B400);
    border: 0;
    box-shadow: 0 7px 16px rgba(244, 180, 0, 0.17);
}

.panel-header .btn {
    box-shadow: 0 4px 12px rgba(11, 46, 89, 0.06);
}

@media (max-width: 767.98px) {
    .dashboard-header {
        background: linear-gradient(135deg, #08274D, #184B8C);
    }

    .stat-card::after {
        opacity: 0.65;
    }
}

/* =========================================================
   VIBRANT MMACI PALETTE
========================================================= */

body {
    background:
        radial-gradient(circle at 100% 0, rgba(24, 75, 140, 0.10), transparent 28rem),
        linear-gradient(180deg, #F3F7FC 0%, #F8FAFD 100%);
}

.container-fluid.py-4 {
    padding-top: 30px !important;
    padding-bottom: 50px !important;
}

.dashboard-header {
    min-height: 185px;
    padding: 38px 40px;
    background:
        radial-gradient(circle at 83% 8%, rgba(244, 180, 0, 0.24), transparent 18%),
        radial-gradient(circle at 67% 110%, rgba(89, 151, 218, 0.35), transparent 29%),
        linear-gradient(120deg, #071F3D 0%, #0B2E59 45%, #1B5B9D 100%);
}

.dashboard-header::after {
    display: block;
    top: -130px;
    right: -30px;
    width: 340px;
    height: 340px;
    border: 58px solid rgba(255, 213, 90, 0.11);
}

.dashboard-eyebrow {
    padding: 5px 10px;
    display: inline-block;
    color: #FFE17D;
    background: rgba(244, 180, 0, 0.12);
    border: 1px solid rgba(255, 213, 90, 0.18);
    border-radius: 6px;
}

.dashboard-title {
    margin-top: 8px;
    font-size: clamp(2rem, 4vw, 2.75rem);
}

.dashboard-date {
    padding: 13px 18px;
    background: rgba(255, 255, 255, 0.14);
    border-color: rgba(255, 255, 255, 0.22);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-card {
    min-height: 165px;
    border: 0;
    box-shadow: 0 14px 32px rgba(11, 46, 89, 0.14);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-card::before {
    display: none;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-card::after {
    right: -30px;
    bottom: -45px;
    width: 125px;
    height: 125px;
    border: 22px solid rgba(255, 255, 255, 0.09);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(1) .stat-card {
    background: linear-gradient(145deg, #0A315F, #164F8C);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(2) .stat-card {
    background: linear-gradient(145deg, #FFD65E, #F4B400);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(3) .stat-card {
    background: linear-gradient(145deg, #2569AD, #174A82);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(4) .stat-card {
    background: linear-gradient(145deg, #E7F2FF, #CFE3F8);
    border: 1px solid #BDD6EE;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(1) .stat-label,
.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(3) .stat-label {
    color: rgba(255, 255, 255, 0.72);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(1) .stat-number,
.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(3) .stat-number {
    color: #ffffff;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(1) .stat-link,
.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(3) .stat-link {
    color: #FFE17D;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(2) .stat-label,
.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(4) .stat-label {
    color: rgba(11, 46, 89, 0.68);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(2) .stat-number,
.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(4) .stat-number,
.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(2) .stat-link,
.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(4) .stat-link {
    color: var(--admin-navy);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-icon {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.16);
    border: 1px solid rgba(255, 255, 255, 0.24);
    box-shadow: inset 0 1px rgba(255, 255, 255, 0.18), 0 9px 20px rgba(0, 0, 0, 0.10);
    backdrop-filter: blur(8px);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(2) .stat-icon,
.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(4) .stat-icon {
    color: var(--admin-navy);
    background: rgba(255, 255, 255, 0.34);
    border-color: rgba(255, 255, 255, 0.42);
}

.dashboard-secondary-stats {
    padding: 18px;
    background:
        linear-gradient(100deg, rgba(24, 75, 140, 0.07), rgba(244, 180, 0, 0.07)),
        #ffffff;
    border: 1px solid #DDE6F0;
    border-radius: 17px;
    box-shadow: 0 9px 26px rgba(11, 46, 89, 0.06);
}

.dashboard-secondary-stats .stat-card {
    border: 0;
    box-shadow: none;
}

.dashboard-secondary-stats > .col-xl-3:nth-child(1) .stat-card {
    background: #FFF5F2;
}

.dashboard-secondary-stats > .col-xl-3:nth-child(2) .stat-card {
    background: #EDF7FF;
}

.dashboard-secondary-stats > .col-xl-3:nth-child(3) .stat-card {
    background: #EEF2F8;
}

.dashboard-secondary-stats > .col-xl-3:nth-child(4) .stat-card {
    background: #FFF7DA;
}

.dashboard-panel {
    border: 0;
    box-shadow: 0 12px 32px rgba(11, 46, 89, 0.09);
}

.row > .col-xl-6:nth-child(1) .panel-header {
    color: #ffffff;
    background:
        radial-gradient(circle at 90% 10%, rgba(255, 255, 255, 0.14), transparent 30%),
        linear-gradient(120deg, #0D3768, #1D5F9F);
    border: 0;
}

.row > .col-xl-6:nth-child(1) .panel-title {
    color: #ffffff;
}

.row > .col-xl-6:nth-child(1) .panel-eyebrow {
    color: #FFE17D;
}

.row > .col-xl-6:nth-child(1) .panel-header .btn {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.12);
    border-color: rgba(255, 255, 255, 0.25);
}

.row > .col-xl-6:nth-child(2) .panel-header {
    background:
        radial-gradient(circle at 90% 10%, rgba(255, 255, 255, 0.30), transparent 28%),
        linear-gradient(120deg, #FFE17D, #F4B400);
    border: 0;
}

.row > .col-xl-6:nth-child(2) .panel-title,
.row > .col-xl-6:nth-child(2) .panel-eyebrow {
    color: var(--admin-navy);
}

.row > .col-xl-6:nth-child(2) .panel-header .btn {
    color: var(--admin-navy);
    background: rgba(255, 255, 255, 0.32);
    border-color: rgba(11, 46, 89, 0.16);
}

.panel-header::before {
    display: none;
}

.panel-body {
    background:
        linear-gradient(180deg, rgba(238, 244, 251, 0.75), transparent 80px),
        #ffffff;
}

.activity-item:hover {
    background: #EEF4FB;
}

@media (max-width: 767.98px) {
    .container-fluid.py-4 {
        padding-top: 18px !important;
    }

    .dashboard-header {
        min-height: auto;
        padding: 28px 24px;
    }

    .dashboard-secondary-stats {
        padding: 12px;
    }
}

/* =========================================================
   FINAL BALANCED CARD SYSTEM
========================================================= */

.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-card,
.dashboard-secondary-stats .stat-card {
    display: grid;
    grid-template-columns: 52px minmax(0, 1fr);
    align-items: start;
    gap: 16px;
    min-height: 145px;
    padding: 22px;
    overflow: hidden;
    border: 1px solid #DDE5EF;
    border-top: 4px solid var(--card-accent, var(--admin-blue));
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(11, 46, 89, 0.075);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-card::before,
.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-card::after,
.dashboard-secondary-stats .stat-card::before,
.dashboard-secondary-stats .stat-card::after {
    display: none !important;
    content: none !important;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(1) .stat-card {
    --card-accent: #184B8C;
    background: linear-gradient(145deg, #FFFFFF, #EDF5FF);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(2) .stat-card {
    --card-accent: #F4B400;
    background: linear-gradient(145deg, #FFFFFF, #FFF8DC);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(3) .stat-card {
    --card-accent: #2D67A3;
    background: linear-gradient(145deg, #FFFFFF, #EAF2FB);
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(4) .stat-card {
    --card-accent: #247E68;
    background: linear-gradient(145deg, #FFFFFF, #EAF7F3);
}

.stat-icon,
.dashboard-secondary-stats .stat-icon {
    position: static !important;
    inset: auto !important;
    width: 52px !important;
    height: 52px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex: none;
    margin: 0 !important;
    overflow: hidden;
    border: 0 !important;
    border-radius: 12px !important;
    box-shadow: 0 8px 18px rgba(11, 46, 89, 0.13) !important;
}

.stat-icon i {
    position: static !important;
    inset: auto !important;
    width: auto !important;
    height: auto !important;
    display: inline-block !important;
    margin: 0 !important;
    padding: 0 !important;
    color: inherit !important;
    background: none !important;
    font-size: 1.25rem !important;
    line-height: 1 !important;
    transform: none !important;
}

.stat-icon i::before {
    position: static !important;
    inset: auto !important;
    display: block !important;
    margin: 0 !important;
    font-size: inherit !important;
    line-height: 1 !important;
    transform: none !important;
}

.stat-content,
.dashboard-secondary-stats .stat-content {
    display: flex;
    min-width: 0;
    min-height: 97px;
    flex-direction: column;
    align-items: flex-start;
}

.stat-label {
    margin: 1px 0 5px !important;
    color: #5D6A7C !important;
    font-size: 0.78rem;
    line-height: 1.3;
}

.stat-number {
    margin: 0 !important;
    color: var(--admin-navy) !important;
    font-size: 1.85rem;
    line-height: 1;
}

.stat-link,
.stat-extra {
    position: static !important;
    inset: auto !important;
    width: auto;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: auto;
    padding-top: 13px;
    color: var(--admin-blue) !important;
    font-size: 0.74rem;
    line-height: 1.2;
}

.stat-extra {
    color: #8A95A5 !important;
}

.stat-link i {
    position: static !important;
    inset: auto !important;
    display: inline-block !important;
    margin: 0 !important;
    color: inherit !important;
    font-size: 0.7rem !important;
    line-height: 1 !important;
    transform: none;
}

.stat-link i::before {
    position: static !important;
    inset: auto !important;
    display: block !important;
    margin: 0 !important;
}

.dashboard-secondary-stats {
    padding: 0;
    background: transparent;
    border: 0;
    box-shadow: none;
}

.dashboard-secondary-stats .stat-card {
    min-height: 125px;
    padding: 19px;
    background: #ffffff !important;
    border-top-width: 1px;
    border-left: 4px solid var(--card-accent, var(--admin-yellow));
}

.dashboard-secondary-stats > .col-xl-3:nth-child(1) .stat-card {
    --card-accent: #C94F46;
}

.dashboard-secondary-stats > .col-xl-3:nth-child(2) .stat-card {
    --card-accent: #2E73B8;
}

.dashboard-secondary-stats > .col-xl-3:nth-child(3) .stat-card {
    --card-accent: #415B76;
}

.dashboard-secondary-stats > .col-xl-3:nth-child(4) .stat-card {
    --card-accent: #F4B400;
}

.dashboard-secondary-stats .stat-content {
    min-height: 83px;
}

.dashboard-secondary-stats .stat-icon {
    width: 46px !important;
    height: 46px !important;
}

.dashboard-secondary-stats .stat-number {
    font-size: 1.55rem;
}

@media (max-width: 1199.98px) {
    .row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-card,
    .dashboard-secondary-stats .stat-card {
        min-height: 135px;
    }
}

@media (max-width: 575.98px) {
    .row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-card,
    .dashboard-secondary-stats .stat-card {
        grid-template-columns: 46px minmax(0, 1fr);
        gap: 13px;
        padding: 18px;
    }

    .stat-icon {
        width: 46px !important;
        height: 46px !important;
    }
}

/* Ensure every primary statistic icon has strong contrast. */

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(1) .stat-icon {
    color: #ffffff !important;
    background: linear-gradient(145deg, #3474B8, #184B8C) !important;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(2) .stat-icon {
    color: #0B2E59 !important;
    background: linear-gradient(145deg, #FFD75D, #F4B400) !important;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(3) .stat-icon {
    color: #ffffff !important;
    background: linear-gradient(145deg, #3B72AA, #274E7C) !important;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3:nth-child(4) .stat-icon {
    color: #ffffff !important;
    background: linear-gradient(145deg, #29936E, #176B52) !important;
}

.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-icon i,
.row:not(.dashboard-secondary-stats) > .col-xl-3 .stat-icon i::before {
    color: inherit !important;
    opacity: 1 !important;
    visibility: visible !important;
}

</style>

@endsection
