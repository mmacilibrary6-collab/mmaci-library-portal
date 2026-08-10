@extends('layouts.app')

@section('title', 'Reserve AVR | MMACI Library Services Office')

@section('content')

@php
    $formUrl = $formUrl
        ?? 'https://forms.gle/U1bEuUY8EZid1hoZ8';

    $embedUrl = $formUrl . '?embedded=true';
@endphp

{{-- Hero --}}
<section class="recommendation-hero">
    <div class="container">
        <div class="recommendation-hero-content">

            <h1>Reserve AVR</h1>

            <p>
                Reserve the Audio Visual Room for classes, meetings, and other
                group activities that need a larger shared space.
            </p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">

                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="breadcrumb-item">
                        More
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">
                        Reserve AVR
                    </li>

                </ol>
            </nav>

        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="recommendation-section">
    <div class="container">

        <div class="recommendation-layout">

            {{-- Information Panel --}}
            <aside class="recommendation-sidebar">

                <span class="content-label">
                    Reserve a Space
                </span>

                <h2>Use the AVR for your next activity</h2>

                <p class="sidebar-description">
                    The Audio Visual Room provides a larger space for classes,
                    meetings, and other group events.
                </p>

                <div class="recommendation-points">

                    <div class="recommendation-point">
                        <span class="point-icon">
                            <i class="bi bi-check-lg" aria-hidden="true"></i>
                        </span>

                        <div>
                            <strong>Quick reservation</strong>
                            <small>Submit the form using any device.</small>
                        </div>
                    </div>

                    <div class="recommendation-point">
                        <span class="point-icon">
                            <i class="bi bi-check-lg" aria-hidden="true"></i>
                        </span>

                        <div>
                            <strong>For classes and meetings</strong>
                            <small>
                                Great for larger groups and focused sessions.
                            </small>
                        </div>
                    </div>

                    <div class="recommendation-point">
                        <span class="point-icon">
                            <i class="bi bi-check-lg" aria-hidden="true"></i>
                        </span>

                        <div>
                            <strong>AVR capacity</strong>
                            <small>
                                Designed to accommodate up to 100 people.
                            </small>
                        </div>
                    </div>

                </div>

                <div class="recommendation-note">
                    <i class="bi bi-info-circle" aria-hidden="true"></i>

                    <p>
                        Please wait for confirmation from the library before
                        using the AVR.
                    </p>
                </div>

                <a
                    href="{{ $formUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="secondary-action">

                    Open in Google Forms

                    <i
                        class="bi bi-box-arrow-up-right"
                        aria-hidden="true">
                    </i>
                </a>

            </aside>

            {{-- Embedded Form --}}
            <div class="recommendation-form-card">

                <header class="recommendation-form-header">

                    <div>
                        <span>Reservation Form</span>
                        <h2>Submit your AVR request</h2>
                    </div>

                    <a
                        href="{{ $formUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="primary-action">

                        Open Form

                        <i
                            class="bi bi-box-arrow-up-right"
                            aria-hidden="true">
                        </i>
                    </a>

                </header>

                <div class="recommendation-embed">

                    <div class="form-loading" aria-hidden="true">
                        <div class="loading-spinner"></div>
                        <span>Loading AVR reservation form...</span>
                    </div>

                    <iframe
                        src="{{ $embedUrl }}"
                        title="MMACI Reserve AVR Form"
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        onload="this.parentElement.classList.add('form-loaded')">
                    </iframe>

                </div>

            </div>

        </div>

    </div>
</section>

<style>
:root {
    --recommendation-navy: #0b2e59;
    --recommendation-blue: #184b8c;
    --recommendation-gold: #f4b400;
    --recommendation-green: #278b5a;
    --recommendation-text: #18263b;
    --recommendation-muted: #667389;
    --recommendation-background: #f4f7fb;
    --recommendation-border: #dfe6ef;
    --recommendation-white: #ffffff;
}

/* Hero */

