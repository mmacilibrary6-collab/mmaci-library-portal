@extends('layouts.app')

@section('title', 'E-Book Collection | MMACI Library Services Office')

@section('content')

<section class="ebooks-page">

    <section class="ebooks-hero">
        <div class="ebooks-hero-overlay"></div>

        <div class="container">
            <div class="ebooks-hero-content">


                <h1>E-Book Collection</h1>

                <p>
                    Browse e-book programs, open the folders under each program,
                    and access the drive links provided by the library admin.
                </p>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">Collection</li>
                        <li class="breadcrumb-item active" aria-current="page">E-Book Collection</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <section class="ebooks-intro">
        <div class="container">
            <header class="section-heading ebooks-motion-reveal">
                <span class="eyebrow">Explore by Program</span>
                <h2>Start with a program, then open its e-books</h2>
                <p>
                    Choose a program below to view the ebook folders linked to
                    it. Each folder opens directly to its Google Drive location.
                </p>
            </header>

            @if($programs->isNotEmpty())
                <div class="ebooks-search ebooks-motion-reveal">
                    <i class="bi bi-search" aria-hidden="true"></i>

                    <input
                        type="search"
                        id="ebookProgramSearch"
                        placeholder="Search e-book programs..."
                        autocomplete="off"
                        aria-label="Search e-book programs">

                    <button
                        type="button"
                        id="clearEbookProgramSearch"
                        aria-label="Clear search">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>
    </section>

    <section class="ebooks-section">
        <div class="container">
            <div class="row g-4" id="ebookProgramGrid">
                @forelse($programs as $program)
                    @php
                        $offcanvasId = 'ebook-folders-offcanvas-' . $program->id;
                        $programImage = $program->image_url;
                        $folderCount = $program->folders->count();
                    @endphp

                    <div class="col-xl-4 col-lg-4 col-md-6 ebook-item ebooks-motion-reveal"
                        data-program-title="{{ strtolower($program->title) }}"
                        data-program-description="{{ strtolower($program->description ?? '') }}">
                        <article class="ebook-card">
                            <button type="button"
                                class="ebook-card-button"
                                data-bs-toggle="modal"
                                data-bs-target="#{{ $offcanvasId }}"
                                aria-label="View ebook folders for {{ $program->title }}">
                                <div class="ebook-image">
                                    <img src="{{ $programImage }}"
                                        alt="{{ $program->title }}"
                                        loading="lazy">

                                    <span class="ebook-count">
                                        {{ $folderCount }}
                                        {{ \Illuminate\Support\Str::plural('Folder', $folderCount) }}
                                    </span>
                                </div>

                                <div class="ebook-content">
                                    <h3>{{ $program->title }}</h3>
                                    <p>
                                        {{ $program->description ?: 'Browse available e-book folders for this program.' }}
                                    </p>

                                    <span class="ebook-action">
                                        {{ $program->folders->isNotEmpty() ? 'View ebook folders' : 'No folders available' }}
                                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </button>
                        </article>

                        <div class="modal fade ebook-modal"
                            id="{{ $offcanvasId }}"
                            tabindex="-1"
                            aria-labelledby="{{ $offcanvasId }}-label"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl ebook-modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div>
                                            <span>E-Book Collection</span>
                                            <h4 class="modal-title" id="{{ $offcanvasId }}-label">
                                                {{ $program->title }}
                                            </h4>
                                        </div>

                                        <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        @if($program->folders->isNotEmpty())
                                            <div class="folder-search">
                                                <i class="bi bi-search" aria-hidden="true"></i>
                                                <input type="search"
                                                    class="folder-search-input"
                                                    placeholder="Search ebook folders..."
                                                    aria-label="Search ebook folders in {{ $program->title }}">
                                                <button type="button"
                                                    class="folder-search-clear"
                                                    aria-label="Clear ebook folder search">
                                                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                                                </button>
                                            </div>

                                            <div class="folder-list">
                                                @foreach($program->folders->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE) as $folder)
                                                        <a href="{{ $folder->drive_link }}"
                                                        role="button"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="folder-link"
                                                        data-folder-title="{{ strtolower($folder->title) }}">
                                                        <span class="folder-link-copy">
                                                            <strong>{{ $folder->title }}</strong>
                                                            <small>
                                                                {{ $folder->description ?: 'Open this e-book folder in Google Drive' }}
                                                            </small>
                                                        </span>

                                                        <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                                                    </a>
                                                @endforeach
                                            </div>

                                            <div class="folder-search-empty" hidden>
                                                <h5>No matching ebook folders</h5>
                                                <p>Try a different folder name or clear the search.</p>
                                            </div>
                                        @else
                                            <div class="folder-empty">
                                                <h5>No ebook folders available</h5>
                                                <p>
                                                    This program does not have any published e-book folders yet.
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

                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="ebook-empty ebooks-motion-reveal ebooks-motion-scale">
                            <div class="ebook-empty-icon">
                                <i class="bi bi-journal-bookmark" aria-hidden="true"></i>
                            </div>

                            <h3>No e-book programs available</h3>

                            <p>
                                Once the admin publishes e-book programs and folders,
                                they will appear here automatically.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div id="ebookSearchEmptyState" class="search-empty d-none">
                <h4>No matching program found</h4>
                <p>Try another program name or keyword.</p>
            </div>
        </div>
    </section>

