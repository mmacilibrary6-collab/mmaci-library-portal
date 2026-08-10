@extends('layouts.app')

@section('title', 'New Arrivals | MMACI Library Services Office')

@section('content')

<section class="new-arrivals-page">

    {{-- =========================================================
        HERO
    ========================================================== --}}
    <div class="arrivals-hero">

        <div class="container">

            <div class="arrivals-hero-content" data-aos="fade-up">

                <span class="arrivals-eyebrow">
                    MMACI Library
                </span>

                <h1>
                    New Arrivals
                </h1>

                <p>
                    Explore the newest printed books and learning resources
                    available at the MMACI Library Services Office.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        CONTENT
    ========================================================== --}}
    <div class="arrivals-content">

        <div class="container">

            {{-- SEARCH --}}
            @if(($arrivals ?? collect())->isNotEmpty())

                <div class="arrival-toolbar">

                    <div class="arrival-heading">

                        <span>
                            Library Collection
                        </span>

                        <h2>
                            Browse New Arrivals
                        </h2>

                    </div>


                    <div class="arrival-search-field">

                        <i class="bi bi-search"></i>

                        <input
                            type="search"
                            id="arrivalSearch"
                            placeholder="Search title, author, accession number..."
                            autocomplete="off"
                            aria-label="Search new arrivals">

                    </div>

                </div>

            @endif


            {{-- =================================================
                BOOK GRID
            ================================================== --}}
            <div
                class="arrivals-grid"
                id="arrivalsGrid">

                @forelse($arrivals ?? [] as $book)

                    <div
                        class="arrival-item"
                        data-aos="fade-up">

                        <button
                            type="button"
                            class="arrival-card arrival-card-button"

                            data-arrival-index="{{ $loop->index }}"

                            data-arrival-title='@json(
                                $book->title
                            )'

                            data-arrival-author='@json(
                                $book->author ?? "Unknown Author"
                            )'

                            data-arrival-accession='@json(
                                $book->accession_number ?? "Not assigned"
                            )'

                            data-arrival-category='@json(
                                $book->category ?? "Uncategorized"
                            )'

                            data-arrival-date='@json(
                                $book->arrival_date
                                    ? \Carbon\Carbon::parse(
                                        $book->arrival_date
                                    )->format("F d, Y")
                                    : "Not specified"
                            )'

                            data-arrival-description='@json(
                                $book->description
                                    ?? "No description available."
                            )'

                            data-arrival-image='@json(
                                $book->image_url
                            )'

                            aria-label="View details for {{ $book->title }}">


                            {{-- COVER --}}
                            <div class="arrival-cover">

                                <img
                                    src="{{ $book->image_url }}"
                                    alt="{{ $book->title }}"
                                    loading="lazy"
                                    onerror="
                                        this.onerror = null;
                                        this.src = '{{ asset('images/readingarea.jpg') }}';
                                    ">

                                <div class="arrival-cover-overlay">

                                    <span>

                                        <i class="bi bi-eye"></i>

                                        View Details

                                    </span>

                                </div>

                            </div>


                            {{-- CARD BODY --}}
                            <div class="arrival-body">

                                <div class="arrival-meta-row">

                                    <span class="arrival-category">

                                        {{ $book->category ?? 'Uncategorized' }}

                                    </span>


                                    @if($book->arrival_date)

                                        <span class="arrival-date-short">

                                            {{ \Carbon\Carbon::parse(
                                                $book->arrival_date
                                            )->format('M d') }}

                                        </span>

                                    @endif

                                </div>


                                <h3>
                                    {{ $book->title }}
                                </h3>


                                <span class="arrival-author">

                                    <i class="bi bi-person"></i>

                                    {{ $book->author ?? 'Unknown Author' }}

                                </span>


                                <p>

                                    {{ \Illuminate\Support\Str::limit(
                                        $book->description
                                            ?? 'No description available.',
                                        110
                                    ) }}

                                </p>


                                <div class="arrival-card-footer">

                                    <span>
                                        View book details
                                    </span>

                                    <span class="arrival-arrow">

                                        <i class="bi bi-arrow-right"></i>

                                    </span>

                                </div>

                            </div>

                        </button>

                    </div>

                @empty

                    <div class="arrival-empty">

                        <div class="empty-icon">

                            <i class="bi bi-book"></i>

                        </div>

                        <h3>
                            No new arrivals available
                        </h3>

                        <p>
                            Newly added library resources will appear here.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- =================================================
                NO SEARCH RESULTS
            ================================================== --}}
            @if(($arrivals ?? collect())->isNotEmpty())

                <div
                    class="arrival-no-results d-none"
                    id="arrivalNoResults">

                    <div class="empty-icon">

                        <i class="bi bi-search"></i>

                    </div>

                    <h3>
                        No matching books found
                    </h3>

                    <p>
                        Try searching by title, author,
                        category, or accession number.
                    </p>

                </div>

            @endif

        </div>

    </div>

</section>



