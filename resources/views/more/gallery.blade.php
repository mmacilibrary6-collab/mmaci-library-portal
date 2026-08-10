@extends('layouts.app')

@section('title', 'Library Gallery | MMACI Library Services Office')

@section('content')

<section class="gallery-hero">
    <div class="container">
        <div class="gallery-hero-content">
            <h1>Moments within our library</h1>
            <p>
                Explore activities, programs, celebrations, and memorable
                experiences from the MMACI Library Services Office.
            </p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Gallery
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="gallery-intro">
    <div class="container">
        <div class="intro-layout">
            <header class="section-heading">
                <span class="eyebrow">Captured Experiences</span>
                <h2>Library activities and programs</h2>
                <p>
                    A collection of events and learning experiences that make
                    the MMACI Library an active part of the academic community.
                </p>
            </header>

            <div class="gallery-summary">
                <strong>{{ $galleries->count() }}</strong>
                <span>
                    {{ \Illuminate\Support\Str::plural(
                        'published gallery folder',
                        $galleries->count()
                    ) }}
                </span>
                <small>Select a folder to view its slideshow.</small>
            </div>
        </div>
    </div>
</section>

<section class="gallery-grid-section">
    <div class="container">
        <div class="editorial-gallery">
            @forelse ($galleries as $gallery)
                <article
                    class="gallery-card {{ $loop->first ? 'gallery-card-featured' : '' }}"
                    role="button"
                    tabindex="0"
                    aria-label="View {{ $gallery->title }}"
                    style="--reveal-delay: {{ min($loop->index * 70, 350) }}ms"
                    data-gallery-title="{{ $gallery->title }}"
                    data-gallery-images='@json($gallery->images->isNotEmpty() ? $gallery->images->map(fn ($image) => $image->image_url)->values() : [$gallery->cover_image_url])'>

                    <div class="gallery-image">
                        <img
                            src="{{ $gallery->cover_image_url }}"
                            alt="{{ $gallery->title }}"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">
                        <div class="gallery-overlay">
                            <span>{{ $gallery->images->count() }} photos</span>
                            <h3>{{ $gallery->title }}</h3>
                            <span class="view-image">
                                <i class="bi bi-arrows-fullscreen" aria-hidden="true"></i>
                                View slideshow
                            </span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="gallery-empty">
                    <h3>Gallery folders are coming soon</h3>
                    <p>
                        Library programs, events, and activities will appear
                        here once folders and images become available.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<div
    class="modal fade"
    id="galleryPreviewModal"
    tabindex="-1"
    aria-labelledby="galleryPreviewModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content gallery-modal">
            <button
                type="button"
                class="btn-close gallery-modal-close"
                data-bs-dismiss="modal"
                aria-label="Close">
            </button>

            <div class="gallery-modal-image">
                <img src="{{ asset('images/readingarea.jpg') }}" id="galleryModalImage" alt="Gallery preview" onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">
                <button type="button" class="gallery-modal-nav gallery-modal-prev" id="galleryModalPrev" aria-label="Previous image">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="gallery-modal-nav gallery-modal-next" id="galleryModalNext" aria-label="Next image">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <div class="gallery-modal-caption">
                <span>MMACI Library Gallery</span>
                <h2 id="galleryPreviewModalLabel"></h2>
                <div id="galleryModalCounter" class="gallery-modal-counter"></div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --gallery-navy: #0b2e59;
    --gallery-blue: #184b8c;
    --gallery-gold: #f4b400;
    --gallery-ink: #17243a;
    --gallery-muted: #647187;
    --gallery-bg: #f4f7fb;
    --gallery-line: #dfe6ef;
    --gallery-white: #ffffff;
}

.gallery-hero {
    position: relative;
    min-height: 380px;
    display: grid;
    place-items: center;
    overflow: hidden;
    color: var(--gallery-white);
    background:
        linear-gradient(105deg, rgba(7, 32, 65, .95), rgba(11, 46, 89, .8)),
        url("{{ asset('images/librarycollect.jpg') }}") center / cover no-repeat;
}

