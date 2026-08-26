@extends('layouts.app')

@section('title', 'Periodical Collection | MMACI Library Services Office')

@section('content')
<section class="theses-hero">
    <div class="container">
        <div class="theses-hero-content">
            <h1>Periodical Collection</h1>
            <p>Browse journal and newspaper clipping programs, plus magazines, with their folder links.</p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Collection</li>
                    <li class="breadcrumb-item active" aria-current="page">Periodical Collection</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="theses-intro">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">Explore by Category</span>
            <h2>Find periodicals for your needs</h2>
            <p>Select a category below to view its available folder links.</p>
        </header>

        @if($programs->isNotEmpty())
            <div class="periodical-program-search">
                <i class="bi bi-search" aria-hidden="true"></i>
                <input
                    type="search"
                    id="periodicalProgramSearch"
                    placeholder="Search periodical programs..."
                    autocomplete="off"
                    aria-label="Search periodical programs">
                <button
                    type="button"
                    id="clearPeriodicalProgramSearch"
                    aria-label="Clear program search">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>
            </div>
        @endif

        <form method="GET" action="{{ route('collection.periodicals') }}" class="periodical-filter">
            <div class="filter-chip-group" role="tablist" aria-label="Periodical categories">
                <button type="submit" name="category" value="" class="filter-chip {{ blank($selectedCategory ?? null) ? 'active' : '' }}">All Categories</button>
                <button type="submit" name="category" value="journal_newspaper" class="filter-chip {{ ($selectedCategory ?? null) === 'journal_newspaper' ? 'active' : '' }}">Journal &amp; Newspaper Clippings</button>
                <button type="submit" name="category" value="magazine" class="filter-chip {{ ($selectedCategory ?? null) === 'magazine' ? 'active' : '' }}">Magazines</button>
            </div>
        </form>
    </div>
</section>

<section class="programs-section">
    <div class="container">
        <div class="row g-4" id="periodicalProgramGrid">
            @forelse($programs as $program)
                @php
                    $modalId = 'periodical-folders-modal-' . $program->id;
                    $programImage = $program->image_url;
                    $folderCount = $program->folders->count();
                @endphp

                <div class="col-xl-4 col-lg-4 col-md-6 program-item"
                    data-program-title="{{ strtolower($program->title) }}"
                    data-program-description="{{ strtolower($program->description ?? '') }}">
                    <article class="program-card">
                        <button type="button" class="program-card-button" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                            <div class="program-image">
                                <img src="{{ $programImage }}" alt="{{ $program->title }}" loading="lazy">
                                <span class="folder-count">{{ $folderCount }} {{ \Illuminate\Support\Str::plural('Folder', $folderCount) }}</span>
                            </div>
                            <div class="program-content">
                                <h3>{{ $program->title }}</h3>
                                <p>{{ $program->description ?: 'Browse available folder links for this periodical program.' }}</p>
                                <span class="program-action">
                                    {{ $program->folders->isNotEmpty() ? 'View available folders' : 'No folders available' }}
                                    <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </button>
                    </article>

                    <div class="modal fade folder-modal" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl periodical-modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div>
                                        <span>Periodical Collection</span>
                                        <h4 class="modal-title">{{ $program->title }}</h4>
                                    </div>
                                    <button type="button" class="periodical-modal-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="collection-folder-search {{ $program->folders->isEmpty() ? 'is-disabled' : '' }}">
                                        <i class="bi bi-search" aria-hidden="true"></i>
                                        <input
                                            type="search"
                                            class="collection-folder-search-input"
                                            placeholder="{{ $program->folders->isNotEmpty() ? 'Search periodical folder titles...' : 'No folder titles available to search' }}"
                                            aria-label="Search periodical folder titles in {{ $program->title }}"
                                            @disabled($program->folders->isEmpty())>
                                        <button
                                            type="button"
                                            class="collection-folder-search-clear"
                                            aria-label="Clear folder title search"
                                            @disabled($program->folders->isEmpty())>
                                            <i class="bi bi-x-lg" aria-hidden="true"></i>
                                        </button>
                                    </div>

                                    @if($program->folders->isNotEmpty())
                                        @php
                                            $groupedFolders = $program->folders->groupBy('category');
                                        @endphp
                                        <div class="folder-list">
                                            @foreach($groupedFolders as $category => $categoryFolders)
                                                <div class="folder-category-group">
                                                    <h5>{{ $categoryFolders->first()?->categoryLabel() ?? 'Periodical' }}</h5>
                                                    <div class="folder-list">
                                                        @foreach($categoryFolders->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE) as $folder)
                                                            <a href="{{ $folder->folder_link }}" target="_blank" rel="noopener noreferrer" class="folder-link" data-folder-title="{{ strtolower($folder->title) }}">
                                                                <span class="folder-link-copy">
                                                                    <strong>{{ $folder->title }}</strong>
                                                                    <small>{{ $folder->description ?: 'Open this folder link' }}</small>
                                                                </span>
                                                                <i class="bi bi-box-arrow-up-right"></i>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="collection-folder-search-empty" hidden>
                                            <h5>No matching titles</h5>
                                            <p>Try a different title or clear the search.</p>
                                        </div>
                                    @else
                                        <div class="folder-empty">
                                            <h5>No folders available</h5>
                                            <p>This program has not been assigned folder links yet.</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <span>{{ $folderCount }} {{ \Illuminate\Support\Str::plural('folder', $folderCount) }} available</span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="program-empty">
                        <h3>No periodical collections available</h3>
                        <p>Please check again later.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div id="periodicalProgramSearchEmpty" class="program-search-empty" hidden>
            <i class="bi bi-search" aria-hidden="true"></i>
            <h3>No matching periodical program</h3>
            <p>Try another program name or clear the search.</p>
        </div>
    </div>
