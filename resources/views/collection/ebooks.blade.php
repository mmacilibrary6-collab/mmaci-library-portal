@extends('layouts.app')

@section('title', 'Electronic Books | MMACI Library Services Office')

@section('content')

<section class="ebooks-hero">
    <div class="container">
        <div class="ebooks-hero-content">
            
            <h1>Electronic Books</h1>
            <p>
                Browse digital learning resources by academic program and
                access available materials through Google Drive.
            </p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Collection</li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Electronic Books
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="ebooks-intro">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">Explore by Program</span>
            <h2>Find resources for your course</h2>
            <p>
                Select an academic program to view its available folders and
                open the digital materials prepared for your studies.
            </p>
        </header>

        @if($programs->isNotEmpty())
            <div class="program-search">
                <i class="bi bi-search" aria-hidden="true"></i>

                <input
                    type="search"
                    id="programSearch"
                    placeholder="Search academic programs..."
                    autocomplete="off"
                    aria-label="Search academic programs">

                <button
                    type="button"
                    id="clearProgramSearch"
                    aria-label="Clear search">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>
            </div>
        @endif
    </div>
</section>

<section class="programs-section">
    <div class="container">
        <div class="row g-4" id="programGrid">
            @forelse($programs as $program)
                @php
                    $modalId = 'program-folders-modal-' . $program->id;
                    $programImage = $program->image_url
                        ?: asset('images/readingarea.jpg');
                    $folderCount = $program->folders->count();
                @endphp

                <div
                    class="col-xl-4 col-lg-4 col-md-6 program-item"
                    data-program-title="{{ strtolower($program->title) }}"
                    data-program-description="{{ strtolower($program->description ?? '') }}">

                    <article class="program-card">
                        <button
                            type="button"
                            class="program-card-button"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $modalId }}"
                            aria-label="View folders for {{ $program->title }}">

                            <div class="program-image">
                                <img
                                    src="{{ $programImage }}"
                                    alt="{{ $program->title }}"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">

                                <span class="folder-count">
                                    {{ $folderCount }}
                                    {{ \Illuminate\Support\Str::plural('Folder', $folderCount) }}
                                </span>
                            </div>

                            <div class="program-content">
                                <h3>{{ $program->title }}</h3>
                                <p>
                                    {{ $program->description
                                        ?: 'Browse available electronic books and digital learning resources for this academic program.' }}
                                </p>

                                <span class="program-action">
                                    {{ $program->folders->isNotEmpty()
                                        ? 'View available folders'
                                        : 'No folders available' }}
                                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </button>
                    </article>

                    <div
                        class="modal fade folder-modal"
                        id="{{ $modalId }}"
                        tabindex="-1"
                        aria-labelledby="{{ $modalId }}-label"
                        aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <span>Electronic Book Collection</span>
                                        <h4 class="modal-title" id="{{ $modalId }}-label">
                                            {{ $program->title }}
                                        </h4>
                                    </div>

                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close">
                                    </button>
                                </div>

                                <div class="modal-body">
                                    @if($program->folders->isNotEmpty())
                                        <div class="folder-list">
                                            @foreach(
                                                $program->folders->sortBy(
                                                    'title',
                                                    SORT_NATURAL | SORT_FLAG_CASE
                                                ) as $folder
                                            )
                                                <a
                                                    href="{{ $folder->drive_link }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="folder-link">

                                                    <span class="folder-link-copy">
                                                        <strong>{{ $folder->title }}</strong>
                                                        <small>
                                                            {{ $folder->description
                                                                ?: 'Open this electronic book folder' }}
                                                        </small>
                                                    </span>

                                                    <i
                                                        class="bi bi-box-arrow-up-right"
                                                        aria-hidden="true">
                                                    </i>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="folder-empty">
                                            <h5>No folders available</h5>
                                            <p>
                                                Electronic book folders for this
                                                program have not been added yet.
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="modal-footer">
                                    <span>
                                        {{ $folderCount }}
                                        {{ \Illuminate\Support\Str::plural('folder', $folderCount) }}
                                        available
                                    </span>

                                    <button
                                        type="button"
                                        class="modal-close-button"
                                        data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="program-empty">
                        <h3>No electronic book collections available</h3>
                        <p>
                            Academic programs and digital folders have not
                            been published yet. Please check again later.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <div id="searchEmptyState" class="search-empty d-none">
            <h4>No matching program found</h4>
            <p>Try another academic program name or keyword.</p>
        </div>
    </div>