</section>

@push('styles')
<style>
:root {
    --ebooks-navy: #0b2e59;
    --ebooks-blue: #184b8c;
    --ebooks-gold: #f4b400;
    --ebooks-text: #17243a;
    --ebooks-muted: #647187;
    --ebooks-bg: #f4f7fb;
    --ebooks-border: #dfe6ef;
    --ebooks-white: #ffffff;
}

.ebooks-hero {
    position: relative;
    min-height: 430px;
    display: grid;
    place-items: center;
    overflow: hidden;
    color: var(--ebooks-white);
    background:
        linear-gradient(105deg, rgba(7, 30, 61, .91), rgba(11, 46, 89, .76), rgba(24, 75, 140, .58)),
        url("{{ asset('images/books1.jpg') }}") center / cover no-repeat;
    isolation: isolate;
}

.ebooks-hero::after {
    content: "";
    position: absolute;
    right: -130px;
    bottom: -210px;
    width: 430px;
    height: 430px;
    border: 58px solid rgba(244, 180, 0, .10);
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
}

.ebooks-hero-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 70% 30%, rgba(255, 255, 255, .08), transparent 30%);
}

.ebooks-hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 820px;
    margin: auto;
    padding: 95px 15px 80px;
    text-align: center;
}

.ebooks-eyebrow,
.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--ebooks-gold);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.ebooks-eyebrow::before,
.eyebrow::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--ebooks-gold);
    border-radius: 20px;
}

.ebooks-hero h1 {
    margin: 18px 0 16px;
    font-size: clamp(45px, 6vw, 70px);
    font-weight: 900;
    line-height: 1.04;
    letter-spacing: -.045em;
}

.ebooks-hero p {
    max-width: 680px;
    margin: 0 auto 26px;
    color: rgba(255, 255, 255, .80);
    font-size: 16px;
    line-height: 1.75;
}

.ebooks-hero .breadcrumb {
    font-size: 13px;
}

.ebooks-hero .breadcrumb-item,
.ebooks-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, .60);
}

.ebooks-hero .breadcrumb-item a {
    color: var(--ebooks-white);
    font-weight: 700;
    text-decoration: none;
}

.ebooks-hero .breadcrumb-item a:hover {
    color: var(--ebooks-gold);
}

.ebooks-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, .38);
}

.ebooks-intro {
    padding: 70px 0 24px;
    background: var(--ebooks-bg);
}

.ebooks-search {
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
    max-width: 560px;
    margin-top: 28px;
    padding: 12px 14px;
    background: var(--ebooks-white);
    border: 1px solid var(--ebooks-border);
    border-radius: 16px;
    box-shadow: 0 10px 26px rgba(11, 46, 89, .06);
}

