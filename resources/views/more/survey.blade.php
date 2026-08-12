@extends('layouts.app')

@section('title', 'Survey | MMACI Library Services Office')

@section('content')

@php
    $formUrl = $formUrl
        ?? 'https://docs.google.com/forms/d/e/1FAIpQLSedbW1FN9CIQ8-vFvwqcEptpBHOtObKgHks_34kz7_3nheTTA/viewform';

    $embedUrl = $formUrl . '?embedded=true';
@endphp

<section class="survey-hero">
    <div class="container">
        <div class="survey-hero-content">

            

            <h1>Survey</h1>

            <p>
                Share your thoughts so we can improve the MMACI Library
                experience, from services and facilities to resources and
                support.
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
                        Survey
                    </li>

                </ol>
            </nav>

        </div>
    </div>
</section>

<section class="survey-section">
    <div class="container">

        <div class="survey-layout">

            <aside class="survey-sidebar">

                <span class="content-label">
                    Tell Us What You Need
                </span>

                <h2>Help shape library improvements</h2>

                <p class="sidebar-description">
                    Use the embedded form to send your feedback and
                    recommendations. Your responses help guide future library
                    services and decisions.
                </p>

                <div class="survey-points">

                    <div class="survey-point">
                        <span class="point-icon">
                            <i class="bi bi-stars" aria-hidden="true"></i>
                        </span>
                        <div>
                            <strong>Fast to complete</strong>
                            <small>Submit your survey from any device.</small>
                        </div>
                    </div>

                    <div class="survey-point">
                        <span class="point-icon">
                            <i class="bi bi-clipboard-data" aria-hidden="true"></i>
                        </span>
                        <div>
                            <strong>Focused feedback</strong>
                            <small>
                                Tell us what works well and what can improve.
                            </small>
                        </div>
                    </div>

                    <div class="survey-point">
                        <span class="point-icon">
                            <i class="bi bi-shield-check" aria-hidden="true"></i>
                        </span>
                        <div>
                            <strong>Official form</strong>
                            <small>
                                Responses are collected through Google Forms.
                            </small>
                        </div>
                    </div>

                </div>

                <div class="survey-note">
                    <i class="bi bi-info-circle" aria-hidden="true"></i>
                    <p>
                        If the embedded form does not load, use the open-in-new
                        tab button to submit your response directly.
                    </p>
                </div>

                <a
                    href="{{ $formUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="secondary-action">

                    Open in Google Forms

                    <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                </a>

            </aside>

            <div class="survey-form-card">

                <header class="survey-form-header">
                    <div>
                        <span>Survey Form</span>
                        <h2>Submit your feedback</h2>
                    </div>
                </header>

                <div class="survey-embed">

                    <div class="form-loading" aria-hidden="true">
                        <div class="loading-spinner"></div>
                        <span>Loading survey form...</span>
                    </div>

                    <iframe
                        src="{{ $embedUrl }}"
                        title="MMACI Library Survey Form"
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
    --survey-navy: #0b2e59;
    --survey-blue: #184b8c;
    --survey-gold: #f4b400;
    --survey-text: #18263b;
    --survey-muted: #667389;
    --survey-background: #f4f7fb;
    --survey-border: #dfe6ef;
    --survey-white: #ffffff;
}

.survey-hero {
    position: relative;
    min-height: 420px;
    display: grid;
    place-items: center;
    overflow: hidden;
    isolation: isolate;
    color: var(--survey-white);
    background:
        linear-gradient(105deg, rgba(7, 30, 61, 0.84), rgba(11, 46, 89, 0.60), rgba(24, 75, 140, 0.42)),
        url("{{ asset('images/libraryphotojpg.jpg') }}") center / cover no-repeat;
}

.survey-hero::after {
    content: "";
    position: absolute;
    right: -130px;
    bottom: -220px;
    width: 440px;
    height: 440px;
    border: 58px solid rgba(244, 180, 0, 0.11);
    border-radius: 50%;
    pointer-events: none;
}

.survey-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 15% 20%, rgba(255, 255, 255, 0.12), transparent 28%),
        radial-gradient(circle at 82% 30%, rgba(244, 180, 0, 0.12), transparent 24%);
    pointer-events: none;
}

.survey-hero-content {
    position: relative;
    z-index: 1;
    max-width: 900px;
    margin: auto;
    padding: 84px 15px 70px;
    text-align: center;
}

.hero-label,
.content-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--survey-gold);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.13em;
    text-transform: uppercase;
}

.hero-label::before,
.content-label::before {
    content: "";
    width: 28px;
    height: 2px;
    border-radius: 20px;
    background: var(--survey-gold);
}

