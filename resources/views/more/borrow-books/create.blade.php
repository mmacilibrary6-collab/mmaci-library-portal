@extends('layouts.app')

@section('title', 'Borrow Books | MMACI Library Services Office')

@section('content')
<section class="borrow-hero">
    <div class="container">
        <span class="borrow-eyebrow">Library Circulation</span>
        <h1>Borrow Books</h1>
        <p>
            Request books from the MMACI Library. Library staff will review your
            request and complete the official borrowing details.
        </p>
    </div>
</section>

<section class="borrow-section">
    <div class="container">
        <div class="borrow-shell">
            <div class="borrow-intro">
                <div class="intro-main">
                    <span class="intro-icon">
                        <i class="bi bi-journal-check"></i>
                    </span>

                    <div>
                        <span class="intro-eyebrow">Request Guide</span>
                        <h2>Borrowing Request</h2>
                        <p>
                            Enter your borrower information, email address, and book title.
                            Library staff will review your request and email you an update.
                            Loan dates are set when you collect the book.
                        </p>
                    </div>
                </div>
            </div>

            <form
                action="{{ route('more.borrow-books.store') }}"
                method="POST"
                class="borrow-form">
                @csrf
                @if(session('success'))
                    <div class="alert alert-success" role="status">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">Please check the highlighted fields below.</div>
                @endif

                <div class="form-block">
                    <h3>Borrower Information</h3>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Borrower Type</label>
                            <select name="borrower_type" class="form-select @error('borrower_type') is-invalid @enderror" required>
                                <option value="" disabled {{ old('borrower_type') ? '' : 'selected' }}>
                                    Select Borrower Type
                                </option>
                                <option value="student" {{ old('borrower_type') === 'student' ? 'selected' : '' }}>
                                    Student
                                </option>
                                <option value="faculty" {{ old('borrower_type') === 'faculty' ? 'selected' : '' }}>
                                    Faculty
                                </option>
                            <option value="other" @selected(old('borrower_type') === 'other')>Other / Specify</option>
                    </select>


                            @error('borrower_type') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="name" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12" data-other-type-field>
                        <div class="custom-type-panel"><div class="custom-type-input">
                        <label for="borrower-type-other" class="form-label">Specify borrower type <span class="text-danger">*</span></label>
                        <input id="borrower-type-other" name="borrower_type_other" class="form-control @error('borrower_type_other') is-invalid @enderror" maxlength="80" value="{{ old('borrower_type_other', '') }}" placeholder="e.g. Staff, Alumni, Guest" aria-describedby="custom-type-help">

                        @error('borrower_type_other')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div><div class="custom-type-help" id="custom-type-help">
                            <p>Appears on your printed borrower card.</p>
                            <div class="custom-type-limits"><span>3 books</span><span>2-day loans</span><span>2 renewals</span></div>
                        </div></div>
                    </div>

                        <div class="col-md-6">
                            <label class="form-label">ID Number</label>
                            <input type="text" name="id_number" class="form-control @error('id_number') is-invalid @enderror" value="{{ old('id_number') }}" autocomplete="off" required>
                            @error('id_number')
                                <small class="text-danger">{{ $message }}</small>
                            @else
                                <small class="field-hint">Use the same ID number if you have borrowed before.</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}" inputmode="tel" autocomplete="tel">
                            @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department') }}" required>
                            @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                                <option value="" disabled {{ old('semester') ? '' : 'selected' }}>Select Semester</option>
                                <option value="1st" {{ old('semester') === '1st' ? 'selected' : '' }}>1st</option>
                                <option value="2nd" {{ old('semester') === '2nd' ? 'selected' : '' }}>2nd</option>
                            </select>
                            @error('semester') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="email" required>
                            <small class="field-hint">We will send approval, rejection, and due-date updates to this address.</small>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-block">
                    <h3>Requested Book Information</h3>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="book-title" class="form-label">Book Title</label>
                            <input id="book-title" type="text" name="book_title"
                                   class="form-control @error('book_title') is-invalid @enderror"
                                   value="{{ old('book_title') }}" maxlength="500"
                                   placeholder="Enter the title of the book you want to borrow" required>
                            @error('book_title') <small class="text-danger">{{ $message }}</small> @enderror
                            <small class="field-hint">Library staff will identify the available copy and complete the borrowing details.</small>
                        </div>
                    </div>
                </div>

                <div class="borrow-actions">
                    <button type="submit" class="btn btn-mmaci">
                        <i class="bi bi-send"></i>
                        Submit Borrowing Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@include('components.lisa-chatbox')
@endsection

@push('styles')
<style>
.borrow-hero {
    padding: 96px 0 80px;
    color: #fff;
    background:
        linear-gradient(rgba(11, 46, 89, .78), rgba(11, 46, 89, .82)),
        url('{{ asset('images/librarycollect.jpg') }}') center/cover;
}

