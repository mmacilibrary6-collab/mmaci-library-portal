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

@endsection


