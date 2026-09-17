@extends('layouts.admin')

@section('title', 'Borrower Profile')

@section('content')
<div class="container-fluid borrower-profile-page">
    <div class="profile-header">
        <div>
            <span>Borrower Profile</span>
            <h1>{{ $borrower->name }}</h1>
            <p>{{ $borrower->id_number }} · {{ $borrower->department }}</p>
        </div>
        <div class="profile-actions">
            <a href="{{ route('admin.borrowings.index') }}" class="btn btn-light"><i class="bi bi-arrow-left"></i> Back</a>
            <a href="{{ route('admin.borrowings.print-card', $borrower) }}" target="_blank" class="btn btn-warning"><i class="bi bi-printer"></i> Print Borrower Card</a>
        </div>
    </div>

    <div class="profile-card mb-4">
        <h2>Borrower Information</h2>
        <div class="info-grid">
            <div><small>Name</small><strong>{{ $borrower->name }}</strong></div>
            <div><small>ID Number</small><strong>{{ $borrower->id_number }}</strong></div>
            <div><small>Contact Number</small><strong>{{ $borrower->contact_number ?: '-' }}</strong></div>
            <div><small>Department</small><strong>{{ $borrower->department }}</strong></div>
            <div><small>Semester</small><strong>{{ $borrower->semester ?: '-' }}</strong></div>
            <div><small>Email Address</small><strong>{{ $borrower->email ?: '-' }}</strong></div>
        </div>
    </div>

    <div class="profile-card">
        <h2>Borrowing History</h2>
        <div class="table-responsive">
            <table class="table align-middle mb-0 borrower-history-table">
                <thead>
                    <tr>
                        <th>Accession Number</th>
                        <th>Book</th>
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
                            <td><span class="accession-pill">{{ $borrowing->accession_number }}</span></td>
                            <td>{{ $borrowing->bibliographical_description }}</td>
                            <td>{{ optional($borrowing->date_borrowed)->format('M d, Y') }}</td>
                            <td>{{ optional($borrowing->due_date)->format('M d, Y') }}</td>
                            <td>{{ optional($borrowing->date_returned)->format('M d, Y') ?? '-' }}</td>
                            <td><span class="status-pill status-{{ $borrowing->display_status }}">{{ ucfirst($borrowing->display_status) }}</span></td>
                            <td>{{ $borrowing->remarks ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-5">No borrowing history yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.borrower-profile-page { padding:24px; }
.profile-header { margin-bottom:22px; padding:28px; display:flex; align-items:center; justify-content:space-between; gap:20px; color:#fff; background:linear-gradient(125deg,#0b2e59,#184b8c); border-radius:22px; }
.profile-header span { color:#ffd96d; font-size:11px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
.profile-header h1 { margin:5px 0; font-weight:800; }
.profile-header p { margin:0; color:rgba(255,255,255,.75); }
.profile-actions { display:flex; flex-wrap:wrap; gap:9px; }
.profile-card { padding:24px; background:#fff; border:1px solid #e2e9f2; border-radius:18px; box-shadow:0 12px 30px rgba(11,46,89,.07); }
.profile-card h2 { margin:0 0 18px; color:#0b2e59; font-size:18px; font-weight:800; }
.info-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:14px; }
.info-grid div { padding:16px; background:#f8fafc; border:1px solid #e5ecf4; border-radius:14px; }
.info-grid small, .info-grid strong { display:block; }
.info-grid small { margin-bottom:5px; color:#718096; font-size:11px; font-weight:800; text-transform:uppercase; }
.info-grid strong { color:#0b2e59; overflow-wrap:anywhere; }
.borrower-history-table { min-width:980px; }
.borrower-history-table th { color:#728096; background:#f8fafc; font-size:10px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
.accession-pill, .status-pill { display:inline-flex; align-items:center; border-radius:999px; font-size:10px; font-weight:800; white-space:nowrap; }
.accession-pill { padding:6px 9px; color:#0b2e59; background:#edf4fb; border:1px solid #d8e4f2; font-family:ui-monospace,SFMono-Regular,Consolas,monospace; }
.status-pill { padding:7px 10px; }
.status-pending { color:#7a5a00; background:#fff4ce; }
.status-approved { color:#164b87; background:#e7f1ff; }
.status-borrowed { color:#12614a; background:#e4f7ef; }
.status-returned { color:#276749; background:#eaf8f0; }
.status-overdue { color:#9b2c2c; background:#fff0f0; }
.status-rejected { color:#6b7280; background:#f1f3f5; }
@media (max-width:991.98px){ .info-grid{grid-template-columns:repeat(2,minmax(0,1fr));} }
@media (max-width:767.98px){ .borrower-profile-page{padding:16px 10px;} .profile-header{align-items:flex-start; flex-direction:column;} .profile-actions .btn{width:100%;} .info-grid{grid-template-columns:1fr;} }
</style>
@endpush
