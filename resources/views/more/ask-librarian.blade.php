@extends('layouts.app')

@section('title', 'Ask the Librarian | MMACI Library Services Office')

@section('content')

@php
    $facebookUrl = 'https://www.facebook.com/MMACILibrary/';
    $youtubeUrl = 'https://www.youtube.com/channel/UC9wkl5BvNXqhxQgYi8WP3ig';
    $surveyUrl = 'https://docs.google.com/forms/d/e/1FAIpQLSedbW1FN9CIQ8-vFvwqcEptpBHOtObKgHks_34kz7_3nheTTA/viewform';

    $officialContacts = collect([
        [
            'title' => 'Facebook',
            'value' => 'MMACI Library',
            'url' => $facebookUrl,
            'icon' => 'bi-facebook',
        ],
        [
            'title' => 'YouTube',
            'value' => 'MMACI Library Channel',
            'url' => $youtubeUrl,
            'icon' => 'bi-youtube',
        ],
    ])->concat(
        collect($contactInformation ?? [])->reject(function ($contact) {
            return in_array(
                strtolower($contact['title'] ?? ''),
                ['facebook', 'youtube'],
                true
            );
        })
    );
@endphp

<!-- ================= HERO ================= -->

<section class="ask-hero">

    <div class="ask-hero-overlay"></div>

    <div class="container position-relative">

        <div class="ask-hero-content">

            

            <h1>
                Contact Us!
            </h1>

            <p>
                Connect with the MMACI Library Services Office for library
                concerns, assistance, learning resources, and service
                feedback.
            </p>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb justify-content-center mb-0">

                    <li class="breadcrumb-item">

                        <a href="{{ route('home') }}">
                            Home
                        </a>

                    </li>

                    <li
                        class="breadcrumb-item active"
                        aria-current="page">

                        Ask the Librarian

                    </li>

                </ol>

            </nav>

        </div>

    </div>

</section>

<!-- ================= CONTACT ================= -->

<section class="library-contact-section">

    <div class="container">

        <div class="text-center contact-heading">

            <span class="section-label">
                Stay Connected
            </span>

            <h2 class="section-title">
                Contact the Library
            </h2>

            <p class="section-description">
                Reach us through our official social media and communication
                channels.
            </p>

        </div>

        <div class="row g-4 justify-content-center">

            @foreach ($officialContacts as $contact)

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <a
                        href="{{ $contact['url'] }}"
                        target="{{ str_starts_with(
                            $contact['url'],
                            'mailto:'
                        ) ? '_self' : '_blank' }}"
                        rel="noopener noreferrer"
                        class="library-contact-card">

                        <div class="library-contact-icon">

                            <i class="bi {{ $contact['icon'] }}"></i>

                        </div>

                        <span>
                            {{ $contact['title'] }}
                        </span>

                        <h3>
                            {{ $contact['value'] }}
                        </h3>

                        <div class="library-contact-link">

                            <span>
                                Open {{ $contact['title'] }}
                            </span>

                            <i class="bi bi-arrow-up-right"></i>

                        </div>

                    </a>

                </div>

            @endforeach

        </div>

    </div>

</section>

<!-- ================= TEACH ME HOW ================= -->

<section class="tutorial-section">

    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-5">

                <span class="section-label">
                    Library Tutorials
                </span>

                <h2 class="section-title text-start">
                    Teach Me How To
                </h2>

                <p class="tutorial-description">
                    Explore simple guides that can help you access library
                    resources and use available digital services.
                </p>

            </div>

            <div class="col-lg-7">

                @foreach ($tutorials as $tutorial)

                    <a
                        href="{{ $tutorial['url'] }}"
                        class="tutorial-card">

                        <div class="tutorial-icon">

                            <i class="bi {{ $tutorial['icon'] }}"></i>

                        </div>

                        <div>

                            <span>
                                Step-by-Step Guide
                            </span>

                            <h3>
                                {{ $tutorial['title'] }}
                            </h3>

                            <p>
                                {{ $tutorial['description'] }}
                            </p>

                        </div>

                        <i class="bi bi-arrow-right tutorial-arrow"></i>

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>

<!-- ================= SATISFACTION SURVEY ================= -->

<section class="survey-section">

    <div class="container">

        <div class="survey-card">
            <div>
                <span>Library Satisfaction Survey</span>

                <h2>Tell us about your library experience.</h2>

                <p>
                    Share your feedback and help us improve our collections,
                    facilities, and services.
                </p>
            </div>

            <a
                href="{{ $surveyUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="survey-button">
                Complete Survey
                <i class="bi bi-arrow-up-right"></i>
            </a>

        </div>

    </div>

