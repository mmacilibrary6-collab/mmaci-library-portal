@extends('layouts.admin')

@section('title', 'Visitors IP Address')

@section('content')

<div class="container-fluid visitor-ip-page">

    {{-- HERO HEADER --}}
    <div class="visitor-hero">
        <div class="visitor-hero-left">
            <div class="visitor-hero-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <div>
                <p class="visitor-eyebrow">SECURITY MONITORING</p>
                <h1>Visitors IP Address</h1>
                <p class="visitor-hero-description">
                    Monitor visitor activity, requests, IP addresses, and suspicious website traffic.
                </p>
            </div>
        </div>

        <div class="visitor-hero-actions">
            <form
                action="{{ route('admin.visitor-ip-address.prune') }}"
                method="POST"
                onsubmit="return confirm('Delete visitor logs older than the configured retention period?');"
            >
                @csrf
                <input
                    type="hidden"
                    name="days"
                    value="{{ (int) config('security.visitor_log_retention_days', 90) }}"
                >

                <button type="submit" class="btn visitor-btn-danger">
                    <i class="bi bi-trash3"></i>
                    Clear Old Logs
                </button>
            </form>
        </div>
    </div>


    {{-- SUMMARY CARDS --}}
    <div class="row g-3 visitor-summary-row">

        <div class="col-xl-4 col-md-4">
            <div class="visitor-stat-card">
                <div class="visitor-stat-icon">
                    <i class="bi bi-list-ul"></i>
                </div>

                <div class="visitor-stat-content">
                    <span>Total Logs</span>
                    <strong>{{ number_format($summary['total']) }}</strong>
                    <small>Recorded visitor requests</small>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4">
            <div class="visitor-stat-card">
                <div class="visitor-stat-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>

                <div class="visitor-stat-content">
                    <span>Today's Visits</span>
                    <strong>{{ number_format($summary['today']) }}</strong>
                    <small>Requests recorded today</small>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-4">
            <div class="visitor-stat-card visitor-stat-warning">
                <div class="visitor-stat-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div class="visitor-stat-content">
                    <span>Security Alerts</span>
                    <strong>{{ number_format($summary['suspicious']) }}</strong>
                    <small>401 / 403 / 404 / 429 responses</small>
                </div>
            </div>
        </div>

    </div>


    {{-- MAIN RECORD CARD --}}
    <div class="visitor-record-card">

        {{-- RECORD HEADER --}}
        <div class="visitor-record-header">

            <div>
                <h4>Visitor Records</h4>
                <p>
                    {{ number_format($logs->total()) }}
                    {{ \Illuminate\Support\Str::plural('record', $logs->total()) }} found
                </p>
            </div>

            <form method="GET" class="visitor-search-form">

                {{-- Preserve existing filters --}}
                @if($date)
                    <input type="hidden" name="date" value="{{ $date }}">
                @endif

                @if($method)
                    <input type="hidden" name="method" value="{{ $method }}">
                @endif

                @if($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif

                <div class="visitor-search-box">
                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search IP, page, browser or user..."
                    >
                </div>

                <button
                    type="button"
                    class="visitor-filter-toggle"
                    data-bs-toggle="collapse"
                    data-bs-target="#visitorFilters"
                    aria-expanded="{{ ($date || $method || $status) ? 'true' : 'false' }}"
                >
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

            </form>

        </div>


        {{-- FILTER PANEL --}}
        <div
            class="collapse {{ ($date || $method || $status) ? 'show' : '' }}"
            id="visitorFilters"
        >
            <div class="visitor-filter-panel">

                <form method="GET">

                    <div class="row g-3 align-items-end">

                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <label class="visitor-label">Search</label>

                            <div class="visitor-input-wrapper">
                                <i class="bi bi-search"></i>

                                <input
                                    type="search"
                                    name="search"
                                    value="{{ $search }}"
                                    class="form-control"
                                    placeholder="IP, URL, browser or user..."
                                >
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-6">
                            <label class="visitor-label">Date</label>

                            <input
                                type="date"
                                name="date"
                                value="{{ $date }}"
                                class="form-control visitor-form-control"
                            >
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <label class="visitor-label">Method</label>

                            <select
                                name="method"
                                class="form-select visitor-form-control"
                            >
                                <option value="">All Methods</option>

                                @foreach(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $httpMethod)
                                    <option
                                        value="{{ $httpMethod }}"
                                        @selected($method === $httpMethod)
                                    >
                                        {{ $httpMethod }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <label class="visitor-label">Status</label>

                            <select
                                name="status"
                                class="form-select visitor-form-control"
                            >
                                <option value="">All Status</option>

                                @foreach([200, 301, 302, 401, 403, 404, 429, 500] as $httpStatus)
                                    <option
                                        value="{{ $httpStatus }}"
                                        @selected((string) $status === (string) $httpStatus)
                                    >
                                        {{ $httpStatus }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <div class="visitor-filter-actions">

                                <button type="submit" class="visitor-apply-filter">
                                    <i class="bi bi-funnel-fill"></i>
                                    Apply
                                </button>

                                <a
                                    href="{{ route('admin.visitor-ip-address.index') }}"
                                    class="visitor-reset-filter"
                                    title="Reset filters"
                                >
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>

                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>


        {{-- TABLE --}}
        <div class="table-responsive visitor-table-wrapper">

            <table class="table visitor-log-table mb-0">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>IP ADDRESS</th>
                        <th>DATE &amp; TIME</th>
                        <th>REQUESTED PAGE</th>
                        <th>METHOD</th>
                        <th>BROWSER / USER AGENT</th>
                        <th>REFERRER</th>
                        <th>USER</th>
                        <th>STATUS</th>
                        <th>INDICATOR</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>

                            <td class="visitor-row-number">
                                {{ $logs->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="visitor-ip-cell">
                                    <div class="visitor-ip-icon">
                                        <i class="bi bi-globe2"></i>
                                    </div>

                                    <span>{{ $log->ip_address }}</span>
                                </div>
                            </td>

                            <td class="visitor-date-cell">
                                {{ $log->created_at?->format('M d, Y') }}

                                <small>
                                    {{ $log->created_at?->format('h:i A') }}
                                </small>
                            </td>

                            <td>
                                <div
                                    class="visitor-page-cell"
                                    title="{{ $log->url }}"
                                >
                                    {{ \Illuminate\Support\Str::limit($log->url, 65) }}
                                </div>
                            </td>

                            <td>
                                @php
                                    $methodClass = match($log->method) {
                                        'GET' => 'method-get',
                                        'POST' => 'method-post',
                                        'PUT', 'PATCH' => 'method-put',
                                        'DELETE' => 'method-delete',
                                        default => 'method-default',
                                    };
                                @endphp

                                <span class="visitor-method-badge {{ $methodClass }}">
                                    {{ $log->method }}
                                </span>
                            </td>

                            <td>
                                <div
                                    class="visitor-agent-cell"
                                    title="{{ $log->user_agent }}"
                                >
                                    {{ \Illuminate\Support\Str::limit($log->user_agent ?? 'Unknown', 55) }}
                                </div>
                            </td>

                            <td>
                                <div
                                    class="visitor-referrer-cell"
                                    title="{{ $log->referrer }}"
                                >
                                    {{ \Illuminate\Support\Str::limit($log->referrer ?: 'Direct / none', 45) }}
                                </div>
                            </td>

                            <td>
                                <div class="visitor-user-cell">
                                    <div class="visitor-user-avatar">
                                        <i class="bi bi-person-fill"></i>
                                    </div>

                                    <span>
                                        {{ $log->user?->name ?? 'Guest' }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                @php
                                    $statusCode = (int) $log->status_code;

                                    $statusClass = match(true) {
                                        $statusCode >= 500 => 'status-danger',
                                        $statusCode >= 400 => 'status-warning',
                                        $statusCode >= 300 => 'status-info',
                                        $statusCode >= 200 => 'status-success',
                                        default => 'status-neutral',
                                    };
                                @endphp

                                <span class="visitor-status {{ $statusClass }}">
                                    {{ $log->status_code ?? '—' }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $indicatorClass = match($log->security_label) {
                                        'Rate Limited' => 'indicator-danger',
                                        'Suspicious Pattern' => 'indicator-warning',
                                        'High Activity' => 'indicator-info',
                                        default => 'indicator-safe',
                                    };

                                    $indicatorIcon = match($log->security_label) {
                                        'Rate Limited' => 'bi-shield-exclamation',
                                        'Suspicious Pattern' => 'bi-exclamation-triangle-fill',
                                        'High Activity' => 'bi-activity',
                                        default => 'bi-check-circle-fill',
                                    };
                                @endphp

                                <span class="visitor-indicator {{ $indicatorClass }}">
                                    <i class="bi {{ $indicatorIcon }}"></i>
                                    {{ $log->security_label }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10">

                                <div class="visitor-empty-state">

                                    <div class="visitor-empty-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>

                                    <h5>No visitor logs yet</h5>

                                    <p>
                                        Public website visits will appear here automatically.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($logs->hasPages())
            <div class="visitor-pagination">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif

    </div>

</div>


@push('styles')

<style>

/* =========================================================
   PAGE
========================================================= */

.visitor-ip-page {
    padding: 38px 52px 50px;
}


/* =========================================================
   HERO
========================================================= */

.visitor-hero {
    min-height: 140px;
    padding: 30px 32px;
    margin-bottom: 24px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;

    background: linear-gradient(
        110deg,
        #0e3969 0%,
        #154a82 50%,
        #1c548e 100%
    );

    border-radius: 24px;
    box-shadow: 0 18px 42px rgba(9, 42, 80, 0.14);
}

.visitor-hero-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.visitor-hero-icon {
    width: 64px;
    height: 64px;
    flex: 0 0 64px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 18px;

    background: #fdbb00;
    color: #07376a;

    font-size: 29px;
}

.visitor-eyebrow {
    margin: 0 0 2px;

    color: #ffd12e;

    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.7px;
}

.visitor-hero h1 {
    margin: 0;

    color: #fff;

    font-size: 32px;
    font-weight: 800;
    letter-spacing: -0.5px;
}

.visitor-hero-description {
    margin: 4px 0 0;

    color: rgba(255, 255, 255, 0.78);

    font-size: 14px;
}

.visitor-hero-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.visitor-btn-danger {
    min-height: 48px;

    padding: 0 20px;

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    border: 0;
    border-radius: 13px;

    background: #fdbb00;
    color: #0b3768;

    font-size: 13px;
    font-weight: 800;

    transition: 0.2s ease;
}

.visitor-btn-danger:hover {
    transform: translateY(-1px);

    background: #ffc928;
    color: #082f5c;

    box-shadow: 0 8px 18px rgba(253, 187, 0, 0.24);
}


/* =========================================================
   SUMMARY
========================================================= */

.visitor-summary-row {
    margin-bottom: 24px;
}

.visitor-stat-card {
    min-height: 116px;

    padding: 20px 22px;

    display: flex;
    align-items: center;
    gap: 16px;

    background: #fff;

    border: 1px solid #e6edf6;
    border-radius: 20px;

    box-shadow: 0 8px 25px rgba(15, 52, 91, 0.055);

    transition: 0.2s ease;
}

.visitor-stat-card:hover {
    transform: translateY(-2px);

    box-shadow: 0 12px 30px rgba(15, 52, 91, 0.09);
}

.visitor-stat-icon {
    width: 52px;
    height: 52px;
    flex: 0 0 52px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: #eef5fc;
    color: #15477d;

    font-size: 22px;
}

.visitor-stat-warning .visitor-stat-icon {
    background: #fff6d7;
    color: #d79700;
}

.visitor-stat-content {
    display: flex;
    flex-direction: column;
}

.visitor-stat-content span {
    color: #718098;

    font-size: 12px;
    font-weight: 600;
}

.visitor-stat-content strong {
    margin: 1px 0;

    color: #0a315e;

    font-size: 27px;
    line-height: 1.15;
    font-weight: 800;
}

.visitor-stat-content small {
    color: #a1acbb;
    font-size: 11px;
}


/* =========================================================
   MAIN CARD
========================================================= */

.visitor-record-card {
    overflow: hidden;

    background: #fff;

    border: 1px solid #e3eaf3;
    border-radius: 22px;

    box-shadow: 0 10px 30px rgba(12, 48, 87, 0.06);
}

.visitor-record-header {
    min-height: 83px;

    padding: 20px 23px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    border-bottom: 1px solid #e9edf3;
}

.visitor-record-header h4 {
    margin: 0;

    color: #0a315e;

    font-size: 17px;
    font-weight: 800;
}

.visitor-record-header p {
    margin: 3px 0 0;

    color: #8e9aab;

    font-size: 11px;
}


/* =========================================================
   SEARCH
========================================================= */

.visitor-search-form {
    display: flex;
    align-items: center;
    gap: 9px;
}

.visitor-search-box {
    width: 280px;
    height: 44px;

    padding: 0 14px;

    display: flex;
    align-items: center;
    gap: 10px;

    background: #fff;

    border: 1px solid #dde5ee;
    border-radius: 13px;
}

.visitor-search-box:focus-within {
    border-color: #1d5d9d;

    box-shadow: 0 0 0 3px rgba(20, 75, 133, 0.08);
}

.visitor-search-box i {
    color: #9aa8ba;
    font-size: 15px;
}

.visitor-search-box input {
    width: 100%;

    border: 0;
    outline: 0;

    background: transparent;

    color: #263d58;

    font-size: 12px;
}

.visitor-search-box input::placeholder {
    color: #a5afbd;
}

.visitor-filter-toggle {
    height: 44px;

    padding: 0 18px;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    border: 0;
    border-radius: 12px;

    background: #fdbb00;
    color: #0a3769;

    font-size: 12px;
    font-weight: 800;

    transition: 0.2s ease;
}

.visitor-filter-toggle:hover {
    background: #ffc72a;

    transform: translateY(-1px);
}


/* =========================================================
   FILTER PANEL
========================================================= */

.visitor-filter-panel {
    padding: 20px 23px 22px;

    background: #f7f9fc;

    border-bottom: 1px solid #e8edf4;
}

.visitor-label {
    margin-bottom: 6px;

    color: #304b69;

    font-size: 11px;
    font-weight: 700;
}

.visitor-form-control,
.visitor-input-wrapper .form-control {
    min-height: 43px;

    border: 1px solid #dce4ed;
    border-radius: 11px;

    background-color: #fff;

    color: #334a63;

    font-size: 12px;
}

.visitor-form-control:focus,
.visitor-input-wrapper .form-control:focus {
    border-color: #1b5b97;

    box-shadow: 0 0 0 3px rgba(21, 75, 130, 0.08);
}

.visitor-input-wrapper {
    position: relative;
}

.visitor-input-wrapper i {
    position: absolute;

    left: 13px;
    top: 50%;

    transform: translateY(-50%);

    color: #9ba8b7;

    z-index: 2;
}

.visitor-input-wrapper .form-control {
    padding-left: 37px;
}

.visitor-filter-actions {
    display: flex;
    gap: 8px;
}

.visitor-apply-filter {
    flex: 1;
    min-height: 43px;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    border: 0;
    border-radius: 11px;

    background: #0e4178;
    color: #fff;

    font-size: 12px;
    font-weight: 700;
}

.visitor-apply-filter:hover {
    background: #0a3565;
}

.visitor-reset-filter {
    width: 43px;
    min-height: 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid #dce4ec;
    border-radius: 11px;

    background: #fff;
    color: #617289;

    text-decoration: none;
}

.visitor-reset-filter:hover {
    background: #edf2f7;
    color: #123e70;
}


/* =========================================================
   TABLE
========================================================= */

.visitor-table-wrapper {
    width: 100%;
}

.visitor-log-table {
    min-width: 1450px;
}

.visitor-log-table thead th {
    padding: 17px 17px;

    background: #f7f9fc;

    border-top: 0;
    border-bottom: 1px solid #e5ebf2;

    color: #52627a;

    font-size: 10.5px;
    font-weight: 800;
    letter-spacing: 0.25px;

    white-space: nowrap;
}

.visitor-log-table tbody td {
    padding: 16px 17px;

    vertical-align: middle;

    border-bottom: 1px solid #edf1f5;

    color: #43536a;

    font-size: 12px;
}

.visitor-log-table tbody tr {
    transition: background 0.15s ease;
}

.visitor-log-table tbody tr:hover {
    background: #f9fbfd;
}

.visitor-log-table tbody tr:last-child td {
    border-bottom: 0;
}

.visitor-row-number {
    color: #24364b !important;
    font-weight: 700;
}


/* =========================================================
   IP
========================================================= */

.visitor-ip-cell {
    display: flex;
    align-items: center;
    gap: 9px;

    white-space: nowrap;
}

.visitor-ip-icon {
    width: 30px;
    height: 30px;
    flex: 0 0 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: #eef5fc;
    color: #14518d;

    font-size: 13px;
}

.visitor-ip-cell span {
    color: #143b67;
    font-weight: 700;
}


/* =========================================================
   DATE
========================================================= */

.visitor-date-cell {
    color: #3c5068 !important;

    white-space: nowrap;
}

.visitor-date-cell small {
    display: block;

    margin-top: 2px;

    color: #9aa6b5;

    font-size: 10px;
}


/* =========================================================
   PAGE / AGENT / REFERRER
========================================================= */

.visitor-page-cell {
    max-width: 280px;

    color: #213e60;
    font-weight: 600;

    overflow-wrap: anywhere;
}

.visitor-agent-cell {
    max-width: 235px;

    color: #69788c;

    line-height: 1.45;

    overflow-wrap: anywhere;
}

.visitor-referrer-cell {
    max-width: 200px;

    color: #7b8899;

    overflow-wrap: anywhere;
}


/* =========================================================
   METHOD
========================================================= */

.visitor-method-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-width: 52px;

    padding: 5px 9px;

    border-radius: 100px;

    font-size: 10px;
    font-weight: 800;
}

.method-get {
    background: #eaf7ef;
    color: #178552;
}

.method-post {
    background: #eaf2ff;
    color: #2764b6;
}

.method-put {
    background: #fff4d9;
    color: #a56b00;
}

.method-delete {
    background: #ffeaea;
    color: #c64545;
}

.method-default {
    background: #eef1f5;
    color: #657386;
}


/* =========================================================
   USER
========================================================= */

.visitor-user-cell {
    display: flex;
    align-items: center;
    gap: 7px;

    white-space: nowrap;
}

.visitor-user-avatar {
    width: 27px;
    height: 27px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #edf3fa;
    color: #275889;

    font-size: 11px;
}


/* =========================================================
   STATUS
========================================================= */

.visitor-status {
    min-width: 44px;

    padding: 5px 9px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 100px;

    font-size: 10px;
    font-weight: 800;
}

.status-success {
    background: #e7f8ef;
    color: #09824c;
}

.status-info {
    background: #e8f3ff;
    color: #2671b8;
}

.status-warning {
    background: #fff1de;
    color: #c26d14;
}

.status-danger {
    background: #ffe6e6;
    color: #c33f3f;
}

.status-neutral {
    background: #eef1f5;
    color: #6f7b89;
}


/* =========================================================
   SECURITY INDICATOR
========================================================= */

.visitor-indicator {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    padding: 6px 10px;

    border-radius: 100px;

    font-size: 10px;
    font-weight: 700;

    white-space: nowrap;
}

.indicator-safe {
    background: #e8f8ef;
    color: #07814a;
}

.indicator-info {
    background: #e7f3ff;
    color: #236faf;
}

.indicator-warning {
    background: #fff1d7;
    color: #b46f00;
}

.indicator-danger {
    background: #ffe5e5;
    color: #c63d3d;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.visitor-empty-state {
    padding: 65px 20px;

    text-align: center;
}

.visitor-empty-icon {
    width: 64px;
    height: 64px;

    margin: 0 auto 14px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 18px;

    background: #edf4fb;
    color: #144b84;

    font-size: 27px;
}

.visitor-empty-state h5 {
    margin-bottom: 4px;

    color: #123b68;

    font-weight: 800;
}

.visitor-empty-state p {
    margin: 0;

    color: #8c99aa;

    font-size: 12px;
}


/* =========================================================
   PAGINATION
========================================================= */

.visitor-pagination {
    padding: 18px 22px;

    display: flex;
    justify-content: flex-end;

    border-top: 1px solid #edf1f5;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .visitor-ip-page {
        padding: 30px;
    }

    .visitor-record-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .visitor-search-form {
        width: 100%;
    }

    .visitor-search-box {
        flex: 1;
        width: auto;
    }

}


@media (max-width: 768px) {

    .visitor-ip-page {
        padding: 20px 15px 35px;
    }

    .visitor-hero {
        padding: 24px 20px;

        align-items: flex-start;
        flex-direction: column;

        border-radius: 19px;
    }

    .visitor-hero-left {
        align-items: flex-start;
    }

    .visitor-hero-icon {
        width: 53px;
        height: 53px;
        flex-basis: 53px;

        font-size: 23px;
    }

    .visitor-hero h1 {
        font-size: 24px;
    }

    .visitor-hero-description {
        font-size: 12px;
    }

    .visitor-hero-actions,
    .visitor-hero-actions form,
    .visitor-btn-danger {
        width: 100%;
    }

    .visitor-record-header {
        padding: 18px;
    }

    .visitor-search-form {
        flex-direction: column;
    }

    .visitor-search-box,
    .visitor-filter-toggle {
        width: 100%;
    }

    .visitor-filter-panel {
        padding: 18px;
    }

}

</style>

@endpush

@endsection