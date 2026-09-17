@extends('layouts.admin')

@section('title', 'Borrowing Record')

@section('content')
<div class="container-fluid borrowing-show-page">

    <section class="record-hero">
        <div class="hero-left">
            <div class="hero-icon">
                <i class="bi bi-journal-bookmark"></i>
            </div>

            <div>
                <span class="hero-eyebrow">Circulation Management</span>
                <div class="hero-title-line">
                    <h1>Borrowing Record</h1>
                    <span class="hero-status status-{{ $borrowing->display_status }}">
                        {{ ucfirst($borrowing->display_status) }}
                    </span>
                </div>
                <p>
                    {{ $borrowing->borrower?->name ?? 'Unknown Borrower' }}
                    · {{ $borrowing->accession_number }}
                </p>
            </div>
        </div>

        <div class="hero-actions">
            <a href="{{ route('admin.borrowings.index') }}" class="hero-btn hero-btn-light">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

            @if($borrowing->borrower)
                <a
                    href="{{ route('admin.borrowings.borrower', $borrowing->borrower) }}"
                    class="hero-btn hero-btn-light">
                    <i class="bi bi-person-vcard"></i>
                    Borrower Profile
                </a>

                <a
                    href="{{ route('admin.borrowings.print-card', $borrowing->borrower) }}"
                    target="_blank"
                    class="hero-btn hero-btn-yellow">
                    <i class="bi bi-printer"></i>
                    Print Card
                </a>
            @endif
        </div>
    </section>

    <div class="record-layout">
        <section class="record-panel borrower-panel">
            <div class="panel-heading">
                <div class="heading-icon">
                    <i class="bi bi-person"></i>
                </div>

                <div>
                    <h2>Borrower Information</h2>
                    <p>Borrower identity and contact details.</p>
                </div>
            </div>

            <div class="detail-list">
                <div class="detail-row">
                    <span>Name</span>
                    <strong>{{ $borrowing->borrower?->name ?? '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>ID Number</span>
                    <strong>{{ $borrowing->borrower?->id_number ?? '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>Department</span>
                    <strong>{{ $borrowing->borrower?->department ?: '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>Semester</span>
                    <strong>{{ $borrowing->borrower?->semester ?: '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>Contact Number</span>
                    <strong>{{ $borrowing->borrower?->contact_number ?: '-' }}</strong>
                </div>

                <div class="detail-row">
                    <span>Email Address</span>
                    <strong>{{ $borrowing->borrower?->email ?: '-' }}</strong>
                </div>
            </div>
        </section>

        <section class="record-panel transaction-panel">
            <div class="panel-heading">
                <div class="heading-icon">
                    <i class="bi bi-journal-text"></i>
                </div>

                <div>
                    <h2>Book Transaction</h2>
                    <p>Loan dates, handling details, and remarks.</p>
                </div>
            </div>

            <div class="transaction-grid">
                <div class="transaction-card">
                    <span>Accession Number</span>
                    <strong class="mono">{{ $borrowing->accession_number }}</strong>
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
            </div>

            <div class="record-actions">
                @if($borrowing->status === 'pending')
                    <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <button class="record-btn btn-success-soft">
                            <i class="bi bi-check-lg"></i>
                            Approve
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <button class="record-btn btn-danger-soft">
                            <i class="bi bi-x-lg"></i>
                            Reject
                        </button>
                    </form>
                @endif

                @if(in_array($borrowing->status, ['pending', 'approved'], true))
                    <form method="POST" action="{{ route('admin.borrowings.borrowed', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <button class="record-btn btn-primary-solid">
                            <i class="bi bi-bookmark-check"></i>
                            Mark as Borrowed
                        </button>
                    </form>
                @endif

                @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                    <form method="POST" action="{{ route('admin.borrowings.returned', $borrowing) }}">
                        @csrf
                        @method('PATCH')
                        <button class="record-btn btn-yellow">
                            <i class="bi bi-arrow-return-left"></i>
                            Mark as Returned
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="record-btn btn-outline">
                    <i class="bi bi-pencil"></i>
                    Edit Record
                </a>

                <form
                    method="POST"
                    action="{{ route('admin.borrowings.destroy', $borrowing) }}"
                    class="delete-record-form"
                    onsubmit="return confirm('Delete this borrowing record only if it was created by mistake. Continue?');">
                    @csrf
                    @method('DELETE')

                    <button class="record-btn btn-danger-soft">
                        <i class="bi bi-trash3"></i>
                        Delete
                    </button>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection

@push('styles')
<style>
.borrowing-show-page{
    --navy:#0b315e;
    --yellow:#ffbd00;
    --line:#dfe7ef;
    --muted:#7d8da1;
    padding:28px 34px 40px;
}

.record-hero{
    min-height:170px;
    margin-bottom:22px;
    padding:32px 36px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    position:relative;
    overflow:hidden;
    color:#fff;
    background:
        radial-gradient(circle at 82% 80%,rgba(255,255,255,.08) 0 72px,transparent 73px),
        radial-gradient(circle at 82% 80%,rgba(255,255,255,.06) 0 112px,transparent 113px),
        linear-gradient(115deg,#0d3b72 0%,#174d7d 65%,#365f7b 100%);
    border-radius:24px;
    box-shadow:0 14px 35px rgba(17,54,91,.12);
}

.hero-left{
    display:flex;
    align-items:center;
    gap:22px;
    min-width:0;
}

.hero-icon{
    width:72px;
    height:72px;
    flex:0 0 72px;
    display:grid;
    place-items:center;
    color:#0b315e;
    background:var(--yellow);
    border-radius:22px;
    font-size:29px;
}

.hero-eyebrow{
    display:block;
    margin-bottom:5px;
    color:#ffd54d;
    font-size:12px;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.hero-title-line{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
}

.record-hero h1{
    margin:0;
    font-size:36px;
    font-weight:800;
    letter-spacing:-.03em;
}

.record-hero p{
    margin:6px 0 0;
    color:rgba(255,255,255,.84);
    font-size:14px;
}

.hero-status{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:7px 11px;
    border-radius:999px;
    font-size:10px;
    font-weight:800;
}

.hero-status::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
}

.hero-status.status-pending{color:#725500;background:#ffedaa}
.hero-status.status-approved{color:#155082;background:#dfeeff}
.hero-status.status-borrowed{color:#0f6545;background:#dff5e9}
.hero-status.status-returned{color:#0f6545;background:#dff5e9}
.hero-status.status-overdue{color:#9e3540;background:#ffe1e4}
.hero-status.status-rejected{color:#596573;background:#e9edf1}

.hero-actions{
    display:flex;
    flex-wrap:wrap;
    justify-content:flex-end;
    gap:9px;
    position:relative;
    z-index:1;
}

.hero-btn{
    min-height:48px;
    padding:0 17px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    border-radius:14px;
    font-size:12px;
    font-weight:800;
    text-decoration:none;
    white-space:nowrap;
}

.hero-btn-light{
    color:#0b315e;
    background:#fff;
    border:1px solid rgba(255,255,255,.75);
}

.hero-btn-yellow{
    color:#0b315e;
    background:var(--yellow);
    border:1px solid #e6aa00;
}

.record-layout{
    display:grid;
    grid-template-columns:minmax(320px,.78fr) minmax(0,1.42fr);
    gap:20px;
}

.record-panel{
    background:#fff;
    border:1px solid var(--line);
    border-radius:24px;
    box-shadow:0 10px 25px rgba(16,48,82,.05);
}

.borrower-panel{
    overflow:hidden;
}

.transaction-panel{
    padding-bottom:20px;
}

.panel-heading{
    padding:22px 24px 18px;
    display:flex;
    align-items:flex-start;
    gap:12px;
}

.heading-icon{
    width:44px;
    height:44px;
    flex:0 0 44px;
    display:grid;
    place-items:center;
    color:#205e93;
    background:#eef5fb;
    border-radius:13px;
    font-size:18px;
}

.panel-heading h2{
    margin:1px 0 0;
    color:#0b315e;
    font-size:20px;
    font-weight:800;
}

.panel-heading p{
    margin:4px 0 0;
    color:var(--muted);
    font-size:12px;
}

.detail-list{
    margin:0 24px 24px;
    overflow:hidden;
    border:1px solid #dce6ef;
    border-radius:15px;
}

.detail-row{
    min-height:69px;
    padding:14px 16px;
    display:grid;
    grid-template-columns:130px minmax(0,1fr);
    align-items:center;
    gap:16px;
    border-bottom:1px solid #e4eaf0;
}

.detail-row:last-child{
    border-bottom:0;
}

.detail-row span,
.transaction-card span{
    color:#74869d;
    font-size:10px;
    font-weight:800;
    letter-spacing:.05em;
    text-transform:uppercase;
}

.detail-row strong,
.transaction-card strong{
    color:#0b315e;
    font-size:12px;
    font-weight:800;
    overflow-wrap:anywhere;
}

.transaction-grid{
    padding:0 24px;
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
}

.transaction-card{
    min-height:93px;
    padding:16px 18px;
    display:flex;
    flex-direction:column;
    gap:7px;
    background:#f7f9fc;
    border:1px solid #dee7f0;
    border-radius:15px;
}

.transaction-card.wide{
    grid-column:1/-1;
}

.mono{
    font-family:ui-monospace,SFMono-Regular,Consolas,monospace;
}

.record-actions{
    margin:20px 24px 0;
    padding-top:18px;
    display:flex;
    flex-wrap:wrap;
    gap:9px;
    border-top:1px solid var(--line);
}

.record-actions form{
    margin:0;
}

.record-btn{
    min-height:42px;
    padding:0 14px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    border-radius:11px;
    font-size:11px;
    font-weight:800;
    text-decoration:none;
}

.btn-success-soft{
    color:#126b48;
    background:#ecf8f1;
    border:1px solid #d1eadb;
}

.btn-danger-soft{
    color:#ac3d48;
    background:#fff5f5;
    border:1px solid #efd1d4;
}

.btn-primary-solid{
    color:#fff;
    background:#0b315e;
    border:1px solid #0b315e;
}

.btn-yellow{
    color:#5f4700;
    background:var(--yellow);
    border:1px solid #e6aa00;
}

.btn-outline{
    color:#205d91;
    background:#fff;
    border:1px solid #d4e1ed;
}

.delete-record-form{
    margin-left:auto!important;
}

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
    .record-actions>*,
    .record-actions form .record-btn{
        width:100%;
    }
    .delete-record-form{margin-left:0!important}
}
</style>
@endpush