</section>


<!-- =========================================================
     PERIODICAL COLLECTION PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes periodicalHeroEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 28px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes periodicalHeroRingFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }
        50% {
            transform: translate3d(-13px, -13px, 0) rotate(4deg);
        }
    }

    @keyframes periodicalModalEnter {
        from {
            opacity: 0;
            transform: translateY(14px) scale(.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .theses-hero-content {
        animation: periodicalHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    .theses-hero::after {
        animation: periodicalHeroRingFloat 7.5s ease-in-out infinite;
        will-change: transform;
    }

    /* Scroll reveal */
    .periodical-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
        transition:
            opacity .72s cubic-bezier(.22, 1, .36, 1),
            transform .72s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--periodical-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .periodical-motion-reveal.periodical-motion-left {
        transform: translate3d(-36px, 0, 0);
    }

    .periodical-motion-reveal.periodical-motion-right {
        transform: translate3d(36px, 0, 0);
    }

    .periodical-motion-reveal.periodical-motion-scale {
        transform: scale(.965);
    }

    .periodical-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Filter chips */
    .filter-chip {
        transition:
            transform .22s ease,
            color .22s ease,
            background .22s ease,
            border-color .22s ease,
            box-shadow .22s ease;
    }

    .filter-chip:hover,
    .filter-chip.active {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(24, 75, 140, .12);
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

    /* Empty state */
    .program-empty {
        transition:
            transform .28s ease,
            box-shadow .28s ease,
            border-color .28s ease;
    }

    .program-empty:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 34px rgba(11, 46, 89, .09);
        border-color: rgba(24, 75, 140, .16);
    }

    /* Folder modal */
    .folder-modal.show .modal-content {
        animation: periodicalModalEnter .28s cubic-bezier(.22, 1, .36, 1) both;
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
        background: #eef4fb;
        border-color: #b8c9dd;
        box-shadow: 0 8px 18px rgba(11, 46, 89, .07);
    }

    .folder-link > i {
        transition: transform .22s ease;
    }

    .folder-link:hover > i {
        transform: translate(3px, -3px);
    }

    .folder-category-group h5 {
        transition:
            transform .22s ease,
            color .22s ease;
    }

    .folder-category-group:hover h5 {
        transform: translateX(2px);
        color: var(--thesis-blue);
    }

    .modal-close-button {
        transition:
            transform .22s ease,
            background .22s ease,
            box-shadow .22s ease;
    }

    .modal-close-button:hover {
        transform: translateY(-2px);
        background: var(--thesis-blue);
        box-shadow: 0 8px 18px rgba(11, 46, 89, .14);
    }

        .periodical-motion-reveal,
        .periodical-motion-reveal.periodical-motion-left,
        .periodical-motion-reveal.periodical-motion-right,
        .periodical-motion-reveal.periodical-motion-scale {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        .filter-chip,
        .program-card,
        .program-image img,
        .folder-count,
        .program-action i,
        .program-empty,
        .folder-link,
        .folder-link > i,
        .folder-category-group h5,
        .modal-close-button {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const programSearch = document.getElementById('periodicalProgramSearch');
    const programSearchClear = document.getElementById('clearPeriodicalProgramSearch');
    const programItems = document.querySelectorAll('#periodicalProgramGrid .program-item');
    const programSearchEmpty = document.getElementById('periodicalProgramSearchEmpty');

    const filterPrograms = function () {
        if (!programSearch) return;

        const query = programSearch.value.trim().toLowerCase();
        let visible = 0;

        programItems.forEach(function (item) {
            const searchableText = [
                item.dataset.programTitle || '',
                item.dataset.programDescription || ''
            ].join(' ');
            const matches = searchableText.includes(query);

            item.hidden = !matches;
            if (matches) visible++;
        });

        if (programSearchEmpty) {
            programSearchEmpty.hidden = visible !== 0 || query === '';
        }

        if (programSearchClear) {
            programSearchClear.classList.toggle('is-visible', query !== '');
        }
    };

    programSearch?.addEventListener('input', filterPrograms);
    programSearchClear?.addEventListener('click', function () {
        programSearch.value = '';
        programSearch.focus();
        filterPrograms();
    });

    document.querySelectorAll('.folder-modal').forEach(function (modal) {
        const input = modal.querySelector('.collection-folder-search-input');
        const clear = modal.querySelector('.collection-folder-search-clear');
        const links = modal.querySelectorAll('.folder-link');
        const empty = modal.querySelector('.collection-folder-search-empty');

        if (!input) return;

        const filter = function () {
            const query = input.value.trim().toLowerCase();
            let visible = 0;
            links.forEach(function (link) {
                const matches = (link.dataset.folderTitle || '').includes(query);
                link.hidden = !matches;
                if (matches) visible++;
            });
            if (empty) empty.hidden = visible !== 0;
            clear?.classList.toggle('is-visible', query !== '');
        };

        input.addEventListener('input', filter);
        clear?.addEventListener('click', function () {
            input.value = '';
            input.focus();
            filter();
        });
    });

    const revealGroups = [
        { selector: '.theses-intro .section-heading', mode: '' },
        { selector: '.periodical-filter', mode: '' },
        { selector: '.program-item', mode: '' },
        { selector: '.program-empty', mode: 'periodical-motion-scale' }
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

            element.classList.add('periodical-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 8) * 65, 390);
            element.style.setProperty('--periodical-motion-delay', stagger + 'ms');

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



<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.folder-modal').forEach(function (modal) {
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
    });
});
</script>

@endsection

@push('styles')
<style>
:root {
    --thesis-navy: #0b2e59;
    --thesis-blue: #184b8c;
    --thesis-gold: #f4b400;
    --thesis-ink: #17243a;
    --thesis-muted: #647187;
    --thesis-bg: #f4f7fb;
    --thesis-line: #dfe6ef;
    --thesis-white: #ffffff;
}

.theses-hero {
    position: relative;
    min-height: 440px;
    display: grid;
    place-items: center;
    overflow: hidden;
    color: var(--thesis-white);
    background:
        linear-gradient(105deg, rgba(7, 30, 61, .86) 0%, rgba(11, 46, 89, .68) 55%, rgba(24, 75, 140, .52) 100%),
        url("{{ asset('images/books1.jpg') }}") center center / cover no-repeat;
}

.theses-hero::after {
    content: "";
    position: absolute;
    right: -130px;
    bottom: -210px;
    width: 430px;
    height: 430px;
    border: 58px solid rgba(244, 180, 0, .1);
    border-radius: 50%;
}

.theses-hero-content {
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
    color: var(--thesis-blue);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.eyebrow::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--thesis-gold);
    border-radius: 10px;
}

.theses-hero h1 {
    margin: 18px 0;
    font-size: clamp(45px, 6vw, 68px);
    font-weight: 800;
    line-height: 1.05;
    letter-spacing: -.045em;
}

.theses-hero p {
    max-width: 650px;
    margin: 0 auto 27px;
    color: rgba(255, 255, 255, .78);
    font-size: 17px;
    line-height: 1.75;
}

.theses-hero .breadcrumb {
    font-size: 13px;
}

.theses-hero .breadcrumb-item,
.theses-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, .6);
}

.theses-hero .breadcrumb-item a {
    color: var(--thesis-white);
    font-weight: 600;
    text-decoration: none;
}

.theses-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, .36);
}

