@extends('layouts.admin')

@section('title', 'Edit Borrowing Record')

@section('content')
<div class="container-fluid borrowing-edit-page">
    <section class="edit-hero">
        <div class="hero-left">
            <div class="hero-icon"><i class="bi bi-pencil-square"></i></div>

            <div>
                <span class="hero-eyebrow">Circulation Management</span>
                <h1>Edit Borrowing Record</h1>
                <p>Update borrower information, transaction details, dates, and remarks.</p>
            </div>
        </div>

        <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="hero-btn">
            <i class="bi bi-arrow-left"></i>
            Back to Record
        </a>
    </section>

    @if($errors->any())
        <div class="alert alert-danger validation-box">
            <div class="validation-title">
                <i class="bi bi-exclamation-circle"></i>
                Please review the highlighted fields.
            </div>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.borrowings.update', $borrowing) }}" method="POST" class="edit-panel">
        @csrf
        @method('PUT')

        <section class="form-section">
            <div class="section-heading">
                <div class="heading-icon"><i class="bi bi-person"></i></div>
                <div>
                    <h2>Borrower Information</h2>
                    <p>Personal and institutional information linked to this borrower.</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Borrower Type <span>*</span></label>
                    <select name="borrower_type" class="form-select @error('borrower_type') is-invalid @enderror" required>
                        <option value="" disabled>Select Borrower Type</option>
                        <option value="student" @selected(old('borrower_type', $borrowing->borrower?->borrower_type) === 'student')>
                            Student
                        </option>
                        <option value="faculty" @selected(old('borrower_type', $borrowing->borrower?->borrower_type) === 'faculty')>
                            Faculty
                        </option>
                    <option value="other" @selected(old('borrower_type', $borrowing->borrower?->borrower_type) === 'other')>Other / Specify</option>
                    </select>
                    <div class="mt-3" data-other-type-field>
                        <label for="borrower-type-other" class="form-label">Specify borrower type <span class="text-danger">*</span></label>
                        <input id="borrower-type-other" name="borrower_type_other" class="form-control @error('borrower_type_other') is-invalid @enderror" maxlength="80" value="{{ old('borrower_type_other', $borrowing->borrower?->borrower_type_other) }}" placeholder="e.g. Staff, Alumni, Guest">
                        <small class="text-muted">Used as the title on your borrower card. Limits: 3 books, 2 days, 2 renewals.</small>
                        @error('borrower_type_other')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @error('borrower_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Name <span>*</span></label>
                    <input class="form-control @error('name') is-invalid @enderror"
                           name="name"
                           value="{{ old('name', $borrowing->borrower?->name) }}"
                           required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">ID Number <span>*</span></label>
                    <input class="form-control @error('id_number') is-invalid @enderror"
                           name="id_number"
                           value="{{ old('id_number', $borrowing->borrower?->id_number) }}"
                           required>
                    @error('id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Department <span>*</span></label>
                    <input class="form-control @error('department') is-invalid @enderror"
                           name="department"
                           value="{{ old('department', $borrowing->borrower?->department) }}"
                           required>
                    @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Semester <span>*</span></label>
                    <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                        <option value="" disabled>Select Semester</option>
                        <option value="1st" @selected(old('semester', $borrowing->borrower?->semester) === '1st')>1st</option>
                        <option value="2nd" @selected(old('semester', $borrowing->borrower?->semester) === '2nd')>2nd</option>
                    </select>
                    @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Contact Number</label>
                    <input class="form-control @error('contact_number') is-invalid @enderror"
                           name="contact_number"
                           value="{{ old('contact_number', $borrowing->borrower?->contact_number) }}">
                    @error('contact_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Email Address</label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email"
                           value="{{ old('email', $borrowing->borrower?->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </section>

        <section class="form-section">
            <div class="section-heading">
                <div class="heading-icon"><i class="bi bi-journal-bookmark"></i></div>
                <div>
                    <h2>Book Transaction</h2>
                    <p>Update accession information, dates, status, handling details, and remarks.</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-4">
                    <label class="form-label">Accession Number</label>
                    <input class="form-control @error('accession_number') is-invalid @enderror"
                           name="accession_number"
                           value="{{ old('accession_number', $borrowing->accession_number) }}"
                           @required(! in_array($borrowing->status, ['pending', 'rejected'], true))>
                    @error('accession_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-lg-8">
                    <label class="form-label">Book Title / Bibliographical Details <span>*</span></label>
                    <textarea class="form-control @error('bibliographical_description') is-invalid @enderror"
                              name="bibliographical_description"
                              rows="3"
                              required>{{ old('bibliographical_description', $borrowing->bibliographical_description) }}</textarea>
                    @error('bibliographical_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <div class="loan-dates-panel">
                        <div class="loan-dates-heading"><i class="bi bi-calendar3" aria-hidden="true"></i> Loan dates</div>
                        <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Date Borrowed</label>
                    <input type="date"
                           class="form-control @error('date_borrowed') is-invalid @enderror"
                           name="date_borrowed"
                           @readonly(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                           value="{{ old('date_borrowed', optional($borrowing->date_borrowed)->toDateString()) }}">
                    @error('date_borrowed')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Due Date</label>
                    <input type="date"
                           class="form-control @error('due_date') is-invalid @enderror"
                           name="due_date"
                           @readonly(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                           value="{{ old('due_date', optional($borrowing->due_date)->toDateString()) }}">
                    @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date Returned</label>
                    <input type="date"
                           class="form-control @error('date_returned') is-invalid @enderror"
                           name="date_returned"
                           value="{{ old('date_returned', optional($borrowing->date_returned)->toDateString()) }}">
                    @error('date_returned')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                        </div>
                        @if(in_array($borrowing->status, ['borrowed', 'overdue'], true))
                            <div class="loan-dates-note">
                                <i class="bi bi-lock" aria-hidden="true"></i>
                                <p>Loan dates are locked after release. <a href="{{ route('admin.borrowings.show', $borrowing) }}">Renew this book</a> to extend the due date, up to 2 times.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status <span>*</span></label>
                    <input type="hidden" name="status" value="{{ $borrowing->status }}">
                    <div class="form-control status-display"><span class="status-indicator" aria-hidden="true"></span>{{ ucfirst($borrowing->status) }}</div>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Received By</label>
                    <input class="form-control @error('received_by') is-invalid @enderror"
                           name="received_by"
                           value="{{ in_array($borrowing->status, ['borrowed', 'overdue', 'returned'], true) ? $borrowing->borrower?->name : '' }}" readonly>
                    @error('received_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Returned By</label>
                    <input class="form-control @error('returned_by') is-invalid @enderror"
                           name="returned_by"
                           value="{{ old('returned_by', $borrowing->returned_by) }}">
                    @error('returned_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control @error('remarks') is-invalid @enderror"
                              name="remarks"
                              rows="4"
                              placeholder="Optional notes about this borrowing transaction">{{ old('remarks', $borrowing->remarks) }}</textarea>
                    @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @if(in_array($borrowing->status, ['borrowed', 'overdue', 'returned'], true))
                <div class="col-12">
                    <label class="form-label">Released By</label>
                    <input
                        type="text"
                        class="form-control @error('released_by') is-invalid @enderror"
                        name="released_by"
                        value="{{ old('released_by', $borrowing->released_by) }}"
                        placeholder="Enter the name of the staff member who released the book">
                    @error('released_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endif
            </div>
        </section>

        <div class="form-actions">
            <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="cancel-btn">Cancel</a>
            <button type="submit" class="save-btn">
                <i class="bi bi-check2"></i>
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.borrowing-edit-page{
    --navy:#0b315e;--yellow:#ffbd00;--line:#dfe7ef;--muted:#7d8da1;
    max-width:1440px;margin:0 auto;padding:28px 34px 40px;
}
.edit-hero{
    min-height:170px;margin-bottom:22px;padding:32px 36px;display:flex;align-items:center;
    justify-content:space-between;gap:24px;position:relative;overflow:hidden;color:#fff;
    background:
        radial-gradient(circle at 82% 80%,rgba(255,255,255,.08) 0 72px,transparent 73px),
        radial-gradient(circle at 82% 80%,rgba(255,255,255,.06) 0 112px,transparent 113px),
        linear-gradient(115deg,#0d3b72 0%,#174d7d 65%,#365f7b 100%);
    border-radius:24px;box-shadow:0 14px 35px rgba(17,54,91,.12);
}
.hero-left{display:flex;align-items:center;gap:22px}
.hero-icon{
    width:72px;height:72px;flex:0 0 72px;display:grid;place-items:center;color:#0b315e;
    background:var(--yellow);border-radius:22px;font-size:28px;
}
.hero-eyebrow{
    display:block;margin-bottom:5px;color:#ffd54d;font-size:12px;font-weight:800;
    letter-spacing:.08em;text-transform:uppercase;
}
.edit-hero h1{margin:0;font-size:36px;font-weight:800;letter-spacing:-.03em}
.edit-hero p{margin:6px 0 0;color:rgba(255,255,255,.84);font-size:14px}
.hero-btn{
    min-height:48px;padding:0 18px;display:inline-flex;align-items:center;justify-content:center;
    gap:8px;color:#0b315e;background:#fff;border:1px solid rgba(255,255,255,.75);
    border-radius:14px;font-size:12px;font-weight:800;text-decoration:none;white-space:nowrap;
}
.validation-box{margin-bottom:18px;border:1px solid #efc9cd;border-radius:15px;font-size:12px}
.validation-title{display:flex;align-items:center;gap:7px;font-weight:800}
.edit-panel{
    overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:24px;
    box-shadow:0 10px 25px rgba(16,48,82,.05);
}
.form-section{padding:26px 28px 28px}
.form-section+.form-section{border-top:1px solid var(--line)}
.form-section .row{--bs-gutter-y:22px}
.loan-dates-panel{padding:20px;background:#f7f9fc;border:1px solid #e2e9f1;border-radius:15px}
.loan-dates-heading{display:flex;align-items:center;gap:8px;margin-bottom:16px;color:#183b62;font-size:12px;font-weight:700}
.loan-dates-heading i{color:#6f89a4;font-size:14px}
.loan-dates-note{display:flex;align-items:flex-start;gap:8px;margin-top:16px;padding-top:13px;border-top:1px solid #e0e8f0;color:#728298}
.loan-dates-note>i{flex-shrink:0;font-size:13px;line-height:20px}
.loan-dates-note p{margin:0;font-size:11px;line-height:20px}
.loan-dates-note a{color:#245b8e;font-weight:600;text-underline-offset:3px}
.borrowing-edit-page .form-control[readonly],.borrowing-edit-page .status-display{background:#f0f4f8;color:#5c7188;border-color:#dde5ee}
.status-display{display:flex;align-items:center;gap:8px}
.status-indicator{height:6px;width:6px;border-radius:50%;background:#748ba3}
.section-heading{margin-bottom:22px;display:flex;align-items:flex-start;gap:12px}
.heading-icon{
    width:44px;height:44px;flex:0 0 44px;display:grid;place-items:center;color:#205e93;
    background:#eef5fb;border-radius:13px;font-size:18px;
}
.section-heading h2{margin:1px 0 0;color:#0b315e;font-size:20px;font-weight:800}
.section-heading p{margin:4px 0 0;color:var(--muted);font-size:12px}
.form-label{margin-bottom:7px;color:#62768c;font-size:11px;font-weight:800}
.form-label span{color:#bd3540}
.form-control,.form-select{
    min-height:47px;padding:10px 13px;border:1px solid #dce5ee;border-radius:13px;
    color:#0b315e;background:#fff;font-size:13px;box-shadow:none!important;
}
textarea.form-control{min-height:auto;resize:vertical}
.form-control:focus,.form-select:focus{
    border-color:#8aa8c6;box-shadow:0 0 0 3px rgba(24,75,140,.08)!important;
}
.form-actions{
    padding:18px 28px;display:flex;align-items:center;justify-content:flex-end;gap:10px;
    background:#fbfcfe;border-top:1px solid var(--line);
}
.cancel-btn,.save-btn{
    min-height:44px;padding:0 17px;display:inline-flex;align-items:center;justify-content:center;
    gap:7px;border-radius:12px;font-size:12px;font-weight:800;text-decoration:none;
}
.cancel-btn{color:#5c6f84;background:#fff;border:1px solid #d6e1eb}
.save-btn{color:#0b315e;background:var(--yellow);border:1px solid #e6aa00}
@media (max-width:991.98px){.edit-hero{align-items:flex-start;flex-direction:column}}
@media (max-width:767.98px){
    .borrowing-edit-page{padding:18px 12px 28px}
    .edit-hero{padding:24px 20px;border-radius:18px}
    .hero-left{align-items:flex-start}
    .hero-icon{width:58px;height:58px;flex-basis:58px;border-radius:17px;font-size:24px}
    .edit-hero h1{font-size:27px}
    .hero-btn{width:100%}
    .edit-panel{border-radius:18px}
    .form-section{padding:22px 18px}
    .form-actions{padding:16px 18px;flex-direction:column-reverse}
    .cancel-btn,.save-btn{width:100%}
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = document.querySelector('select[name="borrower_type"]');
    const field = document.querySelector('[data-other-type-field]');
    const input = field.querySelector('input');
    function toggleOther() { field.hidden = type.value !== 'other'; input.required = type.value === 'other'; input.disabled = type.value !== 'other'; }
    type.addEventListener('change', toggleOther);
    toggleOther();
});
</script>
@endpush