.recommendation-hero {
    position: relative;
    min-height: 430px;
    display: grid;
    place-items: center;
    overflow: hidden;
    isolation: isolate;
    color: var(--recommendation-white);
    background-color: var(--recommendation-navy);
    background-image:
        linear-gradient(
            105deg,
            rgba(7, 30, 61, 0.90) 0%,
            rgba(11, 46, 89, 0.72) 55%,
            rgba(24, 75, 140, 0.58) 100%
        ),
        url("{{ asset('images/AVR.jpg') }}");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

.recommendation-hero::after {
    content: "";
    position: absolute;
    right: -140px;
    bottom: -220px;
    width: 440px;
    height: 440px;
    border: 58px solid rgba(244, 180, 0, 0.11);
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
}

.recommendation-hero-content {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 900px;
    margin: auto;
    padding: 85px 15px 70px;
    text-align: center;
}

.hero-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--recommendation-gold);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.13em;
    text-transform: uppercase;
}

.hero-label::before,
.hero-label::after {
    content: "";
    width: 28px;
    height: 2px;
    border-radius: 20px;
    background: var(--recommendation-gold);
}

.recommendation-hero h1 {
    max-width: 900px;
    margin: 18px auto;
    color: var(--recommendation-white);
    font-size: clamp(46px, 6vw, 72px);
    font-weight: 900;
    line-height: 1.04;
    letter-spacing: -0.045em;
    text-wrap: balance;
}

.recommendation-hero p {
    max-width: 700px;
    margin: 0 auto 26px;
    color: rgba(255, 255, 255, 0.82);
    font-size: 17px;
    line-height: 1.75;
}

.recommendation-hero .breadcrumb {
    display: flex;
    flex-wrap: wrap;
    row-gap: 6px;
    font-size: 13px;
}

.recommendation-hero .breadcrumb-item,
.recommendation-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.62);
}

.recommendation-hero .breadcrumb-item a {
    color: var(--recommendation-white);
    font-weight: 700;
    text-decoration: none;
}

.recommendation-hero .breadcrumb-item a:hover {
    color: var(--recommendation-gold);
}

.recommendation-hero
.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.42);
}

/* Main section */

.recommendation-section {
    padding: 70px 0;
    background: var(--recommendation-background);
}

.recommendation-layout {
    display: grid;
    grid-template-columns: minmax(260px, 340px) minmax(0, 1fr);
    gap: 28px;
    align-items: start;
}

/* Sidebar */

.recommendation-sidebar {
    position: sticky;
    top: 100px;
    padding: 30px;
    border: 1px solid var(--recommendation-border);
    border-radius: 20px;
    background: var(--recommendation-white);
    box-shadow: 0 14px 34px rgba(11, 46, 89, 0.07);
}

.content-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--recommendation-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.11em;
    text-transform: uppercase;
}

.content-label::before {
    content: "";
    width: 24px;
    height: 3px;
    border-radius: 10px;
    background: var(--recommendation-gold);
}

.recommendation-sidebar h2 {
    margin: 14px 0 13px;
    color: var(--recommendation-navy);
    font-size: clamp(27px, 3vw, 36px);
    font-weight: 850;
    line-height: 1.12;
    letter-spacing: -0.035em;
}

.sidebar-description {
    margin: 0;
    color: var(--recommendation-muted);
    font-size: 15px;
    line-height: 1.75;
}

.recommendation-points {
    display: grid;
    gap: 18px;
    margin: 26px 0;
    padding-top: 24px;
    border-top: 1px solid var(--recommendation-border);
}

.recommendation-point {
    display: grid;
    grid-template-columns: 34px 1fr;
    gap: 12px;
    align-items: start;
}

.point-icon {
    width: 34px;
    height: 34px;
    display: grid;
    place-items: center;
    border-radius: 10px;
    color: var(--recommendation-navy);
    background: rgba(244, 180, 0, 0.18);
    font-size: 17px;
}

.recommendation-point strong,
.recommendation-point small {
    display: block;
}

.recommendation-point strong {
    margin-bottom: 3px;
    color: var(--recommendation-navy);
    font-size: 14px;
    font-weight: 800;
}

