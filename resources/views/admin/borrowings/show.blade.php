@extends('layouts.admin')

@section('title', 'Borrowing Record')

@section('content')
<div class="container-fluid borrowing-detail-page">
    <div class="detail-header">
        <div>
            <span>Borrowing Record</span>
            <h1>{{ $borrowing->borrower?->name ?? 'Unknown Borrower' }}</h1>
            <p>{{ $borrowing->accession_number }} · {{ ucfirst($borrowing->display_status) }}</p>
        </div>
        <div class="detail-actions">
            <a href="{{ route('admin.borrowings.index') }}" class="btn btn-light"><i class="bi bi-arrow-left"></i> Back</a>
            <a href="{{ route('admin.borrowings.borrower', $borrowing->borrower) }}" class="btn btn-outline-light"><i class="bi bi-person-vcard"></i> Borrower Profile</a>
            <a href="{{ route('admin.borrowings.print-card', $borrowing->borrower) }}" target="_blank" class="btn btn-warning"><i class="bi bi-printer"></i> Print Borrower Card</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="detail-card">
                <h2>Borrower Information</h2>
                <dl>
                    <dt>Name</dt><dd>{{ $borrowing->borrower?->name }}</dd>
                    <dt>ID Number</dt><dd>{{ $borrowing->borrower?->id_number }}</dd>
                    <dt>Contact Number</dt><dd>{{ $borrowing->borrower?->contact_number ?: '-' }}</dd>
                    <dt>Department</dt><dd>{{ $borrowing->borrower?->department }}</dd>
                    <dt>Semester</dt><dd>{{ $borrowing->borrower?->semester ?: '-' }}</dd>
                    <dt>Email Address</dt><dd>{{ $borrowing->borrower?->email ?: '-' }}</dd>
                </dl>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="detail-card">
                <h2>Book Transaction</h2>
                <dl>
                    <dt>Accession Number</dt><dd>{{ $borrowing->accession_number }}</dd>
                    <dt>Book</dt><dd>{{ $borrowing->bibliographical_description }}</dd>
                    <dt>Date Borrowed</dt><dd>{{ optional($borrowing->date_borrowed)->format('F d, Y') }}</dd>
                    <dt>Due Date</dt><dd>{{ optional($borrowing->due_date)->format('F d, Y') }}</dd>
                    <dt>Date Returned</dt><dd>{{ optional($borrowing->date_returned)->format('F d, Y') ?? '-' }}</dd>
                    <dt>Received By</dt><dd>{{ $borrowing->received_by ?: '-' }}</dd>
                    <dt>Returned By</dt><dd>{{ $borrowing->returned_by ?: '-' }}</dd>
                    <dt>Remarks</dt><dd>{{ $borrowing->remarks ?: '-' }}</dd>
                </dl>

                <div class="record-actions">
                    @if($borrowing->status === 'pending')
                        <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">@csrf @method('PATCH')<button class="btn btn-success"><i class="bi bi-check-lg"></i> Approve</button></form>
                        <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}">@csrf @method('PATCH')<button class="btn btn-outline-danger"><i class="bi bi-x-lg"></i> Reject</button></form>
                    @endif

                    @if(in_array($borrowing->status, ['pending', 'approved'], true))
                        <form method="POST" action="{{ route('admin.borrowings.borrowed', $borrowing) }}">@csrf @method('PATCH')<button class="btn btn-primary"><i class="bi bi-bookmark-check"></i> Mark as Borrowed</button></form>
                    @endif

                    @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                        <form method="POST" action="{{ route('admin.borrowings.returned', $borrowing) }}">@csrf @method('PATCH')<button class="btn btn-warning"><i class="bi bi-arrow-return-left"></i> Mark as Returned</button></form>
                    @endif

                    <a href="{{ route('admin.borrowings.edit', $borrowing) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>

                    <form
                        method="POST"
                        action="{{ route('admin.borrowings.destroy', $borrowing) }}"
                        onsubmit="return confirm('Delete this borrowing record only if it was created by mistake. Continue?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger">
                            <i class="bi bi-trash3"></i>
                            Delete Erroneous Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.borrowing-detail-page { padding:24px; }
.detail-header { margin-bottom:24px; padding:28px; display:flex; align-items:center; justify-content:space-between; gap:20px; color:#fff; background:linear-gradient(125deg,#0b2e59,#184b8c); border-radius:22px; }
.detail-header span { color:#ffd96d; font-size:11px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
.detail-header h1 { margin:5px 0; font-weight:800; }
.detail-header p { margin:0; color:rgba(255,255,255,.75); }
.detail-actions { display:flex; flex-wrap:wrap; gap:9px; }
.detail-card { height:100%; padding:24px; background:#fff; border:1px solid #e2e9f2; border-radius:18px; box-shadow:0 12px 30px rgba(11,46,89,.07); }
.detail-card h2 { margin-bottom:20px; color:#0b2e59; font-size:18px; font-weight:800; }
.detail-card dl { display:grid; grid-template-columns:160px minmax(0,1fr); gap:12px 18px; margin:0; }
.detail-card dt { color:#6f7e91; font-size:12px; font-weight:800; text-transform:uppercase; }
.detail-card dd { margin:0; color:#26384d; font-weight:600; overflow-wrap:anywhere; }
.record-actions { margin-top:24px; display:flex; flex-wrap:wrap; gap:9px; }
.record-actions form { margin:0; }
@media (max-width:767.98px){ .borrowing-detail-page{padding:16px 10px;} .detail-header{align-items:flex-start; flex-direction:column;} .detail-actions .btn{width:100%;} .detail-card dl{grid-template-columns:1fr;} }
</style>
@endpush
