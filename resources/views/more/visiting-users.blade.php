@extends('layouts.app')

@section('title', 'Visiting Researchers | MMACI Library Services Office')

@section('content')

@php
    $appointmentEmbedUrl = $appointmentFormUrl . '?embedded=true';
@endphp

<!-- ================= HERO ================= -->

<section class="visiting-hero">

    <div class="visiting-hero-overlay"></div>

    <div class="container position-relative">

        <div class="row align-items-center g-5 visiting-hero-row">

            <div
                class="col-lg-6 order-2 order-lg-1"
                data-aos="fade-right">

                <span class="visiting-hero-label">
                    Visiting Researchers
                </span>

                <h1>
                    Access Library Resources for Your Research
                </h1>

                <p>
                    Visiting researchers may access selected library
                    resources after completing the appointment process and
                    coordinating with the MMACI Library Services Office.
                </p>

                <div class="visiting-hero-actions">

                    <a
                        href="{{ $appointmentFormUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-warning rounded-pill px-4 py-3 fw-bold">

                        Complete Appointment Form

                        <i class="bi bi-box-arrow-up-right ms-2"></i>

                    </a>

                    <a
                        href="{{ route('collection.printed') }}"
                        class="btn btn-outline-light rounded-pill px-4 py-3">

                        Browse Collections

                    </a>

                </div>

            </div>

            <!-- Placeholder Image -->

            <div
                class="col-lg-6 order-1 order-lg-2"
                data-aos="fade-left">

                <div class="visitor-placeholder">

                    <img
                        src="{{ asset('images/libraryservicess.jpg') }}"
                        alt="MMACI Library visiting researchers"
                        onerror="this.onerror=null; this.src='{{ asset('images/Door.jpg') }}';">

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= INTRODUCTION ================= -->

<section class="visiting-introduction">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-8 text-center">

                <span class="section-label">
                    Research Access
                </span>

                <h2 class="section-title">
                    Do You Wish to Use Our Resources?
                </h2>

                <p class="section-description">
                    Follow the steps below before using the library’s
                    research materials and facilities.
                </p>

            </div>

        </div>

    </div>

</section>

<!-- ================= PROCESS ================= -->

<section class="visitor-process-section">

    <div class="container">

        <div class="row g-4">

            @foreach ($steps as $step)

                <div
                    class="col-lg-6"
                    data-aos="fade-up"
                    data-aos-delay="{{ ($loop->index % 2) * 100 }}">

                    <article class="visitor-step-card">

                        <div class="visitor-step-number">

                            {{ str_pad(
                                $loop->iteration,
                                2,
                                '0',
                                STR_PAD_LEFT
                            ) }}

                        </div>

                        <div class="visitor-step-icon">

                            <i class="bi {{ $step['icon'] }}"></i>

                        </div>

                        <div class="visitor-step-content">

                            <h3>
                                {{ $step['title'] }}
                            </h3>

                            <p>
                                {{ $step['description'] }}
                            </p>

                        </div>

                    </article>

                </div>

            @endforeach

        </div>

    </div>

</section>

<!-- ================= APPOINTMENT CTA ================= -->

<section class="appointment-section">

    <div class="container">

        <div class="appointment-card">

            <div class="row align-items-center g-5">

                <div class="col-lg-8">

                    <span>
                        Appointment Form
                    </span>

                    <h2>
                        Schedule Your Library Visit
                    </h2>

                    <p>
                        Complete the visiting researcher appointment form
                        before your intended visit. You may also inquire
                        directly with the library regarding walk-in access.
                    </p>

                    <a
                        href="{{ $appointmentFormUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-warning rounded-pill px-4 py-3 fw-bold">

                        Open in Google Forms

                        <i class="bi bi-box-arrow-up-right ms-2"></i>

                    </a>

                </div>

                <div class="col-lg-4">

                    <div class="appointment-icon">

                        <i class="bi bi-calendar2-check-fill"></i>

                    </div>

                </div>

            </div>

            <div class="appointment-embed-wrap">

                <div class="appointment-embed-header">

                    <div>

                        <span>Google Form</span>

                        <h3>Visiting Researcher Appointment</h3>

                    </div>

                  

                </div>

                <div class="appointment-embed">

                    <iframe
                        src="{{ $appointmentEmbedUrl }}"
                        title="Visiting Researcher Appointment Form"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= REMINDERS ================= -->

