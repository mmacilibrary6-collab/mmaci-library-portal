@extends('layouts.app')

@section('title', 'Electronic Books | MMACI Library Services Office')

@section('content')

<section class="ebooks-hero">
    <div class="container">
        <div class="ebooks-hero-content">
            <span class="section-badge">Collection</span>
            <h1>Electronic Books</h1>
            <p>
                Browse digital learning resources by academic program and open the available folders in a centered popup.
            </p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Collection</li>
                    <li class="breadcrumb-item active" aria-current="page">Electronic Books</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="ebooks-toolbar">
    <div class="container">
        <div class="ebooks-toolbar-card modern-card">
            <div>
                <span class="section-badge">Explore by Program</span>
                <h2>Find resources for your course</h2>
                <p>
                    Search an academic program, then open its folder list to view the available electronic book materials.
                </p>
            </div>

            @if($programs->isNotEmpty())
                <div class="program-search">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <input
                        type="search"
                        id="programSearch"
                        placeholder="Search academic programs..."
                        autocomplete="off"
                        aria-label="Search academic programs">
                    <button type="button" id="clearProgramSearch" aria-label="Clear search">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="ebooks-grid-section section-space">
    <div class="container">
        @if($programs->isNotEmpty())
            <div class="row g-4" id="programGrid">
                @foreach($programs as $program)
                    @php
                        $programImage = $program->image_url ?: asset('images/readingarea.jpg');
                        $folderCount = $program->folders->count();
                        $folders = $program->folders->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE);
                    @endphp

                    <div class="col-xl-4 col-lg-4 col-md-6 program-item"
                         data-program-title="{{ strtolower($program->title) }}"
                         data-program-description="{{ strtolower($program->description ?? '') }}">
                        <article class="program-card modern-card">
                            <button
                                type="button"
                                class="program-card-button"
                                data-folder-open
                                aria-label="View folders for {{ $program->title }}">
                                <div class="program-image">
                                    <img
                                        src="{{ $programImage }}"
                                        alt="{{ $program->title }}"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">
                                    <span class="folder-count">
                                        {{ $folderCount }} {{ \Illuminate\Support\Str::plural('Folder', $folderCount) }}
                                    </span>
                                </div>

                                <div class="program-content">
                                    <h3>{{ $program->title }}</h3>
                                    <p>{{ $program->description ?: 'Browse available electronic books and digital learning resources for this academic program.' }}</p>
                                    <span class="program-action">
                                        {{ $folderCount > 0 ? 'View available folders' : 'No folders available' }}
                                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </button>

                            <template class="program-folder-template">
                                <div class="folder-list">
                                    @forelse($folders as $folder)
                                        <a
                                            href="{{ $folder->drive_link }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="folder-link">
                                            <span class="folder-link-copy">
                                                <strong>{{ $folder->title }}</strong>
                                                <small>{{ $folder->description ?: 'Open this electronic book folder' }}</small>
                                            </span>
                                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                                        </a>
                                    @empty
                                        <div class="folder-empty">
                                            <h5>No folders available</h5>
                                            <p>Electronic book folders for this program have not been added yet.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </template>
                        </article>
                    </div>
                @endforeach
            </div>

            <div id="searchEmptyState" class="search-empty d-none">
                <h4>No matching program found</h4>
                <p>Try another academic program name or keyword.</p>
            </div>
        @else
            <div class="program-empty modern-card">
                <h3>No electronic book collections available</h3>
                <p>Academic programs and digital folders have not been published yet. Please check again later.</p>
            </div>
        @endif
    </div>
</section>