{{-- =============================================================
    BOOK DETAILS MODAL
============================================================= --}}
<div
    class="book-modal"
    id="arrivalViewer"
    aria-hidden="true">

    {{-- BACKDROP --}}
    <div
        class="book-modal-backdrop"
        data-close-arrival-viewer>
    </div>


    {{-- DIALOG --}}
    <div
        class="book-modal-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="arrivalViewerTitle">


        {{-- CLOSE BUTTON --}}
        <button
            type="button"
            class="book-modal-close"
            data-close-arrival-viewer
            aria-label="Close book details">

            <i class="bi bi-x-lg"></i>

        </button>


        {{-- BOOK COVER --}}
        <div class="book-modal-cover">

            <img
                id="arrivalViewerImage"
                src="{{ asset('images/readingarea.jpg') }}"
                alt="Book cover">

        </div>


        {{-- BOOK DETAILS --}}
        <div class="book-modal-content">


            {{-- HEADER --}}
            <div class="book-modal-header">

                <span
                    class="book-modal-category"
                    id="arrivalViewerCategory">

                    New Arrival

                </span>


                <h2 id="arrivalViewerTitle">
                    Book Title
                </h2>


                <p class="book-modal-label">

                    <i class="bi bi-stars"></i>

                    Recently added to the MMACI Library

                </p>

            </div>


            {{-- =================================================
                MAIN INFORMATION
            ================================================== --}}
            <div class="book-information-grid">


                {{-- ACCESSION NUMBER --}}
                <div class="book-information-item">

                    <div class="book-information-icon">

                        <i class="bi bi-upc-scan"></i>

                    </div>

                    <div>

                        <small>
                            Accession Number
                        </small>

                        <strong id="arrivalViewerAccession">
                            —
                        </strong>

                    </div>

                </div>


                {{-- AUTHOR --}}
                <div class="book-information-item">

                    <div class="book-information-icon">

                        <i class="bi bi-person"></i>

                    </div>

                    <div>

                        <small>
                            Author
                        </small>

                        <strong id="arrivalViewerAuthor">
                            —
                        </strong>

                    </div>

                </div>


                {{-- DATE OF ARRIVAL --}}
                <div class="book-information-item book-date-item">

                    <div class="book-information-icon">

                        <i class="bi bi-calendar-check"></i>

                    </div>

                    <div>

                        <small>
                            Date of Arrival
                        </small>

                        <strong id="arrivalViewerArrivalDate">
                            —
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =================================================
                DESCRIPTION
            ================================================== --}}
            <div class="book-description">

                <h4>

                    <i class="bi bi-card-text"></i>

                    About this Book

                </h4>

                <p id="arrivalViewerDescription">

                    No description available.

                </p>

            </div>


            {{-- =================================================
                FOOTER
            ================================================== --}}
            <div class="book-modal-footer">

                <div class="book-modal-brand">

                    <img
                        src="{{ asset('images/logomml.webp') }}"
                        alt="MMACI Logo"
                        onerror="this.style.display='none';">

                    <div>

                        <strong>
                            MMACI Library
                        </strong>

                        <span>
                            Library Services Office
                        </span>

                    </div>

                </div>


                <span
                    class="book-modal-counter"
                    id="arrivalViewerCounter">
                </span>

            </div>

        </div>

    </div>

</div>



<style>

/* =============================================================
   VARIABLES
============================================================= */

:root {

    --arrival-navy: #0b2e59;
    --arrival-blue: #184b8c;
    --arrival-gold: #f4b400;

    --arrival-text: #17243a;
    --arrival-muted: #647187;

    --arrival-bg: #f4f7fb;
    --arrival-border: #dfe6ef;

    --arrival-white: #ffffff;

}



/* =============================================================
   HERO
============================================================= */

.arrivals-hero {

    min-height: 300px;

    display: flex;
    align-items: center;

    color: #ffffff;

    background:

        linear-gradient(
            105deg,
            rgba(7, 30, 61, .94),
            rgba(11, 46, 89, .88),
            rgba(24, 75, 140, .76)
        ),

        url("{{ asset('images/libraryphotojpg.jpg') }}")
        center / cover no-repeat;

}


.arrivals-hero-content {

    max-width: 760px;

    padding: 75px 0;

}


.arrivals-eyebrow {

    display: inline-flex;
    align-items: center;

    gap: 9px;

    color: var(--arrival-gold);

    font-size: 12px;
    font-weight: 800;

    letter-spacing: .12em;

    text-transform: uppercase;

}


.arrivals-eyebrow::before {

    content: "";

    width: 30px;
    height: 3px;

    background: var(--arrival-gold);

    border-radius: 20px;

}


.arrivals-hero h1 {

    margin: 15px 0 14px;

    font-size:
        clamp(42px, 6vw, 70px);

    font-weight: 900;

    line-height: 1;

    letter-spacing: -.04em;

}


.arrivals-hero p {

    max-width: 640px;

    margin: 0;

    color:
        rgba(255, 255, 255, .80);

    font-size: 16px;

    line-height: 1.8;

}



/* =============================================================
   CONTENT
============================================================= */

.arrivals-content {

    padding: 60px 0 80px;

    background:
        var(--arrival-bg);

}



/* =============================================================
   TOOLBAR
============================================================= */

.arrival-toolbar {

    display: flex;

    justify-content: space-between;
    align-items: flex-end;

    gap: 30px;

    margin-bottom: 35px;

}


.arrival-heading span {

    color:
        var(--arrival-blue);

    font-size: 11px;
    font-weight: 800;

    letter-spacing: .1em;

    text-transform: uppercase;

}


.arrival-heading h2 {

    margin: 5px 0 0;

    color:
        var(--arrival-navy);

    font-size:
        clamp(26px, 4vw, 38px);

    font-weight: 800;

}



/* =============================================================
   SEARCH
============================================================= */

