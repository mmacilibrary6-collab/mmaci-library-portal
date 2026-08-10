@extends('layouts.app')

@section('title', 'New Arrivals | MMACI Library Services Office')

@section('content')

<section class="new-arrivals-page">

    <div class="arrivals-hero">
        <div class="container">
            <div class="arrivals-hero-content" data-aos="fade-up">

                <span class="arrivals-eyebrow">
                    Recently Added
                </span>

                <h1>New Arrivals</h1>

                <p>
                    Explore the newest printed books and learning resources
                    available at the MMACI Library Services Office.
                </p>

            </div>
        </div>
    </div>


    <div class="arrivals-content">

        <div class="container">

            {{-- SEARCH --}}
            @if(($arrivals ?? collect())->isNotEmpty())

                <div class="arrival-toolbar">

                    <div class="arrival-heading">
                        <span>Library Collection</span>
                        <h2>Browse New Arrivals</h2>
                    </div>

                    <div class="arrival-search-field">

                        <i class="bi bi-search" aria-hidden="true"></i>

                        <input
                            type="search"
                            id="arrivalSearch"
                            placeholder="Search title, accession number, or author..."
                            autocomplete="off"
                            aria-label="Search new arrivals">

                    </div>

                </div>

            @endif


            {{-- BOOK GRID --}}
            <div class="arrivals-grid" id="arrivalsGrid">

                @forelse($arrivals ?? [] as $book)

                    <div class="arrival-item" data-aos="fade-up">

                        <button
                            type="button"
                            class="arrival-card arrival-card-button"

                            data-arrival-index="{{ $loop->index }}"

                            data-arrival-title='@json($book->title)'

                            data-arrival-author='@json(
                                $book->author ?? "Unknown Author"
                            )'

                            data-arrival-accession='@json(
                                $book->accession_number ?? "Not assigned"
                            )'

                            data-arrival-category='@json(
                                $book->category ?? "Uncategorized"
                            )'

                            data-arrival-year='@json(
                                $book->publication_year ?? null
                            )'

                            data-arrival-publisher='@json(
                                $book->publisher ?? null
                            )'

                            data-arrival-description='@json(
                                $book->description ?? "No description available."
                            )'

                            data-arrival-image='@json($book->image_url)'

                            aria-label="View {{ $book->title }}"
                        >

                            <div class="arrival-cover">

                                <img
                                    src="{{ $book->image_url }}"
                                    alt="{{ $book->title }}"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">

                            </div>

                            <div class="arrival-body">

                                @if($book->category)

                                    <span class="arrival-category">
                                        {{ $book->category }}
                                    </span>

                                @endif

                                <h3>
                                    {{ $book->title }}
                                </h3>

                                <span class="arrival-author">
                                    {{ $book->author ?? 'Unknown Author' }}
                                </span>

                                <p>
                                    {{ \Illuminate\Support\Str::limit(
                                        $book->description ?? 'No description available.',
                                        100
                                    ) }}
                                </p>

                                <span class="arrival-view-text">

                                    View Details

                                    <i
                                        class="bi bi-arrow-up-right"
                                        aria-hidden="true">
                                    </i>

                                </span>

                            </div>

                        </button>

                    </div>

                @empty

                    <div class="arrival-empty">

                        <i class="bi bi-book"></i>

                        <h3>No new arrivals available</h3>

                        <p>
                            Newly added library resources will appear here.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- NO SEARCH RESULTS --}}
            @if(($arrivals ?? collect())->isNotEmpty())

                <div
                    class="arrival-no-results d-none"
                    id="arrivalNoResults">

                    <i class="bi bi-search"></i>

                    <h3>No matching arrivals found</h3>

                    <p>
                        Try searching by title, accession number, or author.
                    </p>

                </div>

            @endif

        </div>

    </div>

</section>


{{-- ARRIVAL DETAILS VIEWER --}}