.gallery-hero::after {
    content: "";
    position: absolute;
    right: -130px;
    bottom: -210px;
    width: 430px;
    height: 430px;
    border: 58px solid rgba(244, 180, 0, .1);
    border-radius: 50%;
}

.gallery-hero-content {
    position: relative;
    z-index: 1;
    max-width: 790px;
    margin: auto;
    padding: 76px 0 64px;
    text-align: center;
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--gallery-blue);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.eyebrow::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--gallery-gold);
    border-radius: 10px;
}

.eyebrow-light {
    color: var(--gallery-gold);
}

.gallery-hero h1 {
    margin: 13px 0;
    font-size: clamp(42px, 5.5vw, 62px);
    font-weight: 800;
    line-height: 1.05;
    letter-spacing: -.045em;
}

.gallery-hero p {
    max-width: 650px;
    margin: 0 auto 19px;
    color: rgba(255, 255, 255, .78);
    font-size: 17px;
    line-height: 1.75;
}

.gallery-hero .breadcrumb {
    font-size: 13px;
}

.gallery-hero .breadcrumb-item,
.gallery-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, .6);
}

.gallery-hero .breadcrumb-item a {
    color: var(--gallery-white);
    font-weight: 600;
    text-decoration: none;
}

.gallery-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, .36);
}

.gallery-intro {
    padding: 44px 0 20px;
    background: var(--gallery-bg);
}

.intro-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.4fr) minmax(260px, .6fr);
    align-items: end;
    gap: 36px;
}

.section-heading {
    max-width: 730px;
}

.section-heading h2 {
    margin: 14px 0;
    color: var(--gallery-navy);
    font-size: clamp(31px, 4vw, 45px);
    font-weight: 800;
    line-height: 1.14;
    letter-spacing: -.035em;
}

.section-heading p {
    margin: 0;
    color: var(--gallery-muted);
    font-size: 16px;
    line-height: 1.8;
}

.gallery-summary {
    padding-left: 20px;
    background: transparent;
    border-left: 3px solid var(--gallery-gold);
}

.gallery-summary strong,
.gallery-summary span,
.gallery-summary small {
    display: block;
}

.gallery-summary strong {
    color: var(--gallery-navy);
    font-size: 28px;
    font-weight: 800;
    line-height: 1;
}

.gallery-summary span {
    margin-top: 5px;
    color: var(--gallery-blue);
    font-size: 11px;
    font-weight: 800;
    text-transform: capitalize;
}

.gallery-summary small {
    margin-top: 9px;
    color: #8994a4;
    font-size: 10px;
}

.gallery-grid-section {
    min-height: 330px;
    padding: 20px 0 52px;
    background: var(--gallery-bg);
}

.editorial-gallery {
    display: grid;
    grid-template-columns: repeat(12, minmax(0, 1fr));
    grid-auto-rows: 220px;
    gap: 16px;
}

.gallery-card {
    grid-column: span 4;
    position: relative;
    overflow: hidden;
    background: #dfe6ef;
    border-radius: 16px;
    box-shadow: 0 9px 25px rgba(11, 46, 89, .08);
    cursor: pointer;
    outline: 0;
    opacity: 0;
    transform: translateY(28px);
    transition:
        opacity .6s ease var(--reveal-delay, 0ms),
        transform .6s cubic-bezier(.2, .7, .2, 1) var(--reveal-delay, 0ms),
        box-shadow .3s ease;
}

.gallery-card-featured {
    grid-column: span 8;
    grid-row: span 2;
}

.gallery-card.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.gallery-card:hover,
.gallery-card:focus-visible {
    box-shadow: 0 18px 42px rgba(11, 46, 89, .2);
}

.gallery-card:focus-visible {
    box-shadow:
        0 0 0 3px rgba(24, 75, 140, .2),
        0 18px 39px rgba(11, 46, 89, .11);
}

.gallery-image {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .7s cubic-bezier(.2, .7, .2, 1);
}

.gallery-card:hover .gallery-image img {
    transform: scale(1.065);
}

.gallery-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    justify-content: flex-end;
    flex-direction: column;
    padding: 20px;
    color: var(--gallery-white);
    background: linear-gradient(
        180deg,
        transparent 30%,
        rgba(5, 24, 51, .86) 100%
    );
}

