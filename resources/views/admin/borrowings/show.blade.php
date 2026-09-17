@extends('layouts.admin')

@section('title', 'Borrowing Record')

@section('content')
<div class="container-fluid borrowing-show-page">
    @php
        $borrowerType = strtolower($borrowing->borrower?->borrower_type ?? '');
        $borrowerTypeLabel = in_array($borrowerType, ['student', 'faculty'], true)
            ? ucfirst($borrowerType)
            : 'Not Set';
    @endphp

    <section class="record-hero">
        <div class="hero-left">
            <div class="hero-icon"><i class="bi bi-journal-bookmark"></i></div>

            <div>
                <span class="hero-eyebrow">Circulation Management</span>
                <div class="hero-title-line">
                    <h1>Borrowing Record</h1>
                    <span class="hero-status status-{{ $borrowing->display_status }}">
                        {{ ucfirst($borrowing->display_status) }}
                    </span>
                    <span class="borrower-type-badge type-{{ $borrowerType ?: 'unset' }}">
                        {{ $borrowerTypeLabel }}
                    </span>
                </div>
                <p>
                    {{ $borrowing->borrower?->name ?? 'Unknown Borrower' }}
                    · {{ $borrowing->accession_number ?: 'Copy not assigned yet' }}
                </p>
            </div>
        </div>

        <div class="hero-actions">
            <a href="{{ route('admin.borrowings.index') }}" class="hero-btn hero-btn-light">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

            @if($borrowing->borrower)
                <a href="{{ route('admin.borrowings.borrower', $borrowing->borrower) }}" class="hero-btn hero-btn-light">
                    <i class="bi bi-person-vcard"></i>
                    Borrower Profile
                </a>

                <a href="{{ route('admin.borrowings.print-card', $borrowing->borrower) }}"
                   target="_blank"
                   class="hero-btn hero-btn-yellow">
                    <i class="bi bi-printer"></i>
                    Print Card
                </a>
            @endif
        </div>
    </section>

    @if(session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" role="alert"><strong>Please check the following:</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <div class="record-layout">
        <section class="record-panel borrower-panel">
            <div class="panel-heading">
                <div class="heading-icon"><i class="bi bi-person"></i></div>
                <div>
                    <h2>Borrower Information</h2>
                    <p>Borrower identity and contact details.</p>
                </div>
            </div>

            <div class="detail-list">
                <div class="detail-row"><span>Name</span><strong>{{ $borrowing->borrower?->name ?? '-' }}</strong></div>
                <div class="detail-row"><span>ID Number</span><strong>{{ $borrowing->borrower?->id_number ?? '-' }}</strong></div>
                <div class="detail-row">
                    <span>Borrower Type</span>
                    <strong><span class="inline-type type-{{ $borrowerType ?: 'unset' }}">{{ $borrowerTypeLabel }}</span></strong>
                </div>
                <div class="detail-row"><span>Department</span><strong>{{ $borrowing->borrower?->department ?: '-' }}</strong></div>
                <div class="detail-row"><span>Semester</span><strong>{{ $borrowing->borrower?->semester ?: '-' }}</strong></div>
                <div class="detail-row"><span>Contact Number</span><strong>{{ $borrowing->borrower?->contact_number ?: '-' }}</strong></div>
                <div class="detail-row"><span>Email Address</span><strong>{{ $borrowing->borrower?->email ?: '-' }}</strong></div>
            </div>
        </section>

        <section class="record-panel transaction-panel">
            <div class="panel-heading">
                <div class="heading-icon"><i class="bi bi-journal-text"></i></div>
                <div>
                    <h2>Book Transaction</h2>
                    <p>Loan dates, handling details, and remarks.</p>
                </div>
            </div>

            <div class="transaction-grid">
                <div class="transaction-card">
                    <span>Accession Number</span>
                    <strong class="mono">{{ $borrowing->accession_number ?: 'Not assigned — add using Edit Record' }}</strong>
                </div>

                <div class="transaction-card wide">
                    <span>Bibliographical Description</span>
                    <strong>{{ $borrowing->bibliographical_description }}</strong>
                </div>

                <div class="transaction-card">
                    <span>Date Borrowed</span>
                    <strong>{{ optional($borrowing->date_borrowed)->format('F d, Y') ?: '-' }}</strong>
                </div>

                <div class="transaction-card">
                    <span>Due Date</span>
                    <strong>{{ optional($borrowing->due_date)->format('F d, Y') ?: '-' }}</strong>
                </div>

                <div class="transaction-card">
                    <span>Date Returned</span>
                    <strong>{{ optional($borrowing->date_returned)->format('F d, Y') ?: '-' }}</strong>
                </div>

                <div class="transaction-card">
                    <span>Received By</span>
                    <strong>{{ $borrowing->received_by ?: '-' }}</strong>
                </div>

                <div class="transaction-card">
                    <span>Returned By</span>
                    <strong>{{ $borrowing->returned_by ?: '-' }}</strong>
                </div>

                <div class="transaction-card wide">
                    <span>Remarks</span>
                    <strong>{{ $borrowing->remarks ?: '-' }}</strong>
                </div>

                <div class="transaction-card wide">
                    <span>Released By</span>
                    <strong>{{ $borrowing->released_by ?: '-' }}</strong>
                </div>
                <div class="transaction-card wide">
                    <span>Borrowing Policy</span>
                    <strong>{{ $borrowerType === 'faculty' ? '10 books · 1 calendar month per loan' : '3 books · 2 days per loan' }}</strong>
                    <p class="mb-0 mt-2">Renewals used: {{ $borrowing->renewal_count ?? 0 }} / 2. Each renewal adds one loan period from the current due date, or today if overdue.</p>
                </div>
            </div>

            <div class="record-actions">
                @if($borrowing->status === 'pending')
                    <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <button class="record-btn btn-success-soft" @disabled(blank($borrowing->accession_number))>
                            <i class="bi bi-check-lg"></i> Approve
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <button class="record-btn btn-danger-soft">
                            <i class="bi bi-x-lg"></i> Reject
                        </button>
                    </form>
                @endif

                @if($borrowing->status === 'approved')
                    <button type="button" class="record-btn btn-primary-solid" data-bs-toggle="modal" data-bs-target="#release-modal">
                        <i class="bi bi-bookmark-check"></i> Release Book
                    </button>
                @endif

                @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                    <form method="POST" action="{{ route('admin.borrowings.renew', $borrowing) }}" onsubmit="return confirm('Extend this book’s due date by one loan period?');">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="renewal_count" value="{{ $borrowing->renewal_count ?? 0 }}">
                        <button class="record-btn btn-outline" @disabled(($borrowing->renewal_count ?? 0) >= 2 || !$borrowing->due_date || $borrowing->date_returned)>Renew Book</button>
                    </form>
                    <button type="button" class="record-btn btn-yellow" data-bs-toggle="modal" data-bs-target="#return-modal">
                        <i class="bi bi-arrow-return-left"></i> Record Return
                    </button>
                @endif

                <a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="record-btn btn-outline">
                    <i class="bi bi-pencil"></i> Edit Record
                </a>

                <form method="POST"
                      action="{{ route('admin.borrowings.destroy', $borrowing) }}"
                      class="delete-record-form"
                      onsubmit="return confirm('Delete this borrowing record only if it was created by mistake. Continue?');">
                    @csrf
                    @method('DELETE')
                    <button class="record-btn btn-danger-soft">
                        <i class="bi bi-trash3"></i> Delete
                    </button>
                </form>
            </div>
        </section>
    </div>
</div>

    @if($borrowing->status === 'approved')
    <div class="modal fade" id="release-modal" tabindex="-1" aria-labelledby="release-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                    <form class="modal-content" method="POST" action="{{ route('admin.borrowings.borrowed', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="release-title">Release Book</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        @if($errors->any())
                            <div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <div class="row g-3 mb-3">
                            <p class="text-muted mb-0">{{ $borrowerType === 'faculty' ? 'Maximum 10 books at a time; due within 1 calendar month.' : 'Maximum 3 books at a time; due within 2 days.' }}</p>
                            <div class="col-md-6">
                                <label for="release-date" class="form-label">Date Borrowed</label>
                                <input id="release-date" class="form-control" type="date" name="date_borrowed" value="{{ old('date_borrowed', now()->toDateString()) }}" max="{{ now()->toDateString() }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="release-due" class="form-label">Due Date</label>
                                <input id="release-due" class="form-control" type="date" name="due_date" value="{{ old('due_date', optional($borrowing->due_date)->toDateString()) }}" required>
                            </div>
                            <div class="col-12">
                                <label for="release-staff" class="form-label">Released By (library staff)</label>
                                <input id="release-staff" class="form-control" name="released_by" value="{{ old('released_by', auth()->user()?->name) }}" maxlength="255" required>
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="record-btn btn-primary-solid" type="submit">Confirm Book Release</button>
                        </div>
                    </form>
        </div>
    </div>
    @endif
    @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))
    <div class="modal fade" id="return-modal" tabindex="-1" aria-labelledby="return-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                    <form class="modal-content" method="POST" action="{{ route('admin.borrowings.returned', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h2 class="modal-title fs-5" id="return-title">Record Return</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        @if($errors->any())
                            <div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                        @endif
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label for="return-person" class="form-label">Returned By (person returning the book)</label>
                                <input id="return-person" class="form-control" name="returned_by" value="{{ old('returned_by') }}" autocomplete="off" maxlength="255" required>
                            </div>

                            <div class="col-12">
                                <label for="return-remarks" class="form-label">Remarks (optional)</label>
                                <textarea id="return-remarks" class="form-control" name="remarks" maxlength="2000">{{ old('remarks', $borrowing->remarks) }}</textarea>
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="record-btn btn-yellow" type="submit">Confirm Book Return</button>
                        </div>
                    </form>
        </div>
    </div>
    @endif
@endsection

@push('styles')
<style>
.borrowing-show-page{
    --navy:#0b315e;--yellow:#ffbd00;--line:#dfe7ef;--muted:#7d8da1;
    padding:28px 34px 40px;
}
.record-hero{
    min-height:170px;margin-bottom:22px;padding:32px 36px;display:flex;align-items:center;
    justify-content:space-between;gap:24px;position:relative;overflow:hidden;color:#fff;
    background:
        radial-gradient(circle at 82% 80%,rgba(255,255,255,.08) 0 72px,transparent 73px),
        radial-gradient(circle at 82% 80%,rgba(255,255,255,.06) 0 112px,transparent 113px),
        linear-gradient(115deg,#0d3b72 0%,#174d7d 65%,#365f7b 100%);
    border-radius:24px;box-shadow:0 14px 35px rgba(17,54,91,.12);
}
.hero-left{display:flex;align-items:center;gap:22px;min-width:0}
.hero-icon{
    width:72px;height:72px;flex:0 0 72px;display:grid;place-items:center;color:#0b315e;
    background:var(--yellow);border-radius:22px;font-size:29px;
}
.hero-eyebrow{
    display:block;margin-bottom:5px;color:#ffd54d;font-size:12px;font-weight:800;
    letter-spacing:.08em;text-transform:uppercase;
}
.hero-title-line{display:flex;align-items:center;flex-wrap:wrap;gap:9px}
.record-hero h1{margin:0;font-size:36px;font-weight:800;letter-spacing:-.03em}
.record-hero p{margin:6px 0 0;color:rgba(255,255,255,.84);font-size:14px}
.hero-status,.borrower-type-badge{
    display:inline-flex;align-items:center;gap:6px;padding:7px 11px;border-radius:999px;
    font-size:10px;font-weight:800;
}
.hero-status::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
.hero-status.status-pending{color:#725500;background:#ffedaa}
.hero-status.status-approved{color:#155082;background:#dfeeff}
.hero-status.status-borrowed,.hero-status.status-returned{color:#0f6545;background:#dff5e9}
.hero-status.status-overdue{color:#9e3540;background:#ffe1e4}
.hero-status.status-rejected{color:#596573;background:#e9edf1}
.borrower-type-badge{text-transform:uppercase}
.type-student{color:#0f5b96;background:#deefff}
.type-faculty{color:#725700;background:#ffe8a1}
.type-unset{color:#596573;background:#e9edf1}
.hero-actions{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:9px;position:relative;z-index:1}
.hero-btn{
    min-height:48px;padding:0 17px;display:inline-flex;align-items:center;justify-content:center;
    gap:7px;border-radius:14px;font-size:12px;font-weight:800;text-decoration:none;white-space:nowrap;
}
.hero-btn-light{color:#0b315e;background:#fff;border:1px solid rgba(255,255,255,.75)}
.hero-btn-yellow{color:#0b315e;background:var(--yellow);border:1px solid #e6aa00}
.record-layout{display:grid;grid-template-columns:minmax(320px,.78fr) minmax(0,1.42fr);gap:20px}
.record-panel{
    background:#fff;border:1px solid var(--line);border-radius:24px;
    box-shadow:0 10px 25px rgba(16,48,82,.05);
}
.borrower-panel{overflow:hidden}
.transaction-panel{padding-bottom:20px}
.panel-heading{padding:22px 24px 18px;display:flex;align-items:flex-start;gap:12px}
.heading-icon{
    width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;color:#205e93;
    background:#eef5fb;border-radius:13px;font-size:18px;
}
.panel-heading h2{margin:1px 0 0;color:#0b315e;font-size:20px;font-weight:800}
.panel-heading p{margin:4px 0 0;color:var(--muted);font-size:12px}
.detail-list{margin:0 24px 24px;overflow:hidden;border:1px solid #dce6ef;border-radius:15px}
.detail-row{
    min-height:65px;padding:13px 16px;display:grid;grid-template-columns:130px minmax(0,1fr);
    align-items:center;gap:16px;border-bottom:1px solid #e4eaf0;
}
.detail-row:last-child{border-bottom:0}
.detail-row span,.transaction-card span{
    color:#74869d;font-size:10px;font-weight:800;letter-spacing:.05em;text-transform:uppercase;
}
.detail-row strong,.transaction-card strong{
    color:#0b315e;font-size:12px;font-weight:800;overflow-wrap:anywhere;
}
.inline-type{display:inline-flex!important;padding:6px 9px;border-radius:999px;font-size:9px!important}
.transaction-grid{padding:0 24px;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.transaction-card{
    min-height:93px;padding:16px 18px;display:flex;flex-direction:column;gap:7px;
    background:#f7f9fc;border:1px solid #dee7f0;border-radius:15px;
}
.transaction-card.wide{grid-column:1/-1}
.mono{font-family:ui-monospace,SFMono-Regular,Consolas,monospace}
.record-actions{
    margin:20px 24px 0;padding-top:18px;display:flex;flex-wrap:wrap;gap:9px;border-top:1px solid var(--line);
}
.record-actions form{margin:0}
.record-btn{
    min-height:42px;padding:0 14px;display:inline-flex;align-items:center;justify-content:center;
    gap:7px;border-radius:11px;font-size:11px;font-weight:800;text-decoration:none;
}
.btn-success-soft{color:#126b48;background:#ecf8f1;border:1px solid #d1eadb}
.btn-danger-soft{color:#ac3d48;background:#fff5f5;border:1px solid #efd1d4}
.btn-primary-solid{color:#fff;background:#0b315e;border:1px solid #0b315e}
.btn-yellow{color:#5f4700;background:var(--yellow);border:1px solid #e6aa00}
.btn-outline{color:#205d91;background:#fff;border:1px solid #d4e1ed}
.delete-record-form{margin-left:auto!important}
@media (max-width:1199.98px){
    .record-hero{align-items:flex-start;flex-direction:column}
    .hero-actions{justify-content:flex-start}
    .record-layout{grid-template-columns:1fr}
}
@media (max-width:767.98px){
    .borrowing-show-page{padding:18px 12px 28px}
    .record-hero{padding:24px 20px;border-radius:18px}
    .hero-left{align-items:flex-start}
    .hero-icon{width:58px;height:58px;flex-basis:58px;border-radius:17px;font-size:24px}
    .record-hero h1{font-size:27px}
    .hero-actions{width:100%;flex-direction:column}
    .hero-btn{width:100%}
    .record-panel{border-radius:18px}
    .transaction-grid{grid-template-columns:1fr;padding:0 18px}
    .transaction-card.wide{grid-column:auto}
    .detail-list{margin:0 18px 20px}
    .panel-heading{padding:20px 18px 16px}
    .detail-row{grid-template-columns:1fr;gap:4px}
    .record-actions{margin:18px 18px 0;flex-direction:column}
    .record-actions>*,.record-actions form .record-btn{width:100%}
    .delete-record-form{margin-left:0!important}
}
</style>
@endpush

@push('scripts')
@php($modalAction = $borrowing->status === 'approved' ? 'release' : (in_array($borrowing->status, ['borrowed', 'overdue'], true) ? 'return' : ''))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const start = document.getElementById('release-date');
    const due = document.getElementById('release-due');
    function updateDueDate(reset) {
        if (!start || !due || !start.value) return;
        const parts = start.value.split('-').map(Number);
        const maximum = new Date(Date.UTC(parts[0], parts[1] - 1, parts[2]));
        if (@json($borrowerType === 'faculty')) {
            maximum.setUTCDate(1);
            maximum.setUTCMonth(maximum.getUTCMonth() + 1);
            const lastDay = new Date(Date.UTC(maximum.getUTCFullYear(), maximum.getUTCMonth() + 1, 0)).getUTCDate();
            maximum.setUTCDate(Math.min(parts[2], lastDay));
        } else {
            maximum.setUTCDate(maximum.getUTCDate() + 2);
        }
        due.min = start.value;
        due.max = maximum.toISOString().slice(0, 10);
        if (reset || !due.value) due.value = due.max;
    }
    start?.addEventListener('change', function () { updateDueDate(true); });
    updateDueDate(false);
    const action = window.location.hash.slice(1);
    const hasErrors = @json($errors->any() && !$errors->has('renewal') && !$errors->has('renewal_count'));
    const currentAction = @json($modalAction);
    const target = document.getElementById((hasErrors ? currentAction : action) + '-modal');
    if (target && (hasErrors || ['release', 'return'].includes(action))) {
        bootstrap.Modal.getOrCreateInstance(target).show();
    }
});
</script>
@endpush