.survey-hero h1 {
    margin: 18px 0 14px;
    font-size: clamp(46px, 6vw, 72px);
    font-weight: 900;
    line-height: 1.04;
    letter-spacing: -0.045em;
}

.survey-hero p {
    max-width: 740px;
    margin: 0 auto 20px;
    color: rgba(255, 255, 255, 0.82);
    font-size: 17px;
    line-height: 1.8;
}

.survey-hero .breadcrumb,
.survey-hero .breadcrumb-item,
.survey-hero .breadcrumb-item.active,
.survey-hero .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.72);
    text-decoration: none;
}

.survey-section {
    padding: 60px 0 72px;
    background: var(--survey-background);
}

.survey-layout {
    display: grid;
    grid-template-columns: minmax(280px, 400px) minmax(0, 1fr);
    gap: 28px;
    align-items: start;
}

.survey-sidebar,
.survey-form-card {
    border: 1px solid var(--survey-border);
    border-radius: 24px;
    background: var(--survey-white);
    box-shadow: 0 18px 46px rgba(11, 46, 89, 0.08);
}

.survey-sidebar {
    padding: 28px;
}

.survey-sidebar h2 {
    margin: 12px 0;
    color: var(--survey-navy);
    font-size: clamp(28px, 3vw, 40px);
    font-weight: 900;
    letter-spacing: -0.03em;
}

.sidebar-description {
    color: var(--survey-muted);
    line-height: 1.85;
}

.survey-points {
    display: grid;
    gap: 14px;
    margin: 26px 0;
}

.survey-point {
    display: flex;
    gap: 14px;
    padding: 16px;
    background: #f8fbff;
    border: 1px solid #edf2f8;
    border-radius: 18px;
}

.point-icon {
    display: flex;
    width: 44px;
    height: 44px;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--survey-navy);
    background: var(--survey-gold);
    border-radius: 14px;
    font-size: 19px;
}

.survey-point strong {
    display: block;
    margin-bottom: 3px;
    color: var(--survey-navy);
}

.survey-point small {
    color: var(--survey-muted);
    line-height: 1.5;
}

.survey-note {
    display: flex;
    gap: 12px;
    padding: 16px;
    margin-bottom: 18px;
    background: #eff5ff;
    border-radius: 18px;
    color: var(--survey-blue);
}

.survey-note i {
    margin-top: 3px;
    font-size: 18px;
}

.survey-note p {
    margin: 0;
    line-height: 1.7;
}

.secondary-action {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 18px;
    color: var(--survey-navy);
    background: var(--survey-gold);
    border-radius: 12px;
    font-weight: 800;
    text-decoration: none;
}

.survey-form-card {
    overflow: hidden;
}

.survey-form-header {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    padding: 26px 28px 18px;
    border-bottom: 1px solid var(--survey-border);
}

.survey-form-header span {
    color: var(--survey-blue);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.survey-form-header h2 {
    margin: 7px 0 0;
    color: var(--survey-navy);
    font-size: clamp(24px, 2.4vw, 34px);
    font-weight: 900;
}

.survey-embed {
    position: relative;
    min-height: 900px;
    background: #f6f9fd;
}

.survey-embed iframe {
    width: 100%;
    height: 900px;
    border: 0;
    opacity: 0;
    transition: opacity .25s ease;
}

.survey-embed.form-loaded iframe {
    opacity: 1;
}

.form-loading {
    position: absolute;
    inset: 0;
    display: grid;
    place-items: center;
    gap: 12px;
    color: var(--survey-muted);
}

.survey-embed.form-loaded .form-loading {
    opacity: 0;
    pointer-events: none;
}

.loading-spinner {
    width: 34px;
    height: 34px;
    border: 3px solid rgba(24, 75, 140, 0.14);
    border-top-color: var(--survey-blue);
    border-radius: 50%;
    animation: surveySpin 1s linear infinite;
}

@keyframes surveySpin {
    to { transform: rotate(360deg); }
}

@media (max-width: 991.98px) {
    .survey-layout {
        grid-template-columns: 1fr;
    }
    .survey-embed,
    .survey-embed iframe {
        min-height: 820px;
        height: 820px;
    }
}

@media (max-width: 575.98px) {
    .survey-sidebar,
    .survey-form-header {
        padding-left: 20px;
        padding-right: 20px;
    }
    .survey-sidebar {
        padding-top: 22px;
        padding-bottom: 22px;
    }
    .survey-embed,
    .survey-embed iframe {
        min-height: 760px;
        height: 760px;
    }
}
</style>

@endsection