.gallery-overlay > span:first-child {
    margin-bottom: 5px;
    color: var(--gallery-gold);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.gallery-overlay h3 {
    max-width: 90%;
    margin: 0;
    font-size: 17px;
    font-weight: 800;
    line-height: 1.3;
}

.gallery-card-featured .gallery-overlay {
    padding: 28px;
}

.gallery-card-featured .gallery-overlay h3 {
    font-size: clamp(24px, 3vw, 34px);
}

.view-image {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    max-width: max-content;
    margin-top: 12px;
    color: rgba(255, 255, 255, .78);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    opacity: 0;
    transform: translateY(8px);
    transition: opacity .3s ease, transform .3s ease;
}

.gallery-card:hover .view-image,
.gallery-card:focus-visible .view-image {
    opacity: 1;
    transform: translateY(0);
}

.gallery-empty {
    grid-column: 1 / -1;
    width: 100%;
    min-width: 0;
    min-height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 40px 24px;
    overflow: hidden;
    text-align: center;
    background: var(--gallery-white);
    border: 1px solid var(--gallery-line);
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(11, 46, 89, .055);
}

.gallery-empty h3 {
    max-width: 100%;
    margin: 0;
    color: var(--gallery-navy);
    font-size: 22px;
    font-weight: 800;
    line-height: 1.3;
    overflow-wrap: anywhere;
}

.gallery-empty p {
    width: 100%;
    max-width: 570px;
    margin: 8px auto 0;
    color: var(--gallery-muted);
    font-size: 14px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

.gallery-modal {
    overflow: hidden;
    background: #071f3e;
    border: 0;
    border-radius: 18px;
    box-shadow: 0 25px 80px rgba(3, 18, 38, .4);
}

.gallery-modal-close {
    position: absolute;
    z-index: 3;
    top: 15px;
    right: 15px;
    padding: 10px;
    background-color: var(--gallery-white);
    border-radius: 8px;
    opacity: 1;
}

.gallery-modal-image {
    position: relative;
    display: grid;
    place-items: center;
    min-height: 320px;
    max-height: 72vh;
    background: #071f3e;
}

.gallery-modal-image img {
    width: 100%;
    max-height: 72vh;
    display: block;
    object-fit: contain;
}

.gallery-modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 42px;
    height: 42px;
    display: grid;
    place-items: center;
    color: #fff;
    background: rgba(7, 31, 62, .55);
    border: 0;
    border-radius: 999px;
}

.gallery-modal-prev { left: 14px; }
.gallery-modal-next { right: 14px; }

.gallery-modal-counter {
    margin-top: 6px;
    color: rgba(255, 255, 255, .7);
    font-size: 12px;
}

.gallery-modal-caption {
    padding: 18px 22px 20px;
    color: var(--gallery-white);
    border-top: 1px solid rgba(255, 255, 255, .12);
}

.gallery-modal-caption span {
    color: var(--gallery-gold);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.gallery-modal-caption h2 {
    margin: 5px 0 0;
    font-size: 21px;
    font-weight: 800;
}

@media (max-width: 991.98px) {
    .intro-layout {
        grid-template-columns: 1fr;
        align-items: start;
        gap: 25px;
    }

    .gallery-summary {
        max-width: 400px;
    }

    .editorial-gallery {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        grid-auto-rows: 230px;
    }

    .gallery-card,
    .gallery-card-featured {
        grid-column: span 1;
        grid-row: span 1;
    }

    .gallery-card:first-child {
        grid-column: 1 / -1;
        grid-row: span 2;
    }
}

@media (max-width: 767.98px) {
    .gallery-hero {
        min-height: 350px;
    }

    .gallery-hero-content {
        padding: 70px 0 58px;
    }

    .gallery-intro {
        padding-top: 36px;
    }

    .gallery-grid-section {
        padding-bottom: 44px;
    }
}

@media (max-width: 575.98px) {
    .gallery-hero h1 {
        font-size: 41px;
    }

    .gallery-hero p {
        font-size: 15px;
    }

    .editorial-gallery {
        grid-template-columns: 1fr;
        grid-auto-rows: 240px;
        gap: 12px;
    }

    .gallery-card,
    .gallery-card:first-child,
    .gallery-card-featured {
        grid-column: auto;
        grid-row: auto;
    }

    .gallery-card:first-child {
        min-height: 310px;
    }

    .gallery-modal .modal-dialog {
        margin: 12px;
    }

}

    .gallery-image img,
    .view-image {
        transition: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const galleryCards = document.querySelectorAll('.gallery-card');
    const modalElement = document.getElementById('galleryPreviewModal');
    const modalImage = document.getElementById('galleryModalImage');
    const modalTitle = document.getElementById('galleryPreviewModalLabel');
    const modalCounter = document.getElementById('galleryModalCounter');
    const modalPrev = document.getElementById('galleryModalPrev');
    const modalNext = document.getElementById('galleryModalNext');
    let currentImages = [];
    let currentIndex = 0;
    let slideshowTimer = null;

    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver(
            function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0.12,
                rootMargin: '0px 0px -35px'
            }
        );

        galleryCards.forEach(function (card) {
            revealObserver.observe(card);
        });
    } else {
        galleryCards.forEach(function (card) {
            card.classList.add('is-visible');
        });
    }

    if (
        !modalElement ||
        !modalImage ||
        !modalTitle ||
        typeof bootstrap === 'undefined'
    ) {
        return;
    }

    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    function renderSlide(index) {
        if (!currentImages.length) {
            return;
        }

        currentIndex = (index + currentImages.length) % currentImages.length;
        modalImage.src = currentImages[currentIndex];
        modalCounter.textContent = `${currentIndex + 1} / ${currentImages.length}`;
    }

    function openGalleryImage(card) {
        currentImages = JSON.parse(card.dataset.galleryImages || '[]');
        const title = card.dataset.galleryTitle;

        if (!currentImages.length) {
            currentImages = ['{{ asset('images/readingarea.jpg') }}'];
        }

        modalImage.alt = title;
        modalTitle.textContent = title;
        renderSlide(0);
        modal.show();

        window.clearInterval(slideshowTimer);
        slideshowTimer = window.setInterval(function () {
            renderSlide(currentIndex + 1);
        }, 2800);
    }

    function moveSlide(direction) {
        renderSlide(currentIndex + direction);
    }

    galleryCards.forEach(function (card) {
        card.addEventListener('click', function () {
            openGalleryImage(card);
        });

        card.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openGalleryImage(card);
            }
        });
    });

    modalElement.addEventListener('hidden.bs.modal', function () {
        window.clearInterval(slideshowTimer);
        modalImage.src = '';
        modalTitle.textContent = '';
        modalCounter.textContent = '';
        currentImages = [];
        currentIndex = 0;
    });

    modalPrev?.addEventListener('click', function () {
        moveSlide(-1);
    });

    modalNext?.addEventListener('click', function () {
        moveSlide(1);
    });
});
</script>