</section>

<!-- ================= VISITING RESEARCHERS ================= -->

<section class="researcher-form-section">

    <div class="container">

        <div class="researcher-form-card">

            <div class="researcher-form-icon">

                <i class="bi bi-person-badge-fill"></i>

            </div>

            <div>

                <span>
                    For Visiting Researchers
                </span>

                <h2>
                    File an Appointment Before Your Visit
                </h2>

                <p>
                    Visiting researchers may complete the appointment form
                    before accessing selected library materials and
                    services.
                </p>

            </div>

            <a
                href="{{ $visitingResearcherFormUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-primary rounded-pill px-4 py-3">

                Open Appointment Form

                <i class="bi bi-box-arrow-up-right ms-2"></i>

            </a>

        </div>

    </div>

</section>

<style>

:root {
    --mmaci-navy: #0B2E59;
    --mmaci-blue: #184B8C;
    --mmaci-yellow: #F4B400;
    --mmaci-light: #F5F7FB;
    --mmaci-text: #5E6878;
    --mmaci-border: #E1E7F0;
}

/* Hero */

.ask-hero {
    position: relative;
    min-height: 380px;
    display: flex;
    align-items: center;
    overflow: hidden;
    color: #ffffff;
    background:
        linear-gradient(
            115deg,
            rgba(5, 25, 54, 0.97),
            rgba(11, 46, 89, 0.91),
            rgba(24, 75, 140, 0.76)
        ),
        url("{{ asset('images/readingarea.jpg') }}")
        center / cover no-repeat;
}

.ask-hero::before {
    content: "";
    position: absolute;
    top: -190px;
    right: -110px;
    width: 440px;
    height: 440px;
    border: 76px solid rgba(244, 180, 0, 0.09);
    border-radius: 50%;
}

.ask-hero-overlay {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(
            circle at 72% 25%,
            rgba(255, 255, 255, 0.10),
            transparent 29%
        );
}

.ask-hero-content {
    position: relative;
    z-index: 2;
    max-width: 900px;
    margin: auto;
    padding: 78px 0 64px;
    text-align: center;
}

.ask-hero-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--mmaci-yellow);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.10em;
    text-transform: uppercase;
}

.ask-hero-label::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--mmaci-yellow);
    border-radius: 10px;
}

.ask-hero h1 {
    margin: 14px 0;
    font-size: clamp(43px, 5.5vw, 64px);
    font-weight: 800;
    letter-spacing: -0.04em;
}

.ask-hero p {
    max-width: 700px;
    margin: 0 auto 20px;
    color: rgba(255, 255, 255, 0.80);
    font-size: 17px;
    line-height: 1.8;
}

.ask-hero .breadcrumb {
    display: inline-flex;
    font-size: 13px;
}

.ask-hero .breadcrumb-item,
.ask-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.6);
    font-size: 13px;
}

.ask-hero .breadcrumb-item a {
    color: #ffffff;
    font-weight: 600;
    text-decoration: none;
}

.ask-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.36);
}

/* Shared */

.library-contact-section,
.survey-section,
.researcher-form-section {
    padding: 56px 0;
    background: #ffffff;
}

.contact-heading {
    max-width: 760px;
    margin: 0 0 28px;
    text-align: left !important;
}

.section-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--mmaci-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.10em;
    text-transform: uppercase;
}

.section-label::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--mmaci-yellow);
    border-radius: 10px;
}

.section-title {
    margin: 11px 0;
    color: var(--mmaci-navy);
    font-size: clamp(32px, 4vw, 47px);
    font-weight: 800;
    letter-spacing: -0.03em;
}

.section-description {
    color: var(--mmaci-text);
    font-size: 16px;
    line-height: 1.85;
}

/* Contact cards */

.library-contact-card {
    display: block;
    height: 100%;
    padding: 22px;
    color: inherit;
    text-decoration: none;
    background: #ffffff;
    border: 1px solid var(--mmaci-border);
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(11, 46, 89, 0.06);
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.library-contact-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 42px rgba(11, 46, 89, 0.14);
}

.library-contact-icon {
    display: flex;
    width: 48px;
    height: 48px;
    align-items: center;
    justify-content: center;
    margin-bottom: 17px;
    color: var(--mmaci-navy);
    background: var(--mmaci-yellow);
    border-radius: 12px;
    font-size: 20px;
}

