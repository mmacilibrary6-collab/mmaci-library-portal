@extends('layouts.app')

@section('title', 'Subscribed Online Database | MMACI Library Services Office')

@section('content')

@php
    $accessUrl = $accessUrl ?? 'https://search.ebscohost.com/';
@endphp

{{-- Hero --}}
<section class="database-hero">
    <div class="container">

        <div class="database-hero-grid">

            {{-- Hero Content --}}
            <div class="database-hero-content">

                <h1>Subscribed Online Database</h1>

                <p>
                    Access reliable journals, articles, research papers, and
                    academic resources through the MMACI Library's EBSCO
                    subscription.
                </p>

                <div class="credential-notice">

                    <i class="bi bi-person-badge" aria-hidden="true"></i>

                    <span>
                        Students must use the login credentials provided by the
                        MMACI Circulation Staff.
                    </span>

                </div>

                <div class="database-actions">

                    <a
                        href="{{ $accessUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="database-primary-button">

                        Open EBSCO Login

                        <i
                            class="bi bi-box-arrow-up-right"
                            aria-hidden="true">
                        </i>
                    </a>

                    <a
                        href="{{ route('collection.ebooks') }}"
                        class="database-secondary-button">

                        Browse E-Books
                    </a>

                </div>

            </div>

            {{-- Complete EBSCO Screenshot --}}
            <div class="database-preview">

                <div class="preview-toolbar">

                    <span class="preview-dot preview-dot-red"></span>
                    <span class="preview-dot preview-dot-yellow"></span>
                    <span class="preview-dot preview-dot-green"></span>

                    <div class="preview-address">
                        EBSCO Online Database
                    </div>

                </div>

                <div class="preview-image-wrapper">

                    <img
                        src="{{ asset('images/ebsco-signin.png') }}"
                        alt="Complete EBSCO sign-in screen"
                        class="database-image"
                        loading="eager"
                        onerror="this.onerror=null;this.src='{{ asset('images/database-placeholder.jpg') }}';">

                </div>

            </div>

        </div>

    </div>
</section>

{{-- Access Instructions --}}
<section class="database-access-section">
    <div class="container">

        <header class="database-section-heading">

            <span class="database-content-label">
                How to Access
            </span>

            <h2>Start using the EBSCO database</h2>

            <p>
                Follow these steps to access the subscribed academic resources.
            </p>

        </header>

        <div class="access-layout">

            {{-- Steps --}}
            <div class="access-steps">

                <article class="access-step">
                    <span class="step-number">01</span>

                    <div>
                        <h3>Request your credentials</h3>

                        <p>
                            Visit the MMACI Circulation Desk and request the
                            official EBSCO username and password.
                        </p>
                    </div>
                </article>

                <article class="access-step">
                    <span class="step-number">02</span>

                    <div>
                        <h3>Open the EBSCO website</h3>

                        <p>
                            Select the access button to open the official
                            database securely in a new browser tab.
                        </p>
                    </div>
                </article>

                <article class="access-step">
                    <span class="step-number">03</span>

                    <div>
                        <h3>Enter your login details</h3>

                        <p>
                            Use the credentials given by the Circulation Staff
                            and keep the account details private.
                        </p>
                    </div>
                </article>

                <article class="access-step">
                    <span class="step-number">04</span>

                    <div>
                        <h3>Search academic resources</h3>

                        <p>
                            Browse journals, articles, research papers, and
                            other learning resources available through EBSCO.
                        </p>
                    </div>
                </article>

            </div>

            {{-- Access Card --}}
            <aside class="access-card">

                <span class="access-card-label">
                    Subscribed Resource
                </span>

                <h2>EBSCO Online Access</h2>


                <div class="access-card-notice">

                    <i class="bi bi-shield-check" aria-hidden="true"></i>

                    <div>
                        <strong>Authorized access only</strong>

                        <span>
                            Available to MMACI students and authorized library
                            users.
                        </span>
                    </div>

                </div>

                <a
                    href="{{ $accessUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="access-card-button">

                    Continue to EBSCO

                    <i
                        class="bi bi-box-arrow-up-right"
                        aria-hidden="true">
                    </i>
                </a>

                <small>
                    Need assistance? Visit the Circulation Desk during library
                    hours.
                </small>

            </aside>

        </div>

    </div>
</section>

