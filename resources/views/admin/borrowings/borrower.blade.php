@extends('layouts.admin')

@section('title', 'Borrower Profile')

@section('content')
<div class="container-fluid borrower-profile-page">

    <section class="profile-hero">
        <div class="hero-left">
            <div class="hero-icon">
                <i class="bi bi-person-vcard"></i>
            </div>

            <div>
                <span class="hero-eyebrow">Circulation Management</span>
                <h1>{{ $borrower->name }}</h1>
                <p>{{ $borrower->id_number }} · {{ $borrower->department ?: 'No Department' }}</p>
            </div>
        </div>

        <div class="hero-actions">
            <a href="{{ route('admin.borrowings.index') }}" class="hero-btn hero-btn-light">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

            <a
                href="{{ route('admin.borrowings.print-card', $borrower) }}"
                target="_blank"
                class="hero-btn hero-btn-yellow">
                <i class="bi bi-printer"></i>
                Print Borrower Card
            </a>
        </div>
    </section>

    <section class="borrower-info-panel">
        <div class="panel-heading">
            <div>
                <h2>Borrower Information</h2>
                <p>Personal and institutional details for this borrower.</p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <span>Name</span>
                <strong>{{ $borrower->name }}</strong>
            </div>

            <div class="info-card">
                <span>ID Number</span>
                <strong>{{ $borrower->id_number }}</strong>
            </div>

            <div class="info-card">
                <span>Department</span>
                <strong>{{ $borrower->department ?: '-' }}</strong>
            </div>

            <div class="info-card">
                <span>Semester</span>
                <strong>{{ $borrower->semester ?: '-' }}</strong>
            </div>

            <div class="info-card">
                <span>Contact Number</span>
                <strong>{{ $borrower->contact_number ?: '-' }}</strong>
            </div>

            <div class="info-card">
                <span>Email Address</span>
                <strong>{{ $borrower->email ?: '-' }}</strong>
            </div>
        </div>
    </section>

    <section class="history-panel">
        <div class="panel-heading history-heading">
            <div>
                <h2>Borrowing History</h2>
                <p>{{ $borrower->borrowings->count() }} {{ \Illuminate\Support\Str::plural('record', $borrower->borrowings->count()) }} found</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table borrower-history-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Accession No.</th>
                        <th>Material</th>
                        <th>Date Borrowed</th>
                        <th>Due Date</th>
                        <th>Date Returned</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($borrower->borrowings as $borrowing)
                        <tr>
                            <td class="row-number">{{ $loop->iteration }}</td>

                            <td>
                                <span class="accession-chip">{{ $borrowing->accession_number }}</span>
                            </td>

                            <td class="material-cell">
                                <strong>{{ $borrowing->bibliographical_description }}</strong>
                            </td>

                            <td>{{ optional($borrowing->date_borrowed)->format('M d, Y') ?: '-' }}</td>
                            <td>{{ optional($borrowing->due_date)->format('M d, Y') ?: '-' }}</td>
                            <td>{{ optional($borrowing->date_returned)->format('M d, Y') ?: '-' }}</td>

                            <td>
                                <span class="status-badge status-{{ $borrowing->display_status }}">
                                    {{ ucfirst($borrowing->display_status) }}
                                </span>
                            </td>

                            <td>{{ $borrowing->remarks ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <h3>No borrowing history yet</h3>
                                    <p>This borrower does not have any recorded transactions.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
.borrower-profile-page{
    --navy:#0b315e;
    --yellow:#ffbd00;
    --line:#dfe7ef;
    --muted:#7d8da1;
    padding:28px 34px 40px;
}

.profile-hero{
    min-height:170px;
    margin-bottom:22px;
    padding:32px 36px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:25px;
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

.profile-hero h1{
    margin:0;
    font-size:36px;
    font-weight:800;
    letter-spacing:-.03em;
}

.profile-hero p{
    margin:6px 0 0;
    color:rgba(255,255,255,.84);
    font-size:14px;
}

.hero-actions{
    display:flex;
    align-items:center;
    gap:10px;
    position:relative;
    z-index:1;
}

.hero-btn{
    min-height:48px;
    padding:0 18px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    border-radius:14px;
    font-size:12px;
    font-weight:800;
    text-decoration:none;
    white-space:nowrap;
}

.hero-btn-light{
    color:#0b315e;
    background:#fff;
    border:1px solid rgba(255,255,255,.7);
}

.hero-btn-yellow{
    color:#0b315e;
    background:var(--yellow);
    border:1px solid #e6aa00;
}

.borrower-info-panel,
.history-panel{
    background:#fff;
    border:1px solid var(--line);
    border-radius:24px;
    box-shadow:0 10px 25px rgba(16,48,82,.05);
}

.borrower-info-panel{
    margin-bottom:22px;
    padding-bottom:22px;
}

.panel-heading{
    padding:22px 24px 18px;
}

.panel-heading h2{
    margin:0;
    color:#0b315e;
    font-size:20px;
    font-weight:800;
}

.panel-heading p{
    margin:4px 0 0;
    color:var(--muted);
    font-size:12px;
}

.info-grid{
    padding:0 24px;
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:12px;
}

.info-card{
    min-height:93px;
    padding:16px 18px;
    background:#f7f9fc;
    border:1px solid #dee7f0;
    border-radius:15px;
}

.info-card span{
    display:block;
    margin-bottom:7px;
    color:#75879d;
    font-size:10px;
    font-weight:800;
    letter-spacing:.05em;
    text-transform:uppercase;
}

.info-card strong{
    display:block;
    color:#0b315e;
    font-size:13px;
    font-weight:800;
    overflow-wrap:anywhere;
}

.history-panel{
    overflow:hidden;
}

.history-heading{
    border-bottom:1px solid var(--line);
}

.borrower-history-table{
    min-width:1050px;
}

.borrower-history-table th{
    padding:14px 16px;
    color:#7b8ca2;
    background:#f6f9fc;
    border-bottom:1px solid var(--line);
    font-size:10px;
    font-weight:800;
    letter-spacing:.05em;
    text-transform:uppercase;
    white-space:nowrap;
}

.borrower-history-table td{
    padding:15px 16px;
    color:#5b6d81;
    border-color:#edf1f5;
    font-size:12px;
}

.row-number{
    width:44px;
    color:#95a2b0!important;
}

.material-cell{
    min-width:280px;
    max-width:390px;
}

.material-cell strong{
    color:#0b315e;
    font-weight:800;
}

.accession-chip{
    display:inline-flex;
    align-items:center;
    min-height:35px;
    padding:0 12px;
    color:#0b315e;
    background:#f0f6fc;
    border:1px solid #d8e5f0;
    border-radius:10px;
    font-family:ui-monospace,SFMono-Regular,Consolas,monospace;
    font-size:11px;
    font-weight:800;
}


.status-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:7px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
    white-space:nowrap;
}
.status-badge::before{
    content:"";
    width:7px;
    height:7px;
    border-radius:50%;
    background:currentColor;
}
.status-pending{color:#8b6800;background:#fff5cf}
.status-approved{color:#23639d;background:#eaf4ff}
.status-borrowed{color:#15734e;background:#e7f8ef}
.status-returned{color:#198754;background:#e8f8ef}
.status-overdue{color:#b33845;background:#fff0f1}
.status-rejected{color:#697586;background:#f0f2f5}


.empty-state{
    padding:58px 20px;
    text-align:center;
}

.empty-icon{
    width:58px;
    height:58px;
    margin:0 auto 13px;
    display:grid;
    place-items:center;
    color:#245f94;
    background:#eef5fb;
    border-radius:18px;
    font-size:24px;
}

.empty-state h3{
    margin:0 0 5px;
    color:#0b315e;
    font-size:17px;
    font-weight:800;
}

.empty-state p{
    margin:0;
    color:#8191a3;
    font-size:12px;
}

@media (max-width:991.98px){
    .profile-hero{align-items:flex-start;flex-direction:column}
    .info-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
}

@media (max-width:767.98px){
    .borrower-profile-page{padding:18px 12px 28px}
    .profile-hero{padding:24px 20px;border-radius:18px}
    .hero-left{align-items:flex-start}
    .hero-icon{width:58px;height:58px;flex-basis:58px;border-radius:17px;font-size:24px}
    .profile-hero h1{font-size:27px}
    .hero-actions{width:100%;flex-direction:column}
    .hero-btn{width:100%}
    .borrower-info-panel,.history-panel{border-radius:18px}
    .info-grid{grid-template-columns:1fr;padding:0 18px}
    .panel-heading{padding:20px 18px 16px}
}
</style>
@endpush