.arrival-search-field {

    width:
        min(100%, 450px);

    display: flex;
    align-items: center;

    gap: 11px;

    padding:
        14px 17px;

    background: #ffffff;

    border:
        1px solid var(--arrival-border);

    border-radius: 14px;

    box-shadow:
        0 8px 25px
        rgba(11, 46, 89, .06);

    transition:
        border-color .2s ease,
        box-shadow .2s ease;

}


.arrival-search-field:focus-within {

    border-color:
        rgba(24, 75, 140, .45);

    box-shadow:
        0 0 0 4px
        rgba(24, 75, 140, .08);

}


.arrival-search-field i {

    flex-shrink: 0;

    color:
        var(--arrival-blue);

}


.arrival-search-field input {

    width: 100%;

    padding: 0;

    color:
        var(--arrival-text);

    background:
        transparent;

    border: 0;

    outline: 0;

    font-size: 13px;

}


.arrival-search-field input::placeholder {

    color: #9aa5b3;

}



/* =============================================================
   GRID
============================================================= */

.arrivals-grid {

    display: grid;

    grid-template-columns:
        repeat(
            4,
            minmax(0, 1fr)
        );

    gap: 24px;

}


.arrival-item {

    min-width: 0;

}



/* =============================================================
   BOOK CARD
============================================================= */

.arrival-card {

    width: 100%;
    height: 100%;

    display: flex;
    flex-direction: column;

    padding: 0;

    overflow: hidden;

    color: inherit;

    text-align: left;

    background: #ffffff;

    border:
        1px solid var(--arrival-border);

    border-radius: 18px;

    box-shadow:
        0 7px 22px
        rgba(11, 46, 89, .06);

    cursor: pointer;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;

}


.arrival-card:hover {

    transform:
        translateY(-6px);

    border-color:
        rgba(24, 75, 140, .28);

    box-shadow:
        0 18px 38px
        rgba(11, 46, 89, .13);

}


.arrival-card:focus-visible {

    outline:
        3px solid
        rgba(244, 180, 0, .55);

    outline-offset: 4px;

}



/* =============================================================
   COVER
============================================================= */

.arrival-cover {

    position: relative;

    width: 100%;

    aspect-ratio:
        3 / 4;

    overflow: hidden;

    background:
        #e5eaf0;

}


.arrival-cover img {

    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    transition:
        transform .35s ease;

}


.arrival-card:hover
.arrival-cover img {

    transform:
        scale(1.045);

}



/* OVERLAY */

.arrival-cover-overlay {

    position: absolute;

    inset: 0;

    display: flex;

    align-items: flex-end;
    justify-content: center;

    padding: 18px;

    opacity: 0;

    background:

        linear-gradient(
            to top,
            rgba(5, 20, 40, .82),
            transparent 55%
        );

    transition:
        opacity .25s ease;

}


.arrival-card:hover
.arrival-cover-overlay {

    opacity: 1;

}


.arrival-cover-overlay span {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding:
        8px 13px;

    color: #ffffff;

    background:
        rgba(11, 46, 89, .90);

    border:
        1px solid
        rgba(255, 255, 255, .22);

    border-radius: 50px;

    font-size: 10px;
    font-weight: 700;

    backdrop-filter:
        blur(5px);

}



/* =============================================================
   CARD BODY
============================================================= */

.arrival-body {

    flex: 1;

    display: flex;
    flex-direction: column;

    padding: 19px;

}


.arrival-meta-row {

    min-height: 25px;

    display: flex;

    justify-content: space-between;
    align-items: center;

    gap: 8px;

    margin-bottom: 10px;

}


.arrival-category {

    display: inline-flex;

    max-width: 72%;

    padding:
        5px 9px;

    overflow: hidden;

    color:
        var(--arrival-navy);

    background:
        rgba(244, 180, 0, .15);

    border-radius: 50px;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .04em;

    text-overflow: ellipsis;
    text-transform: uppercase;

    white-space: nowrap;

}


.arrival-date-short {

    flex-shrink: 0;

    color: #8995a5;

    font-size: 10px;
    font-weight: 700;

}


.arrival-body h3 {

    display: -webkit-box;

    overflow: hidden;

    margin:
        0 0 7px;

    color:
        var(--arrival-navy);

    font-size: 17px;
    font-weight: 800;

    line-height: 1.4;

    -webkit-box-orient:
        vertical;

    -webkit-line-clamp: 2;

}


.arrival-author {

    display: flex;

    align-items: center;

    gap: 5px;

    color: #798697;

    font-size: 11px;

}


.arrival-author i {

    color:
        var(--arrival-blue);

}


.arrival-body p {

    display: -webkit-box;

    overflow: hidden;

    margin:
        13px 0 20px;

    color:
        var(--arrival-muted);

    font-size: 12px;

    line-height: 1.7;

    -webkit-box-orient:
        vertical;

    -webkit-line-clamp: 3;

}



/* =============================================================
   CARD FOOTER
============================================================= */

.arrival-card-footer {

    display: flex;

    justify-content: space-between;
    align-items: center;

    gap: 10px;

    margin-top: auto;

    padding-top: 14px;

    border-top:
        1px solid #edf1f5;

}


.arrival-card-footer > span:first-child {

    color:
        var(--arrival-blue);

    font-size: 10px;
    font-weight: 800;

}