.theses-intro {
    padding: 68px 0 24px;
    background: var(--thesis-bg);
}

.periodical-filter {
    margin-top: 26px;
}

.periodical-program-search {
    position: relative;
    display: flex;
    align-items: center;
    width: min(700px, 100%);
    margin: 28px auto 0;
    background: var(--thesis-white);
    border: 1px solid var(--thesis-line);
    border-radius: 18px;
    box-shadow: 0 12px 30px rgba(11, 46, 89, .07);
}

.periodical-program-search > i {
    position: absolute;
    left: 20px;
    color: var(--thesis-blue);
    font-size: 20px;
    pointer-events: none;
}

.periodical-program-search input {
    width: 100%;
    min-width: 0;
    padding: 18px 60px 18px 54px;
    color: var(--thesis-ink);
    background: transparent;
    border: 0;
    outline: 0;
    font-size: 16px;
}

.periodical-program-search:focus-within {
    border-color: rgba(24, 75, 140, .55);
    box-shadow: 0 0 0 4px rgba(24, 75, 140, .1), 0 14px 34px rgba(11, 46, 89, .09);
}

.periodical-program-search button {
    position: absolute;
    right: 12px;
    display: grid;
    width: 38px;
    height: 38px;
    padding: 0;
    place-items: center;
    color: var(--thesis-blue);
    background: #edf3fa;
    border: 0;
    border-radius: 11px;
    opacity: 0;
    pointer-events: none;
    transition: opacity .2s ease, background .2s ease;
}