<style>
:root {
    --database-navy: #0b2e59;
    --database-blue: #184b8c;
    --database-gold: #f4b400;
    --database-green: #278b5a;
    --database-text: #18263b;
    --database-muted: #647187;
    --database-background: #f4f7fb;
    --database-border: #dfe6ef;
    --database-white: #ffffff;
}

/* Hero */

.database-hero {
    position: relative;
    overflow: hidden;
    padding: 75px 0;
    color: var(--database-white);
    background-color: var(--database-navy);
    background-image:
        linear-gradient(
            105deg,
            rgba(7, 30, 61, 0.95),
            rgba(11, 46, 89, 0.84)
        ),
        url("{{ asset('images/database-placeholder.jpg') }}");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

.database-hero::after {
    content: "";
    position: absolute;
    right: -160px;
    bottom: -270px;
    width: 490px;
    height: 490px;
    border: 68px solid rgba(244, 180, 0, 0.10);
    border-radius: 50%;
    pointer-events: none;
}

.database-hero-grid {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: minmax(0, 0.9fr) minmax(440px, 1.1fr);
    gap: 60px;
    align-items: center;
}

.database-label,
.database-content-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.13em;
    text-transform: uppercase;
}

.database-label {
    color: var(--database-gold);
}

.database-label::before,
.database-content-label::before {
    content: "";
    width: 28px;
    height: 3px;
    border-radius: 10px;
    background: var(--database-gold);
}

.database-hero h1 {
    margin: 17px 0 20px;
    color: var(--database-white);
    font-size: clamp(45px, 5.7vw, 72px);
    font-weight: 900;
    line-height: 1.02;
    letter-spacing: -0.05em;
    text-wrap: balance;
}

.database-hero-content > p {
    max-width: 620px;
    margin: 0 0 23px;
    color: rgba(255, 255, 255, 0.80);
    font-size: 16px;
    line-height: 1.75;
}

.credential-notice {
    max-width: 590px;
    padding: 14px 16px;
    display: grid;
    grid-template-columns: 21px 1fr;
    gap: 11px;
    align-items: start;
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 10px;
    color: rgba(255, 255, 255, 0.84);
    background: rgba(255, 255, 255, 0.08);
    font-size: 13px;
    line-height: 1.6;
}

.credential-notice i {
    color: var(--database-gold);
    font-size: 17px;
}

.database-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 26px;
}

.database-primary-button,
.database-secondary-button,
.access-card-button {
    min-height: 46px;
    padding: 12px 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}

.database-primary-button {
    color: var(--database-navy);
    background: var(--database-gold);
}

.database-primary-button:hover {
    color: var(--database-navy);
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(244, 180, 0, 0.24);
}

.database-secondary-button {
    border: 1px solid rgba(255, 255, 255, 0.34);
    color: var(--database-white);
    background: rgba(255, 255, 255, 0.07);
}

.database-secondary-button:hover {
    color: var(--database-white);
    background: rgba(255, 255, 255, 0.14);
    transform: translateY(-2px);
}

/* Complete Screenshot */

.database-preview {
    min-width: 0;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.20);
    border-radius: 18px;
    background: var(--database-white);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
    transform: rotate(0.8deg);
    transition: transform 0.25s ease;
}

.database-preview:hover {
    transform: rotate(0deg) translateY(-4px);
}

.preview-toolbar {
    min-height: 44px;
    padding: 0 14px;
    display: flex;
    align-items: center;
    gap: 7px;
    border-bottom: 1px solid var(--database-border);
    background: #f4f6f9;
}

.preview-dot {
    width: 9px;
    height: 9px;
    flex-shrink: 0;
    border-radius: 50%;
}

.preview-dot-red {
    background: #e26a5d;
}

.preview-dot-yellow {
    background: #e9b949;
}

.preview-dot-green {
    background: #43a86b;
}

.preview-address {
    min-width: 0;
    margin-left: 8px;
    padding: 6px 12px;
    flex: 1;
    overflow: hidden;
    border-radius: 7px;
    color: var(--database-muted);
    background: var(--database-white);
    font-size: 10px;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.preview-image-wrapper {
    width: 100%;
    padding: 0;
    overflow: visible;
    background: var(--database-white);
}

.database-image {
    width: 100%;
    height: auto;
    display: block;
    object-fit: contain;
}

/* Instructions */

.database-access-section {
    padding: 70px 0;
    background: var(--database-background);
}

.database-section-heading {
    max-width: 720px;
    margin-bottom: 35px;
}

.database-content-label {
    color: var(--database-blue);
}

.database-section-heading h2 {
    margin: 12px 0 10px;
    color: var(--database-navy);
    font-size: clamp(31px, 4vw, 47px);
    font-weight: 900;
    line-height: 1.08;
    letter-spacing: -0.04em;
}

.database-section-heading p {
    margin: 0;
    color: var(--database-muted);
    font-size: 16px;
    line-height: 1.7;
}

.access-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(280px, 365px);
    gap: 28px;
    align-items: start;
}