.recommendation-point small {
    color: var(--recommendation-muted);
    font-size: 12px;
    line-height: 1.5;
}

.recommendation-note {
    display: grid;
    grid-template-columns: 20px 1fr;
    gap: 10px;
    margin-bottom: 22px;
    padding: 14px;
    border-left: 3px solid var(--recommendation-blue);
    border-radius: 8px;
    color: var(--recommendation-muted);
    background: #f3f7fc;
}

.recommendation-note i {
    color: var(--recommendation-blue);
}

.recommendation-note p {
    margin: 0;
    font-size: 12px;
    line-height: 1.6;
}

/* Buttons */

.primary-action,
.secondary-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    min-height: 44px;
    padding: 11px 17px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        background 0.2s ease;
}

.primary-action {
    flex-shrink: 0;
    color: var(--recommendation-navy);
    background: var(--recommendation-gold);
}

.secondary-action {
    width: 100%;
    color: var(--recommendation-white);
    background: var(--recommendation-navy);
}

.primary-action:hover,
.secondary-action:hover {
    transform: translateY(-2px);
}

.primary-action:hover {
    color: var(--recommendation-navy);
    box-shadow: 0 10px 22px rgba(244, 180, 0, 0.22);
}

.secondary-action:hover {
    color: var(--recommendation-white);
    background: var(--recommendation-blue);
    box-shadow: 0 10px 22px rgba(11, 46, 89, 0.18);
}

/* Form card */

.recommendation-form-card {
    min-width: 0;
    overflow: hidden;
    border: 1px solid var(--recommendation-border);
    border-radius: 20px;
    background: var(--recommendation-white);
    box-shadow: 0 14px 34px rgba(11, 46, 89, 0.08);
}

.recommendation-form-header {
    min-height: 88px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    border-bottom: 1px solid var(--recommendation-border);
}

.recommendation-form-header span {
    display: block;
    color: var(--recommendation-blue);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.11em;
    text-transform: uppercase;
}

.recommendation-form-header h2 {
    margin: 5px 0 0;
    color: var(--recommendation-navy);
    font-size: clamp(20px, 2vw, 25px);
    font-weight: 850;
    line-height: 1.2;
    letter-spacing: -0.025em;
}

.recommendation-embed {
    position: relative;
    width: 100%;
    height: min(1050px, calc(100vh - 120px));
    min-height: 720px;
    background: #f7f9fc;
}

.recommendation-embed iframe {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    display: block;
    border: 0;
    background: var(--recommendation-white);
}

.form-loading {
    position: absolute;
    inset: 0;
    display: grid;
    place-content: center;
    justify-items: center;
    gap: 12px;
    color: var(--recommendation-muted);
    font-size: 13px;
}

.form-loaded .form-loading {
    display: none;
}

.loading-spinner {
    width: 34px;
    height: 34px;
    border: 3px solid #dfe6ef;
    border-top-color: var(--recommendation-blue);
    border-radius: 50%;
    animation: recommendation-spin 0.8s linear infinite;
}

@keyframes recommendation-spin {
    to {
        transform: rotate(360deg);
    }
}

/* Responsive */

@media (max-width: 991.98px) {
    .recommendation-layout {
        grid-template-columns: 1fr;
    }

    .recommendation-sidebar {
        position: static;
    }

    .recommendation-points {
        grid-template-columns: repeat(3, 1fr);
    }

    .recommendation-note {
        max-width: 700px;
    }

    .secondary-action {
        width: auto;
    }
}

@media (max-width: 767.98px) {
    .recommendation-hero {
        min-height: 390px;
    }

    .recommendation-hero-content {
        padding: 72px 10px 62px;
    }

    .recommendation-hero h1 {
        font-size: clamp(40px, 12vw, 56px);
    }

    .recommendation-hero p {
        font-size: 15px;
        line-height: 1.65;
    }

    .recommendation-section {
        padding: 45px 0;
    }

    .recommendation-sidebar {
        padding: 24px 21px;
        border-radius: 17px;
    }

    .recommendation-points {
        grid-template-columns: 1fr;
    }

    .recommendation-form-card {
        border-radius: 17px;
    }

    .recommendation-form-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 19px 20px;
    }

    .primary-action {
        width: 100%;
    }

    .recommendation-embed {
        height: 900px;
        min-height: 900px;
    }
}