.ebooks-search i {
    color: var(--ebooks-blue);
}

.ebooks-search input {
    width: 100%;
    min-width: 0;
    border: 0;
    outline: 0;
    background: transparent;
    color: var(--ebooks-text);
    font-size: 15px;
}

.ebooks-search input::-webkit-search-cancel-button,
.ebooks-search input::-webkit-search-decoration {
    -webkit-appearance: none;
    appearance: none;
}

.ebooks-search button {
    display: grid;
    place-items: center;
    width: 34px;
    height: 34px;
    color: var(--ebooks-muted);
    background: #f1f5f9;
    border: 0;
    border-radius: 10px;
}

.ebooks-search button:hover {
    color: var(--ebooks-navy);
    background: #e7edf6;
}

.section-heading {
    max-width: 760px;
}

.section-heading h2 {
    margin: 13px 0 14px;
    color: var(--ebooks-navy);
    font-size: clamp(30px, 4vw, 44px);
    font-weight: 850;
    line-height: 1.15;
    letter-spacing: -.035em;
}

.section-heading p {
    margin: 0;
    color: var(--ebooks-muted);
    font-size: 16px;
    line-height: 1.8;
}

.ebooks-section {
    min-height: 420px;
    padding: 10px 0 85px;
    background: var(--ebooks-bg);
}

.ebook-item {
    display: flex;
}

.ebook-card {
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: var(--ebooks-white);
    border: 1px solid var(--ebooks-border);
    border-radius: 20px;
    box-shadow: 0 12px 32px rgba(11, 46, 89, .07);
}

.ebook-card-button {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    padding: 0;
    color: inherit;
    background: transparent;
    border: 0;
    text-align: left;
}

.ebook-image {
    position: relative;
    height: 230px;
    overflow: hidden;
    background: #dfe6ef;
}

.ebook-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ebook-count {
    position: absolute;
    right: 16px;
    bottom: 16px;
    padding: 8px 11px;
    color: var(--ebooks-white);
    background: rgba(11, 46, 89, .86);
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 8px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
}

.ebook-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 26px 28px 28px;
}

.ebook-content h3 {
    margin: 0 0 12px;
    color: var(--ebooks-navy);
    font-size: 24px;
    font-weight: 800;
}

.ebook-content p {
    flex: 1;
    margin: 0 0 18px;
    color: var(--ebooks-muted);
    font-size: 15px;
    line-height: 1.7;
}

.ebook-action {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    color: var(--ebooks-blue);
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
}

.folder-list {
    display: grid;
    gap: 12px;
}

.folder-search {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 16px;
}

.folder-search > i {
    position: absolute;
    left: 16px;
    color: var(--ebooks-blue);
}

.folder-search-input {
    width: 100%;
    padding: 13px 44px 13px 44px;
    color: var(--ebooks-text);
    background: #f8fafc;
    border: 1px solid var(--ebooks-border);
    border-radius: 12px;
    outline: 0;
}

.folder-search-input:focus {
    border-color: var(--ebooks-blue);
    box-shadow: 0 0 0 3px rgba(24, 75, 140, .12);
}

.folder-search-input::-webkit-search-cancel-button,
.folder-search-input::-webkit-search-decoration {
    -webkit-appearance: none;
    appearance: none;
}

.folder-search-clear {
    position: absolute;
    right: 10px;
    display: grid;
    width: 30px;
    height: 30px;
    place-items: center;
    color: var(--ebooks-muted);
    background: transparent;
    border: 0;
}

.folder-search-empty {
    padding: 36px 20px;
    text-align: center;
    background: #f8fafc;
    border: 1px dashed #c9d3e1;
    border-radius: 14px;
}

.folder-search-empty h5 {
    margin: 0 0 8px;
    color: var(--ebooks-navy);
    font-weight: 800;
}

.folder-search-empty p {
    margin: 0;
    color: var(--ebooks-muted);
}

.folder-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 16px 18px;
    color: var(--ebooks-text);
    background: #f8fafc;
    border: 1px solid var(--ebooks-border);
    border-radius: 14px;
    text-decoration: none;
}