.periodical-program-search button.is-visible {
    opacity: 1;
    pointer-events: auto;
}

.periodical-program-search button:hover {
    background: #dfeaf6;
}

.program-item[hidden] {
    display: none !important;
}

.program-search-empty {
    margin-top: 24px;
    padding: 54px 20px;
    text-align: center;
    background: var(--thesis-white);
    border: 1px dashed #bfd0e3;
    border-radius: 20px;
}

.program-search-empty[hidden] {
    display: none !important;
}

.program-search-empty > i {
    display: inline-grid;
    width: 48px;
    height: 48px;
    margin-bottom: 16px;
    place-items: center;
    color: var(--thesis-blue);
    background: #edf3fa;
    border-radius: 50%;
    font-size: 20px;
}

.program-search-empty h3 {
    margin: 0 0 8px;
    color: var(--thesis-navy);
    font-size: 24px;
    font-weight: 800;
}

.program-search-empty p {
    margin: 0;
    color: var(--thesis-muted);
}

.filter-chip-group {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
}

.filter-chip {
    padding: 12px 18px;
    color: var(--thesis-navy);
    background: var(--thesis-white);
    border: 1px solid var(--thesis-line);
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    transition: .2s ease;
}

.filter-chip:hover,
.filter-chip.active {
    color: var(--thesis-white);
    background: var(--thesis-blue);
    border-color: var(--thesis-blue);
}

.section-heading h2 {
    margin: 14px 0;
    color: var(--thesis-navy);
    font-size: clamp(31px, 4vw, 45px);
    font-weight: 800;
    line-height: 1.14;
    letter-spacing: -.035em;
}

.section-heading p {
    margin: 0;
    color: var(--thesis-muted);
    font-size: 16px;
    line-height: 1.8;
}

.programs-section {
    min-height: 340px;
    padding: 24px 0 68px;
    background: var(--thesis-bg);
}

.program-card {
    height: 100%;
    overflow: hidden;
    background: var(--thesis-white);
    border: 1px solid var(--thesis-line);
    border-radius: 22px;
    box-shadow: 0 12px 32px rgba(11, 46, 89, .065);
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
}

.folder-count {
    position: absolute;
    right: 16px;
    bottom: 16px;
    padding: 8px 11px;
    color: var(--thesis-white);
    background: rgba(11, 46, 89, .86);
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 8px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
}

.program-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 26px 28px 28px;
}

.program-content h3 {
    display: -webkit-box;
    min-height: 2.35em;
    margin: 0 0 12px;
    overflow: hidden;
    color: var(--thesis-navy);
    font-size: 24px;
    font-weight: 800;
    line-height: 1.17;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.program-content p {
    display: -webkit-box;
    min-height: 7em;
    margin: 0 0 18px;
    overflow: hidden;
    color: var(--thesis-muted);
    line-height: 1.75;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4;
}

.program-action {
    display: inline-flex;
    align-items: center;
    align-self: flex-start;
    gap: 9px;
    margin-top: auto;
    color: var(--thesis-blue);
    font-size: 14px;
    font-weight: 800;
}

.program-empty {
    padding: 60px 20px;
    text-align: center;
    background: var(--thesis-white);
    border: 1px solid var(--thesis-line);
    border-radius: 20px;
}

.folder-modal .modal-content {
    overflow: hidden;
    border: 0;
    border-radius: 22px;
}

.folder-modal .modal-header {
    padding: 24px 28px;
    border-bottom: 1px solid var(--thesis-line);
}

.folder-modal .modal-title {
    margin: 8px 0 0;
    color: var(--thesis-navy);
    font-size: 26px;
    font-weight: 800;
}

.folder-modal .modal-body {
    padding: 26px 28px;
}

.folder-list {
    display: grid;
    gap: 12px;
}

.folder-category-group {
    display: grid;
    gap: 12px;
}

.folder-category-group h5 {
    margin: 2px 0 0;
    color: var(--thesis-navy);
    font-size: 18px;
    font-weight: 800;
}

.folder-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 18px 20px;
    color: inherit;
    text-decoration: none;
    background: var(--thesis-bg);
    border: 1px solid var(--thesis-line);
    border-radius: 14px;
}