<section class="visitor-reminders-section">

    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-5">

                <span class="section-label">
                    Before You Visit
                </span>

                <h2 class="section-title text-start">
                    Important Reminders
                </h2>

                <p class="visitor-reminder-description">
                    Please prepare the necessary information and coordinate
                    with library personnel before accessing materials.
                </p>

            </div>

            <div class="col-lg-7">

                <div class="visitor-reminder-list">

                    <div class="visitor-reminder-item">

                        <i class="bi bi-person-vcard-fill"></i>

                        <div>

                            <h3>
                                Bring Valid Identification
                            </h3>

                            <p>
                                Visiting researchers may be requested to
                                present a valid school, company, or
                                government-issued identification card.
                            </p>

                        </div>

                    </div>

                    <div class="visitor-reminder-item">

                        <i class="bi bi-clock-fill"></i>

                        <div>

                            <h3>
                                Visit During Library Hours
                            </h3>

                            <p>
                                Monday to Friday, 8:00 AM to 9:00 PM, and
                                Saturday, 8:00 AM to 5:00 PM.
                            </p>

                        </div>

                    </div>

                    <div class="visitor-reminder-item">

                        <i class="bi bi-chat-left-text-fill"></i>

                        <div>

                            <h3>
                                Coordinate With Library Personnel
                            </h3>

                            <p>
                                Ask the library staff for assistance in
                                locating and accessing the materials you
                                need.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<style>
    :root {
        --mmaci-navy: #0b2e59;
        --mmaci-blue: #184b8c;
        --mmaci-yellow: #f4b400;
        --mmaci-light: #f5f7fb;
        --mmaci-text: #5e6878;
        --mmaci-border: #e1e7f0;
    }

    /* ================= HERO ================= */

    .visiting-hero {
        position: relative;
        overflow: hidden;
        color: #ffffff;
        background:
            radial-gradient(
                circle at 86% 15%,
                rgba(244, 180, 0, 0.20),
                transparent 27%
            ),
            linear-gradient(
                135deg,
                #071f3d,
                var(--mmaci-navy) 55%,
                var(--mmaci-blue)
            );
    }

    .visiting-hero::before {
        content: "";
        position: absolute;
        right: -130px;
        bottom: -180px;
        width: 430px;
        height: 430px;
        border: 75px solid rgba(255, 255, 255, 0.04);
        border-radius: 50%;
        pointer-events: none;
    }

    .visiting-hero-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                rgba(11, 46, 89, 0.70),
                rgba(11, 46, 89, 0.70)
            ),
            url("{{ asset('images/readingarea.jpg') }}")
            center / cover no-repeat;
        opacity: 0.16;
    }

    .visiting-hero-row {
        min-height: 680px;
        padding: 100px 0 70px;
    }

    .visiting-hero-label {
        display: inline-block;
        padding: 9px 18px;
        color: var(--mmaci-navy);
        background: var(--mmaci-yellow);
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.10em;
        text-transform: uppercase;
    }

    .visiting-hero h1 {
        max-width: 690px;
        margin: 24px 0 22px;
        font-size: clamp(44px, 5.5vw, 70px);
        font-weight: 800;
        line-height: 1.07;
        letter-spacing: -0.04em;
    }

    .visiting-hero p {
        max-width: 650px;
        margin-bottom: 31px;
        color: rgba(255, 255, 255, 0.79);
        font-size: 17px;
        line-height: 1.85;
    }

    .visiting-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .visiting-hero-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-width: 2px;
        font-size: 13px;
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease;
    }

    .visiting-hero-actions .btn:hover {
        transform: translateY(-3px);
    }

    .visiting-hero-actions .btn-warning {
        color: var(--mmaci-navy);
        background: var(--mmaci-yellow);
        border-color: var(--mmaci-yellow);
        box-shadow: 0 12px 25px rgba(244, 180, 0, 0.18);
    }

    /* ================= PLACEHOLDER IMAGE ================= */

    .visitor-placeholder {
        position: relative;
        width: 100%;
        max-width: 540px;
        height: 470px;
        margin-left: auto;
        padding: 10px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.24);
        border-radius: 28px;
        box-shadow:
            0 28px 60px rgba(0, 0, 0, 0.28),
            inset 0 1px rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
    }

    .visitor-placeholder::before {
        content: "";
        position: absolute;
        z-index: 2;
        top: -75px;
        right: -75px;
        width: 190px;
        height: 190px;
        pointer-events: none;
        background: rgba(244, 180, 0, 0.18);
        border-radius: 50%;
    }

    .visitor-placeholder::after {
        content: "";
        position: absolute;
        z-index: 2;
        right: 10px;
        bottom: 10px;
        left: 10px;
        height: 42%;
        pointer-events: none;
        background: linear-gradient(
            180deg,
            transparent,
            rgba(7, 31, 61, 0.33)
        );
        border-radius: 0 0 19px 19px;
    }

    .visitor-placeholder img {
        position: relative;
        z-index: 1;
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
        border-radius: 19px;
        transition:
            transform 0.55s ease,
            filter 0.55s ease;
    }

    .visitor-placeholder:hover img {
        filter: saturate(1.06);
        transform: scale(1.025);
    }

    /* ================= GENERAL ================= */

    .visiting-introduction,
    .visitor-reminders-section {
        padding: 100px 0;
        background: #ffffff;
    }

    .section-label {
        display: inline-block;
        padding: 8px 14px;
        color: var(--mmaci-blue);
        background: rgba(24, 75, 140, 0.08);
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.10em;
        text-transform: uppercase;
    }

    .section-title {
        margin: 18px 0 16px;
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

    /* ================= PROCESS ================= */

    .visitor-process-section {
        padding: 20px 0 105px;
        background: var(--mmaci-light);
    }

    .visitor-step-card {
        position: relative;
        height: 100%;
        padding: 30px;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid var(--mmaci-border);
        border-radius: 19px;
        box-shadow: 0 10px 30px rgba(11, 46, 89, 0.07);
        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease;
    }

    .visitor-step-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 42px rgba(11, 46, 89, 0.14);
    }

    .visitor-step-number {
        position: absolute;
        top: 15px;
        right: 18px;
        color: rgba(11, 46, 89, 0.10);
        font-size: 40px;
        font-weight: 900;
    }

    .visitor-step-icon {
        width: 58px;
        height: 58px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--mmaci-navy);
        background: var(--mmaci-yellow);
        border-radius: 15px;
        font-size: 24px;
    }

    .visitor-step-content {
        position: relative;
        z-index: 1;
    }

    .visitor-step-content h3 {
        margin-bottom: 10px;
        color: var(--mmaci-navy);
        font-size: 19px;
        font-weight: 800;
    }

    .visitor-step-content p {
        margin: 0;
        color: var(--mmaci-text);
        font-size: 14px;
        line-height: 1.75;
    }

    /* ================= APPOINTMENT ================= */

    .appointment-section {
        padding: 100px 0;
        background: #ffffff;
    }

    .appointment-card {
        position: relative;
        overflow: hidden;
        border-radius: 27px;
        background: #ffffff;
        box-shadow: 0 22px 55px rgba(11, 46, 89, 0.12);
    }

    .appointment-card::after {
        content: "";
        position: absolute;
        right: -80px;
        bottom: -120px;
        width: 270px;
        height: 270px;
        border: 45px solid rgba(255, 255, 255, 0.04);
        border-radius: 50%;
        pointer-events: none;
    }

    .appointment-card .row {
        position: relative;
        z-index: 1;
        padding: 55px;
        color: #ffffff;
        background:
            radial-gradient(
                circle at top right,
                rgba(244, 180, 0, 0.28),
                transparent 35%
            ),
            linear-gradient(
                135deg,
                var(--mmaci-navy),
                var(--mmaci-blue)
            );
    }

    .appointment-embed-wrap {
        border-top: 1px solid #e7edf5;
        background: #ffffff;
    }

    .appointment-embed-header {
        padding: 22px 55px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .appointment-embed-header span {
        display: block;
        color: var(--mmaci-muted);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .appointment-embed-header h3 {
        margin: 4px 0 0;
        color: var(--mmaci-navy);
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .appointment-open-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 18px;
        border-radius: 999px;
        background: var(--mmaci-yellow);
        color: var(--mmaci-navy);
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .appointment-embed {
        min-height: 1120px;
        background: #f7f9fc;
    }

    .appointment-embed iframe {
        width: 100%;
        min-height: 1120px;
        display: block;
        border: 0;
    }

    .appointment-card span {
        color: var(--mmaci-yellow);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .appointment-card h2 {
        margin: 13px 0;
        font-size: clamp(31px, 4vw, 45px);
        font-weight: 800;
    }

    .appointment-card p {
        max-width: 700px;
        margin-bottom: 25px;
        color: rgba(255, 255, 255, 0.76);
        line-height: 1.8;
    }

    .appointment-icon {
        width: 210px;
        height: 210px;
        margin-left: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--mmaci-navy);
        background: var(--mmaci-yellow);
        border: 22px solid rgba(255, 255, 255, 0.10);
        border-radius: 50%;
        background-clip: padding-box;
        font-size: 75px;
    }

    /* ================= REMINDERS ================= */

    .visitor-reminder-description {
        color: var(--mmaci-text);
        line-height: 1.85;
    }

    .visitor-reminder-list {
        padding: 12px 32px;
        background: var(--mmaci-light);
        border: 1px solid var(--mmaci-border);
        border-radius: 20px;
    }

    .visitor-reminder-item {
        padding: 24px 0;
        display: flex;
        gap: 18px;
        border-bottom: 1px solid #dce4ee;
    }

    .visitor-reminder-item:last-child {
        border-bottom: 0;
    }

    .visitor-reminder-item > i {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--mmaci-blue);
        background: rgba(24, 75, 140, 0.09);
        border-radius: 14px;
        font-size: 21px;
    }

    .visitor-reminder-item h3 {
        margin-bottom: 6px;
        color: var(--mmaci-navy);
        font-size: 18px;
        font-weight: 800;
    }

    .visitor-reminder-item p {
        margin: 0;
        color: var(--mmaci-text);
        font-size: 14px;
        line-height: 1.75;
    }

    /* ================= RESPONSIVE ================= */

    @media (max-width: 991.98px) {
        .visiting-hero-row {
            padding-top: 130px;
            text-align: center;
        }

        .visiting-hero p {
            margin-right: auto;
            margin-left: auto;
        }

        .visiting-hero-actions {
            justify-content: center;
        }

        .visitor-placeholder {
            max-width: 650px;
            height: 430px;
            margin: 0 auto;
        }

        .appointment-icon {
            width: 170px;
            height: 170px;
            margin: auto;
            font-size: 60px;
        }
    }

    @media (max-width: 767.98px) {
        .visiting-introduction,
        .visitor-reminders-section,
        .appointment-section {
            padding: 75px 0;
        }

        .visitor-process-section {
            padding-bottom: 75px;
        }

        .appointment-card {
            border-radius: 22px;
        }

        .appointment-card .row {
            padding: 40px 24px 30px;
        }

        .appointment-embed-header {
            padding: 18px 24px 16px;
            flex-direction: column;
            align-items: flex-start;
        }

        .appointment-embed,
        .appointment-embed iframe {
            min-height: 980px;
        }
    }

    @media (max-width: 575.98px) {
        .visiting-hero-row {
            min-height: auto;
            padding: 115px 0 65px;
        }

        .visiting-hero h1 {
            margin-top: 20px;
            font-size: 39px;
        }

        .visiting-hero p {
            font-size: 15px;
            line-height: 1.75;
        }

        .visiting-hero-actions {
            flex-direction: column;
        }

        .visiting-hero-actions .btn {
            width: 100%;
        }

        .visitor-placeholder {
            height: 330px;
            padding: 7px;
            border-radius: 21px;
        }

        .visitor-placeholder img {
            border-radius: 15px;
        }

        .visitor-placeholder::after {
            right: 7px;
            bottom: 7px;
            left: 7px;
            border-radius: 0 0 15px 15px;
        }

        .visitor-step-card {
            padding: 25px 21px;
        }

        .visitor-step-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }

        .appointment-card {
            padding: 37px 25px;
        }

        .visitor-reminder-list {
            padding: 8px 20px;
        }

        .visitor-reminder-item {
            align-items: flex-start;
        }

        .visitor-reminder-item > i {
            width: 46px;
            height: 46px;
            font-size: 18px;
        }
    }
</style>

    @include('components.lisa-chatbox')

@endsection


