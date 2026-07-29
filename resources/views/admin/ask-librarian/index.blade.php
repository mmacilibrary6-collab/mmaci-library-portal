@extends('layouts.admin')

@section('title', 'Librarian Inquiries')

@section('content')

<div class="container-fluid py-4">

    <div class="dashboard-panel">

        <div class="panel-header">

            <div>
                <p class="panel-eyebrow mb-1">Communication</p>
                <h3 class="panel-title mb-0">Librarian Inquiries</h3>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Back to dashboard
            </a>

        </div>

        <div class="panel-body">

            @forelse($questions as $question)
                <div class="activity-item">
                    <div class="activity-avatar">
                        {{ strtoupper(substr($question->name ?? 'U', 0, 1)) }}
                    </div>

                    <div class="activity-details w-100">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <h6 class="activity-title mb-1">{{ $question->name ?? 'Unknown User' }}</h6>
                            <span class="status-badge status-{{ $question->status ?? 'pending' }}">
                                {{ ucfirst($question->status ?? 'pending') }}
                            </span>
                        </div>

                        <p class="activity-meta mb-1">{{ $question->email ?? 'No email provided' }}</p>
                        <p class="activity-meta mb-0">{{ $question->question ?? 'No question provided.' }}</p>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-chat-left-dots"></i>
                    <h5>No inquiries yet</h5>
                    <p>Submitted questions will appear here.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $questions->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