.access-steps {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.access-step {
    min-height: 180px;
    padding: 24px;
    display: grid;
    grid-template-columns: 44px 1fr;
    gap: 16px;
    align-items: start;
    border: 1px solid var(--database-border);
    border-radius: 16px;
    background: var(--database-white);
    box-shadow: 0 10px 26px rgba(11, 46, 89, 0.05);
    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        border-color 0.2s ease;
}

.access-step:hover {
    transform: translateY(-3px);
    border-color: rgba(24, 75, 140, 0.30);
    box-shadow: 0 15px 32px rgba(11, 46, 89, 0.09);
}

.step-number {
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    color: var(--database-navy);
    background: rgba(244, 180, 0, 0.18);
    font-size: 12px;
    font-weight: 900;
}

.access-step h3 {
    margin: 3px 0 8px;
    color: var(--database-navy);
    font-size: 17px;
    font-weight: 850;
    line-height: 1.3;
}

.access-step p {
    margin: 0;
    color: var(--database-muted);
    font-size: 13px;
    line-height: 1.65;
}

/* Access Card */

.access-card {
    position: sticky;
    top: 100px;
    padding: 28px;
    overflow: hidden;
    border-radius: 18px;
    color: var(--database-white);
    background:
        radial-gradient(
            circle at top right,
            rgba(244, 180, 0, 0.15),
            transparent 35%
        ),
        linear-gradient(
            145deg,
            var(--database-navy),
            var(--database-blue)
        );
    box-shadow: 0 18px 40px rgba(11, 46, 89, 0.18);
}

.access-card-label {
    color: var(--database-gold);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.access-card h2 {
    margin: 9px 0 12px;
    color: var(--database-white);
    font-size: 29px;
    font-weight: 900;
    letter-spacing: -0.035em;
}

.access-card > p {
    margin: 0;
    color: rgba(255, 255, 255, 0.76);
    font-size: 14px;
    line-height: 1.7;
}

.access-card-notice {
    margin: 23px 0;
    padding: 14px;
    display: grid;
    grid-template-columns: 35px 1fr;
    gap: 11px;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.13);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.08);
}

.access-card-notice i {
    color: var(--database-gold);
    font-size: 25px;
}

.access-card-notice strong,
.access-card-notice span {
    display: block;
}

.access-card-notice strong {
    margin-bottom: 3px;
    color: var(--database-white);
    font-size: 13px;
}

.access-card-notice span {
    color: rgba(255, 255, 255, 0.65);
    font-size: 11px;
    line-height: 1.45;
}

.access-card-button {
    width: 100%;
    color: var(--database-navy);
    background: var(--database-gold);
}

.access-card-button:hover {
    color: var(--database-navy);
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(244, 180, 0, 0.20);
}

.access-card small {
    display: block;
    margin-top: 13px;
    color: rgba(255, 255, 255, 0.58);
    font-size: 10px;
    line-height: 1.5;
    text-align: center;
}

/* Responsive */

@media (max-width: 991.98px) {
    .database-hero-grid,
    .access-layout {
        grid-template-columns: 1fr;
    }

    .database-hero-grid {
        gap: 40px;
    }

    .database-preview {
        width: 100%;
        max-width: 760px;
        transform: none;
    }

    .access-card {
        position: static;
    }
}

@media (max-width: 767.98px) {
    .database-hero {
        padding: 58px 0;
    }

    .database-hero h1 {
        font-size: clamp(41px, 12vw, 57px);
    }

    .database-hero-content > p {
        font-size: 15px;
    }

    .database-access-section {
        padding: 45px 0;
    }

    .access-steps {
        grid-template-columns: 1fr;
    }

    .access-step {
        min-height: auto;
        padding: 21px;
    }
}