.folder-link-copy strong,
.folder-link-copy small {
    display: block;
}

.folder-link-copy strong {
    color: var(--thesis-navy);
    font-size: 15px;
    font-weight: 800;
}

.folder-link-copy small {
    margin-top: 3px;
    color: var(--thesis-muted);
    font-size: 12px;
}

.folder-empty {
    padding: 36px 12px;
    text-align: center;
}

.folder-empty h5 {
    color: var(--thesis-navy);
    font-weight: 800;
}

.folder-empty p {
    margin: 0;
    color: var(--thesis-muted);
}

.modal-close-button {
    padding: 11px 18px;
    color: var(--thesis-white);
    background: var(--thesis-navy);
    border: 0;
    border-radius: 10px;
    font-weight: 700;
}

@media (max-width: 767.98px) {
    .theses-hero { min-height: 320px; }
    .theses-hero-content { padding: 85px 0 70px; }
    .periodical-program-search input { padding-block: 15px; font-size: 15px; }
    .program-content h3,
    .program-content p { min-height: 0; }
}


/* =========================================================
   PERIODICAL POPUP — EBOOK/THESIS STYLE
========================================================= */
.folder-modal .modal-content {
    display: flex !important;
    flex-direction: column !important;
    overflow: hidden !important;
    border: 0 !important;
    border-radius: 22px !important;
    box-shadow: 0 24px 54px rgba(11, 46, 89, .18) !important;
}

.folder-modal .modal-header {
    position: relative !important;
    flex: 0 0 auto !important;
    align-items: center !important;
    padding: 22px 78px 18px 24px !important;
    background: #fff !important;
    border-bottom: 1px solid var(--thesis-line) !important;
}

.folder-modal .modal-header > div {
    min-width: 0 !important;
}

.folder-modal .modal-header span {
    display: block !important;
    color: var(--thesis-blue) !important;
    font-size: 11px !important;
    font-weight: 800 !important;
    letter-spacing: .08em !important;
    text-transform: uppercase !important;
}

.folder-modal .modal-title {
    margin: 6px 0 0 !important;
    color: var(--thesis-navy) !important;
    font-size: 22px !important;
    font-weight: 800 !important;
    line-height: 1.3 !important;
}

.folder-modal .periodical-modal-close {
    position: absolute !important;
    top: 18px !important;
    right: 20px !important;
    z-index: 30 !important;
    width: 38px !important;
    height: 38px !important;
    min-width: 38px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 !important;
    padding: 0 !important;
    color: #647187 !important;
    background: transparent !important;
    border: 0 !important;
    border-radius: 50% !important;
    box-shadow: none !important;
    outline: none !important;
    font-size: 22px !important;
    line-height: 1 !important;
    opacity: .9 !important;
    cursor: pointer !important;
    transform: none !important;
}

.folder-modal .periodical-modal-close i {
    display: block !important;
    margin: 0 !important;
    padding: 0 !important;
    color: inherit !important;
    font-size: inherit !important;
    line-height: 1 !important;
    pointer-events: none !important;
}

.folder-modal .periodical-modal-close:hover,
.folder-modal .periodical-modal-close:focus-visible {
    color: var(--thesis-navy) !important;
    background: rgba(11, 46, 89, .07) !important;
    opacity: 1 !important;
}

.folder-modal .modal-body {
    flex: 1 1 auto !important;
    min-height: 0 !important;
    max-height: none !important;
    padding: 22px 24px !important;
    overflow-y: auto !important;
    overscroll-behavior: contain !important;
    background: #fff !important;
}

.folder-modal .folder-list {
    display: grid !important;
    gap: 12px !important;
}