<div
    class="arrival-viewer"
    id="arrivalViewer"
    aria-hidden="true">

    <div
        class="arrival-viewer-backdrop"
        data-close-arrival-viewer>
    </div>


    <div
        class="arrival-viewer-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="arrivalViewerTitle">

        <button
            type="button"
            class="viewer-close-button"
            data-close-arrival-viewer
            aria-label="Close arrival details">

            <i
                class="bi bi-x-lg"
                aria-hidden="true">
            </i>

        </button>


        <div class="viewer-image-panel">

            <img
                id="arrivalViewerImage"
                src="{{ asset('images/readingarea.jpg') }}"
                alt="New arrival">

        </div>


        <aside class="viewer-content-panel">

            <div class="viewer-brand">

                <img
                    src="{{ asset('images/logomml.png') }}"
                    alt="MMACI logo"
                    onerror="this.style.display='none';">

                <div>

                    <strong>
                        MMACI Library Services Office
                    </strong>

                    <span>
                        New Arrival
                    </span>

                </div>

            </div>


            <div class="viewer-copy">

                <span class="viewer-eyebrow">
                    Recently Added
                </span>

                <h3 id="arrivalViewerTitle"></h3>

                <p
                    class="viewer-author"
                    id="arrivalViewerAuthor">
                </p>

                <div
                    class="viewer-details"
                    id="arrivalViewerDetails">
                </div>

            </div>


            <div class="viewer-footer">

                <span id="arrivalViewerCounter"></span>

                <small>
                    Click outside or press Escape to close.
                </small>

            </div>

        </aside>

    </div>

</div>


<style>

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


/* =============================================
   HERO
============================================= */

.arrivals-hero {

    min-height: 300px;

    display: flex;
    align-items: center;

    color: #ffffff;

    background:

        linear-gradient(
            105deg,
            rgba(7, 30, 61, .93),
            rgba(11, 46, 89, .88),
            rgba(24, 75, 140, .75)
        ),

        url("{{ asset('images/libraryphotojpg.jpg') }}")
        center / cover no-repeat;

}


.arrivals-hero-content {

    max-width: 750px;

    padding: 75px 0;

}


.arrivals-eyebrow {

    display: inline-flex;
    align-items: center;
    gap: 10px;

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

    border-radius: 10px;

}


.arrivals-hero h1 {

    margin: 15px 0 14px;

    font-size: clamp(42px, 6vw, 70px);

    font-weight: 900;

    line-height: 1;

    letter-spacing: -.04em;

}


.arrivals-hero p {

    max-width: 640px;

    margin: 0;

    color: rgba(255,255,255,.78);

    font-size: 16px;

    line-height: 1.8;

}


/* =============================================
   CONTENT
============================================= */

.arrivals-content {

    padding: 60px 0 80px;

    background: var(--arrival-bg);

}


/* TOOLBAR */

.arrival-toolbar {

    display: flex;

    justify-content: space-between;
    align-items: flex-end;

    gap: 30px;

    margin-bottom: 35px;

}


.arrival-heading span {

    color: var(--arrival-blue);

    font-size: 11px;
    font-weight: 800;

    letter-spacing: .1em;
    text-transform: uppercase;

}


.arrival-heading h2 {

    margin: 6px 0 0;

    color: var(--arrival-navy);

    font-size: clamp(27px, 4vw, 38px);

    font-weight: 800;

}


/* SEARCH */

.arrival-search-field {

    width: min(100%, 460px);

    display: flex;
    align-items: center;

    gap: 12px;

    padding: 14px 17px;

    background: #ffffff;

    border: 1px solid var(--arrival-border);

    border-radius: 14px;

    box-shadow:
        0 8px 25px rgba(11,46,89,.06);

}


.arrival-search-field i {

    color: var(--arrival-blue);

    font-size: 16px;

}


.arrival-search-field input {

    width: 100%;

    border: 0;

    outline: 0;

    background: transparent;

    color: var(--arrival-text);

    font-size: 14px;

}


.arrival-search-field input::placeholder {

    color: #98a2b0;

}


/* =============================================
   BOOK GRID
============================================= */

.arrivals-grid {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 25px;

}


.arrival-item {

    min-width: 0;

}