.arrival-arrow {

    width: 28px;
    height: 28px;

    display: grid;

    place-items: center;

    flex-shrink: 0;

    color:
        var(--arrival-blue);

    background:
        rgba(24, 75, 140, .08);

    border-radius: 50%;

    transition:
        background .2s ease,
        color .2s ease,
        transform .2s ease;

}


.arrival-card:hover
.arrival-arrow {

    color: #ffffff;

    background:
        var(--arrival-blue);

    transform:
        translateX(2px);

}



/* =============================================================
   EMPTY STATE
============================================================= */

.arrival-empty,
.arrival-no-results {

    grid-column:
        1 / -1;

    padding:
        70px 25px;

    text-align: center;

    background: #ffffff;

    border:
        1px solid var(--arrival-border);

    border-radius: 18px;

}


.empty-icon {

    width: 62px;
    height: 62px;

    display: grid;

    place-items: center;

    margin:
        0 auto 16px;

    color:
        var(--arrival-blue);

    background:
        rgba(24, 75, 140, .08);

    border-radius: 50%;

    font-size: 26px;

}


.arrival-empty h3,
.arrival-no-results h3 {

    margin:
        0 0 7px;

    color:
        var(--arrival-navy);

    font-size: 20px;
    font-weight: 800;

}


.arrival-empty p,
.arrival-no-results p {

    margin: 0;

    color:
        var(--arrival-muted);

}



/* =============================================================
   BOOK MODAL
============================================================= */

.book-modal {

    position: fixed;

    inset: 0;

    z-index: 1065;

    display: flex;

    align-items: flex-start;
    justify-content: center;

    padding: 24px;

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity .22s ease,
        visibility .22s ease;

}


.book-modal.is-open {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

}



/* BACKDROP */

.book-modal-backdrop {

    position: absolute;

    inset: 0;

    background:
        rgba(3, 14, 29, .78);

    backdrop-filter:
        blur(7px);

}



/* =============================================================
   MODAL DIALOG
============================================================= */

.book-modal-dialog {

    position: relative;

    z-index: 2;

    width:
        min(850px, 100%);

    max-height:
        calc(100vh - 48px);
    max-height:
        calc(100dvh - 48px);

    display: grid;

    grid-template-columns:
        290px minmax(0, 1fr);

    overflow: hidden;

    background: #ffffff;

    border-radius: 22px;

    box-shadow:
        0 30px 90px
        rgba(0, 0, 0, .38);
    pointer-events: auto;

    transform:
        translateY(15px)
        scale(.98);

    transition:
        transform .25s ease;

}


.book-modal.is-open
.book-modal-dialog {

    transform:
        translateY(0)
        scale(1);

}



/* =============================================================
   CLOSE BUTTON
============================================================= */

.book-modal-close {

    position: absolute;

    top: 14px;
    right: 14px;

    z-index: 10;

    width: 38px;
    height: 38px;

    display: grid;

    place-items: center;

    padding: 0;

    color:
        var(--arrival-navy);

    background:
        rgba(255, 255, 255, .96);

    border:
        1px solid
        rgba(11, 46, 89, .12);

    border-radius: 11px;

    box-shadow:
        0 6px 16px
        rgba(0, 0, 0, .12);

    cursor: pointer;

    transition:
        color .2s ease,
        background .2s ease,
        transform .2s ease;

}


.book-modal-close:hover {

    color: #ffffff;

    background:
        var(--arrival-navy);

    transform:
        rotate(4deg);

}



/* =============================================================
   MODAL COVER
============================================================= */

.book-modal-cover {

    min-height: 0;
    height: 100%;

    display: flex;

    align-items: center;
    justify-content: center;

    padding: 28px;

    overflow: auto;

    background:

        linear-gradient(
            145deg,
            #eaf0f7,
            #dfe8f3
        );

}


.book-modal-cover img {

    width: auto;

    max-width: 225px;
    max-height: min(62vh, 400px);

    display: block;

    object-fit: contain;

    border-radius: 8px;

    box-shadow:
        0 20px 40px
        rgba(11, 46, 89, .22);

}



/* =============================================================
   MODAL CONTENT
============================================================= */

.book-modal-content {

    min-width: 0;

    display: flex;

    flex-direction: column;

    max-height:
        calc(100vh - 48px);
    max-height:
        calc(100dvh - 48px);

    overflow-y: auto;
    overscroll-behavior: contain;

    padding:
        32px 32px 25px;

}



/* HEADER */

.book-modal-header {

    padding-right: 35px;

}


.book-modal-category {

    display: inline-flex;

    margin-bottom: 13px;

    padding:
        6px 10px;

    color:
        var(--arrival-navy);

    background:
        rgba(244, 180, 0, .17);

    border-radius: 50px;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .06em;

    text-transform: uppercase;

}


.book-modal-header h2 {

    margin:
        0 0 9px;

    color:
        var(--arrival-navy);

    font-size:
        clamp(23px, 3vw, 32px);

    font-weight: 900;

    line-height: 1.25;

    letter-spacing: -.02em;

}


.book-modal-label {

    display: flex;

    align-items: center;

    gap: 6px;

    margin: 0;

    color:
        var(--arrival-blue);

    font-size: 11px;
    font-weight: 700;

}


.book-modal-label i {

    color:
        var(--arrival-gold);

}



/* =============================================================
   BOOK INFORMATION
============================================================= */