.folder-modal .folder-category-group {
    display: grid !important;
    gap: 12px !important;
}

.folder-modal .folder-link {
    position: relative !important;
    z-index: 1 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 18px !important;
    padding: 16px 18px !important;
    color: var(--thesis-ink) !important;
    background: #f8fafc !important;
    border: 1px solid var(--thesis-line) !important;
    border-radius: 14px !important;
    text-decoration: none !important;
    pointer-events: auto !important;
}

.folder-modal .folder-link:hover {
    background: #eef4fb !important;
    border-color: #b8c9dd !important;
}

.folder-modal .folder-link-copy {
    min-width: 0 !important;
    flex: 1 !important;
}

.folder-modal .folder-link-copy strong {
    display: block !important;
    color: var(--thesis-navy) !important;
    font-size: 15px !important;
    font-weight: 800 !important;
    white-space: normal !important;
    overflow-wrap: anywhere !important;
}

.folder-modal .folder-link-copy small {
    display: block !important;
    margin-top: 4px !important;
    color: var(--thesis-muted) !important;
    font-size: 13px !important;
    line-height: 1.45 !important;
    white-space: normal !important;
    overflow-wrap: anywhere !important;
}

.folder-modal .modal-footer {
    flex: 0 0 auto !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 16px !important;
    padding: 18px 24px 22px !important;
    background: #fff !important;
    border-top: 1px solid var(--thesis-line) !important;
}

.folder-modal .modal-footer > span {
    color: var(--thesis-muted) !important;
    font-size: 14px !important;
}

.folder-modal .modal-close-button {
    width: auto !important;
    padding: 10px 16px !important;
    color: #fff !important;
    background: var(--thesis-blue) !important;
    border: 0 !important;
    border-radius: 10px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
}

@media (min-width: 768px) {
    .folder-modal .modal-dialog {
        width: min(calc(100vw - 32px), 1140px) !important;
        max-width: min(calc(100vw - 32px), 1140px) !important;
        height: calc(100vh - 2rem) !important;
        margin: 1rem auto !important;
    }

    .folder-modal .modal-content {
        width: 100% !important;
        height: 100% !important;
        max-height: calc(100vh - 2rem) !important;
    }
}

@media (max-width: 767.98px) {
    .folder-modal .modal-dialog {
        width: 100% !important;
        max-width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
    }

    .folder-modal .modal-content {
        width: 100% !important;
        height: 100dvh !important;
        max-height: 100dvh !important;
        border-radius: 0 !important;
    }

    .folder-modal .modal-header {
        padding: 18px 62px 18px 18px !important;
    }

    .folder-modal .periodical-modal-close {
        top: 13px !important;
        right: 13px !important;
        width: 34px !important;
        height: 34px !important;
        min-width: 34px !important;
        font-size: 19px !important;
    }

    .folder-modal .modal-body {
        padding: 18px !important;
    }

    .folder-modal .modal-footer {
        flex-direction: row !important;
        align-items: center !important;
        padding: 16px 18px !important;
    }
}

</style>
<style>
.collection-folder-search { position: relative; display: flex; align-items: center; margin-bottom: 16px; }
.collection-folder-search > i { position: absolute; left: 16px; color: var(--thesis-blue); }
.collection-folder-search-input { width: 100%; padding: 13px 44px; color: var(--thesis-ink); background: var(--thesis-bg); border: 1px solid var(--thesis-line); border-radius: 12px; outline: 0; }
.collection-folder-search-input:focus { border-color: var(--thesis-blue); box-shadow: 0 0 0 3px rgba(24, 75, 140, .12); }
.collection-folder-search-clear { position: absolute; right: 10px; display: grid; width: 30px; height: 30px; place-items: center; color: var(--thesis-muted); background: transparent; border: 0; opacity: 0; pointer-events: none; }
.collection-folder-search-clear.is-visible { opacity: 1; pointer-events: auto; }
.collection-folder-search.is-disabled { opacity: .7; }
.collection-folder-search.is-disabled > i { color: var(--thesis-muted); }
.collection-folder-search-input:disabled { cursor: not-allowed; background: #f1f4f8; }
.collection-folder-search-empty { padding: 36px 20px; text-align: center; background: var(--thesis-bg); border: 1px dashed var(--thesis-line); border-radius: 14px; }
.collection-folder-search-empty h5 { margin: 0 0 8px; color: var(--thesis-navy); font-weight: 800; }
.collection-folder-search-empty p { margin: 0; color: var(--thesis-muted); }
</style>
@endpush