.library-contact-card > span {
    color: var(--mmaci-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.09em;
    text-transform: uppercase;
}

.library-contact-card h3 {
    min-height: 45px;
    margin: 7px 0 15px;
    color: var(--mmaci-navy);
    font-size: 17px;
    font-weight: 800;
    line-height: 1.45;
}

.library-contact-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 13px;
    color: var(--mmaci-blue);
    border-top: 1px solid #EDF0F5;
    font-size: 13px;
    font-weight: 800;
}

/* Tutorials */

.tutorial-section {
    padding: 56px 0;
    background: var(--mmaci-light);
}

.tutorial-description {
    color: var(--mmaci-text);
    line-height: 1.85;
}

.tutorial-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    color: inherit;
    text-decoration: none;
    background: #ffffff;
    border: 1px solid var(--mmaci-border);
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(11, 46, 89, 0.06);
    transition:
        transform 0.3s ease,
        box-shadow 0.3s ease;
}

.tutorial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 18px 38px rgba(11, 46, 89, 0.13);
}

.tutorial-icon {
    display: flex;
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    color: var(--mmaci-navy);
    background: var(--mmaci-yellow);
    border-radius: 12px;
    font-size: 20px;
}

.tutorial-card span {
    color: var(--mmaci-blue);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
}

.tutorial-card h3 {
    margin: 6px 0;
    color: var(--mmaci-navy);
    font-size: 18px;
    font-weight: 800;
}

.tutorial-card p {
    margin: 0;
    color: var(--mmaci-text);
    font-size: 14px;
    line-height: 1.7;
}

.tutorial-arrow {
    margin-left: auto;
    color: var(--mmaci-blue);
    font-size: 22px;
}

/* Survey */

.survey-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    padding: 34px 38px;
    color: #ffffff;
    background:
        radial-gradient(
            circle at top right,
            rgba(244, 180, 0, 0.30),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            var(--mmaci-navy),
            var(--mmaci-blue)
        );
    border-radius: 17px;
    box-shadow: 0 16px 40px rgba(11, 46, 89, 0.16);
}

.survey-card span {
    color: var(--mmaci-yellow);
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}

.survey-card h2 {
    margin: 7px 0;
    font-size: clamp(25px, 3vw, 34px);
    font-weight: 800;
}

.survey-card p {
    max-width: 700px;
    margin: 0;
    color: rgba(255, 255, 255, 0.76);
    line-height: 1.8;
}

.survey-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-shrink: 0;
    padding: 13px 19px;
    color: var(--mmaci-navy);
    background: var(--mmaci-yellow);
    border-radius: 9px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
}

.survey-button:hover {
    color: var(--mmaci-navy);
    transform: translateY(-2px);
}

/* Researcher form */

.researcher-form-section {
    padding-top: 0;
}

.researcher-form-card {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 26px;
    background: var(--mmaci-light);
    border: 1px solid var(--mmaci-border);
    border-radius: 15px;
}

.researcher-form-icon {
    display: flex;
    width: 52px;
    height: 52px;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    background: var(--mmaci-navy);
    border-radius: 13px;
    font-size: 21px;
}

.researcher-form-card > div:nth-child(2) {
    flex: 1;
}

.researcher-form-card span {
    color: var(--mmaci-blue);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
}

.researcher-form-card h2 {
    margin: 7px 0;
    color: var(--mmaci-navy);
    font-weight: 800;
}

.researcher-form-card p {
    margin: 0;
    color: var(--mmaci-text);
    line-height: 1.7;
}

.researcher-form-card .btn-primary {
    flex-shrink: 0;
    background: var(--mmaci-blue);
    border: 0;
    font-weight: 700;
}

@media (max-width: 991.98px) {
    .survey-card {
        align-items: flex-start;
        flex-direction: column;
    }

    .researcher-form-card {
        align-items: flex-start;
        flex-direction: column;
    }

}

@media (max-width: 575.98px) {

    .ask-hero h1 {
        font-size: 44px;
    }

    .tutorial-card {
        align-items: flex-start;
        flex-direction: column;
    }

    .tutorial-arrow {
        margin-left: 0;
    }

    .survey-card {
        padding: 28px 23px;
    }

    .researcher-form-card {
        padding: 27px 22px;
    }

    .survey-button {
        width: 100%;
    }

}

</style>

    @include('components.lisa-chatbox')


