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
                        <p class="activity-meta mb-1">{{ $question->contact_number ?? 'No contact number provided' }}</p>
                        <p class="activity-meta mb-0">
                            <strong>Subject:</strong> {{ $question->subject ?? 'No subject provided.' }}
                        </p>
                        <p class="activity-meta mb-0 mt-1">{{ $question->message ?? 'No message provided.' }}</p>

                        @if(!empty($question->reply))
                            <div class="mt-3 p-3 rounded-3" style="background: #f7f9fc; border: 1px solid #e2e8f0;">
                                <small class="text-uppercase fw-bold text-muted d-block mb-1">Reply</small>
                                <div>{{ $question->reply }}</div>
                            </div>
                        @endif
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