.arrival-card {

    width: 100%;
    height: 100%;

    display: flex;
    flex-direction: column;

    padding: 0;

    overflow: hidden;

    text-align: left;

    background: #ffffff;

    border: 1px solid var(--arrival-border);

    border-radius: 18px;

    box-shadow:
        0 9px 25px rgba(11,46,89,.06);

    cursor: pointer;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;

}


.arrival-card:hover {

    transform: translateY(-5px);

    border-color:
        rgba(24,75,140,.25);

    box-shadow:
        0 16px 35px rgba(11,46,89,.12);

}


.arrival-card:focus-visible {

    outline:
        3px solid rgba(244,180,0,.55);

    outline-offset: 3px;

}


/* COVER */

.arrival-cover {

    width: 100%;

    aspect-ratio: 3 / 4;

    overflow: hidden;

    background: #e7ebf0;

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

    transform: scale(1.025);

}


/* CARD BODY */

.arrival-body {

    flex: 1;

    display: flex;
    flex-direction: column;

    padding: 20px;

}


.arrival-category {

    align-self: flex-start;

    margin-bottom: 9px;

    padding: 5px 9px;

    color: var(--arrival-navy);

    background:
        rgba(244,180,0,.14);

    border-radius: 50px;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .05em;

    text-transform: uppercase;

}


.arrival-body h3 {

    margin: 0 0 5px;

    color: var(--arrival-navy);

    font-size: 17px;

    font-weight: 800;

    line-height: 1.4;

}


.arrival-author {

    color: #7c899a;

    font-size: 11px;

}


.arrival-body p {

    display: -webkit-box;

    overflow: hidden;

    margin: 13px 0 18px;

    color: var(--arrival-muted);

    font-size: 12px;

    line-height: 1.7;

    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;

}


.arrival-view-text {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    margin-top: auto;

    color: var(--arrival-blue);

    font-size: 11px;

    font-weight: 800;

}


/* =============================================
   EMPTY STATES
============================================= */

.arrival-empty,
.arrival-no-results {

    grid-column: 1 / -1;

    padding: 70px 25px;

    text-align: center;

    background: #ffffff;

    border: 1px solid var(--arrival-border);

    border-radius: 18px;

}


.arrival-empty i,
.arrival-no-results i {

    display: block;

    margin-bottom: 15px;

    color: var(--arrival-blue);

    font-size: 38px;

}


.arrival-empty h3,
.arrival-no-results h3 {

    margin-bottom: 7px;

    color: var(--arrival-navy);

    font-size: 20px;

    font-weight: 800;

}


.arrival-empty p,
.arrival-no-results p {

    margin: 0;

    color: var(--arrival-muted);

}


/* =============================================
   VIEWER
============================================= */

.arrival-viewer {

    position: fixed;

    inset: 0;

    z-index: 9999;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 16px;

}


.arrival-viewer.is-open {

    display: flex;

}


.arrival-viewer-backdrop {

    position: absolute;

    inset: 0;

    background:
        rgba(3,14,29,.92);

    backdrop-filter: blur(8px);

}


.arrival-viewer-dialog {

    position: relative;

    z-index: 1;

    width: min(1100px, 100%);

    height: min(
        760px,
        calc(100vh - 32px)
    );

    display: grid;

    grid-template-columns:
        minmax(0, 1.25fr)
        minmax(320px, .8fr);

    overflow: hidden;

    background: #07101d;

    border:
        1px solid rgba(255,255,255,.14);

    border-radius: 22px;

    box-shadow:
        0 30px 90px rgba(0,0,0,.48);

}


.viewer-image-panel {

    min-width: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    overflow: hidden;

    background: #030810;

}


.viewer-image-panel img {

    width: 100%;
    height: 100%;

    display: block;

    object-fit: contain;

}


.viewer-content-panel {

    display: flex;

    flex-direction: column;

    padding: 28px;

    overflow-y: auto;

    color: #ffffff;

    background:

        radial-gradient(
            circle at 100% 0,
            rgba(244,180,0,.09),
            transparent 32%
        ),

        linear-gradient(
            165deg,
            #0b2e59,
            #071f3e
        );

}