</section>

<section class="ebooks-guide">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-5">
                <div class="guide-intro">
                    <span class="eyebrow">Using E-Books</span>
                    <h2>Access digital resources anywhere</h2>
                    <p>
                        Choose your academic program, open the appropriate
                        folder, and access its files through Google Drive.
                        Sign in using an account with permission to view the
                        selected resource.
                    </p>

                    <a href="{{ route('more.ask-librarian') }}" class="text-action">
                        Ask the Librarian
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="guide-steps">
                    <div class="guide-step">
                        <span>01</span>
                        <div>
                            <h3>Choose a program</h3>
                            <p>Search for your course or academic program.</p>
                        </div>
                    </div>

                    <div class="guide-step">
                        <span>02</span>
                        <div>
                            <h3>Open a folder</h3>
                            <p>Select the semester or resource folder you need.</p>
                        </div>
                    </div>

                    <div class="guide-step">
                        <span>03</span>
                        <div>
                            <h3>Access resources</h3>
                            <p>View the available files securely through Google Drive.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ebooks-cta">
    <div class="container">
        <div class="cta-panel">
            <div>
                <span>Need assistance?</span>
                <h2>Cannot find the digital material you need?</h2>
                <p>Let our library personnel help you locate the right resource.</p>
            </div>

            <a href="{{ route('more.ask-librarian') }}">
                Contact a Librarian
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

<style>
:root {
    --ebook-navy: #0b2e59;
    --ebook-blue: #184b8c;
    --ebook-gold: #f4b400;
    --ebook-ink: #17243a;
    --ebook-muted: #647187;
    --ebook-bg: #f4f7fb;
    --ebook-line: #dfe6ef;
    --ebook-white: #ffffff;
}

.ebooks-hero {
    position: relative;
    min-height: 440px;
    display: grid;
    place-items: center;
    overflow: hidden;
    color: var(--ebook-white);
    background-color: var(--ebook-navy);
    background:
        linear-gradient(
            105deg,
            rgba(7, 30, 61, .86) 0%,
            rgba(11, 46, 89, .68) 55%,
            rgba(24, 75, 140, .52) 100%
        ),
        url("{{ asset('images/ebookzs.jpg') }}") center center / cover no-repeat;
    isolation: isolate;
}

.ebooks-hero::after {
    content: "";
    position: absolute;
    right: -130px;
    bottom: -210px;
    width: 430px;
    height: 430px;
    border: 58px solid rgba(244, 180, 0, .1);
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
}

.ebooks-hero-content {
    position: relative;
    z-index: 1;
    max-width: 790px;
    margin: auto;
    padding: 95px 0 80px;
    text-align: center;
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--ebook-blue);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.eyebrow::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--ebook-gold);
    border-radius: 10px;
}

.eyebrow-light {
    color: var(--ebook-gold);
}

.ebooks-hero h1 {
    margin: 18px 0;
    font-size: clamp(45px, 6vw, 68px);
    font-weight: 800;
    line-height: 1.05;
    letter-spacing: -.045em;
}

.ebooks-hero p {
    max-width: 650px;
    margin: 0 auto 27px;
    color: rgba(255, 255, 255, .78);
    font-size: 17px;
    line-height: 1.75;
}

.ebooks-hero .breadcrumb {
    font-size: 13px;
}

.ebooks-hero .breadcrumb-item,
.ebooks-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, .6);
}

.ebooks-hero .breadcrumb-item a {
    color: var(--ebook-white);
    font-weight: 600;
    text-decoration: none;
}

.ebooks-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, .36);
}

.ebooks-intro {
    padding: 68px 0 24px;
    background: var(--ebook-bg);
}

.section-heading {
    max-width: 760px;
}