.book-information-grid {

    display: grid;

    grid-template-columns:
        repeat(
            2,
            minmax(0, 1fr)
        );

    gap: 11px;

    margin:
        25px 0;

}


.book-information-item {

    display: flex;

    align-items: center;

    gap: 12px;

    min-width: 0;

    padding: 14px;

    background:
        #f7f9fc;

    border:
        1px solid #e3e9f0;

    border-radius: 13px;

}


.book-date-item {

    grid-column:
        1 / -1;

}


.book-information-icon {

    width: 40px;
    height: 40px;

    display: grid;

    place-items: center;

    flex-shrink: 0;

    color:
        var(--arrival-blue);

    background:
        #eaf0f8;

    border-radius: 10px;

    font-size: 15px;

}


.book-information-item > div:last-child {

    min-width: 0;

}


.book-information-item small {

    display: block;

    margin-bottom: 3px;

    color:
        #8995a5;

    font-size: 9px;
    font-weight: 700;

    letter-spacing: .02em;

    text-transform: uppercase;

}


.book-information-item strong {

    display: block;

    overflow: hidden;

    color:
        var(--arrival-navy);

    font-size: 12px;
    font-weight: 800;

    line-height: 1.4;

    text-overflow: ellipsis;

}



/* =============================================================
   DESCRIPTION
============================================================= */

.book-description {

    padding-top: 3px;

}


.book-description h4 {

    display: flex;

    align-items: center;

    gap: 7px;

    margin:
        0 0 10px;

    color:
        var(--arrival-navy);

    font-size: 13px;
    font-weight: 800;

}


.book-description h4 i {

    color:
        var(--arrival-blue);

}


.book-description p {

    margin: 0;

    color:
        var(--arrival-muted);

    font-size: 12px;

    line-height: 1.8;

}



/* =============================================================
   MODAL FOOTER
============================================================= */

.book-modal-footer {

    display: flex;

    justify-content: space-between;
    align-items: center;

    gap: 15px;

    margin-top: auto;

    padding-top: 25px;

}


.book-modal-brand {

    display: flex;

    align-items: center;

    gap: 9px;

}


.book-modal-brand img {

    width: 35px;
    height: 35px;

    object-fit: contain;

    background: #ffffff;

    border:
        1px solid #e7ebf0;

    border-radius: 50%;

}


.book-modal-brand strong {

    display: block;

    color:
        var(--arrival-navy);

    font-size: 10px;
    font-weight: 800;

}


.book-modal-brand span {

    display: block;

    color: #8a96a5;

    font-size: 8px;

}


.book-modal-counter {

    padding:
        6px 10px;

    color:
        var(--arrival-blue);

    background:
        rgba(24, 75, 140, .07);

    border-radius: 50px;

    font-size: 9px;
    font-weight: 800;

}



/* DISABLE BODY SCROLL */

body.arrival-viewer-open {

    overflow: hidden;

}



/* =============================================================
   TABLET
============================================================= */

@media (max-width: 1199px) {

    .arrivals-grid {

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

    }

}



@media (max-width: 991px) {

    .arrival-toolbar {

        align-items: stretch;

        flex-direction: column;

    }


    .arrival-search-field {

        width: 100%;

    }


    .arrivals-grid {

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

    }


    .book-modal-dialog {

        width:
            min(700px, 100%);

        grid-template-columns:
            245px
            minmax(0, 1fr);

    }


    .book-modal-cover {

        padding: 20px;

    }


    .book-modal-cover img {

        max-width: 195px;

    }


    .book-modal-content {

        padding:
            28px 25px 23px;

    }

}



/* =============================================================
   MOBILE
============================================================= */

@media (max-width: 650px) {

    .arrivals-hero {

        min-height: 240px;

    }


    .arrivals-hero-content {

        padding:
            55px 0;

    }


    .arrivals-content {

        padding:
            42px 0 60px;

    }


    .arrivals-grid {

        grid-template-columns:
            1fr;

        gap: 18px;

    }


    .arrival-card {

        max-width: 380px;

        margin:
            0 auto;

    }


    .arrival-cover-overlay {

        display: none;

    }


    /* MODAL */

    .book-modal {

        padding: 12px;

        align-items: flex-end;

    }


    .book-modal-dialog {

        width: 100%;

        max-height:
            calc(100dvh - 24px);

        display: block;

        overflow-y: auto;

        border-radius:
            20px;

    }


    .book-modal-cover {

        min-height: 0;

        height: 280px;

        padding:
            22px 45px 18px;

    }


    .book-modal-cover img {

        width: auto;

        max-width: 180px;
        max-height: 240px;

    }


    .book-modal-content {

        max-height: none;

        overflow: visible;

        padding:
            22px 19px 20px;

    }


    .book-modal-header {

        padding-right: 20px;

    }


    .book-modal-header h2 {

        font-size: 23px;

    }


    .book-information-grid {

        grid-template-columns:
            1fr;

        gap: 8px;

        margin:
            20px 0;

    }


    .book-date-item {

        grid-column: auto;

    }


    .book-modal-footer {

        margin-top: 20px;

    }

}



/* =============================================================
   EXTRA SMALL
============================================================= */

@media (max-width: 400px) {

    .arrival-body {

        padding: 17px;

    }


    .book-modal-cover {

        height: 250px;

    }


    .book-modal-cover img {

        max-height: 215px;

    }


    .book-modal-footer {

        align-items: flex-start;

        flex-direction: column;

    }

}