.viewer-brand {

    display: flex;

    align-items: center;

    gap: 12px;

    padding-right: 45px;
    padding-bottom: 20px;

    border-bottom:
        1px solid rgba(255,255,255,.12);

}


.viewer-brand img {

    width: 46px;
    height: 46px;

    object-fit: contain;

    background: #ffffff;

    border-radius: 50%;

}


.viewer-brand strong {

    display: block;

    font-size: 13px;

    font-weight: 800;

}


.viewer-brand span {

    display: block;

    margin-top: 3px;

    color:
        rgba(255,255,255,.58);

    font-size: 10px;

}


.viewer-copy {

    padding: 28px 0;

}


.viewer-eyebrow {

    display: inline-flex;

    margin-bottom: 14px;

    padding: 6px 10px;

    color: var(--arrival-navy);

    background: var(--arrival-gold);

    border-radius: 50px;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: .08em;

    text-transform: uppercase;

}


.viewer-copy h3 {

    margin: 0 0 10px;

    color: #ffffff;

    font-size: clamp(
        25px,
        3vw,
        38px
    );

    font-weight: 900;

    line-height: 1.2;

}


.viewer-author {

    margin-bottom: 18px !important;

    color: var(--arrival-gold) !important;

    font-size: 14px !important;

    font-weight: 700;

}


.viewer-details {

    color:
        rgba(255,255,255,.76);

    font-size: 13px;

    line-height: 1.85;

    white-space: pre-line;

}


.viewer-footer {

    margin-top: auto;

    padding-top: 20px;

    border-top:
        1px solid rgba(255,255,255,.12);

}


.viewer-footer span {

    display: block;

    color: var(--arrival-gold);

    font-size: 11px;

    font-weight: 800;

}


.viewer-footer small {

    color:
        rgba(255,255,255,.5);

    font-size: 9px;

}


.viewer-close-button {

    position: absolute;

    top: 16px;
    right: 16px;

    z-index: 5;

    width: 42px;
    height: 42px;

    display: grid;

    place-items: center;

    color: #ffffff;

    background:
        rgba(7,31,62,.82);

    border:
        1px solid rgba(255,255,255,.2);

    border-radius: 12px;

    cursor: pointer;

}


.viewer-close-button:hover {

    background:
        rgba(24,75,140,.96);

}


body.arrival-viewer-open {

    overflow: hidden;

}


/* =============================================
   RESPONSIVE
============================================= */

@media (max-width: 1199px) {

    .arrivals-grid {

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

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
            repeat(2, minmax(0, 1fr));

    }


    .arrival-viewer-dialog {

        grid-template-columns: 1fr;

        grid-template-rows:
            minmax(0, 56%)
            minmax(0, 44%);

    }

}


@media (max-width: 575px) {

    .arrivals-hero {

        min-height: 240px;

    }


    .arrivals-hero-content {

        padding: 55px 0;

    }


    .arrivals-content {

        padding: 42px 0 60px;

    }


    .arrivals-grid {

        grid-template-columns: 1fr;

        gap: 18px;

    }


    .arrival-card {

        max-width: 360px;

        margin: auto;

    }


    .arrival-viewer {

        padding: 0;

    }


    .arrival-viewer-dialog {

        width: 100%;

        height: 100dvh;

        border: 0;

        border-radius: 0;

        grid-template-rows:
            minmax(0, 53%)
            minmax(0, 47%);

    }


    .viewer-content-panel {

        padding: 20px 18px;

    }

}