<!-- =========================================================
     LIBRARY GALLERY PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes galleryHeroEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 26px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes galleryHeroRingFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }
        50% {
            transform: translate3d(-13px, -13px, 0) rotate(4deg);
        }
    }

    @keyframes galleryModalImageEnter {
        from {
            opacity: 0;
            transform: scale(.975);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .gallery-hero-content {
        animation: galleryHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    .gallery-hero::after {
        animation: galleryHeroRingFloat 7.5s ease-in-out infinite;
        will-change: transform;
    }

    /* Intro / summary reveal */
    .gallery-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 28px, 0);
        transition:
            opacity .7s cubic-bezier(.22, 1, .36, 1),
            transform .7s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--gallery-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .gallery-motion-reveal.gallery-motion-left {
        transform: translate3d(-34px, 0, 0);
    }

    .gallery-motion-reveal.gallery-motion-right {
        transform: translate3d(34px, 0, 0);
    }

    .gallery-motion-reveal.gallery-motion-scale {
        transform: scale(.97);
    }

    .gallery-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Summary */
    .gallery-summary {
        transition:
            transform .28s ease,
            border-color .28s ease;
    }

    .gallery-summary:hover {
        transform: translateY(-3px);
        border-left-color: var(--gallery-blue);
    }

    .gallery-summary strong {
        display: inline-block;
        transition: transform .25s ease;
    }

    .gallery-summary:hover strong {
        transform: scale(1.06);
    }

    /* Existing cards already reveal themselves; enhance hover only */
    .gallery-card {
        transition:
            opacity .6s ease var(--reveal-delay, 0ms),
            transform .6s cubic-bezier(.2, .7, .2, 1) var(--reveal-delay, 0ms),
            box-shadow .3s ease,
            filter .3s ease;
    }

    .gallery-card:hover,
    .gallery-card:focus-visible {
        transform: translateY(-6px);
        box-shadow: 0 22px 46px rgba(11, 46, 89, .2);
    }

    .gallery-image img {
        transition:
            transform .75s cubic-bezier(.2, .7, .2, 1),
            filter .45s ease;
    }

    .gallery-card:hover .gallery-image img,
    .gallery-card:focus-visible .gallery-image img {
        transform: scale(1.075);
        filter: saturate(1.05);
    }

    .gallery-overlay h3,
    .gallery-overlay > span:first-child {
        transition: transform .28s ease;
    }

    .gallery-card:hover .gallery-overlay h3,
    .gallery-card:hover .gallery-overlay > span:first-child {
        transform: translateY(-2px);
    }

    .view-image i {
        transition: transform .25s ease;
    }

    .gallery-card:hover .view-image i,
    .gallery-card:focus-visible .view-image i {
        transform: scale(1.08);
    }

    /* Empty state */
    .gallery-empty {
        transition:
            transform .3s ease,
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .gallery-empty:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 34px rgba(11, 46, 89, .09);
        border-color: rgba(24, 75, 140, .16);
    }

    /* Modal */
    .modal.show .gallery-modal {
        animation: galleryHeroEnter .28s cubic-bezier(.22, 1, .36, 1) both;
    }

    .modal.show .gallery-modal-image img {
        animation: galleryModalImageEnter .3s cubic-bezier(.22, 1, .36, 1) both;
    }

    .gallery-modal-nav {
        transition:
            transform .22s ease,
            background .22s ease;
    }

    .gallery-modal-prev:hover {
        transform: translateY(-50%) scale(1.07) translateX(-2px);
        background: rgba(24, 75, 140, .9);
    }

    .gallery-modal-next:hover {
        transform: translateY(-50%) scale(1.07) translateX(2px);
        background: rgba(24, 75, 140, .9);
    }

    .gallery-modal-close {
        transition:
            transform .22s ease,
            background .22s ease;
    }

    .gallery-modal-close:hover {
        transform: rotate(4deg) scale(1.04);
    }

        .gallery-motion-reveal,
        .gallery-motion-reveal.gallery-motion-left,
        .gallery-motion-reveal.gallery-motion-right,
        .gallery-motion-reveal.gallery-motion-scale {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        .gallery-summary,
        .gallery-summary strong,
        .gallery-card,
        .gallery-image img,
        .gallery-overlay h3,
        .gallery-overlay > span:first-child,
        .view-image i,
        .gallery-empty,
        .gallery-modal-nav,
        .gallery-modal-close {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const revealGroups = [
        { selector: '.gallery-intro .section-heading', mode: 'gallery-motion-left' },
        { selector: '.gallery-summary', mode: 'gallery-motion-right' },
        { selector: '.gallery-empty', mode: 'gallery-motion-scale' }
    ];

    const revealElements = [];

    revealGroups.forEach(function (group) {
        document.querySelectorAll(group.selector).forEach(function (element, index) {
            /*
             * Gallery cards already have their own reveal observer in this file.
             * Only unrelated elements are handled here.
             */
            if (element.classList.contains('gallery-card')) {
                return;
            }

            element.classList.add('gallery-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 6) * 75, 375);
            element.style.setProperty('--gallery-motion-delay', stagger + 'ms');

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
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px'
    });

    revealElements.forEach(function (element) {
        observer.observe(element);
    });
});
</script>
@include('components.lisa-chatbox')

@endsection