.folder-link strong {
    display: block;
    margin-bottom: 4px;
    color: var(--ebooks-navy);
    font-size: 15px;
}

.folder-link small {
    color: var(--ebooks-muted);
    font-size: 13px;
    line-height: 1.45;
}

.folder-link i {
    color: var(--ebooks-blue);
    font-size: 16px;
}

.folder-empty,
.ebook-empty,
.search-empty {
    padding: 58px 28px;
    text-align: center;
    background: var(--ebooks-white);
    border: 1px dashed #c9d3e1;
    border-radius: 20px;
}

.ebook-empty-icon {
    width: 72px;
    height: 72px;
    display: grid;
    place-items: center;
    margin: 0 auto 20px;
    color: var(--ebooks-navy);
    background: rgba(244, 180, 0, .18);
    border-radius: 18px;
    font-size: 30px;
}

.ebook-empty h3,
.folder-empty h5,
.search-empty h4 {
    margin: 0 0 10px;
    color: var(--ebooks-navy);
    font-weight: 850;
}

.ebook-empty p,
.folder-empty p,
.search-empty p {
    margin: 0;
    color: var(--ebooks-muted);
    line-height: 1.75;
}

.ebook-modal .modal-content {
    border: 0;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 24px 54px rgba(11, 46, 89, .18);
}

.ebook-modal .modal-header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid var(--ebooks-border);
}