<div id="ebookFolderOverlay" class="ebook-folder-overlay" hidden aria-hidden="true">
    <button type="button" class="ebook-folder-overlay-backdrop" data-ebook-close aria-label="Close overlay"></button>

    <div class="ebook-folder-dialog" role="dialog" aria-modal="true" aria-labelledby="ebookFolderOverlayTitle">
        <div class="ebook-folder-card modern-card">
            <div class="ebook-folder-header">
                <div>
                    <span>Electronic Book Collection</span>
                    <h3 id="ebookFolderOverlayTitle">Program Folders</h3>
                </div>
                <button type="button" class="ebook-folder-close" data-ebook-close aria-label="Close folders">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>
            </div>

            <div class="ebook-folder-body" id="ebookFolderOverlayBody"></div>

            <div class="ebook-folder-footer">
                <span id="ebookFolderOverlayCount">0 folders available</span>
                <button type="button" class="btn-mmaci btn-mmaci-sm" data-ebook-close>Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.ebooks-hero {
    position: relative;
    overflow: hidden;
    padding: 96px 0 78px;
    color: #fff;
    background:
        radial-gradient(circle at 82% 18%, rgba(244, 180, 0, .25), transparent 24%),
        linear-gradient(135deg, #0b2e59, #184b8c);
}

.ebooks-hero-content {
    max-width: 840px;
    margin: 0 auto;
    text-align: center;
}

.ebooks-hero h1 {
    margin: 16px 0 14px;
    font-size: clamp(2.5rem, 5vw, 4.75rem);
    font-weight: 800;
    letter-spacing: -0.05em;
}

.ebooks-hero p {
    max-width: 780px;
    margin: 0 auto 22px;
    color: rgba(255, 255, 255, .86);
    line-height: 1.8;
    font-size: 1.04rem;
}

.ebooks-hero .breadcrumb a,
.ebooks-hero .breadcrumb {
    color: rgba(255, 255, 255, .82);
}

.ebooks-toolbar {
    margin-top: -26px;
}

.ebooks-toolbar-card {
    display: grid;
    gap: 20px;
    padding: 28px;
}

.ebooks-toolbar-card h2 {
    margin: 12px 0 8px;
    color: #0b2e59;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 800;
    letter-spacing: -0.04em;
}

.ebooks-toolbar-card p {
    margin: 0;
    color: #6c7a89;
    line-height: 1.8;
    max-width: 760px;
}

.program-search {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    background: #f5f8fc;
    border: 1px solid rgba(11, 46, 89, .10);
    border-radius: 18px;
}

.program-search i {
    color: #184b8c;
    font-size: 1.05rem;
}

.program-search input {
    flex: 1 1 auto;
    min-width: 0;
    border: 0;
    outline: 0;
    background: transparent;
    font-size: 1rem;
    color: #26384d;
}

.program-search button {
    width: 36px;
    height: 36px;
    display: grid;
    place-items: center;
    border: 0;
    border-radius: 50%;
    background: rgba(24, 75, 140, .10);
    color: #184b8c;
}

.program-card,
.program-empty {
    overflow: hidden;
    height: 100%;
}

.program-card-button {
    width: 100%;
    padding: 0;
    border: 0;
    background: transparent;
    text-align: left;
}

.program-image {
    position: relative;
    aspect-ratio: 4 / 3;
    background: #0b2e59;
    overflow: hidden;
}

.program-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.folder-count {
    position: absolute;
    right: 16px;
    bottom: 16px;
    padding: 10px 14px;
    border-radius: 12px;
    background: rgba(11, 46, 89, .82);
    color: #fff;
    font-size: .82rem;
    font-weight: 800;
    letter-spacing: .03em;
}

.program-content {
    padding: 24px 24px 28px;
}

.program-content h3 {
    margin: 0 0 12px;
    color: #0b2e59;
    font-size: 1.85rem;
    font-weight: 800;
    letter-spacing: -0.04em;
}

.program-content p {
    margin: 0;
    color: #6c7a89;
    line-height: 1.85;
}

.program-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 20px;
    color: #184b8c;
    font-weight: 800;
}

.search-empty,
.program-empty {
    padding: 36px;
    text-align: center;
}

.search-empty h4,
.program-empty h3 {
    margin: 0 0 10px;
    color: #0b2e59;
    font-weight: 800;
}

.search-empty p,
.program-empty p {
    margin: 0;
    color: #6c7a89;
    line-height: 1.8;
}

.ebook-folder-overlay {
    position: fixed;
    inset: 0;
    z-index: 2000;
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
    border: 0;
    background: rgba(6, 18, 36, .58);
}

.ebook-folder-dialog {
    position: relative;
    z-index: 1;
    width: min(720px, calc(100vw - 24px));
    max-height: calc(100dvh - 24px);
    pointer-events: auto;
}

.ebook-folder-card {
    display: flex;
    flex-direction: column;
    max-height: calc(100dvh - 24px);
    overflow: hidden;
}

.ebook-folder-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 18px;
    padding: 22px 24px;
    color: #fff;
    background: linear-gradient(135deg, #0b2e59, #184b8c);
}

.ebook-folder-header span {
    display: block;
    margin-bottom: 6px;
    color: #f4b400;
    font-size: .72rem;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.ebook-folder-header h3 {
    margin: 0;
    color: #fff;
    font-size: clamp(1.35rem, 2.2vw, 2rem);
    font-weight: 800;
    letter-spacing: -0.04em;
}

.ebook-folder-close {
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    display: grid;
    place-items: center;
    padding: 0;
    border: 1px solid rgba(255, 255, 255, .2);
    border-radius: 12px;
    background: rgba(255, 255, 255, .12);
    color: #fff;
}

.ebook-folder-body {
    min-height: 0;
    flex: 1 1 auto;
    padding: 14px;
    overflow: auto;
    background: #f5f8fc;
    overscroll-behavior: contain;
}

.ebook-folder-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 12px 16px;
    background: #fff;
    border-top: 1px solid #dfe6ef;
}

.ebook-folder-footer span {
    color: #6c7a89;
    font-size: .92rem;
    font-weight: 700;
}

.folder-list {
    display: grid;
    gap: 10px;
}

.folder-link {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    gap: 14px;
    align-items: center;
    padding: 14px 16px;
    color: inherit;
    text-decoration: none;
    background: #fff;
    border: 1px solid #dfe6ef;
    border-radius: 14px;
}

.folder-link strong {
    display: block;
    color: #0b2e59;
    font-size: 1rem;
    font-weight: 800;
    line-height: 1.45;
    overflow-wrap: anywhere;
}