.section-heading h2,
.guide-intro h2 {
    margin: 14px 0;
    color: var(--ebook-navy);
    font-size: clamp(31px, 4vw, 45px);
    font-weight: 800;
    line-height: 1.14;
    letter-spacing: -.035em;
}

.section-heading p,
.guide-intro > p {
    margin: 0;
    color: var(--ebook-muted);
    font-size: 16px;
    line-height: 1.8;
}

.program-search {
    max-width: 620px;
    height: 52px;
    display: flex;
    align-items: center;
    margin-top: 27px;
    padding: 0 15px;
    background: var(--ebook-white);
    border: 1px solid var(--ebook-line);
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(11, 46, 89, .055);
}

.program-search > i {
    color: var(--ebook-blue);
}

.program-search input {
    min-width: 0;
    flex: 1;
    padding: 0 12px;
    color: var(--ebook-ink);
    background: transparent;
    border: 0;
    outline: 0;
    font: inherit;
    font-size: 14px;
}

.program-search button {
    width: 32px;
    height: 32px;
    display: grid;
    place-items: center;
    visibility: hidden;
    color: var(--ebook-muted);
    background: transparent;
    border: 0;
    border-radius: 7px;
    opacity: 0;
}

.program-search button.visible {
    visibility: visible;
    opacity: 1;
}

.programs-section {
    min-height: 340px;
    padding: 24px 0 68px;
    background: var(--ebook-bg);
}

.program-card {
    height: 100%;
    overflow: hidden;
    background: var(--ebook-white);
    border: 1px solid var(--ebook-line);
    border-radius: 22px;
    box-shadow: 0 12px 32px rgba(11, 46, 89, .065);
    transition: transform .3s ease, box-shadow .3s ease;
}

.program-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 18px 39px rgba(11, 46, 89, .11);
}

.program-card-button {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    padding: 0;
    overflow: hidden;
    color: inherit;
    background: transparent;
    border: 0;
    text-align: left;
}

.program-image {
    position: relative;
    width: 100%;
    height: 230px;
    overflow: hidden;
    background: #dfe6ef;
}

.program-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}

.program-card:hover .program-image img {
    transform: scale(1.035);
}

.folder-count {
    position: absolute;
    right: 16px;
    bottom: 16px;
    padding: 8px 11px;
    color: var(--ebook-white);
    background: rgba(11, 46, 89, .86);
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 8px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    backdrop-filter: blur(7px);
}

.program-content {
    display: flex;
    flex: 1;
    flex-direction: column;
    padding: 25px 26px 27px;
}

.program-content h3 {
    margin: 0 0 10px;
    color: var(--ebook-navy);
    font-size: 21px;
    font-weight: 800;
    line-height: 1.3;
}

.program-content p {
    margin: 0 0 20px;
    color: var(--ebook-muted);
    font-size: 13px;
    line-height: 1.7;
}

.program-action {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: auto;
    color: var(--ebook-blue);
    font-size: 12px;
    font-weight: 800;
}

.program-empty,
.search-empty {
    padding: 55px 24px;
    text-align: center;
    background: var(--ebook-white);
    border: 1px solid var(--ebook-line);
    border-radius: 18px;
}

.search-empty {
    margin-top: 20px;
}

.program-empty h3,
.search-empty h4 {
    margin: 0;
    color: var(--ebook-navy);
    font-size: 21px;
    font-weight: 800;
}

.program-empty p,
.search-empty p {
    max-width: 570px;
    margin: 8px auto 0;
    color: var(--ebook-muted);
}

.folder-modal .modal-content {
    overflow: hidden;
    border: 0;
    border-radius: 18px;
    box-shadow: 0 24px 70px rgba(11, 46, 89, .22);
    pointer-events: auto;
}

.folder-modal {
    z-index: 1065;
}

.folder-modal .modal-dialog {
    z-index: 2;
}

.folder-modal .modal-header {
    padding: 21px 23px;
    border-bottom: 1px solid var(--ebook-line);
}