@media (max-width: 575.98px) {
    .hero-label {
        font-size: 10px;
    }

    .hero-label::before,
    .hero-label::after {
        width: 17px;
    }

    .recommendation-hero .breadcrumb {
        display: none;
    }

    .recommendation-embed {
        height: 820px;
        min-height: 820px;
    }
}
</style>

    @include('components.lisa-chatbox')


<!-- =========================================================
     RESERVE AVR PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes avrHeroEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 28px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes avrHeroRingFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }
        50% {
            transform: translate3d(-13px, -13px, 0) rotate(4deg);
        }
    }

    .recommendation-hero-content {
        animation: avrHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    .recommendation-hero::after {
        animation: avrHeroRingFloat 7.5s ease-in-out infinite;
        will-change: transform;
    }

    /* Scroll reveal */
    .avr-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
        transition:
            opacity .72s cubic-bezier(.22, 1, .36, 1),
            transform .72s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--avr-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .avr-motion-reveal.avr-motion-left {
        transform: translate3d(-36px, 0, 0);
    }

    .avr-motion-reveal.avr-motion-right {
        transform: translate3d(36px, 0, 0);
    }

    .avr-motion-reveal.avr-motion-scale {
        transform: scale(.965);
    }

    .avr-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Sidebar */
    .recommendation-sidebar {
        transition:
            transform .34s cubic-bezier(.22, 1, .36, 1),
            box-shadow .34s ease,
            border-color .34s ease;
    }

    .recommendation-sidebar:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 46px rgba(11, 46, 89, .11);
        border-color: rgba(24, 75, 140, .18);
    }

    .recommendation-point {
        transition:
            transform .24s ease,
            color .24s ease;
    }

    .recommendation-point:hover {
        transform: translateX(5px);
    }

    .point-icon {
        transition:
            transform .24s ease,
            background .24s ease;
    }

    .recommendation-point:hover .point-icon {
        transform: scale(1.08);
        background: rgba(244, 180, 0, .28);
    }

    .recommendation-note {
        transition:
            transform .26s ease,
            box-shadow .26s ease;
    }

    .recommendation-note:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(11, 46, 89, .08);
    }

    /* Buttons */
    .primary-action i,
    .secondary-action i {
        transition: transform .24s ease;
    }

    .primary-action:hover i,
    .secondary-action:hover i {
        transform: translate(3px, -3px);
    }

    /* Form card */
    .recommendation-form-card {
        transition:
            transform .34s cubic-bezier(.22, 1, .36, 1),
            box-shadow .34s ease,
            border-color .34s ease;
    }

    .recommendation-form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 46px rgba(11, 46, 89, .12);
        border-color: rgba(24, 75, 140, .18);
    }

    .recommendation-form-header {
        transition: background .25s ease;
    }

    .recommendation-form-card:hover .recommendation-form-header {
        background: rgba(24, 75, 140, .018);
    }

    /* Loading animation polish */
    .form-loading span {
        animation: avrLoadingPulse 1.6s ease-in-out infinite;
    }

    @keyframes avrLoadingPulse {
        0%, 100% {
            opacity: .55;
        }
        50% {
            opacity: 1;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const revealGroups = [
        { selector: '.recommendation-sidebar', mode: 'avr-motion-left' },
        { selector: '.recommendation-form-card', mode: 'avr-motion-right' }
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

            element.classList.add('avr-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 6) * 75, 375);
            element.style.setProperty('--avr-motion-delay', stagger + 'ms');

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
        rootMargin: '0px 0px -45px 0px'
    });

    revealElements.forEach(function (element) {
        observer.observe(element);
    });
});
</script>


@endsection


