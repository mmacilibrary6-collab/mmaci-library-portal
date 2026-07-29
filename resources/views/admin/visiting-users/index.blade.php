@extends('layouts.admin')

@section('title', 'Visiting Users')

@section('content')

<div class="container-fluid py-4">

    <div class="dashboard-panel">

        <div class="panel-header">

            <div>
                <p class="panel-eyebrow mb-1">Visitor Management</p>
                <h3 class="panel-title mb-0">Visiting User Requests</h3>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Back to dashboard
            </a>

        </div>

        <div class="panel-body">

            @forelse($visitors as $visitor)
                <div class="activity-item">
                    <div class="activity-avatar">
                        {{ strtoupper(substr($visitor->full_name ?? 'V', 0, 1)) }}
                    </div>

                    <div class="activity-details w-100">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <h6 class="activity-title mb-1">{{ $visitor->full_name ?? 'Unknown Visitor' }}</h6>
                            <span class="status-badge status-{{ $visitor->status ?? 'pending' }}">
                                {{ ucfirst($visitor->status ?? 'pending') }}
                            </span>
                        </div>

                        <p class="activity-meta mb-1">{{ $visitor->institution ?? $visitor->school ?? 'Institution not specified' }}</p>
                        <p class="activity-meta mb-1">{{ $visitor->visitor_type ? ucfirst($visitor->visitor_type) : 'Visitor type not specified' }}</p>
                        <p class="activity-meta mb-0">{{ $visitor->purpose ?? 'Purpose not specified.' }}</p>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-person-x"></i>
                    <h5>No visitor requests yet</h5>
                    <p>Visiting-user submissions will appear here.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $visitors->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
