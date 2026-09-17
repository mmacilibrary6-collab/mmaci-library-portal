@extends('layouts.admin')

@section('title', 'Edit Borrowing Record')

@section('content')
<div class="container-fluid borrowing-edit-page">
    <div class="edit-shell">
        <div class="edit-header">
            <div>
                <span>Circulation Management</span>
                <h1>Edit Borrowing Record</h1>
                <p>Update borrower details, loan dates, status, and card remarks.</p>
            </div>
            <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="btn btn-light"><i class="bi bi-arrow-left"></i> Back</a>
        </div>

        <form action="{{ route('admin.borrowings.update', $borrowing) }}" method="POST" class="edit-form">
            @csrf
            @method('PUT')

            <h2>Borrower Information</h2>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" value="{{ old('name', $borrowing->borrower?->name) }}" required></div>
                <div class="col-md-6"><label class="form-label">ID Number</label><input class="form-control" name="id_number" value="{{ old('id_number', $borrowing->borrower?->id_number) }}" required></div>
                <div class="col-md-6"><label class="form-label">Contact Number</label><input class="form-control" name="contact_number" value="{{ old('contact_number', $borrowing->borrower?->contact_number) }}"></div>
                <div class="col-md-6"><label class="form-label">Department</label><input class="form-control" name="department" value="{{ old('department', $borrowing->borrower?->department) }}" required></div>
                <div class="col-md-6"><label class="form-label">Semester</label><input class="form-control" name="semester" value="{{ old('semester', $borrowing->borrower?->semester) }}"></div>
                <div class="col-md-6"><label class="form-label">Email Address</label><input type="email" class="form-control" name="email" value="{{ old('email', $borrowing->borrower?->email) }}"></div>
            </div>

            <h2>Book Transaction</h2>
            <div class="row g-3">
                <div class="col-lg-4">
                    <label class="form-label">Accession Number</label>
                    <select name="accession_number" id="editBorrowAccession" class="form-select" required>
                        @foreach($books as $book)
                            @php
                                $description = collect([$book->title, filled($book->author) ? 'by '.$book->author : null, $book->publisher, $book->publication_year])->filter()->implode(' ');
                            @endphp
                            <option value="{{ $book->accession_number }}" data-description="{{ $description }}" @selected(old('accession_number', $borrowing->accession_number) === $book->accession_number)>
                                {{ $book->accession_number }} — {{ $book->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-8"><label class="form-label">Bibliographical Description of Book</label><input id="editBorrowDescription" class="form-control" name="bibliographical_description" value="{{ old('bibliographical_description', $borrowing->bibliographical_description) }}" required></div>
                <div class="col-md-4"><label class="form-label">Date Borrowed</label><input type="date" class="form-control" name="date_borrowed" value="{{ old('date_borrowed', optional($borrowing->date_borrowed)->toDateString()) }}" required></div>
                <div class="col-md-4"><label class="form-label">Due Date</label><input type="date" class="form-control" name="due_date" value="{{ old('due_date', optional($borrowing->due_date)->toDateString()) }}" required></div>
                <div class="col-md-4"><label class="form-label">Date Returned</label><input type="date" class="form-control" name="date_returned" value="{{ old('date_returned', optional($borrowing->date_returned)->toDateString()) }}"></div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['pending', 'approved', 'borrowed', 'returned', 'overdue', 'rejected'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $borrowing->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Received By</label><input class="form-control" name="received_by" value="{{ old('received_by', $borrowing->received_by) }}"></div>
                <div class="col-md-4"><label class="form-label">Returned By</label><input class="form-control" name="returned_by" value="{{ old('returned_by', $borrowing->returned_by) }}"></div>
                <div class="col-12"><label class="form-label">Remarks</label><textarea class="form-control" name="remarks" rows="4">{{ old('remarks', $borrowing->remarks) }}</textarea></div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger mt-4">
                    <strong>Please check the form.</strong>
                    <ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="edit-actions">
                <button class="btn btn-admin"><i class="bi bi-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.borrowing-edit-page { padding:24px; }
.edit-shell { max-width:1180px; margin:0 auto; }
.edit-header { margin-bottom:22px; padding:28px; display:flex; align-items:center; justify-content:space-between; gap:20px; color:#fff; background:linear-gradient(125deg,#0b2e59,#184b8c); border-radius:22px; }
.edit-header span { color:#ffd96d; font-size:11px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; }
.edit-header h1 { margin:5px 0; font-weight:800; }
.edit-header p { margin:0; color:rgba(255,255,255,.75); }
.edit-form { padding:28px; background:#fff; border:1px solid #e2e9f2; border-radius:20px; box-shadow:0 12px 30px rgba(11,46,89,.07); }
.edit-form h2 { margin:0 0 18px; color:#0b2e59; font-size:18px; font-weight:800; }
.edit-form h2:not(:first-child) { margin-top:30px; padding-top:26px; border-top:1px solid #e6edf5; }
.form-label { color:#18385f; font-size:12px; font-weight:800; }
.edit-actions { margin-top:26px; display:flex; justify-content:flex-end; }
@media (max-width:767.98px){ .borrowing-edit-page{padding:16px 10px;} .edit-header{align-items:flex-start; flex-direction:column;} .edit-form{padding:22px;} .edit-actions .btn{width:100%;} }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('editBorrowAccession');
    const description = document.getElementById('editBorrowDescription');
    select?.addEventListener('change', function () {
        const selected = select.options[select.selectedIndex];
        if (description && selected?.dataset?.description) {
            description.value = selected.dataset.description;
        }
    });
});
</script>
@endpush