</style>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /* =====================================================
           ELEMENTS
        ====================================================== */

        const searchInput =
            document.getElementById(
                'arrivalSearch'
            );


        const arrivalCards =
            Array.from(
                document.querySelectorAll(
                    '.arrival-card-button'
                )
            );


        const noResults =
            document.getElementById(
                'arrivalNoResults'
            );


        const viewer =
            document.getElementById(
                'arrivalViewer'
            );



        /* =====================================================
           JSON PARSER
        ====================================================== */

        function parseJson(
            value,
            fallback = ''
        ) {

            if (
                value === undefined ||
                value === null ||
                value === ''
            ) {

                return fallback;

            }


            try {

                return JSON.parse(
                    value
                );

            }

            catch (error) {

                return value ||
                    fallback;

            }

        }



        /* =====================================================
           SEARCH
        ====================================================== */

        function filterArrivals() {

            if (!searchInput) {

                return;

            }


            const term =
                searchInput
                    .value
                    .trim()
                    .toLowerCase();


            let visibleCount = 0;


            arrivalCards.forEach(
                function (card) {

                    const searchableData = [

                        parseJson(
                            card.dataset.arrivalTitle,
                            ''
                        ),

                        parseJson(
                            card.dataset.arrivalAuthor,
                            ''
                        ),

                        parseJson(
                            card.dataset.arrivalAccession,
                            ''
                        ),

                        parseJson(
                            card.dataset.arrivalCategory,
                            ''
                        ),

                        parseJson(
                            card.dataset.arrivalDate,
                            ''
                        )

                    ]
                    .join(' ')
                    .toLowerCase();


                    const matches =
                        term === '' ||
                        searchableData.includes(
                            term
                        );


                    const item =
                        card.closest(
                            '.arrival-item'
                        );


                    if (item) {

                        item.style.display =
                            matches
                                ? ''
                                : 'none';

                    }


                    if (matches) {

                        visibleCount++;

                    }

                }
            );


            if (noResults) {

                noResults.classList.toggle(
                    'd-none',
                    visibleCount !== 0
                );

            }

        }


        if (searchInput) {

            searchInput.addEventListener(
                'input',
                filterArrivals
            );

        }



        /* =====================================================
           STOP IF NO BOOKS
        ====================================================== */

        if (
            !viewer ||
            arrivalCards.length === 0
        ) {

            return;

        }



        /* =====================================================
           MODAL ELEMENTS
        ====================================================== */

        const viewerImage =
            document.getElementById(
                'arrivalViewerImage'
            );


        const viewerTitle =
            document.getElementById(
                'arrivalViewerTitle'
            );


        const viewerCategory =
            document.getElementById(
                'arrivalViewerCategory'
            );


        const viewerAccession =
            document.getElementById(
                'arrivalViewerAccession'
            );


        const viewerAuthor =
            document.getElementById(
                'arrivalViewerAuthor'
            );


        const viewerArrivalDate =
            document.getElementById(
                'arrivalViewerArrivalDate'
            );


        const viewerDescription =
            document.getElementById(
                'arrivalViewerDescription'
            );


        const viewerCounter =
            document.getElementById(
                'arrivalViewerCounter'
            );


        const closeElements =
            viewer.querySelectorAll(
                '[data-close-arrival-viewer]'
            );


        let lastFocusedElement =
            null;



        /* =====================================================
           GET BOOK DATA
        ====================================================== */

        function getBookData(card) {

            return {

                title:
                    parseJson(
                        card.dataset.arrivalTitle,
                        'New Arrival'
                    ),

                author:
                    parseJson(
                        card.dataset.arrivalAuthor,
                        'Unknown Author'
                    ),

                accession:
                    parseJson(
                        card.dataset.arrivalAccession,
                        'Not assigned'
                    ),

                category:
                    parseJson(
                        card.dataset.arrivalCategory,
                        'Uncategorized'
                    ),

                arrivalDate:
                    parseJson(
                        card.dataset.arrivalDate,
                        'Not specified'
                    ),

                description:
                    parseJson(
                        card.dataset.arrivalDescription,
                        'No description available.'
                    ),

                image:
                    parseJson(
                        card.dataset.arrivalImage,
                        ''
                    )

            };

        }



        /* =====================================================
           RENDER BOOK
        ====================================================== */

        function renderBook(
            card,
            index
        ) {

            const book =
                getBookData(
                    card
                );


            viewerTitle.textContent =
                book.title ||
                'New Arrival';


            viewerCategory.textContent =
                book.category ||
                'Uncategorized';


            viewerAccession.textContent =
                book.accession ||
                'Not assigned';


            viewerAuthor.textContent =
                book.author ||
                'Unknown Author';


            viewerArrivalDate.textContent =
                book.arrivalDate ||
                'Not specified';


            viewerDescription.textContent =
                book.description ||
                'No description available.';


            viewerCounter.textContent =
                `${index + 1} of ${arrivalCards.length}`;


            viewerImage.src =
                book.image ||
                @json(
                    asset(
                        'images/readingarea.jpg'
                    )
                );


            viewerImage.alt =
                book.title ||
                'Book cover';

        }



        /* =====================================================
           OPEN MODAL
        ====================================================== */

        function openViewer(
            card,
            index
        ) {

            lastFocusedElement =
                card;


            renderBook(
                card,
                index
            );


            viewer.classList.add(
                'is-open'
            );


            viewer.setAttribute(
                'aria-hidden',
                'false'
            );


            document.body.classList.add(
                'arrival-viewer-open'
            );


            setTimeout(
                function () {

                    viewer
                        .querySelector(
                            '.book-modal-close'
                        )
                        ?.focus();

                },
                50
            );

        }



        /* =====================================================
           CLOSE MODAL
        ====================================================== */

        function closeViewer() {

            viewer.classList.remove(
                'is-open'
            );


            viewer.setAttribute(
                'aria-hidden',
                'true'
            );


            document.body.classList.remove(
                'arrival-viewer-open'
            );


            if (lastFocusedElement) {

                lastFocusedElement.focus();

            }

        }



        /* =====================================================
           CARD CLICK
        ====================================================== */

        arrivalCards.forEach(
            function (
                card,
                index
            ) {

                card.addEventListener(
                    'click',
                    function () {

                        openViewer(
                            card,
                            index
                        );

                    }
                );

            }
        );



        /* =====================================================
           CLOSE BUTTON / BACKDROP
        ====================================================== */

        closeElements.forEach(
            function (element) {

                element.addEventListener(
                    'click',
                    function () {

                        closeViewer();

                    }
                );

            }
        );



        /* =====================================================
           ESCAPE KEY
        ====================================================== */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape' &&
                    viewer.classList.contains(
                        'is-open'
                    )
                ) {

                    closeViewer();

                }

            }
        );



        /* =====================================================
           IMAGE FALLBACK
        ====================================================== */

        viewerImage.addEventListener(
            'error',
            function () {

                viewerImage.onerror =
                    null;


                viewerImage.src =
                    @json(
                        asset(
                            'images/readingarea.jpg'
                        )
                    );

            }
        );



        /* =====================================================
           INITIAL SEARCH
        ====================================================== */

        filterArrivals();

    }
);

