@extends('layouts.admin')

@section('title', 'Borrowing Management')

@section('content')
<div class="container-fluid borrowing-admin-page">
    <section class="borrow-admin-hero">
        <div class="hero-copy">
            <span class="hero-icon"><i class="bi bi-journal-check"></i></span>
            <div>
                <span class="hero-eyebrow">Circulation Management</span>
                <h2>Borrowing Management</h2>
                <p>Review borrowing requests, due dates, returns, and borrower card history.</p>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-4">
        @foreach([
            ['label' => 'Currently Borrowed', 'value' => $stats['borrowed'] ?? 0, 'icon' => 'bi-book-half'],
            ['label' => 'Pending Requests', 'value' => $stats['pending'] ?? 0, 'icon' => 'bi-hourglass-split'],
            ['label' => 'Overdue Books', 'value' => $stats['overdue'] ?? 0, 'icon' => 'bi-exclamation-triangle'],
            ['label' => 'Returned Books', 'value' => $stats['returned'] ?? 0, 'icon' => 'bi-check2-circle'],
        ] as $stat)
            <div class="col-xl-3 col-md-6">
                <div class="borrow-stat-card">
                    <span><i class="bi {{ $stat['icon'] }}"></i></span>
                    <div>
                        <small>{{ $stat['label'] }}</small>
                        <strong>{{ $stat['value'] }}</strong>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <section class="borrow-panel">
        <div class="panel-toolbar">
            <div>
                <h5>Borrowing Records</h5>
                <p>{{ $borrowings->total() }} {{ \Illuminate\Support\Str::plural('record', $borrowings->total()) }} found</p>
            </div>

            <form action="{{ route('admin.borrowings.index') }}" method="GET" class="filter-form">
                <div class="search-field">
                    <i class="bi bi-search"></i>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search borrower, ID, accession or book...">
                </div>

                <select name="status" aria-label="Status">
                    <option value="">All statuses</option>
                    @foreach(['pending', 'approved', 'borrowed', 'returned', 'overdue', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>

                <input type="date" name="date_borrowed" value="{{ request('date_borrowed') }}" aria-label="Date borrowed">
                <input type="date" name="due_date" value="{{ request('due_date') }}" aria-label="Due date">

                <button type="submit" class="filter-button"><i class="bi bi-funnel"></i> Filter</button>

                @if(request()->hasAny(['search', 'status', 'date_borrowed', 'due_date']))
                    <a href="{{ route('admin.borrowings.index') }}" class="reset-button" aria-label="Clear filters"><i class="bi bi-x-lg"></i></a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table borrow-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Borrower</th>
                        <th>ID Number</th>
                        <th>Department</th>
                        <th>Accession</th>
                        <th>Book</th>
                        <th>Date Borrowed</th>
                        <th>Due Date</th>
                        <th>Date Returned</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                        <tr>
                            <td>
                                <a href="{{ route('admin.borrowings.borrower', $borrowing->borrower) }}" class="borrower-link">
                                    {{ $borrowing->borrower?->name ?? 'Unknown borrower' }}
                                </a>
                            </td>
                            <td>{{ $borrowing->borrower?->id_number ?? '-' }}</td>
                            <td>{{ $borrowing->borrower?->department ?? '-' }}</td>
                            <td><span class="accession-pill">{{ $borrowing->accession_number }}</span></td>
                            <td class="book-cell">{{ \Illuminate\Support\Str::limit($borrowing->bibliographical_description, 65) }}</td>
                            <td>{{ optional($borrowing->date_borrowed)->format('M d, Y') }}</td>
                            <td>{{ optional($borrowing->due_date)->format('M d, Y') }}</td>
                            <td>{{ optional($borrowing->date_returned)->format('M d, Y') ?? '-' }}</td>
                            <td><span class="status-pill status-{{ $borrowing->display_status }}">{{ ucfirst($borrowing->display_status) }}</span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="action-button view" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="action-button edit" title="Edit"><i class="bi bi-pencil"></i></a>

                                    @if($borrowing->status === 'pending')
                                        <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">@csrf @method('PATCH')<button class="action-button approve" title="Approve"><i class="bi bi-check-lg"></i></button></form>
                                        <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}">@csrf @method('PATCH')<button class="action-button reject" title="Reject"><i class="bi bi-x-lg"></i></button></form>
                                    @endif

                                    @if(in_array($borrowing->status, ['pending', 'approved'], true))
                                        <form method="POST" action="{{ route('admin.borrowings.borrowed', $borrowing) }}">@csrf @method('PATCH')<button class="action-button borrowed" title="Mark as borrowed"><i class="bi bi-bookmark-check"></i></button></form>
                                    @endif

                                    @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                                        <form method="POST" action="{{ route('admin.borrowings.returned', $borrowing) }}">@csrf @method('PATCH')<button class="action-button returned" title="Mark as returned"><i class="bi bi-arrow-return-left"></i></button></form>
                                    @endif

                                    <a href="{{ route('admin.borrowings.print-card', $borrowing->borrower) }}" target="_blank" class="action-button print" title="Print card"><i class="bi bi-printer"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="borrow-empty">
                                    <i class="bi bi-journal-x"></i>
                                    <h5>No borrowing records found</h5>
                                    <p>Borrowing requests will appear here after users submit the public form.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($borrowings->hasPages())
            <div class="panel-footer">
                <p>Showing {{ $borrowings->firstItem() }}-{{ $borrowings->lastItem() }} of {{ $borrowings->total() }}</p>
                {{ $borrowings->links() }}
            </div>
        @endif
    </section>
</div>
@endsection

@push('styles')
<style>
.borrowing-admin-page { --navy:#0b2e59; --blue:#184b8c; --gold:#f4b400; --line:#e2e9f2; --muted:#718096; padding:24px; }
.borrow-admin-hero { min-height:150px; margin-bottom:22px; padding:28px 30px; display:flex; align-items:center; color:#fff; background:radial-gradient(circle at 90% 10%,rgba(244,180,0,.2),transparent 28%),linear-gradient(125deg,var(--navy),var(--blue)); border-radius:22px; box-shadow:0 16px 36px rgba(11,46,89,.16); overflow:hidden; }
.hero-copy { display:flex; align-items:center; gap:18px; }
.hero-icon { width:62px; height:62px; display:grid; place-items:center; color:var(--navy); background:var(--gold); border-radius:18px; font-size:27px; }
.hero-eyebrow { display:block; color:#ffd96d; font-size:10px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
.borrow-admin-hero h2 { margin:4px 0; font-size:clamp(24px,3vw,34px); font-weight:800; }
.borrow-admin-hero p { margin:0; color:rgba(255,255,255,.75); font-size:13px; }
.borrow-stat-card { min-height:112px; display:flex; align-items:center; gap:16px; padding:22px; background:#fff; border:1px solid var(--line); border-left:4px solid var(--gold); border-radius:18px; box-shadow:0 12px 30px rgba(11,46,89,.07); }
.borrow-stat-card span { width:52px; height:52px; display:grid; place-items:center; color:#fff; background:var(--navy); border-radius:14px; font-size:20px; }
.borrow-stat-card small, .borrow-stat-card strong { display:block; }
.borrow-stat-card small { color:var(--muted); font-weight:700; }
.borrow-stat-card strong { color:var(--navy); font-size:30px; line-height:1; }
.borrow-panel { overflow:hidden; background:#fff; border:1px solid var(--line); border-radius:20px; box-shadow:0 12px 30px rgba(25,50,80,.07); }
.panel-toolbar { padding:20px 22px; display:flex; align-items:center; justify-content:space-between; gap:20px; border-bottom:1px solid var(--line); }
.panel-toolbar h5 { margin:0 0 3px; color:var(--navy); font-weight:800; }
.panel-toolbar p { margin:0; color:var(--muted); font-size:12px; }
.filter-form { flex:1; display:flex; justify-content:flex-end; gap:8px; flex-wrap:wrap; }
.search-field { position:relative; width:min(100%,360px); }
.search-field i { position:absolute; left:14px; top:50%; color:#93a1b2; transform:translateY(-50%); }
.search-field input, .filter-form select, .filter-form input[type=date] { height:42px; border:1px solid var(--line); border-radius:11px; padding:0 13px; font-size:12px; outline:0; }
.search-field input { width:100%; padding-left:40px; }
.filter-button, .reset-button { height:42px; display:inline-flex; align-items:center; justify-content:center; border-radius:11px; text-decoration:none; font-size:12px; font-weight:800; }
.filter-button { gap:7px; padding:0 15px; color:#fff; background:var(--navy); border:0; }
.reset-button { width:42px; color:#667; background:#fff; border:1px solid var(--line); }
.borrow-table { min-width:1220px; }
.borrow-table th { padding:14px 16px; color:#728096; background:#f8fafc; border-bottom:1px solid var(--line); font-size:10px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; white-space:nowrap; }
.borrow-table td { padding:15px 16px; border-color:#edf1f5; color:#26384d; font-size:12px; }
.borrower-link { color:var(--navy); font-weight:800; }
.accession-pill, .status-pill { display:inline-flex; align-items:center; border-radius:999px; font-size:10px; font-weight:800; white-space:nowrap; }
.accession-pill { padding:6px 9px; color:var(--navy); background:#edf4fb; border:1px solid #d8e4f2; font-family:ui-monospace,SFMono-Regular,Consolas,monospace; }
.status-pill { padding:7px 10px; }
.status-pending { color:#7a5a00; background:#fff4ce; }
.status-approved { color:#164b87; background:#e7f1ff; }
.status-borrowed { color:#12614a; background:#e4f7ef; }
.status-returned { color:#276749; background:#eaf8f0; }
.status-overdue { color:#9b2c2c; background:#fff0f0; }
.status-rejected { color:#6b7280; background:#f1f3f5; }
.book-cell { max-width:260px; }
.table-actions { display:flex; justify-content:flex-end; gap:6px; }
.table-actions form { margin:0; }
.action-button { width:34px; height:34px; padding:0; display:grid; place-items:center; border:1px solid #d8e4f2; border-radius:9px; background:#f5f9fd; color:var(--blue); text-decoration:none; }
.action-button.approve, .action-button.returned { color:#157347; background:#eaf8f0; border-color:#cdebdc; }
.action-button.reject { color:#b02a37; background:#fff4f4; border-color:#f1c9ce; }
.action-button.borrowed, .action-button.print { color:#7a5a00; background:#fff5d8; border-color:#f3df9e; }
.borrow-empty { padding:58px 20px; color:var(--muted); text-align:center; }
.borrow-empty i { color:var(--blue); font-size:34px; }
.borrow-empty h5 { margin:12px 0 4px; color:var(--navy); font-weight:800; }
.panel-footer { padding:14px 20px; display:flex; align-items:center; justify-content:space-between; gap:20px; background:#fbfcfd; border-top:1px solid var(--line); }
.panel-footer p { margin:0; color:var(--muted); font-size:12px; }
@media (max-width:991.98px){ .panel-toolbar{align-items:flex-start; flex-direction:column;} .filter-form{width:100%; justify-content:flex-start;} .search-field{width:100%;} }
@media (max-width:767.98px){ .borrowing-admin-page{padding:16px 10px;} .borrow-admin-hero{padding:24px 20px;} .hero-copy{align-items:flex-start;} .panel-footer{align-items:flex-start; flex-direction:column;} .filter-form>*{width:100%;} .reset-button{width:42px;} }
</style>
@endpush
