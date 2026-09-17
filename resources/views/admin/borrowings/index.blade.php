@extends('layouts.admin')

@section('title', 'Borrowing Management')

@section('content')
<div class="container-fluid borrowing-admin-page">

    <section class="borrow-hero">
        <div class="hero-left">
            <div class="hero-icon">
                <i class="bi bi-journal-check"></i>
            </div>

            <div>
                <span class="hero-eyebrow">Circulation Management</span>
                <h1>Borrowing Management</h1>
                <p>Manage borrower requests, active loans, due dates, returns, and history.</p>
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
                <div class="stat-icon {{ $stat['class'] }}">
                    <i class="bi {{ $stat['icon'] }}"></i>
                </div>

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
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search borrower, ID, accession or book...">
                </div>

                <select name="status" aria-label="Status">
                    <option value="">All Statuses</option>
                    @foreach(['pending', 'approved', 'borrowed', 'returned', 'overdue', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>

                <input
                    type="date"
                    name="date_borrowed"
                    value="{{ request('date_borrowed') }}"
                    title="Date Borrowed">

                <input
                    type="date"
                    name="due_date"
                    value="{{ request('due_date') }}"
                    title="Due Date">

                <button class="filter-btn" type="submit">
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

                @if(request()->hasAny(['search', 'status', 'date_borrowed', 'due_date']))
                    <a href="{{ route('admin.borrowings.index') }}" class="clear-btn" title="Clear filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table borrow-record-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Borrower</th>
                        <th>ID Number</th>
                        <th>Department</th>
                        <th>Accession No.</th>
                        <th>Material</th>
                        <th>Date Borrowed</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($borrowings as $borrowing)
                        <tr>
                            <td class="row-number">
                                {{ ($borrowings->firstItem() ?? 1) + $loop->index }}
                            </td>

                            <td>
                                @if($borrowing->borrower)
                                    <a
                                        href="{{ route('admin.borrowings.borrower', $borrowing->borrower) }}"
                                        class="borrower-link">
                                        {{ $borrowing->borrower->name }}
                                    </a>
                                @else
                                    <span class="text-muted">Unknown Borrower</span>
                                @endif
                            </td>

                            <td>{{ $borrowing->borrower?->id_number ?? '-' }}</td>
                            <td>{{ $borrowing->borrower?->department ?? '-' }}</td>

                            <td>
                                <span class="accession-chip">
                                    {{ $borrowing->accession_number }}
                                </span>
                            </td>

                            <td class="material-cell">
                                <strong>{{ \Illuminate\Support\Str::limit($borrowing->bibliographical_description, 55) }}</strong>
                                @if($borrowing->remarks)
                                    <small>{{ \Illuminate\Support\Str::limit($borrowing->remarks, 55) }}</small>
                                @endif
                            </td>

                            <td>{{ optional($borrowing->date_borrowed)->format('M d, Y') ?: '-' }}</td>
                            <td>{{ optional($borrowing->due_date)->format('M d, Y') ?: '-' }}</td>

                            <td>
                                <span class="status-badge status-{{ $borrowing->display_status }}">
                                    {{ ucfirst($borrowing->display_status) }}
                                </span>
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a
                                        href="{{ route('admin.borrowings.show', $borrowing) }}"
                                        class="action-btn action-view">
                                        <i class="bi bi-eye"></i>
                                        <span>View</span>
                                    </a>

                                    <a
                                        href="{{ route('admin.borrowings.edit', $borrowing) }}"
                                        class="action-btn action-edit">
                                        <i class="bi bi-pencil"></i>
                                        <span>Edit</span>
                                    </a>

                                    @if($borrowing->status === 'pending')
                                        <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn action-approve" type="submit">
                                                <i class="bi bi-check-lg"></i>
                                                <span>Approve</span>
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn action-delete" type="submit">
                                                <i class="bi bi-x-lg"></i>
                                                <span>Reject</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($borrowing->status, ['pending', 'approved'], true))
                                        <form method="POST" action="{{ route('admin.borrowings.borrowed', $borrowing) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn action-borrowed" type="submit">
                                                <i class="bi bi-bookmark-check"></i>
                                                <span>Borrow</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                                        <form method="POST" action="{{ route('admin.borrowings.returned', $borrowing) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="action-btn action-approve" type="submit">
                                                <i class="bi bi-arrow-return-left"></i>
                                                <span>Return</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if($borrowing->borrower)
                                        <a
                                            href="{{ route('admin.borrowings.print-card', $borrowing->borrower) }}"
                                            target="_blank"
                                            class="action-btn action-print">
                                            <i class="bi bi-printer"></i>
                                            <span>Print</span>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-journal-x"></i>
                                    </div>
                                    <h3>No borrowing records found</h3>
                                    <p>Borrowing requests will appear here once records are submitted.</p>
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
    --navy:#0d396b;
    --navy-dark:#072d59;
    --blue:#174c7f;
    --yellow:#ffbd00;
    --line:#dfe7ef;
    --soft:#f5f8fb;
    --text:#0b2f5b;
    --muted:#7789a0;
    padding:28px 34px 40px;
}