</script>


<!-- =========================================================
     NEW ARRIVALS PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes arrivalsHeroEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 26px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes arrivalsEmptyPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.045);
        }
    }

    .arrivals-hero-content {
        animation: arrivalsHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    /* Scroll reveal */
    .arrivals-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 28px, 0);
        transition:
            opacity .7s cubic-bezier(.22, 1, .36, 1),
            transform .7s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--arrivals-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .arrivals-motion-reveal.arrivals-motion-left {
        transform: translate3d(-34px, 0, 0);
    }

    .arrivals-motion-reveal.arrivals-motion-right {
        transform: translate3d(34px, 0, 0);
    }

    .arrivals-motion-reveal.arrivals-motion-scale {
        transform: scale(.97);
    }

    .arrivals-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Toolbar */
    .arrival-toolbar {
        transition: transform .28s ease;
    }

    .arrival-search-field {
        transition:
            transform .22s ease,
            border-color .22s ease,
            box-shadow .22s ease;
    }

    .arrival-search-field:focus-within {
        transform: translateY(-2px);
    }

    /* Cards */
    .arrival-card {
        transition:
            transform .3s cubic-bezier(.22, 1, .36, 1),
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .arrival-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 44px rgba(11, 46, 89, .14);
    }

    .arrival-cover img {
        transition:
            transform .48s cubic-bezier(.22, 1, .36, 1),
            filter .48s ease;
    }

    .arrival-card:hover .arrival-cover img {
        transform: scale(1.06);
        filter: saturate(1.04);
    }

    .arrival-cover-overlay span {
        transform: translateY(8px);
        transition:
            transform .28s ease,
            opacity .28s ease;
    }

    .arrival-card:hover .arrival-cover-overlay span {
        transform: translateY(0);
    }

    .arrival-arrow {
        transition:
            background .22s ease,
            color .22s ease,
            transform .22s ease;
    }

    .arrival-card:hover .arrival-arrow {
        transform: translateX(4px) scale(1.04);
    }

    .arrival-category,
    .arrival-date-short {
        transition: transform .22s ease;
    }

    .arrival-card:hover .arrival-category,
    .arrival-card:hover .arrival-date-short {
        transform: translateY(-1px);
    }

    /* Empty states */
    .arrival-empty,
    .arrival-no-results {
        transition:
            transform .28s ease,
            box-shadow .28s ease;
    }

    .arrival-empty:hover,
    .arrival-no-results:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 34px rgba(11, 46, 89, .09);
    }

    .empty-icon {
        transition: transform .26s ease;
    }

    .arrival-empty:hover .empty-icon,
    .arrival-no-results:hover .empty-icon {
        animation: arrivalsEmptyPulse 1.2s ease-in-out infinite;
    }

    /* Modal polish */
    .book-modal-dialog {
        transition:
            transform .28s cubic-bezier(.22, 1, .36, 1),
            opacity .28s ease;
    }

    .book-modal.is-open .book-modal-cover img {
        animation: arrivalsModalCoverEnter .34s cubic-bezier(.22, 1, .36, 1) both;
    }

    @keyframes arrivalsModalCoverEnter {
        from {
            opacity: 0;
            transform: translateY(12px) scale(.97);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .book-information-item {
        transition:
            transform .22s ease,
            box-shadow .22s ease,
            border-color .22s ease;
    }

    .book-information-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 20px rgba(11, 46, 89, .07);
        border-color: rgba(24, 75, 140, .16);
    }

    .book-information-icon {
        transition:
            transform .22s ease,
            background .22s ease;
    }

    .book-information-item:hover .book-information-icon {
        transform: scale(1.06);
        background: rgba(24, 75, 140, .12);
    }

    .book-modal-close {
        transition:
            color .2s ease,
            background .2s ease,
            transform .2s ease;
    }

        .arrivals-motion-reveal,
        .arrivals-motion-reveal.arrivals-motion-left,
        .arrivals-motion-reveal.arrivals-motion-right,
        .arrivals-motion-reveal.arrivals-motion-scale {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        .arrival-toolbar,
        .arrival-search-field,
        .arrival-card,
        .arrival-cover img,
        .arrival-cover-overlay span,
        .arrival-arrow,
        .arrival-category,
        .arrival-date-short,
        .arrival-empty,
        .arrival-no-results,
        .empty-icon,
        .book-modal-dialog,
        .book-information-item,
        .book-information-icon,
        .book-modal-close {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const revealGroups = [
        { selector: '.arrival-toolbar', mode: '' },
        { selector: '.arrival-item', mode: '' },
        { selector: '.arrival-empty', mode: 'arrivals-motion-scale' },
        { selector: '.arrival-no-results', mode: 'arrivals-motion-scale' }
    ];

    const revealElements = [];

    revealGroups.forEach(function (group) {
        document.querySelectorAll(group.selector).forEach(function (element, index) {
            /*
             * Existing data-aos elements stay managed by AOS.
             * This avoids stacking transforms on the same node.
             */
            if (element.hasAttribute('data-aos')) {
                return;
            }

            const aosParent = element.closest('[data-aos]');
            if (aosParent && aosParent !== element) {
                return;
            }

            element.classList.add('arrivals-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 8) * 65, 390);
            element.style.setProperty('--arrivals-motion-delay', stagger + 'ms');

            revealElements.push(element);
        });
    });

    if (!('IntersectionObserver' in window)) {
        revealElements.forEach(function (element) {
            element.classList.add('is-visible');
        });
        return;
    }

    const observer = new IntersectionObserver(function (entries, instance) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-visible');
            instance.unobserve(entry.target);
        });
    }, {
        root: null,
        threshold: 0.1,
        rootMargin: '0px 0px -40px 0px'
    });

    revealElements.forEach(function (element) {
        observer.observe(element);
    });
});
</script>