.folder-modal .modal-header span {
    color: var(--ebook-blue);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.folder-modal .modal-title {
    margin-top: 3px;
    color: var(--ebook-navy);
    font-size: 20px;
    font-weight: 800;
}

.folder-modal .modal-body {
    max-height: 55vh;
    padding: 14px 20px;
    overflow-y: auto;
    overscroll-behavior: contain;
}

.folder-list {
    display: grid;
    gap: 8px;
}

.folder-link {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 15px;
    color: inherit;
    background: var(--ebook-bg);
    border: 1px solid var(--ebook-line);
    border-radius: 11px;
    text-decoration: none;
    transition: border-color .2s ease, background .2s ease;
}

.folder-link:hover {
    color: inherit;
    background: #eef4fb;
    border-color: #b8c9dd;
}

.folder-link-copy {
    min-width: 0;
    flex: 1;
}

.folder-link strong,
.folder-link small {
    display: block;
}

.folder-link strong {
    overflow: hidden;
    color: var(--ebook-navy);
    font-size: 14px;
    font-weight: 800;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.folder-link small {
    margin-top: 3px;
    overflow: hidden;
    color: var(--ebook-muted);
    font-size: 11px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.folder-link > i {
    flex-shrink: 0;
    color: var(--ebook-blue);
}

.folder-empty {
    padding: 40px 20px;
    text-align: center;
}

.folder-empty h5 {
    color: var(--ebook-navy);
    font-weight: 800;
}

.folder-empty p {
    margin: 8px 0 0;
    color: var(--ebook-muted);
}

.folder-modal .modal-footer {
    justify-content: space-between;
    padding: 14px 20px;
    background: var(--ebook-bg);
    border-top: 1px solid var(--ebook-line);
}

.folder-modal .modal-footer > span {
    color: var(--ebook-muted);
    font-size: 11px;
}

.modal-close-button {
    padding: 9px 16px;
    color: var(--ebook-white);
    background: var(--ebook-navy);
    border: 0;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
}

.ebooks-guide {
    padding: 68px 0;
    background: var(--ebook-white);
}

.guide-intro {
    position: sticky;
    top: 110px;
}

.text-action {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 24px;
    color: var(--ebook-blue);
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
}

.guide-steps {
    border-top: 1px solid var(--ebook-line);
}

.guide-step {
    display: grid;
    grid-template-columns: 44px 1fr;
    gap: 17px;
    padding: 22px 0;
    border-bottom: 1px solid var(--ebook-line);
}

.guide-step > span {
    color: var(--ebook-gold);
    font-size: 12px;
    font-weight: 800;
}

.guide-step h3 {
    margin: 0 0 6px;
    color: var(--ebook-ink);
    font-size: 18px;
    font-weight: 800;
}

.guide-step p {
    margin: 0;
    color: var(--ebook-muted);
    font-size: 14px;
    line-height: 1.65;
}

.ebooks-cta {
    padding: 0 0 68px;
    background: var(--ebook-white);
}

.cta-panel {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    padding: 38px 42px;
    color: var(--ebook-white);
    background: linear-gradient(115deg, var(--ebook-navy), var(--ebook-blue));
    border-radius: 22px;
}

.cta-panel > div {
    max-width: 700px;
}

.cta-panel span {
    color: var(--ebook-gold);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.cta-panel h2 {
    margin: 7px 0;
    font-size: clamp(25px, 3vw, 32px);
    font-weight: 800;
}

.cta-panel p {
    margin: 0;
    color: rgba(255, 255, 255, .7);
}

.cta-panel > a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-shrink: 0;
    padding: 13px 19px;
    color: var(--ebook-navy);
    background: var(--ebook-gold);
    border-radius: 9px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
}

@media (max-width: 991.98px) {
    .guide-intro {
        position: static;
        max-width: 650px;
    }

    .cta-panel {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (max-width: 767.98px) {
    .ebooks-hero {
        min-height: 400px;
    }

    .ebooks-hero-content {
        padding: 82px 0 70px;
    }

    .ebooks-intro {
        padding-top: 55px;
    }

    .programs-section {
        padding-bottom: 55px;
    }

    .ebooks-guide {
        padding: 55px 0;
    }

    .ebooks-cta {
        padding-bottom: 55px;
    }

    .cta-panel {
        padding: 31px 25px;
    }
}

@media (max-width: 575.98px) {
    .ebooks-hero h1 {
        font-size: 42px;
    }

    .ebooks-hero p {
        font-size: 15px;
    }

    .program-image {
        height: 210px;
    }

    .folder-modal .modal-dialog {
        margin: 12px;
    }

    .folder-modal .modal-footer {
        align-items: flex-start;
        flex-direction: column;
    }

    .modal-close-button,
    .cta-panel > a {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('programSearch');
    const clearButton = document.getElementById('clearProgramSearch');
    const programItems = document.querySelectorAll('.program-item');
    const emptyState = document.getElementById('searchEmptyState');

    if (!searchInput || !clearButton) {
        return;
    }

    function filterPrograms() {
        const searchValue = searchInput.value.toLowerCase().trim();
        let visiblePrograms = 0;

        programItems.forEach(function (item) {
            const title = item.dataset.programTitle || '';
            const description = item.dataset.programDescription || '';
            const matches =
                title.includes(searchValue) ||
                description.includes(searchValue);

            item.classList.toggle('d-none', !matches);

            if (matches) {
                visiblePrograms++;
            }
        });

        clearButton.classList.toggle('visible', searchValue.length > 0);

        if (emptyState) {
            emptyState.classList.toggle('d-none', visiblePrograms > 0);
        }
    }

    searchInput.addEventListener('input', filterPrograms);

    clearButton.addEventListener('click', function () {
        searchInput.value = '';
        searchInput.focus();
        filterPrograms();
    });
});
</script>


<!-- =========================================================
     ELECTRONIC BOOKS PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes ebookHeroEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 28px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes ebookHeroRingFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }
        50% {
            transform: translate3d(-13px, -13px, 0) rotate(4deg);
        }
    }

    @keyframes ebookModalEnter {
        from {
            opacity: 0;
            transform: translateY(14px) scale(.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .ebooks-hero-content {
        animation: ebookHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    .ebooks-hero::after {
        animation: ebookHeroRingFloat 7.5s ease-in-out infinite;
        will-change: transform;
    }

    /* Scroll reveal */
    .ebook-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
        transition:
            opacity .72s cubic-bezier(.22, 1, .36, 1),
            transform .72s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--ebook-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .ebook-motion-reveal.ebook-motion-left {
        transform: translate3d(-36px, 0, 0);
    }

    .ebook-motion-reveal.ebook-motion-right {
        transform: translate3d(36px, 0, 0);
    }

    .ebook-motion-reveal.ebook-motion-scale {
        transform: scale(.965);
    }

    .ebook-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Search */
    .program-search {
        transition:
            transform .24s ease,
            box-shadow .24s ease,
            border-color .24s ease;
    }

    .program-search:focus-within {
        transform: translateY(-2px);
        border-color: rgba(24, 75, 140, .3);
        box-shadow: 0 12px 30px rgba(11, 46, 89, .09);
    }

    .program-search button {
        transition:
            opacity .2s ease,
            visibility .2s ease,
            background .2s ease,
            transform .2s ease;
    }

    .program-search button:hover {
        background: rgba(24, 75, 140, .08);
        transform: scale(1.05);
    }

    /* Program cards */
    .program-card {
        transition:
            transform .32s cubic-bezier(.22, 1, .36, 1),
            box-shadow .32s ease,
            border-color .32s ease;
    }

    .program-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 46px rgba(11, 46, 89, .13);
        border-color: rgba(24, 75, 140, .18);
    }

    .program-image img {
        transition:
            transform .5s cubic-bezier(.22, 1, .36, 1),
            filter .5s ease;
    }

    .program-card:hover .program-image img {
        transform: scale(1.055);
        filter: saturate(1.04);
    }

    .folder-count {
        transition:
            transform .24s ease,
            background .24s ease;
    }

    .program-card:hover .folder-count {
        transform: translateY(-2px);
        background: rgba(24, 75, 140, .92);
    }

    .program-action i {
        transition: transform .24s ease;
    }

    .program-card:hover .program-action i {
        transform: translateX(5px);
    }

    /* Empty states */
    .program-empty,
    .search-empty {
        transition:
            transform .28s ease,
            box-shadow .28s ease,
            border-color .28s ease;
    }

    .program-empty:hover,
    .search-empty:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 34px rgba(11, 46, 89, .09);
        border-color: rgba(24, 75, 140, .16);
    }

    /* Folder modal */
    .folder-modal.show .modal-content {
        animation: ebookModalEnter .28s cubic-bezier(.22, 1, .36, 1) both;
    }

    .folder-link {
        transition:
            transform .22s ease,
            border-color .22s ease,
            background .22s ease,
            box-shadow .22s ease;
    }

    .folder-link:hover {
        transform: translateX(4px);
        box-shadow: 0 8px 18px rgba(11, 46, 89, .07);
    }

    .folder-link > i {
        transition: transform .22s ease;
    }

    .folder-link:hover > i {
        transform: translate(3px, -3px);
    }

    .modal-close-button {
        transition:
            transform .22s ease,
            background .22s ease,
            box-shadow .22s ease;
    }

    .modal-close-button:hover {
        transform: translateY(-2px);
        background: var(--ebook-blue);
        box-shadow: 0 8px 18px rgba(11, 46, 89, .14);
    }

    /* Guide */
    .text-action i {
        transition: transform .24s ease;
    }

    .text-action:hover i {
        transform: translateX(5px);
    }

    .guide-step {
        transition:
            transform .24s ease,
            background .24s ease;
    }

    .guide-step:hover {
        transform: translateX(5px);
        background: rgba(24, 75, 140, .025);
    }

    .guide-step > span {
        display: inline-block;
        transition:
            transform .23s ease,
            color .23s ease;
    }

    .guide-step:hover > span {
        transform: scale(1.08);
        color: var(--ebook-blue);
    }

    /* CTA */
    .cta-panel {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .cta-panel:hover {
        transform: translateY(-5px);
        box-shadow: 0 24px 54px rgba(11, 46, 89, .2);
    }

    .cta-panel > a {
        transition:
            transform .22s ease,
            box-shadow .22s ease;
    }

    .cta-panel > a:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(244, 180, 0, .22);
    }

    .cta-panel > a i {
        transition: transform .24s ease;
    }

    .cta-panel > a:hover i {
        transform: translateX(5px);
    }

        .ebook-motion-reveal,
        .ebook-motion-reveal.ebook-motion-left,
        .ebook-motion-reveal.ebook-motion-right,
        .ebook-motion-reveal.ebook-motion-scale {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        .program-search,
        .program-search button,
        .program-card,
        .program-image img,
        .folder-count,
        .program-action i,
        .program-empty,
        .search-empty,
        .folder-link,
        .folder-link > i,
        .modal-close-button,
        .text-action i,
        .guide-step,
        .guide-step > span,
        .cta-panel,
        .cta-panel > a,
        .cta-panel > a i {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const revealGroups = [
        { selector: '.ebooks-intro .section-heading', mode: '' },
        { selector: '.program-search', mode: '' },
        { selector: '.program-item', mode: '' },
        { selector: '.program-empty', mode: 'ebook-motion-scale' },
        { selector: '.search-empty', mode: 'ebook-motion-scale' },
        { selector: '.guide-intro', mode: 'ebook-motion-left' },
        { selector: '.guide-steps', mode: 'ebook-motion-right' },
        { selector: '.cta-panel', mode: '' }
    ];

    const revealElements = [];

    revealGroups.forEach(function (group) {
        document.querySelectorAll(group.selector).forEach(function (element, index) {
            if (element.hasAttribute('data-aos')) {
                return;
            }

            const aosParent = element.closest('[data-aos]');
            if (aosParent && aosParent !== element) {
                return;
            }

            element.classList.add('ebook-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 8) * 65, 390);
            element.style.setProperty('--ebook-motion-delay', stagger + 'ms');

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
     E-BOOK MODAL
     Bootstrap-centered modal with one scrollable content area.
========================================================= -->
<div id="ebookFolderModal" class="ebook-folder-overlay" hidden aria-hidden="true">
    <div class="ebook-folder-overlay-backdrop" data-ebook-modal-close aria-hidden="true"></div>

    <div class="ebook-folder-modal" role="dialog" aria-modal="true" aria-labelledby="ebookFolderModalTitle">
        <div class="ebook-folder-modal-content">
            <div class="ebook-folder-modal-header">
                <div>
                    <span>Electronic Book Collection</span>
                    <h3 id="ebookFolderModalTitle">E-Book Folders</h3>
                </div>
                <button type="button" class="ebook-folder-modal-close" data-ebook-modal-close aria-label="Close E-Book folders">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>
            </div>

            <div id="ebookFolderModalBody" class="ebook-folder-modal-body"></div>

            <div class="ebook-folder-modal-footer">
                <span id="ebookFolderModalCount">0 folders available</span>
                <button type="button" class="ebook-folder-modal-close-text" data-ebook-modal-close>
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.ebook-folder-overlay {
    position: fixed !important;
    top: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100dvh !important;
    z-index: 1070;
    display: grid;
    place-items: center;
    padding: 12px;
}

.ebook-folder-overlay[hidden] {
    display: none;
}

.ebook-folder-overlay-backdrop {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    background: rgba(6, 18, 36, .58);
    z-index: 0;
    pointer-events: auto;
}

.ebook-folder-modal {
    position: relative;
    z-index: 1;
    width: min(650px, calc(100vw - 24px));
    max-width: none;
    max-height: calc(100dvh - 24px);
    display: block;
    pointer-events: auto;
}

.ebook-folder-modal-content {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-height: calc(100dvh - 24px);
    overflow: hidden;
    background: #fff;
    border: 1px solid rgba(11, 46, 89, .09);
    border-radius: 18px;
    box-shadow: 0 28px 80px rgba(0, 0, 0, .30);
}

.ebook-folder-modal-header {
    flex: 0 0 auto;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 18px;
    padding: 20px 22px;
    color: #fff;
    background: radial-gradient(circle at 100% 0, rgba(244, 180, 0, .17), transparent 35%), linear-gradient(135deg, #0b2e59, #184b8c);
}

.ebook-folder-modal-header span {
    display: block;
    color: #f4b400;
    font-size: 8px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.ebook-folder-modal-header h3 {
    margin: 3px 0 0;
    color: #fff;
    font-size: 20px;
    font-weight: 800;
    line-height: 1.35;
}

.ebook-folder-modal-close {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    display: grid;
    place-items: center;
    padding: 0;
    color: #fff;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 10px;
}

.ebook-folder-modal-body {
    min-height: 0;
    flex: 1 1 auto;
    padding: 12px;
    overflow: auto;
    background: #f5f7fb;
    scrollbar-gutter: stable;
    overscroll-behavior: contain;
}

.ebook-folder-modal-footer {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 13px;
    background: #fff;
    border-top: 1px solid #dfe6ef;
}

.ebook-folder-modal-close-text {
    padding: 8px 13px;
    color: #fff;
    background: #0b2e59;
    border: 0;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 700;
}

.ebook-folder-modal-body .folder-list {
    display: grid;
    gap: 9px;
}

.ebook-folder-modal-body .folder-link {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 12px;
    align-items: center;
    padding: 13px 14px;
    color: inherit;
    background: #fff;
    border: 1px solid #dfe6ef;
    border-radius: 11px;
    text-decoration: none;
}

.ebook-folder-modal-body .folder-link strong {
    display: block;
    color: #0b2e59;
    font-size: 13px;
    font-weight: 800;
    line-height: 1.45;
    overflow-wrap: anywhere;
}

.ebook-folder-modal-body .folder-link small {
    display: -webkit-box;
    margin-top: 3px;
    overflow: hidden;
    color: #647187;
    font-size: 10px;
    line-height: 1.5;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.ebook-folder-modal-body .folder-link-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex: 0 0 auto;
    padding: 8px 10px;
    color: #184b8c;
    background: rgba(24, 75, 140, .08);
    border-radius: 8px;
    font-size: 10px;
    font-weight: 800;
}

@media (max-width: 575.98px) {
    .ebook-folder-overlay {
        padding: 6px;
    }

    .ebook-folder-modal {
        width: calc(100vw - 12px);
    }

    .ebook-folder-modal-content {
        max-height: calc(100dvh - 12px);
        border-radius: 14px;
    }

    .ebook-folder-modal-header {
        padding: 12px;
    }

    .ebook-folder-modal-header h3 {
        font-size: 17px;
    }

    .ebook-folder-modal-close {
        width: 34px;
        height: 34px;
        flex-basis: 34px;
    }

    .ebook-folder-modal-body {
        padding: 8px;
    }

    .ebook-folder-modal-body .folder-link {
        grid-template-columns: minmax(0, 1fr);
        gap: 8px;
        padding: 10px;
    }

    .ebook-folder-modal-body .folder-link-action {
        justify-content: center;
    }

    .ebook-folder-modal-footer {
        flex-direction: column;
        align-items: stretch;
        padding: 8px 10px;
    }

    .ebook-folder-modal-close-text {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('ebookFolderModal');
    const titleEl = document.getElementById('ebookFolderModalTitle');
    const bodyEl = document.getElementById('ebookFolderModalBody');
    const countEl = document.getElementById('ebookFolderModalCount');

    if (!modalEl || !titleEl || !bodyEl || !countEl) {
        return;
    }

    const originalParent = modalEl.parentElement;
    const originalNextSibling = modalEl.nextSibling;
    let lastFocused = null;

    function openFromPanel(panel, trigger) {
        if (!panel) return;

        lastFocused = trigger || null;

        const panelTitle = panel.querySelector('.program-folder-panel-header h4');
        const panelBody = panel.querySelector('.program-folder-panel-body');
        const panelCount = panel.querySelector('.program-folder-panel-footer > span');

        titleEl.textContent = panelTitle ? panelTitle.textContent.trim() : 'E-Book Folders';
        bodyEl.innerHTML = panelBody ? panelBody.innerHTML : '';
        countEl.textContent = panelCount ? panelCount.textContent.trim() : '0 folders available';

        if (modalEl.parentElement !== document.body) {
            document.body.appendChild(modalEl);
        }

        modalEl.style.position = 'fixed';
        modalEl.style.inset = '0';
        modalEl.style.width = '100vw';
        modalEl.style.height = '100dvh';
        modalEl.style.display = 'grid';
        modalEl.style.placeItems = 'center';
        modalEl.style.padding = window.matchMedia('(max-width: 575.98px)').matches ? '6px' : '12px';

        modalEl.hidden = false;
        modalEl.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';

        window.setTimeout(function () {
            modalEl.querySelector('.ebook-folder-modal-close')?.focus();
        }, 50);
    }

    function closeModal() {
        modalEl.hidden = true;
        modalEl.setAttribute('aria-hidden', 'true');
        modalEl.style.removeProperty('position');
        modalEl.style.removeProperty('inset');
        modalEl.style.removeProperty('width');
        modalEl.style.removeProperty('height');
        modalEl.style.removeProperty('display');
        modalEl.style.removeProperty('place-items');
        modalEl.style.removeProperty('padding');
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');

        bodyEl.innerHTML = '';

        if (originalParent && modalEl.parentElement !== originalParent) {
            if (originalNextSibling && originalNextSibling.parentNode === originalParent) {
                originalParent.insertBefore(modalEl, originalNextSibling);
            } else {
                originalParent.appendChild(modalEl);
            }
        }

        if (lastFocused) {
            lastFocused.focus();
        }
    }

    document.addEventListener('click', function (event) {
        const trigger = event.target.closest('.program-folder-toggle');

        if (trigger) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            const panelId = trigger.getAttribute('data-folder-target');
            openFromPanel(document.getElementById(panelId), trigger);
            return;
        }

        if (event.target.closest('[data-ebook-modal-close]')) {
            event.preventDefault();
            closeModal();
        }
    }, true);

    modalEl.addEventListener('click', function (event) {
        if (event.target === modalEl || event.target.classList.contains('ebook-folder-overlay-backdrop')) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modalEl.hidden) {
            closeModal();
        }
    });
});
</script>

@include('components.lisa-chatbox')

@endsection