.borrow-eyebrow {
    color: #f4b400;
    font-size: .78rem;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.borrow-hero h1 {
    margin: 10px 0;
    font-size: clamp(2.4rem, 6vw, 4.4rem);
    font-weight: 800;
}

.borrow-hero p {
    max-width: 720px;
    color: rgba(255,255,255,.82);
    font-size: 1.05rem;
    line-height: 1.8;
}

.borrow-section {
    padding: 82px 0;
    background: linear-gradient(180deg, #eef4fb 0%, #f7f9fc 42%, #ffffff 100%);
}

.borrow-shell {
    display: grid;
    grid-template-columns: minmax(260px, 360px) minmax(0, 1fr);
    align-items: start;
    gap: 26px;
    max-width: 1220px;
    margin: 0 auto;
}

.borrow-intro,
.borrow-form {
    background: #fff;
    border: 1px solid #dfe7f0;
    border-radius: 22px;
    box-shadow: 0 18px 44px rgba(11,46,89,.09);
}

.borrow-intro {
    position: sticky;
    top: 105px;
    overflow: hidden;
}

.intro-main {
    padding: 30px;
}

.intro-eyebrow {
    display: block;
    margin-bottom: 8px;
    color: #184b8c;
    font-size: .72rem;
    font-weight: 800;
    letter-spacing: .11em;
    text-transform: uppercase;
}

.intro-icon {
    width: 56px;
    height: 56px;
    display: grid;
    place-items: center;
    margin-bottom: 20px;
    color: #0b2e59;
    background: #f4b400;
    border-radius: 16px;
    font-size: 1.5rem;
    box-shadow: 0 12px 24px rgba(244,180,0,.24);
}

.borrow-intro h2,
.form-block h3 {
    color: #0b2e59;
    font-weight: 800;
}

.borrow-intro h2 {
    margin-bottom: 12px;
    font-size: clamp(1.8rem, 3vw, 2.2rem);
    line-height: 1.12;
}

.borrow-intro p {
    margin: 0;
    color: #687589;
    line-height: 1.8;
}

.field-hint {
    display: block;
    margin-top: 5px;
    color: #8a98a9;
    font-size: .75rem;
}

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #dc6973;
}

.form-control.is-invalid:focus,
.form-select.is-invalid:focus {
    border-color: #dc6973;
    box-shadow: 0 0 0 .2rem rgba(220,105,115,.12);
}

.borrow-form {
    padding: 30px;
}

.form-block + .form-block {
    margin-top: 28px;
    padding-top: 28px;
    border-top: 1px solid #e6edf5;
}

.form-block h3 {
    margin-bottom: 18px;
    font-size: 1.15rem;
}

.form-label {
    color: #18385f;
    font-size: .85rem;
    font-weight: 700;
}

.form-control,
.form-select {
    min-height: 48px;
    border: 1px solid #d8e2ec;
    border-radius: 12px;
    color: #18385f;
    background-color: #fff;
    box-shadow: none;
}

.form-control:focus,
.form-select:focus {
    border-color: #7fa2c7;
    box-shadow: 0 0 0 .2rem rgba(24,75,140,.10);
}

textarea.form-control {
    min-height: 100px;
}

.borrow-actions {
    margin-top: 28px;
    display: flex;
    justify-content: flex-end;
}

@media (max-width: 991.98px) {
    .borrow-shell { grid-template-columns: 1fr; }
    .borrow-intro { position: static; }
    .intro-main { display: flex; gap: 18px; align-items: flex-start; }
    .intro-icon { flex: 0 0 56px; margin-bottom: 0; }
}

@media (max-width: 575.98px) {
    .borrow-hero { padding: 70px 0 58px; }
    .borrow-section { padding: 42px 0; }
    .borrow-intro, .borrow-form { border-radius: 16px; }
    .intro-main { display: block; padding: 22px; }
    .intro-icon { margin-bottom: 16px; }
    .borrow-form { padding: 22px; }
    .borrow-actions .btn { width: 100%; }
}

.custom-type-panel{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);align-items:center;gap:20px;padding:18px 20px;background:#f7f9fc;border:1px solid #dfe7ef;border-radius:14px}
.custom-type-input{min-width:0}
.custom-type-help p{margin:0 0 10px;color:#73849a;font-size:12px;line-height:1.6}
.custom-type-limits{display:flex;flex-wrap:wrap;gap:6px}
.custom-type-limits span{display:inline-block;padding:5px 9px;border:1px solid #dce6f0;border-radius:6px;background:#fff;color:#46617d;font-size:11px;font-weight:600;line-height:1.4}
@media(max-width:575.98px){.custom-type-panel{grid-template-columns:1fr;gap:12px;padding:16px}.custom-type-help p{margin-bottom:8px}}
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
