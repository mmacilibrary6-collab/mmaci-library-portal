@extends('layouts.admin')

@section('title', 'Borrowing Management')

@section('content')
<div class="container-fluid borrowing-admin-page">
    <section class="borrow-hero">
        <div class="hero-left">
            <div class="hero-icon"><i class="bi bi-journal-check"></i></div>
            <div>
                <span class="hero-eyebrow">Circulation Management</span>
                <h1>Borrowing Management</h1>
                <p>Manage student and faculty requests, active loans, due dates, returns, and history.</p>
            </div>
        </div>
    </section>

    <div class="borrow-stats">
        @foreach([
            ['label' => 'Currently Borrowed', 'value' => $stats['borrowed'] ?? 0, 'icon' => 'bi-book-half', 'class' => 'blue'],
            ['label' => 'Pending Requests', 'value' => $stats['pending'] ?? 0, 'icon' => 'bi-hourglass-split', 'class' => 'yellow'],
            ['label' => 'Overdue Books', 'value' => $stats['overdue'] ?? 0, 'icon' => 'bi-exclamation-triangle', 'class' => 'red'],
            ['label' => 'Returned Books', 'value' => $stats['returned'] ?? 0, 'icon' => 'bi-check2-circle', 'class' => 'green'],
        ] as $stat)
            <div class="borrow-stat-card">
                <div class="stat-icon {{ $stat['class'] }}"><i class="bi {{ $stat['icon'] }}"></i></div>
                <div>
                    <span>{{ $stat['label'] }}</span>
                    <strong>{{ $stat['value'] }}</strong>
                </div>
            </div>
        @endforeach
    </div>

    <section class="records-panel">
        <div class="records-toolbar">
            <div class="records-title">
                <h2>Borrowing Records</h2>
                <p>{{ $borrowings->total() }} {{ \Illuminate\Support\Str::plural('record', $borrowings->total()) }} found</p>
            </div>

            <form action="{{ route('admin.borrowings.index') }}" method="GET" class="records-filters">
                <div class="search-control">
                    <i class="bi bi-search"></i>
                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search borrower, ID, accession or book...">
                </div>

                <select name="borrower_type" aria-label="Borrower Type">
                    <option value="">All Borrowers</option>
                    <option value="student" @selected(request('borrower_type') === 'student')>Students</option>
                    <option value="faculty" @selected(request('borrower_type') === 'faculty')>Faculty</option>
                </select>

                <select name="status" aria-label="Status">
                    <option value="">All Statuses</option>
                    @foreach(['pending', 'approved', 'borrowed', 'returned', 'overdue', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                <input type="date"
                       name="date_borrowed"
                       value="{{ request('date_borrowed') }}"
                       title="Date Borrowed">

                <input type="date"
                       name="due_date"
                       value="{{ request('due_date') }}"
                       title="Due Date">

                <button class="filter-btn" type="submit">
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

                @if(request()->hasAny(['search', 'borrower_type', 'status', 'date_borrowed', 'due_date']))
                    <a href="{{ route('admin.borrowings.index') }}" class="clear-btn" title="Clear filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive records-table-wrap">
            <table class="table borrow-record-table align-middle mb-0">
                <colgroup>
                    <col class="col-no">
                    <col class="col-borrower">
                    <col class="col-type">
                    <col class="col-dept">
                    <col class="col-accession">
                    <col class="col-material">
                    <col class="col-dates">
                    <col class="col-status">
                    <col class="col-actions">
                </colgroup>

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Borrower</th>
                        <th>Type</th>
                        <th>Department</th>
                        <th>Accession</th>
                        <th>Material</th>
                        <th>Loan Dates</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($borrowings as $borrowing)
                        @php
                            $type = strtolower($borrowing->borrower?->borrower_type ?? '');
                            $typeLabel = in_array($type, ['student', 'faculty'], true) ? ucfirst($type) : 'Not Set';
                        @endphp

                        <tr>
                            <td class="row-number">{{ ($borrowings->firstItem() ?? 1) + $loop->index }}</td>

                            <td>
                                @if($borrowing->borrower)
                                    <a href="{{ route('admin.borrowings.borrower', $borrowing->borrower) }}" class="borrower-link">
                                        {{ $borrowing->borrower->name }}
                                    </a>
                                    <small class="borrower-meta">{{ $borrowing->borrower->id_number }}</small>
                                @else
                                    <span class="text-muted">Unknown Borrower</span>
                                @endif
                            </td>

                            <td>
                                <span class="type-badge type-{{ $type ?: 'unset' }}">{{ $typeLabel }}</span>
                            </td>

                            <td>{{ $borrowing->borrower?->department ?? '-' }}</td>

                            <td><span class="accession-chip">{{ $borrowing->accession_number }}</span></td>

                            <td class="material-cell">
                                <strong>{{ \Illuminate\Support\Str::limit($borrowing->bibliographical_description, 72) }}</strong>
                                @if($borrowing->remarks)
                                    <small>{{ \Illuminate\Support\Str::limit($borrowing->remarks, 54) }}</small>
                                @endif
                            </td>

                            <td class="date-cell">
                                <span><b>Borrowed:</b> {{ optional($borrowing->date_borrowed)->format('M d, Y') ?: '-' }}</span>
                                <span><b>Due:</b> {{ optional($borrowing->due_date)->format('M d, Y') ?: '-' }}</span>
                            </td>

                            <td>
                                <span class="status-badge status-{{ $borrowing->display_status }}">
                                    {{ ucfirst($borrowing->display_status) }}
                                </span>
                            </td>

                            <td class="actions-cell">
                                <div class="table-actions">
                                    <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="action-btn action-view">
                                        <i class="bi bi-eye"></i><span>View</span>
                                    </a>

                                    <a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="action-btn action-edit">
                                        <i class="bi bi-pencil"></i><span>Edit</span>
                                    </a>

                                    @if($borrowing->status === 'pending')
                                        <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn action-approve" type="submit">
                                                <i class="bi bi-check-lg"></i><span>Approve</span>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn action-delete" type="submit">
                                                <i class="bi bi-x-lg"></i><span>Reject</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($borrowing->status, ['pending', 'approved'], true))
                                        <form method="POST" action="{{ route('admin.borrowings.borrowed', $borrowing) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn action-borrowed" type="submit">
                                                <i class="bi bi-bookmark-check"></i><span>Borrow</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                                        <form method="POST" action="{{ route('admin.borrowings.returned', $borrowing) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn action-approve" type="submit">
                                                <i class="bi bi-arrow-return-left"></i><span>Return</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if($borrowing->borrower)
                                        <a href="{{ route('admin.borrowings.print-card', $borrowing->borrower) }}"
                                           target="_blank"
                                           class="action-btn action-print">
                                            <i class="bi bi-printer"></i><span>Print</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-journal-x"></i></div>
                                    <h3>No borrowing records found</h3>
                                    <p>Try changing the filters or wait for a new borrowing request.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($borrowings->hasPages())
            <div class="panel-footer">
                <span>
                    Showing {{ $borrowings->firstItem() }}–{{ $borrowings->lastItem() }}
                    of {{ $borrowings->total() }}
                </span>
                {{ $borrowings->links() }}
            </div>
        @endif
    </section>
</div>
@endsection

@push('styles')
<style>
.borrowing-admin-page{
    --navy:#0d396b;--navy-dark:#072d59;--blue:#174c7f;--yellow:#ffbd00;
    --line:#dfe7ef;--soft:#f5f8fb;--text:#0b2f5b;--muted:#7789a0;
    width:100%;max-width:100%;padding:28px 30px 40px;overflow-x:hidden;
}
.borrow-hero{
    min-height:172px;margin-bottom:22px;padding:34px 36px;display:flex;align-items:center;
    position:relative;overflow:hidden;color:#fff;
    background:
        radial-gradient(circle at 82% 78%,rgba(255,255,255,.08) 0 72px,transparent 73px),
        radial-gradient(circle at 82% 78%,rgba(255,255,255,.06) 0 112px,transparent 113px),
        linear-gradient(115deg,#0d3b72 0%,#174d7d 65%,#365f7b 100%);
    border-radius:24px;box-shadow:0 14px 35px rgba(17,54,91,.12);
}
.hero-left{display:flex;align-items:center;gap:22px;position:relative;z-index:1}
.hero-icon{
    width:72px;height:72px;flex:0 0 72px;display:grid;place-items:center;color:#0b2f5b;
    background:var(--yellow);border-radius:22px;font-size:30px;
}
.hero-eyebrow{
    display:block;margin-bottom:5px;color:#ffd54d;font-size:12px;font-weight:800;
    letter-spacing:.08em;text-transform:uppercase;
}
.borrow-hero h1{margin:0;font-size:37px;font-weight:800;letter-spacing:-.03em}
.borrow-hero p{margin:6px 0 0;color:rgba(255,255,255,.86);font-size:14px}
.borrow-stats{
    display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:15px;margin-bottom:22px;
}
.borrow-stat-card{
    min-height:105px;padding:18px 20px;display:flex;align-items:center;gap:15px;
    background:#fff;border:1px solid var(--line);border-radius:18px;
    box-shadow:0 8px 22px rgba(17,54,91,.05);
}
.stat-icon{
    width:48px;height:48px;flex:0 0 48px;display:grid;place-items:center;
    border-radius:14px;font-size:20px;
}
.stat-icon.blue{color:#0d4c88;background:#eaf4ff}
.stat-icon.yellow{color:#8c6500;background:#fff5d6}
.stat-icon.red{color:#b23d47;background:#fff0f1}
.stat-icon.green{color:#18754e;background:#e9f8f0}
.borrow-stat-card span{display:block;margin-bottom:3px;color:#7d8da1;font-size:11px;font-weight:700}
.borrow-stat-card strong{display:block;color:#0b2f5b;font-size:28px;line-height:1;font-weight:800}
.records-panel{
    width:100%;overflow:hidden;background:#fff;border:1px solid var(--line);
    border-radius:24px;box-shadow:0 10px 25px rgba(16,48,82,.05);
}
.records-toolbar{padding:22px 24px;border-bottom:1px solid var(--line)}
.records-title{margin-bottom:16px}
.records-title h2{margin:0;color:#0b2f5b;font-size:20px;font-weight:800}
.records-title p{margin:3px 0 0;color:#7d8da1;font-size:12px}
.records-filters{
    width:100%;display:grid;
    grid-template-columns:minmax(240px,1.35fr) minmax(120px,.55fr) minmax(120px,.55fr) 150px 150px auto auto;
    gap:9px;align-items:center;
}
.search-control{position:relative;min-width:0}
.search-control i{
    position:absolute;top:50%;left:14px;color:#92a0b0;transform:translateY(-50%);
}
.search-control input,.records-filters select,.records-filters input[type="date"]{
    width:100%;height:44px;border:1px solid #dbe4ed;border-radius:12px;background:#fff;
    color:#43566d;font-size:12px;outline:none;min-width:0;
}
.search-control input{padding:0 13px 0 40px}
.records-filters select,.records-filters input[type="date"]{padding:0 11px}
.search-control input:focus,.records-filters select:focus,.records-filters input[type="date"]:focus{
    border-color:#8eaaca;box-shadow:0 0 0 3px rgba(24,75,140,.08);
}
.filter-btn,.clear-btn{
    height:44px;display:inline-flex;align-items:center;justify-content:center;border-radius:12px;
    font-size:12px;font-weight:800;text-decoration:none;white-space:nowrap;
}
.filter-btn{gap:7px;padding:0 17px;color:#fff;background:#0b315e;border:1px solid #0b315e}
.clear-btn{width:44px;color:#60748a;background:#fff;border:1px solid #dbe4ed}
.records-table-wrap{width:100%;overflow-x:auto}
.borrow-record-table{width:100%;table-layout:fixed;margin:0!important}
.col-no{width:36px}
.col-borrower{width:150px}
.col-type{width:90px}
.col-dept{width:90px}
.col-accession{width:95px}
.col-material{width:auto}
.col-dates{width:145px}
.col-status{width:95px}
.col-actions{width:285px}
.borrow-record-table thead th{
    padding:13px 10px;color:#7b8ca2;background:#f6f9fc;border-bottom:1px solid var(--line);
    font-size:9px;font-weight:800;letter-spacing:.045em;text-transform:uppercase;white-space:nowrap;
}
.borrow-record-table tbody td{
    padding:13px 10px;color:#5a6d82;border-color:#edf1f5;font-size:11px;vertical-align:middle;
}
.borrow-record-table tbody tr:hover{background:#fbfdff}
.row-number{color:#94a1b0!important}
.borrower-link{display:block;color:#0b315e;font-weight:800;text-decoration:none;line-height:1.2}
.borrower-link:hover{text-decoration:underline}
.borrower-meta{display:block;margin-top:4px;color:#8797aa;font-size:9.5px}
.type-badge{
    display:inline-flex;align-items:center;justify-content:center;padding:6px 8px;border-radius:999px;
    font-size:9px;font-weight:800;text-transform:uppercase;white-space:nowrap;
}
.type-student{color:#175a91;background:#e6f2ff}
.type-faculty{color:#7d5c00;background:#fff2c5}
.type-unset{color:#65717f;background:#eef1f4}
.accession-chip{
    display:inline-flex;align-items:center;min-height:32px;padding:0 9px;color:#0b315e;
    background:#f0f6fc;border:1px solid #d8e5f0;border-radius:9px;
    font-family:ui-monospace,SFMono-Regular,Consolas,monospace;font-size:10px;font-weight:800;
}
.material-cell{min-width:0}
.material-cell strong{
    display:block;color:#0b315e;font-size:11px;font-weight:800;line-height:1.3;overflow-wrap:anywhere;
}
.material-cell small{display:block;margin-top:3px;color:#8b9bad;font-size:9px;line-height:1.25}
.date-cell span{display:block;line-height:1.45;white-space:nowrap}
.date-cell b{color:#6d7f93;font-size:9px}
.status-badge{
    display:inline-flex;align-items:center;gap:5px;padding:6px 9px;border-radius:999px;
    font-size:9.5px;font-weight:700;white-space:nowrap;
}
.status-badge::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
.status-pending{color:#8b6800;background:#fff5cf}
.status-approved{color:#23639d;background:#eaf4ff}
.status-borrowed{color:#15734e;background:#e7f8ef}
.status-returned{color:#198754;background:#e8f8ef}
.status-overdue{color:#b33845;background:#fff0f1}
.status-rejected{color:#697586;background:#f0f2f5}
.actions-cell{padding-right:12px!important}
.table-actions{
    display:flex;justify-content:flex-end;align-items:center;gap:5px;flex-wrap:wrap;
}
.table-actions form{margin:0}
.action-btn{
    min-height:32px;padding:0 8px;display:inline-flex;align-items:center;justify-content:center;
    gap:4px;border-radius:9px;font-size:9px;font-weight:800;line-height:1;text-decoration:none;
    white-space:nowrap;transition:.15s ease;
}
.action-btn i{font-size:10px}
.action-btn:hover{transform:translateY(-1px)}
.action-view,.action-edit{color:#205d91;background:#f1f7fc;border:1px solid #d6e5f1}
.action-approve{color:#15734e;background:#eef9f3;border:1px solid #d2ecdf}
.action-borrowed,.action-print{color:#815f00;background:#fff8df;border:1px solid #f0dfa3}
.action-delete{color:#bc4650;background:#fff5f5;border:1px solid #f1d0d3}
.empty-state{padding:62px 20px;text-align:center}
.empty-icon{
    width:58px;height:58px;margin:0 auto 13px;display:grid;place-items:center;color:#245f94;
    background:#eef5fb;border-radius:18px;font-size:24px;
}
.empty-state h3{margin:0 0 5px;color:#0b315e;font-size:17px;font-weight:800}
.empty-state p{margin:0;color:#8191a3;font-size:12px}
.panel-footer{
    padding:15px 22px;display:flex;align-items:center;justify-content:space-between;gap:18px;
    color:#7e8fa2;background:#fbfcfe;border-top:1px solid var(--line);font-size:12px;
}
@media (max-width:1399.98px){
    .borrowing-admin-page{padding-left:22px;padding-right:22px}
    .records-filters{
        grid-template-columns:minmax(220px,1fr) 120px 120px 145px 145px auto auto;
    }
    .col-actions{width:260px}
    .action-btn{padding:0 7px;font-size:8.5px}
}
@media (max-width:1199.98px){
    .borrow-stats{grid-template-columns:repeat(2,minmax(0,1fr))}
    .records-filters{grid-template-columns:repeat(3,minmax(0,1fr))}
    .search-control{grid-column:span 3}
    .filter-btn{width:100%}
    .records-table-wrap{overflow-x:auto}
    .borrow-record-table{min-width:1120px}
}
@media (max-width:767.98px){
    .borrowing-admin-page{padding:18px 12px 28px}
    .borrow-hero{min-height:auto;padding:25px 20px;border-radius:18px}
    .hero-left{align-items:flex-start}
    .hero-icon{width:58px;height:58px;flex-basis:58px;border-radius:17px;font-size:24px}
    .borrow-hero h1{font-size:27px}
    .borrow-stats{grid-template-columns:1fr}
    .records-panel{border-radius:18px}
    .records-filters{grid-template-columns:1fr}
    .search-control{grid-column:auto}
    .clear-btn{width:44px}
    .panel-footer{align-items:flex-start;flex-direction:column}
}
</style>
@endpush