<!-- =========================================================
     ASK THE LIBRARIAN PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes askHeroEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 26px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes askHeroRingFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }
        50% {
            transform: translate3d(-14px, 12px, 0) rotate(4deg);
        }
    }

    .ask-hero-content {
        animation: askHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    .ask-hero::before {
        animation: askHeroRingFloat 8s ease-in-out infinite;
        will-change: transform;
    }

    /* Scroll reveal */
    .ask-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 28px, 0);
        transition:
            opacity .7s cubic-bezier(.22, 1, .36, 1),
            transform .7s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--ask-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .ask-motion-reveal.ask-motion-left {
        transform: translate3d(-34px, 0, 0);
    }

    .ask-motion-reveal.ask-motion-right {
        transform: translate3d(34px, 0, 0);
    }

    .ask-motion-reveal.ask-motion-scale {
        transform: scale(.97);
    }

    .ask-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Contact cards */
    .library-contact-card {
        transition:
            transform .32s cubic-bezier(.22, 1, .36, 1),
            box-shadow .32s ease,
            border-color .32s ease;
    }

    .library-contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 46px rgba(11, 46, 89, .14);
        border-color: rgba(24, 75, 140, .18);
    }

    .library-contact-icon {
        transition:
            transform .25s ease,
            box-shadow .25s ease;
    }

    .library-contact-card:hover .library-contact-icon {
        transform: translateY(-3px) scale(1.07);
        box-shadow: 0 12px 24px rgba(244, 180, 0, .2);
    }

    .library-contact-link i {
        transition: transform .24s ease;
    }

    .library-contact-card:hover .library-contact-link i {
        transform: translate(3px, -3px);
    }

    /* Tutorials */
    .tutorial-card {
        transition:
            transform .3s cubic-bezier(.22, 1, .36, 1),
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .tutorial-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 42px rgba(11, 46, 89, .13);
        border-color: rgba(24, 75, 140, .18);
    }

    .tutorial-icon {
        transition:
            transform .25s ease,
            box-shadow .25s ease;
    }

    .tutorial-card:hover .tutorial-icon {
        transform: scale(1.07);
        box-shadow: 0 10px 22px rgba(244, 180, 0, .18);
    }

    .tutorial-arrow {
        transition: transform .25s ease;
    }

    .tutorial-card:hover .tutorial-arrow {
        transform: translateX(5px);
    }

    /* Survey */
    .survey-card {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .survey-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 24px 54px rgba(11, 46, 89, .2);
    }

    .survey-button {
        transition:
            transform .22s ease,
            box-shadow .22s ease;
    }

    .survey-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(244, 180, 0, .22);
    }

    .survey-button i {
        transition: transform .24s ease;
    }

    .survey-button:hover i {
        transform: translate(3px, -3px);
    }

    /* Visiting researcher CTA */
    .researcher-form-card {
        transition:
            transform .32s cubic-bezier(.22, 1, .36, 1),
            box-shadow .32s ease,
            border-color .32s ease;
    }

    .researcher-form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 40px rgba(11, 46, 89, .11);
        border-color: rgba(24, 75, 140, .18);
    }

    .researcher-form-icon {
        transition:
            transform .25s ease,
            background .25s ease;
    }

    .researcher-form-card:hover .researcher-form-icon {
        transform: scale(1.07);
        background: var(--mmaci-blue);
    }

    .researcher-form-card .btn i {
        transition: transform .24s ease;
    }

    .researcher-form-card .btn:hover i {
        transform: translate(3px, -3px);
    }

    @media (prefers-reduced-motion: reduce) {
        .ask-hero-content,
        .ask-hero::before {
            animation: none !important;
        }

        .ask-motion-reveal,
        .ask-motion-reveal.ask-motion-left,
        .ask-motion-reveal.ask-motion-right,
        .ask-motion-reveal.ask-motion-scale {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        .library-contact-card,
        .library-contact-icon,
        .library-contact-link i,
        .tutorial-card,
        .tutorial-icon,
        .tutorial-arrow,
        .survey-card,
        .survey-button,
        .survey-button i,
        .researcher-form-card,
        .researcher-form-icon,
        .researcher-form-card .btn i {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const revealGroups = [
        { selector: '.contact-heading', mode: '' },
        { selector: '.library-contact-card', mode: '' },
        { selector: '.tutorial-section .col-lg-5', mode: 'ask-motion-left' },
        { selector: '.tutorial-section .col-lg-7', mode: 'ask-motion-right' },
        { selector: '.survey-card', mode: 'ask-motion-scale' },
        { selector: '.researcher-form-card', mode: '' }
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

            element.classList.add('ask-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 6) * 75, 375);
            element.style.setProperty('--ask-motion-delay', stagger + 'ms');

            revealElements.push(element);
        });
    });

    if (reducedMotion || !('IntersectionObserver' in window)) {
        revealElements.forEach(function (element) {
            element.classList.add('is-visible');
        });
        return;
    }

    const observer = new IntersectionObserver(function (entries, instance) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;

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
