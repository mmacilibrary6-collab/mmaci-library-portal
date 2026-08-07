@extends('layouts.admin')

@section('title', 'Donated Books')
@section('page-title', 'Donated Books')

@section('content')
<div class="container-fluid donated-books-page">
    <section class="programs-hero">
        <div class="hero-copy">
            <span class="hero-icon">
                <i class="bi bi-gift-fill"></i>
            </span>

            <div>
                <span class="hero-eyebrow">Collection Management</span>
                <h2>Donated Books</h2>
                <p>Organize donated books displayed in your public collection.</p>
            </div>
        </div>

        <a href="{{ route('admin.donated-books.create') }}" class="btn-add-program">
            <i class="bi bi-plus-lg"></i>
            <span>Add Book</span>
        </a>
    </section>


    <section class="programs-panel">
        <div class="panel-toolbar">
            <div>
                <h5>Book List</h5>
                <p>
                    {{ $books->total() }}
                    {{ \Illuminate\Support\Str::plural('book', $books->total()) }} found
                </p>
            </div>

            <form method="GET" action="{{ route('admin.donated-books.index') }}" class="program-search">
                <div class="search-field">
                    <i class="bi bi-search"></i>
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search donated books..."
                        aria-label="Search donated books">

                    @if(request('search'))
                        <a href="{{ route('admin.donated-books.index') }}"
                           class="clear-search"
                           title="Clear search"
                           aria-label="Clear search">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>

                <button type="submit">Search</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table programs-table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="number-column">#</th>
                        <th>Book</th>
                        <th>Description</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="row-number">
                                {{ ($books->firstItem() ?? 1) + $loop->index }}
                            </td>

                            <td>
                                <div class="program-identity">
                                    <div class="program-thumbnail">
                                        @if(!empty($book->image_url))
                                            <img src="{{ $book->image_url }}"
                                                 alt="{{ $book->title }}">
                                        @else
                                            <i class="bi bi-book-half"></i>
                                        @endif
                                    </div>

                                    <div>
                                        <strong>{{ $book->title }}</strong>
                                        <small>Donated book</small>
                                    </div>
                                </div>
                            </td>

                            <td class="description-cell">
                                {{ \Illuminate\Support\Str::limit(
                                    $book->description ?: 'No description provided.',
                                    85
                                ) }}
                            </td>

                            <td class="text-center">
                                <span class="status-badge {{ (int) $book->status === 1 ? 'active' : 'hidden' }}">
                                    <span></span>
                                    {{ (int) $book->status === 1 ? 'Active' : 'Hidden' }}
                                </span>
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.donated-books.edit', $book) }}"
                                       class="action-button edit"
                                       title="Edit {{ $book->title }}"
                                       aria-label="Edit {{ $book->title }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form
                                        action="{{ route('admin.donated-books.destroy', $book) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete &quot;{{ addslashes($book->title) }}&quot;? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-button delete"
                                                title="Delete {{ $book->title }}"
                                                aria-label="Delete {{ $book->title }}">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <span><i class="bi bi-book"></i></span>
                                    <h5>No donated books found</h5>
                                    <p>
                                        @if(request('search'))
                                            Try a different search term or clear the search.
                                        @else
                                            Add your first donated book to get started.
                                        @endif
                                    </p>

                                    @if(request('search'))
                                        <a href="{{ route('admin.donated-books.index') }}">
                                            Clear search
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($books->hasPages())
            <div class="panel-footer">
                <p>
                    Showing {{ $books->firstItem() }}–{{ $books->lastItem() }}
                    of {{ $books->total() }}
                </p>

                <div>
                    {{ $books->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </section>
</div>
@endsection

@push('styles')
<style>
    .donated-books-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        --ink: #21344d;
        --muted: #728096;
        --line: #e5eaf1;
        --surface: #ffffff;
        padding: 24px;
    }

    .programs-hero {
        position: relative;
        overflow: hidden;
        min-height: 150px;
        margin-bottom: 22px;
        padding: 28px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        border-radius: 22px;
        background:
            radial-gradient(circle at 90% 10%, rgba(244, 180, 0, .2), transparent 28%),
            linear-gradient(125deg, var(--navy), var(--blue));
        box-shadow: 0 16px 36px rgba(11, 46, 89, .16);
        color: #fff;
    }

    .programs-hero::after {
        content: "";
        position: absolute;
        right: 12%;
        bottom: -70px;
        width: 180px;
        height: 180px;
        border: 28px solid rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .hero-copy {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .hero-icon {
        width: 62px;
        height: 62px;
        flex: 0 0 62px;
        display: grid;
        place-items: center;
        border-radius: 18px;
        background: var(--gold);
        color: var(--navy);
        font-size: 27px;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .14);
    }

    .hero-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .programs-hero h2 {
        margin: 0 0 5px;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 800;
    }

    .programs-hero p {
        max-width: 600px;
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 13px;
    }

    .btn-add-program {
        position: relative;
        z-index: 1;
        min-height: 46px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        border-radius: 12px;
        background: var(--gold);
        color: var(--navy);
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 22px rgba(0, 0, 0, .15);
        transition: .2s ease;
    }

    .btn-add-program:hover {
        color: var(--navy);
        background: #ffc62b;
        transform: translateY(-2px);
    }

    .programs-panel {
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 20px;
        background: var(--surface);
        box-shadow: 0 12px 30px rgba(25, 50, 80, .07);
    }

    .panel-toolbar {
        padding: 20px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        border-bottom: 1px solid var(--line);
    }

    .panel-toolbar h5 {
        margin: 0 0 3px;
        color: var(--navy);
        font-size: 16px;
        font-weight: 800;
    }

    .panel-toolbar p {
        margin: 0;
        color: var(--muted);
        font-size: 11px;
    }

    .program-search {
        width: min(100%, 430px);
        display: flex;
        gap: 8px;
    }

    .search-field {
        position: relative;
        flex: 1;
    }

    .search-field > i {
        position: absolute;
        top: 50%;
        left: 14px;
        color: #93a0b2;
        transform: translateY(-50%);
    }

    .search-field input {
        width: 100%;
        height: 42px;
        padding: 0 42px 0 40px;
        border: 1px solid var(--line);
        border-radius: 11px;
        outline: none;
        color: var(--ink);
        font-size: 12px;
        transition: .2s ease;
    }

    .search-field input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(24, 75, 140, .1);
    }

    .clear-search {
        position: absolute;
        top: 50%;
        right: 13px;
        color: #9aa6b5;
        font-size: 11px;
        transform: translateY(-50%);
    }

    .program-search button {
        height: 42px;
        padding: 0 17px;
        border: 0;
        border-radius: 11px;
        background: var(--navy);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
    }

    .program-search button:hover {
        background: var(--blue);
    }

    .programs-table {
        min-width: 850px;
    }

    .programs-table thead th {
        padding: 13px 18px;
        border: 0;
        border-bottom: 1px solid var(--line);
        background: #f8fafc;
        color: #7b8798;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .programs-table tbody td {
        padding: 15px 18px;
        border-color: #edf0f4;
        color: var(--ink);
        font-size: 12px;
        vertical-align: middle;
    }

    .programs-table tbody tr:hover {
        background: #fbfcfe;
    }

    .number-column,
    .row-number {
        width: 58px;
        color: #98a4b4 !important;
        text-align: center;
    }

    .program-identity {
        min-width: 220px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .program-thumbnail {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        overflow: hidden;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: linear-gradient(145deg, #fff4ca, #ffe078);
        color: var(--navy);
        font-size: 20px;
    }

    .program-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .program-identity strong {
        display: block;
        margin-bottom: 2px;
        color: var(--navy);
        font-size: 13px;
        font-weight: 750;
    }

    .program-identity small {
        color: #98a4b4;
        font-size: 10px;
    }

    .description-cell {
        max-width: 360px;
        color: var(--muted) !important;
        line-height: 1.55;
    }

    .status-badge {
        min-width: 78px;
        padding: 6px 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
    }

    .status-badge > span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-badge.active {
        background: #eaf8f0;
        color: #1b7548;
    }

    .status-badge.active > span {
        background: #27a866;
    }

    .status-badge.hidden {
        background: #f0f2f5;
        color: #687589;
    }

    .status-badge.hidden > span {
        background: #8995a6;
    }

    .table-actions {
        display: flex;
        justify-content: flex-end;
        gap: 7px;
    }

    .table-actions form {
        margin: 0;
    }

    .action-button {
        width: 35px;
        height: 35px;
        padding: 0;
        display: inline-grid;
        place-items: center;
        border: 1px solid transparent;
        border-radius: 10px;
        font-size: 13px;
        text-decoration: none;
        transition: .2s ease;
    }

    .action-button.edit {
        border-color: #d8e4f2;
        background: #f2f7fc;
        color: var(--blue);
    }

    .action-button.delete {
        border-color: #f3d8d8;
        background: #fff5f5;
        color: #c53e3e;
    }

    .action-button:hover {
        transform: translateY(-2px);
    }

    .action-button.edit:hover {
        background: var(--blue);
        color: #fff;
    }

    .action-button.delete:hover {
        background: #d64a4a;
        color: #fff;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state > span {
        width: 64px;
        height: 64px;
        margin: 0 auto 15px;
        display: grid;
        place-items: center;
        border-radius: 18px;
        background: #edf3f9;
        color: var(--blue);
        font-size: 27px;
    }

    .empty-state h5 {
        margin-bottom: 5px;
        color: var(--navy);
        font-weight: 800;
    }

    .empty-state p {
        margin-bottom: 14px;
        color: var(--muted);
        font-size: 12px;
    }

    .empty-state a {
        color: var(--blue);
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .panel-footer {
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        border-top: 1px solid var(--line);
        background: #fbfcfd;
    }

    .panel-footer p {
        margin: 0;
        color: var(--muted);
        font-size: 11px;
    }

    .panel-footer .pagination {
        margin: 0;
    }

    @media (max-width: 767.98px) {
        .donated-books-page {
            padding: 16px 10px;
        }

        .programs-hero {
            padding: 24px 20px;
            align-items: flex-start;
            flex-direction: column;
        }

        .hero-icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
        }

        .btn-add-program {
            width: 100%;
        }

        .panel-toolbar,
        .panel-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .program-search {
            width: 100%;
        }

        .panel-footer > div {
            max-width: 100%;
            overflow-x: auto;
        }
    }

    @media (max-width: 480px) {
        .hero-copy {
            align-items: flex-start;
        }

        .program-search {
            flex-direction: column;
        }

        .program-search button {
            width: 100%;
        }
    }
</style>
@endpush
