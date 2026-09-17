@extends('layouts.app')

@section('title', 'Borrow Books | MMACI Library Services Office')

@section('content')
<section class="borrow-hero">
    <div class="container">
        <span class="borrow-eyebrow">Library Circulation</span>
        <h1>Borrow Books</h1>
        <p>
            Borrow books from the MMACI Library and keep track of your borrowed
            materials and due dates.
        </p>
    </div>
</section>

<section class="borrow-section">
    <div class="container">
        <div class="borrow-shell">
            <div class="borrow-intro">
                <span class="intro-icon">
                    <i class="bi bi-journal-check"></i>
                </span>
                <h2>Borrowing Request</h2>
                <p>
                    Select an available accession number and complete the
                    borrower details. Library staff will review the request
                    before release.
                </p>
            </div>

            <form
                action="{{ route('more.borrow-books.store') }}"
                method="POST"
                class="borrow-form">
                @csrf

                <div class="form-block">
                    <h3>Borrower Information</h3>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ID Number</label>
                            <input type="text" name="id_number" class="form-control" value="{{ old('id_number') }}" required>
                            @error('id_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}">
                            @error('contact_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control" value="{{ old('department') }}" required>
                            @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Semester</label>
                            <input type="text" name="semester" class="form-control" value="{{ old('semester') }}">
                            @error('semester') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="form-block">
                    <h3>Book Information</h3>

                    <div class="row g-3">
                        <div class="col-lg-4">
                            <label class="form-label">Accession Number</label>
                            <select
                                name="accession_number"
                                id="borrowAccession"
                                class="form-select"
                                required>
                                <option value="">Select available book</option>
                                @foreach($books as $book)
                                    @php
                                        $description = collect([
                                            $book->title,
                                            filled($book->author) ? 'by '.$book->author : null,
                                            $book->publisher,
                                            $book->publication_year,
                                        ])->filter()->implode(' ');
                                    @endphp
                                    <option
                                        value="{{ $book->accession_number }}"
                                        data-title="{{ $book->title }}"
                                        data-description="{{ $description }}"
                                        @selected(old('accession_number') === $book->accession_number)>
                                        {{ $book->accession_number }} — {{ $book->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('accession_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-8">
                            <label class="form-label">Book Title / Bibliographical Description</label>
                            <input
                                type="text"
                                id="borrowBookDescription"
                                class="form-control"
                                value=""
                                placeholder="Book information appears after selecting an accession number"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date Borrowed</label>
                            <input type="date" name="date_borrowed" class="form-control" value="{{ old('date_borrowed', now()->toDateString()) }}" required>
                            @error('date_borrowed') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" required>
                            @error('due_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="4" placeholder="Optional notes for the librarian">{{ old('remarks') }}</textarea>
                            @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
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
    padding: 72px 0;
    background: #f4f7fb;
}

.borrow-shell {
    display: grid;
    grid-template-columns: 320px minmax(0, 1fr);
    gap: 24px;
}

.borrow-intro,
.borrow-form {
    background: #fff;
    border: 1px solid #dfe7f0;
    border-radius: 20px;
    box-shadow: 0 18px 40px rgba(11,46,89,.08);
}

.borrow-intro {
    align-self: start;
    padding: 28px;
}

.intro-icon {
    width: 58px;
    height: 58px;
    display: grid;
    place-items: center;
    margin-bottom: 18px;
    color: #0b2e59;
    background: #f4b400;
    border-radius: 18px;
    font-size: 1.5rem;
}

.borrow-intro h2,
.form-block h3 {
    color: #0b2e59;
    font-weight: 800;
}

.borrow-intro p {
    margin: 0;
    color: #687589;
    line-height: 1.8;
}

.borrow-form {
    padding: 28px;
}

.form-block + .form-block {
    margin-top: 28px;
    padding-top: 28px;
    border-top: 1px solid #e6edf5;
}

.form-block h3 {
    margin-bottom: 18px;
    font-size: 1.1rem;
}

.form-label {
    color: #18385f;
    font-size: .85rem;
    font-weight: 700;
}

.borrow-actions {
    margin-top: 28px;
    display: flex;
    justify-content: flex-end;
}

@media (max-width: 991.98px) {
    .borrow-shell {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 575.98px) {
    .borrow-hero {
        padding: 70px 0 58px;
    }

    .borrow-section {
        padding: 48px 0;
    }

    .borrow-intro,
    .borrow-form {
        padding: 22px;
        border-radius: 16px;
    }

    .borrow-actions .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const accession = document.getElementById('borrowAccession');
    const description = document.getElementById('borrowBookDescription');

    function updateBookDescription() {
        if (!accession || !description) return;

        const selected = accession.options[accession.selectedIndex];
        description.value = selected?.dataset?.description || '';
    }

    accession?.addEventListener('change', updateBookDescription);
    updateBookDescription();
});
</script>
@endpush