@media (max-width: 575.98px) {
    .database-actions {
        flex-direction: column;
    }

    .database-primary-button,
    .database-secondary-button {
        width: 100%;
    }

    .database-preview {
        border-radius: 13px;
    }

    .access-step {
        grid-template-columns: 38px 1fr;
        gap: 13px;
    }

    .step-number {
        width: 38px;
        height: 38px;
    }

    .access-card {
        padding: 24px 21px;
    }
}
</style>


<!-- =========================================================
     SUBSCRIBED ONLINE DATABASE PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes databaseHeroEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 28px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes databaseHeroRingFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }
        50% {
            transform: translate3d(-14px, -14px, 0) rotate(4deg);
        }
    }

    @keyframes databasePreviewFloat {
        0%, 100% {
            transform: rotate(.8deg) translateY(0);
        }
        50% {
            transform: rotate(.3deg) translateY(-7px);
        }
    }

    .database-hero-content {
        animation: databaseHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    .database-hero::after {
        animation: databaseHeroRingFloat 8s ease-in-out infinite;
        will-change: transform;
    }

    .database-preview {
        animation: databasePreviewFloat 6.5s ease-in-out infinite;
        will-change: transform;
    }

    @media (max-width: 991.98px) {
        .database-preview {
            animation: none;
        }
    }

    /* Scroll reveal */
    .database-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
        transition:
            opacity .72s cubic-bezier(.22, 1, .36, 1),
            transform .72s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--database-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .database-motion-reveal.database-motion-left {
        transform: translate3d(-36px, 0, 0);
    }

    .database-motion-reveal.database-motion-right {
        transform: translate3d(36px, 0, 0);
    }

    .database-motion-reveal.database-motion-scale {
        transform: scale(.965);
    }

    .database-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Credential notice */
    .credential-notice {
        transition:
            transform .26s ease,
            background .26s ease,
            border-color .26s ease;
    }

    .credential-notice:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, .11);
        border-color: rgba(244, 180, 0, .22);
    }

    .credential-notice i {
        transition: transform .24s ease;
    }

    .credential-notice:hover i {
        transform: scale(1.08);
    }

    /* Buttons */
    .database-primary-button i,
    .access-card-button i {
        transition: transform .24s ease;
    }

    .database-primary-button:hover i,
    .access-card-button:hover i {
        transform: translate(3px, -3px);
    }

    /* Preview */
    .database-preview {
        transition:
            box-shadow .32s ease,
            border-color .32s ease;
    }

    .database-preview:hover {
        box-shadow: 0 32px 70px rgba(0, 0, 0, .3);
        border-color: rgba(244, 180, 0, .26);
    }

    .database-image {
        transition:
            transform .5s cubic-bezier(.22, 1, .36, 1),
            filter .5s ease;
    }

    .database-preview:hover .database-image {
        transform: scale(1.015);
        filter: saturate(1.03);
    }

    /* Access steps */
    .access-step {
        transition:
            transform .3s cubic-bezier(.22, 1, .36, 1),
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .access-step:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 38px rgba(11, 46, 89, .11);
        border-color: rgba(24, 75, 140, .25);
    }

    .step-number {
        transition:
            transform .24s ease,
            background .24s ease;
    }

    .access-step:hover .step-number {
        transform: scale(1.08);
        background: rgba(244, 180, 0, .28);
    }

    /* Access card */
    .access-card {
        transition:
            transform .34s cubic-bezier(.22, 1, .36, 1),
            box-shadow .34s ease;
    }

    .access-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 24px 54px rgba(11, 46, 89, .22);
    }

    .access-card-notice {
        transition:
            transform .24s ease,
            background .24s ease;
    }

    .access-card-notice:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, .11);
    }

    .access-card-notice i {
        transition: transform .24s ease;
    }

    .access-card-notice:hover i {
        transform: scale(1.08);
    }

        .database-motion-reveal,
        .database-motion-reveal.database-motion-left,
        .database-motion-reveal.database-motion-right,
        .database-motion-reveal.database-motion-scale {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        .credential-notice,
        .credential-notice i,
        .database-primary-button i,
        .access-card-button i,
        .database-preview,
        .database-image,
        .access-step,
        .step-number,
        .access-card,
        .access-card-notice,
        .access-card-notice i {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const revealGroups = [
        { selector: '.database-section-heading', mode: '' },
        { selector: '.access-step', mode: '' },
        { selector: '.access-card', mode: 'database-motion-right' }
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

            element.classList.add('database-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 6) * 75, 375);
            element.style.setProperty('--database-motion-delay', stagger + 'ms');

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


@endsection