.folder-link small {
    display: -webkit-box;
    margin-top: 4px;
    overflow: hidden;
    color: #6c7a89;
    font-size: .86rem;
    line-height: 1.5;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.folder-link i {
    color: #184b8c;
    font-size: 1.05rem;
}

.folder-empty {
    padding: 20px;
    text-align: center;
}

.folder-empty h5 {
    margin: 0 0 8px;
    color: #0b2e59;
    font-weight: 800;
}

.folder-empty p {
    margin: 0;
    color: #6c7a89;
    line-height: 1.8;
}

.btn-mmaci-sm {
    padding: 10px 18px;
    font-size: .92rem;
}

body.modal-open {
    overflow: hidden;
}

@media (max-width: 767.98px) {
    .ebooks-toolbar-card {
        padding: 20px;
    }

    .program-content {
        padding: 18px 18px 22px;
    }

    .program-content h3 {
        font-size: 1.5rem;
    }

    .ebook-folder-dialog {
        width: calc(100vw - 12px);
        max-height: calc(100dvh - 12px);
    }

    .ebook-folder-card {
        max-height: calc(100dvh - 12px);
        border-radius: 14px;
    }

    .ebook-folder-header {
        padding: 16px;
    }

    .ebook-folder-body {
        padding: 10px;
    }

    .ebook-folder-footer {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-mmaci-sm {
        width: 100%;
    }

    .folder-link {
        grid-template-columns: minmax(0, 1fr);
        gap: 8px;
        padding: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('programSearch');
    const clearSearchButton = document.getElementById('clearProgramSearch');
    const programItems = Array.from(document.querySelectorAll('.program-item'));
    const searchEmptyState = document.getElementById('searchEmptyState');

    const overlay = document.getElementById('ebookFolderOverlay');
    const overlayTitle = document.getElementById('ebookFolderOverlayTitle');
    const overlayBody = document.getElementById('ebookFolderOverlayBody');
    const overlayCount = document.getElementById('ebookFolderOverlayCount');
    const overlayDialog = overlay ? overlay.querySelector('.ebook-folder-dialog') : null;

    let lastFocused = null;

    function getVisibleCount() {
        return programItems.filter(function (item) {
            return !item.classList.contains('d-none');
        }).length;
    }

    function updateSearchState() {
        if (!searchEmptyState) return;
        searchEmptyState.classList.toggle('d-none', getVisibleCount() !== 0);
    }

    function filterPrograms() {
        if (!searchInput) return;

        const query = searchInput.value.trim().toLowerCase();

        programItems.forEach(function (item) {
            const title = item.dataset.programTitle || '';
            const description = item.dataset.programDescription || '';
            const isMatch = !query || title.includes(query) || description.includes(query);
            item.classList.toggle('d-none', !isMatch);
        });

        updateSearchState();
    }

    function openOverlay(card) {
        if (!overlay || !overlayTitle || !overlayBody || !overlayCount || !card) return;

        const template = card.querySelector('.program-folder-template');
        const title = card.querySelector('.program-content h3')?.textContent?.trim() || 'Program Folders';
        const countText = card.querySelector('.folder-count')?.textContent?.trim() || '0 folders available';
        const clonedContent = template ? template.content.cloneNode(true) : document.createDocumentFragment();

        lastFocused = document.activeElement;
        overlayTitle.textContent = title;
        overlayBody.innerHTML = '';
        overlayBody.appendChild(clonedContent);
        overlayCount.textContent = countText.toLowerCase().includes('folder') ? countText : '0 folders available';

        overlay.hidden = false;
        overlay.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');

        window.requestAnimationFrame(function () {
            overlayDialog?.querySelector('.ebook-folder-close')?.focus();
        });
    }

    function closeOverlay() {
        if (!overlay) return;

        overlay.hidden = true;
        overlay.setAttribute('aria-hidden', 'true');
        overlayBody.innerHTML = '';
        document.body.classList.remove('modal-open');

        if (lastFocused && typeof lastFocused.focus === 'function') {
            lastFocused.focus();
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterPrograms);
    }

    if (clearSearchButton && searchInput) {
        clearSearchButton.addEventListener('click', function () {
            searchInput.value = '';
            filterPrograms();
            searchInput.focus();
        });
    }

    document.addEventListener('click', function (event) {
        const trigger = event.target.closest('[data-folder-open]');
        const closer = event.target.closest('[data-ebook-close]');

        if (trigger) {
            event.preventDefault();
            const card = trigger.closest('.program-card');
            openOverlay(card);
            return;
        }

        if (closer) {
            event.preventDefault();
            closeOverlay();
            return;
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && overlay && !overlay.hidden) {
            closeOverlay();
        }
    });

    if (overlay) {
        overlay.addEventListener('click', function (event) {
            if (event.target === overlay || event.target.classList.contains('ebook-folder-overlay-backdrop')) {
                closeOverlay();
            }
        });
    }

    updateSearchState();
});
</script>

@include('components.lisa-chatbox')

@endsection