</style>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const searchInput =
            document.getElementById('arrivalSearch');

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


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        function filterArrivals() {

            const term =
                (
                    searchInput?.value || ''
                )
                .trim()
                .toLowerCase();


            let visibleCount = 0;


            arrivalCards.forEach(
                function (card) {

                    const data = [

                        card.dataset.arrivalTitle,

                        card.dataset.arrivalAuthor,

                        card.dataset.arrivalAccession,

                        card.dataset.arrivalCategory

                    ]
                    .join(' ')
                    .toLowerCase();


                    const match =
                        !term ||
                        data.includes(term);


                    const item =
                        card.closest(
                            '.arrival-item'
                        );


                    if (item) {

                        item.style.display =
                            match
                                ? ''
                                : 'none';

                    }


                    if (match) {

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


        searchInput?.addEventListener(
            'input',
            filterArrivals
        );


        /*
        |--------------------------------------------------------------------------
        | VIEWER
        |--------------------------------------------------------------------------
        */

        if (
            !viewer ||
            arrivalCards.length === 0
        ) {

            return;

        }


        const image =
            document.getElementById(
                'arrivalViewerImage'
            );

        const title =
            document.getElementById(
                'arrivalViewerTitle'
            );

        const author =
            document.getElementById(
                'arrivalViewerAuthor'
            );

        const details =
            document.getElementById(
                'arrivalViewerDetails'
            );

        const counter =
            document.getElementById(
                'arrivalViewerCounter'
            );

        const closeButtons =
            viewer.querySelectorAll(
                '[data-close-arrival-viewer]'
            );


        let currentIndex = 0;

        let lastFocusedElement = null;


        function parseJson(
            value,
            fallback
        ) {

            try {

                return JSON.parse(value);

            }

            catch (error) {

                return fallback;

            }

        }


        function readCard(card) {

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

                year:
                    parseJson(
                        card.dataset.arrivalYear,
                        ''
                    ),

                publisher:
                    parseJson(
                        card.dataset.arrivalPublisher,
                        ''
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


        function renderArrival(index) {

            currentIndex =
                Math.max(
                    0,
                    Math.min(
                        index,
                        arrivalCards.length - 1
                    )
                );


            const arrival =
                readCard(
                    arrivalCards[currentIndex]
                );


            image.src =
                arrival.image ||
                @json(asset('images/readingarea.jpg'));


            image.alt =
                arrival.title;


            title.textContent =
                arrival.title;


            author.textContent =
                arrival.author;


            let html = '';


            html += `
                <div>
                    <strong>Accession Number</strong><br>
                    ${escapeHtml(arrival.accession)}
                </div>
            `;


            html += `
                <div style="margin-top:14px;">
                    <strong>Category</strong><br>
                    ${escapeHtml(arrival.category)}
                </div>
            `;


            if (arrival.year) {

                html += `
                    <div style="margin-top:14px;">
                        <strong>Publication Year</strong><br>
                        ${escapeHtml(arrival.year)}
                    </div>
                `;

            }


            if (arrival.publisher) {

                html += `
                    <div style="margin-top:14px;">
                        <strong>Publisher</strong><br>
                        ${escapeHtml(arrival.publisher)}
                    </div>
                `;

            }


            html += `
                <div style="margin-top:20px;">
                    <strong>Description</strong><br>
                    ${escapeHtml(arrival.description)}
                </div>
            `;


            details.innerHTML = html;


            counter.textContent =
                `${currentIndex + 1} of ${arrivalCards.length}`;

        }


        function escapeHtml(value) {

            const element =
                document.createElement('div');

            element.textContent =
                value ?? '';

            return element.innerHTML;

        }


        function openViewer(
            index,
            trigger
        ) {

            lastFocusedElement =
                trigger;


            renderArrival(index);


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
                            '.viewer-close-button'
                        )
                        ?.focus();

                },
                20
            );

        }


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


            lastFocusedElement?.focus();

        }


        arrivalCards.forEach(
            function (
                card,
                index
            ) {

                card.addEventListener(
                    'click',
                    function () {

                        openViewer(
                            index,
                            card
                        );

                    }
                );

            }
        );


        closeButtons.forEach(
            function (button) {

                button.addEventListener(
                    'click',
                    closeViewer
                );

            }
        );


        image.addEventListener(
            'error',
            function () {

                image.src =
                    @json(
                        asset(
                            'images/readingarea.jpg'
                        )
                    );

            }
        );


        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    !viewer.classList.contains(
                        'is-open'
                    )
                ) {

                    return;

                }


                if (
                    event.key === 'Escape'
                ) {

                    closeViewer();

                }

            }
        );


        filterArrivals();

    }
);

</script>

@include('components.lisa-chatbox')

@endsection