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
                            Fill in your borrower information and the book details
                            you want to request. Library staff will review and
                            process the borrowing dates after approval.
                        </p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="borrow-alert borrow-alert-success">
                    <i class="bi bi-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="borrow-alert borrow-alert-error">
                    <i class="bi bi-exclamation-circle"></i>
                    <div>
                        <strong>Please check the highlighted fields.</strong>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <form
                action="{{ route('more.borrow-books.store') }}"
                method="POST"
                class="borrow-form">
                @csrf

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
                            </select>
                            @error('borrower_type') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="name" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
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
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="email">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-block">
                    <h3>Requested Book Information</h3>

                    <div class="row g-3">
                        <div class="col-lg-4">
                            <label class="form-label">Accession Number</label>
                            <input
                                type="text"
                                name="accession_number"
                                class="form-control @error('accession_number') is-invalid @enderror"
                                value="{{ old('accession_number') }}"
                                placeholder="e.g. 06734"
                                required>
                            @error('accession_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-8">
                            <label class="form-label">Bibliographical Description</label>
                            <textarea
                                name="bibliographical_description"
                                class="form-control @error('bibliographical_description') is-invalid @enderror"
                                rows="3"
                                placeholder="Enter book title, author, year, or other bibliographical details"
                                required>{{ old('bibliographical_description') }}</textarea>
                            @error('bibliographical_description') <small class="text-danger">{{ $message }}</small> @enderror
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

.borrow-alert {
    max-width: 1220px;
    margin: 0 auto 18px;
    padding: 14px 16px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    border-radius: 14px;
    font-size: .88rem;
    line-height: 1.5;
}

.borrow-alert i {
    margin-top: 2px;
    font-size: 1rem;
}

.borrow-alert-success {
    color: #17603f;
    background: #edf9f3;
    border: 1px solid #cfeadb;
}

.borrow-alert-error {
    color: #9a3038;
    background: #fff3f4;
    border: 1px solid #efcfd3;
}

.borrow-alert-error strong,
.borrow-alert-error span {
    display: block;
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
</style>
@endpush