.borrow-hero{
    min-height:172px;
    margin-bottom:22px;
    padding:34px 36px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    position:relative;
    overflow:hidden;
    color:#fff;
    background:
        radial-gradient(circle at 82% 78%,rgba(255,255,255,.08) 0 72px,transparent 73px),
        radial-gradient(circle at 82% 78%,rgba(255,255,255,.06) 0 112px,transparent 113px),
        linear-gradient(115deg,#0d3b72 0%,#174d7d 65%,#365f7b 100%);
    border-radius:24px;
    box-shadow:0 14px 35px rgba(17,54,91,.12);
}

.hero-left{
    display:flex;
    align-items:center;
    gap:22px;
    position:relative;
    z-index:1;
}

.hero-icon{
    width:72px;
    height:72px;
    flex:0 0 72px;
    display:grid;
    place-items:center;
    color:#0b2f5b;
    background:var(--yellow);
    border-radius:22px;
    font-size:30px;
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

.borrow-hero h1{
    margin:0;
    font-size:37px;
    font-weight:800;
    letter-spacing:-.03em;
}

.borrow-hero p{
    margin:6px 0 0;
    color:rgba(255,255,255,.86);
    font-size:14px;
}

.borrow-stats{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:15px;
    margin-bottom:22px;
}

.borrow-stat-card{
    min-height:105px;
    padding:18px 20px;
    display:flex;
    align-items:center;
    gap:15px;
    background:#fff;
    border:1px solid var(--line);
    border-radius:18px;
    box-shadow:0 8px 22px rgba(17,54,91,.05);
}

.stat-icon{
    width:48px;
    height:48px;
    flex:0 0 48px;
    display:grid;
    place-items:center;
    border-radius:14px;
    font-size:20px;
}

.stat-icon.blue{color:#0d4c88;background:#eaf4ff}
.stat-icon.yellow{color:#8c6500;background:#fff5d6}
.stat-icon.red{color:#b23d47;background:#fff0f1}
.stat-icon.green{color:#18754e;background:#e9f8f0}

.borrow-stat-card span{
    display:block;
    margin-bottom:3px;
    color:#7d8da1;
    font-size:11px;
    font-weight:700;
}

.borrow-stat-card strong{
    display:block;
    color:#0b2f5b;
    font-size:28px;
    line-height:1;
    font-weight:800;
}

.records-panel{
    overflow:hidden;
    background:#fff;
    border:1px solid var(--line);
    border-radius:24px;
    box-shadow:0 10px 25px rgba(16,48,82,.05);
}

.records-toolbar{
    padding:22px 24px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    border-bottom:1px solid var(--line);
}

.records-title h2{
    margin:0;
    color:#0b2f5b;
    font-size:20px;
    font-weight:800;
}

.records-title p{
    margin:3px 0 0;
    color:#7d8da1;
    font-size:12px;
}

.records-filters{
    flex:1;
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:9px;
    flex-wrap:wrap;
}

.search-control{
    position:relative;
    width:min(380px,100%);
}

.search-control i{
    position:absolute;
    top:50%;
    left:14px;
    color:#92a0b0;
    transform:translateY(-50%);
}

.search-control input,
.records-filters select,
.records-filters input[type="date"]{
    height:46px;
    border:1px solid #dbe4ed;
    border-radius:13px;
    background:#fff;
    color:#43566d;
    font-size:12px;
    outline:none;
}

.search-control input{
    width:100%;
    padding:0 14px 0 42px;
}

.records-filters select,
.records-filters input[type="date"]{
    padding:0 13px;
}

.search-control input:focus,
.records-filters select:focus,
.records-filters input[type="date"]:focus{
    border-color:#8eaaca;
    box-shadow:0 0 0 3px rgba(24,75,140,.08);
}

.filter-btn,
.clear-btn{
    height:46px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:13px;
    font-size:12px;
    font-weight:800;
    text-decoration:none;
}

.filter-btn{
    gap:7px;
    padding:0 18px;
    color:#fff;
    background:#0b315e;
    border:1px solid #0b315e;
}

.clear-btn{
    width:46px;
    color:#60748a;
    background:#fff;
    border:1px solid #dbe4ed;
}

.borrow-record-table{
    min-width:1480px;
}

.borrow-record-table thead th{
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

.borrow-record-table tbody td{
    padding:15px 16px;
    color:#5a6d82;
    border-color:#edf1f5;
    font-size:12px;
    vertical-align:middle;
}

.borrow-record-table tbody tr:hover{
    background:#fbfdff;
}

.row-number{
    width:44px;
    color:#94a1b0!important;
}

.borrower-link{
    color:#0b315e;
    font-weight:800;
    text-decoration:none;
}

.borrower-link:hover{
    text-decoration:underline;
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

.material-cell{
    min-width:260px;
    max-width:330px;
}

.material-cell strong{
    display:block;
    color:#0b315e;
    font-size:12px;
    font-weight:800;
}

.material-cell small{
    display:block;
    margin-top:3px;
    color:#8b9bad;
    font-size:10px;
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


.table-actions{
    display:flex;
    justify-content:flex-end;
    align-items:center;
    gap:6px;
    white-space:nowrap;
}

.table-actions form{
    margin:0;
}

.action-btn{
    min-height:36px;
    padding:0 11px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    border-radius:10px;
    font-size:10px;
    font-weight:800;
    line-height:1;
    text-decoration:none;
    white-space:nowrap;
    transition:.15s ease;
}

.action-btn i{
    font-size:12px;
}

.action-btn:hover{
    transform:translateY(-1px);
}

.action-view,
.action-edit{
    color:#205d91;
    background:#f1f7fc;
    border:1px solid #d6e5f1;
}

.action-approve{
    color:#15734e;
    background:#eef9f3;
    border:1px solid #d2ecdf;
}

.action-borrowed,
.action-print{
    color:#815f00;
    background:#fff8df;
    border:1px solid #f0dfa3;
}

.action-delete{
    color:#bc4650;
    background:#fff5f5;
    border:1px solid #f1d0d3;
}

.empty-state{
    padding:62px 20px;
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

.panel-footer{
    padding:15px 22px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:18px;
    color:#7e8fa2;
    background:#fbfcfe;
    border-top:1px solid var(--line);
    font-size:12px;
}

@media (max-width:1199.98px){
    .borrow-stats{grid-template-columns:repeat(2,minmax(0,1fr))}
    .records-toolbar{align-items:flex-start;flex-direction:column}
    .records-filters{width:100%;justify-content:flex-start}
}

@media (max-width:767.98px){
    .borrowing-admin-page{padding:18px 12px 28px}
    .borrow-hero{min-height:auto;padding:25px 20px;border-radius:18px}
    .hero-left{align-items:flex-start}
    .hero-icon{width:58px;height:58px;flex-basis:58px;border-radius:17px;font-size:24px}
    .borrow-hero h1{font-size:27px}
    .borrow-stats{grid-template-columns:1fr}
    .records-panel{border-radius:18px}
    .records-filters>*{width:100%}
    .search-control{width:100%}
    .clear-btn{width:46px}
    .panel-footer{align-items:flex-start;flex-direction:column}
}
</style>
@endpush