<!-- =========================================================
     BOOK MODAL VIEWPORT / CLIPPING FIX
========================================================= -->
<style>
    /*
     * The global app layout animates <main> using transform.
     * A transformed ancestor changes how position: fixed behaves,
     * which is why the modal can appear pushed down / clipped.
     */
    main {
        transform: none !important;
    }

    .book-modal {
        position: fixed !important;
        inset: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        height: 100dvh !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        padding:
            clamp(12px, 2.5vh, 24px)
            clamp(12px, 2vw, 24px) !important;

        overflow-y: auto !important;
        overflow-x: hidden !important;

        z-index: 99999 !important;
        isolation: isolate;
    }

    .book-modal-backdrop {
        position: fixed !important;
        inset: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        height: 100dvh !important;
    }

    .book-modal-dialog {
        position: relative !important;
        width: min(850px, 100%) !important;
        max-height: calc(100dvh - 48px) !important;
        margin: auto !important;
        overflow: hidden !important;
    }

    .book-modal-content {
        max-height: calc(100dvh - 48px) !important;
        overflow-y: auto !important;
        overscroll-behavior: contain;
        scrollbar-gutter: stable;
    }

    .book-modal-cover {
        min-height: 0 !important;
        height: auto;
    }

    @media (min-width: 651px) {
        .book-modal-cover {
            min-height: 100% !important;
        }

        .book-modal-cover img {
            max-height: min(400px, calc(100dvh - 150px)) !important;
        }
    }

    @media (min-width: 651px) and (max-height: 760px) {
        .book-modal {
            padding-top: 14px !important;
            padding-bottom: 14px !important;
        }

        .book-modal-dialog {
            max-height: calc(100dvh - 28px) !important;
            grid-template-columns: 240px minmax(0, 1fr) !important;
        }

        .book-modal-content {
            max-height: calc(100dvh - 28px) !important;
            padding: 24px 26px 20px !important;
        }

        .book-modal-cover {
            padding: 22px !important;
        }

        .book-modal-cover img {
            max-width: 190px !important;
            max-height: calc(100dvh - 105px) !important;
        }

        .book-information-grid {
            margin: 18px 0 !important;
        }

        .book-modal-footer {
            padding-top: 18px !important;
        }
    }

    @media (max-width: 650px) {
        .book-modal {
            align-items: flex-end !important;
            padding: 10px !important;
        }

        .book-modal-dialog {
            width: 100% !important;
            max-height: calc(100dvh - 20px) !important;
            display: block !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            border-radius: 20px !important;
        }

        .book-modal-cover {
            min-height: 0 !important;
            height: 260px !important;
            padding: 20px 44px 16px !important;
        }

        .book-modal-cover img {
            width: auto !important;
            max-width: 175px !important;
            max-height: 225px !important;
        }

        .book-modal-content {
            max-height: none !important;
            overflow: visible !important;
        }
    }

    @media (max-width: 400px) {
        .book-modal-cover {
            height: 235px !important;
        }

        .book-modal-cover img {
            max-height: 200px !important;
        }
    }
</style>


@include('components.lisa-chatbox')

@endsection