.ebook-modal .modal-header span {
    color: var(--ebooks-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.ebook-modal .modal-title {
    margin: 6px 0 0;
    color: var(--ebooks-navy);
    font-size: 22px;
    font-weight: 850;
}

.ebook-modal .modal-body {
    padding: 22px 24px;
}

.ebook-modal .modal-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 18px 24px 22px;
    border-top: 1px solid var(--ebooks-border);
}

.ebook-modal .modal-footer span {
    color: var(--ebooks-muted);
    font-size: 14px;
}

.ebook-modal .btn-close {
    box-shadow: none;
}

.modal-close-button {
    padding: 10px 16px;
    color: var(--ebooks-white);
    background: var(--ebooks-blue);
    border: 0;
    border-radius: 10px;
    font-weight: 700;
}

.folder-link {
    position: relative;
    z-index: 1;
    pointer-events: auto;
}

@keyframes ebooksHeroEnter {
    from { opacity: 0; transform: translate3d(0, 28px, 0); }
    to { opacity: 1; transform: translate3d(0, 0, 0); }
}

@keyframes ebooksHeroRingFloat {
    0%, 100% { transform: translate3d(0, 0, 0) rotate(0deg); }
    50% { transform: translate3d(-14px, -13px, 0) rotate(4deg); }
}

.ebooks-hero-content {
    animation: ebooksHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
}

.ebooks-hero::after {
    animation: ebooksHeroRingFloat 8s ease-in-out infinite;
    will-change: transform;
}

.ebooks-motion-reveal {
    opacity: 0;
    transform: translate3d(0, 30px, 0);
    transition: opacity .72s cubic-bezier(.22, 1, .36, 1), transform .72s cubic-bezier(.22, 1, .36, 1);
    transition-delay: var(--ebooks-motion-delay, 0ms);
    will-change: opacity, transform;
}

.ebooks-motion-reveal.ebooks-motion-scale {
    transform: scale(.965);
}

.ebooks-motion-reveal.is-visible {
    opacity: 1;
    transform: translate3d(0, 0, 0) scale(1);
}

@media (max-width: 767.98px) {
    .ebooks-hero {
        min-height: 360px;
    }

    .ebooks-hero-content {
        padding: 78px 12px 64px;
    }

    .ebooks-section {
        padding-bottom: 65px;
    }

    .ebook-content {
        padding: 22px 22px 24px;
    }

    .ebooks-search {
        max-width: none;
    }

    .ebook-modal .modal-dialog {
        width: 100%;
        max-width: 100%;
        height: 100%;
        margin: 0;
    }

    .ebook-modal .modal-content {
        height: 100vh;
        max-height: 100vh;
        border-radius: 0;
    }

    .ebook-modal .modal-body {
        padding: 18px 18px 20px;
        overflow-y: auto;
    }

    .ebook-modal .modal-header,
    .ebook-modal .modal-footer {
        padding-left: 18px;
        padding-right: 18px;
    }
}

@media (max-width: 575.98px) {
    .ebooks-hero h1 {
        font-size: 42px;
    }

    .ebooks-hero p {
        font-size: 14px;
    }

    .ebooks-hero .breadcrumb {
        display: none;
    }

    .folder-link {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (prefers-reduced-motion: reduce) {
    .ebooks-motion-reveal,
    .ebooks-hero-content,
    .ebooks-hero::after {
        opacity: 1 !important;
        transform: none !important;
        animation: none !important;
        transition: none !important;
    }
}

@media (min-width: 768px) {
    .ebook-modal .modal-dialog {
        width: min(calc(100vw - 32px), 1140px);
        max-width: min(calc(100vw - 32px), 1140px);
        margin: 1rem auto;
        height: calc(100vh - 2rem);
    }

    .ebook-modal .modal-content {
        height: 100%;
        max-height: calc(100vh - 2rem);
    }

    .ebook-modal .modal-body {
        overflow-y: auto;
    }
}
</style>
@endpush

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Keep Bootstrap modals outside the animated <main> stacking context.
    document.querySelectorAll('.ebook-modal').forEach(function (modal) {
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
    });

    const revealElements = document.querySelectorAll('.ebooks-motion-reveal');
    const searchInput = document.getElementById('ebookProgramSearch');
    const clearButton = document.getElementById('clearEbookProgramSearch');
    const programItems = document.querySelectorAll('.ebook-item');
    const searchEmptyState = document.getElementById('ebookSearchEmptyState');

    revealElements.forEach(function (element, index) {
        element.style.setProperty('--ebooks-motion-delay', Math.min(index * 90, 270) + 'ms');
    });

    if (searchInput) {
        const applySearch = function () {
            const searchValue = searchInput.value.trim().toLowerCase();
            let visibleItems = 0;

            programItems.forEach(function (item) {
                const title = item.dataset.programTitle || '';
                const description = item.dataset.programDescription || '';
                const matches = title.includes(searchValue) || description.includes(searchValue);

                item.style.display = matches ? '' : 'none';

                if (matches) {
                    visibleItems++;
                }
            });

            if (searchEmptyState) {
                searchEmptyState.classList.toggle('d-none', visibleItems !== 0);
            }
        };

        searchInput.addEventListener('input', applySearch);

        if (clearButton) {
            clearButton.addEventListener('click', function () {
                searchInput.value = '';
                searchInput.focus();
                applySearch();
            });
        }
    }

    document.querySelectorAll('.ebook-modal').forEach(function (modal) {
        const titleInput = modal.querySelector('.folder-search-input');
        const clearTitleSearch = modal.querySelector('.folder-search-clear');
        const folderLinks = modal.querySelectorAll('.folder-link');
        const noMatches = modal.querySelector('.folder-search-empty');

        if (!titleInput) {
            return;
        }

        const applyTitleSearch = function () {
            const searchValue = titleInput.value.trim().toLowerCase();
            let visibleTitles = 0;

            folderLinks.forEach(function (folderLink) {
                const matches = (folderLink.dataset.folderTitle || '').includes(searchValue);
                folderLink.hidden = !matches;

                if (matches) {
                    visibleTitles++;
                }
            });

            if (noMatches) {
                noMatches.hidden = visibleTitles !== 0;
            }
        };

        titleInput.addEventListener('input', applyTitleSearch);

        clearTitleSearch?.addEventListener('click', function () {
            titleInput.value = '';
            titleInput.focus();
            applyTitleSearch();
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
        threshold: .12,
        rootMargin: '0px 0px -40px 0px'
    });

    revealElements.forEach(function (element) {
        observer.observe(element);
    });
});
</script>

@include('components.lisa-chatbox')
@endsection
