@extends('layouts.admin')

@section('title', 'Visitors IP Address')

@section('content')

<div class="container-fluid py-4">

    <div class="dashboard-panel">

        <div class="panel-header flex-wrap gap-3">

            <div>
                <p class="panel-eyebrow mb-1">Security Monitoring</p>
                <h3 class="panel-title mb-0">Visitors IP Address</h3>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <form action="{{ route('admin.visitor-ip-address.prune') }}" method="POST" onsubmit="return confirm('Delete visitor logs older than the configured retention period?');">
                    @csrf
                    <input type="hidden" name="days" value="{{ (int) config('security.visitor_log_retention_days', 90) }}">
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                        Clear old logs
                    </button>
                </form>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Back to dashboard
                </a>
            </div>

        </div>

        <div class="panel-body">

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="visitor-summary-card">
                        <span>Total logs</span>
                        <strong>{{ number_format($summary['total']) }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="visitor-summary-card">
                        <span>Today</span>
                        <strong>{{ number_format($summary['today']) }}</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="visitor-summary-card">
                        <span>401 / 403 / 404 / 429</span>
                        <strong>{{ number_format($summary['suspicious']) }}</strong>
                    </div>
                </div>
            </div>

            <form method="GET" class="visitor-filter-bar mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Search</label>
                        <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="IP, URL, user agent, user name...">
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" value="{{ $date }}" class="form-control">
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">Method</label>
                        <select name="method" class="form-select">
                            <option value="">All</option>
                            @foreach(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $httpMethod)
                                <option value="{{ $httpMethod }}" @selected($method === $httpMethod)>{{ $httpMethod }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            @foreach([200, 301, 302, 401, 403, 404, 429, 500] as $httpStatus)
                                <option value="{{ $httpStatus }}" @selected((string) $status === (string) $httpStatus)>{{ $httpStatus }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-admin w-100">Filter</button>
                        <a href="{{ route('admin.visitor-ip-address.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle visitor-log-table">
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Date &amp; Time</th>
                            <th>Requested Page</th>
                            <th>Method</th>
                            <th>Browser / User Agent</th>
                            <th>Referrer</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Indicator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="text-nowrap fw-semibold">{{ $log->ip_address }}</td>
                                <td class="text-nowrap">{{ $log->created_at?->format('M d, Y h:i A') }}</td>
                                <td class="text-break">
                                    <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($log->url, 70) }}</div>
                                </td>
                                <td><span class="badge bg-primary-subtle text-primary-emphasis">{{ $log->method }}</span></td>
                                <td class="text-break">{{ \Illuminate\Support\Str::limit($log->user_agent ?? 'Unknown', 80) }}</td>
                                <td class="text-break">{{ \Illuminate\Support\Str::limit($log->referrer ?: 'Direct / none', 80) }}</td>
                                <td class="text-break">{{ $log->user?->name ?? 'Guest' }}</td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis">
                                        {{ $log->status_code ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $indicatorClass = match($log->security_label) {
                                            'Rate Limited' => 'bg-danger-subtle text-danger-emphasis',
                                            'Suspicious Pattern' => 'bg-warning-subtle text-warning-emphasis',
                                            'High Activity' => 'bg-info-subtle text-info-emphasis',
                                            default => 'bg-success-subtle text-success-emphasis',
                                        };
                                    @endphp
                                    <span class="badge {{ $indicatorClass }}">{{ $log->security_label }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state py-5">
                                        <i class="bi bi-shield-lock"></i>
                                        <h5>No visitor logs yet</h5>
                                        <p>Public website visits will appear here automatically.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>

        </div>

    </div>

</div>

@push('styles')
<style>
.visitor-summary-card {
    border-radius: 18px;
    padding: 18px 20px;
    background: linear-gradient(145deg, #ffffff, #f5f8ff);
    border: 1px solid rgba(24, 75, 140, 0.08);
    box-shadow: 0 10px 26px rgba(11, 46, 89, 0.06);
}

.visitor-summary-card span {
    display: block;
    color: #6d7b92;
    font-size: 0.85rem;
    margin-bottom: 6px;
}

.visitor-summary-card strong {
    color: #0b2e59;
    font-size: 1.5rem;
    font-weight: 800;
}

.visitor-filter-bar {
    padding: 18px;
    border-radius: 18px;
    background: #fff;
    border: 1px solid rgba(24, 75, 140, 0.08);
    box-shadow: 0 10px 26px rgba(11, 46, 89, 0.05);
}

.visitor-log-table td,
.visitor-log-table th {
    vertical-align: top;
}
</style>
@endpush

@endsection
