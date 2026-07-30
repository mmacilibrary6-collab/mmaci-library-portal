@extends('layouts.app')

@section('title', 'Subscribed Online Database | MMACI Library Services Office')

@section('content')

@php
    $accessUrl = $accessUrl ?? 'https://search.ebscohost.com/';

    $embedUrl = $accessUrl
        . (str_contains($accessUrl, '?') ? '&' : '?')
        . 'embedded=true';
@endphp

{{-- Hero --}}
<section class="database-hero">
    <div class="container">

        <div class="database-hero-grid">

            <div class="database-hero-copy">

                <span class="database-label">
                    Digital Collection
                </span>

                <h1>Subscribed Online Database</h1>

                <p>
                    Access reliable journals, articles, research papers, and
                    academic resources available through the MMACI Library's
                    EBSCO subscription.
                </p>

                <div class="database-notice">
                    <i class="bi bi-person-badge" aria-hidden="true"></i>

                    <span>
                        Login credentials are available from the Circulation
                        Staff at the library desk.
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

            <div class="database-preview">

                <div class="preview-toolbar">
                    <span class="preview-dot"></span>
                    <span class="preview-dot"></span>
                    <span class="preview-dot"></span>

                    <div class="preview-address">
                        EBSCO Online Database
                    </div>
                </div>

                <div class="preview-image-wrapper">

                    <img
                        src="{{ asset('images/ebsco-signin.png') }}"
                        alt="EBSCO online database sign-in page"
                        class="database-image"
                        loading="lazy"
                        onerror="this.onerror=null;this.src='{{ asset('images/database-placeholder.jpg') }}';">

                </div>

            </div>

        </div>

    </div>
</section>

{{-- Access Section --}}
<section class="database-access-section">
    <div class="container">

        <header class="database-section-heading">

            <span class="database-content-label">
                Database Access
            </span>

            <h2>Search academic resources online</h2>

            <p>
                Sign in with the account details provided by the MMACI
                Circulation Staff.
            </p>

        </header>

        <div class="database-layout">

            {{-- Instructions --}}
            <aside class="database-instructions">

                <div class="instruction-heading">
                    <span>Before you continue</span>
                    <h3>Access instructions</h3>
                </div>

                <div class="instruction-list">

                    <div class="instruction-item">
                        <span class="instruction-number">1</span>

                        <div>
                            <strong>Request your credentials</strong>
                            <p>
                                Visit the Circulation Desk to receive your EBSCO
                                username and password.
                            </p>
                        </div>
                    </div>

                    <div class="instruction-item">
                        <span class="instruction-number">2</span>

                        <div>
                            <strong>Open the database</strong>
                            <p>
                                Use the embedded window or open EBSCO in a
                                separate browser tab.
                            </p>
                        </div>
                    </div>

                    <div class="instruction-item">
                        <span class="instruction-number">3</span>

                        <div>
                            <strong>Sign in securely</strong>
                            <p>
                                Enter the credentials given by the Circulation
                                Staff and avoid sharing them publicly.
                            </p>
                        </div>
                    </div>

                    <div class="instruction-item">
                        <span class="instruction-number">4</span>

                        <div>
                            <strong>Ask for assistance</strong>
                            <p>
                                Contact the library staff if your login does not
                                work or the database cannot be opened.
                            </p>
                        </div>
                    </div>

                </div>

                <div class="help-note">
                    <i class="bi bi-info-circle" aria-hidden="true"></i>

                    <p>
                        Some database providers may prevent their login page
                        from loading inside an embedded window. Select
                        <strong>Open EBSCO</strong> if the form does not appear.
                    </p>
                </div>

            </aside>

            {{-- Embedded Database --}}
            <div class="database-card">

                <header class="database-card-header">

                    <div>
                        <span>Subscribed Resource</span>
                        <h3>EBSCO Online Access</h3>
                    </div>

                    <a
                        href="{{ $accessUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="database-open-button">

                        Open EBSCO

                        <i
                            class="bi bi-box-arrow-up-right"
                            aria-hidden="true">
                        </i>
                    </a>

                </header>

                <div class="database-frame">

                    <div class="database-loading" aria-hidden="true">
                        <div class="database-spinner"></div>
                        <span>Loading EBSCO database...</span>
                    </div>

                    <iframe
                        src="{{ $embedUrl }}"
                        title="EBSCO Subscribed Online Database"
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        onload="this.parentElement.classList.add('database-loaded')">
                    </iframe>

                </div>

                <footer class="database-card-footer">

                    <i class="bi bi-shield-check" aria-hidden="true"></i>

                    <span>
                        Access is intended for authorized MMACI library users.
                    </span>

                </footer>

            </div>

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
            rgba(7, 30, 61, 0.94),
            rgba(11, 46, 89, 0.82)
        ),
        url("{{ asset('images/database-placeholder.jpg') }}");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

.database-hero::after {
    content: "";
    position: absolute;
    right: -150px;
    bottom: -250px;
    width: 470px;
    height: 470px;
    border: 65px solid rgba(244, 180, 0, 0.10);
    border-radius: 50%;
    pointer-events: none;
}

.database-hero-grid {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(400px, 0.88fr);
    gap: 65px;
    align-items: center;
}

.database-label {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--database-gold);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.13em;
    text-transform: uppercase;
}

.database-label::before {
    content: "";
    width: 28px;
    height: 3px;
    border-radius: 10px;
    background: var(--database-gold);
}

.database-hero h1 {
    max-width: 720px;
    margin: 17px 0 20px;
    color: var(--database-white);
    font-size: clamp(45px, 5.7vw, 73px);
    font-weight: 900;
    line-height: 1.02;
    letter-spacing: -0.05em;
    text-wrap: balance;
}

.database-hero-copy > p {
    max-width: 650px;
    margin: 0 0 24px;
    color: rgba(255, 255, 255, 0.80);
    font-size: 16px;
    line-height: 1.75;
}

.database-notice {
    max-width: 610px;
    display: grid;
    grid-template-columns: 22px 1fr;
    gap: 11px;
    align-items: start;
    padding: 14px 16px;
    border: 1px solid rgba(255, 255, 255, 0.13);
    border-radius: 10px;
    color: rgba(255, 255, 255, 0.83);
    background: rgba(255, 255, 255, 0.08);
    font-size: 13px;
    line-height: 1.6;
}

.database-notice i {
    color: var(--database-gold);
    font-size: 18px;
}

.database-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 27px;
}

.database-primary-button,
.database-secondary-button,
.database-open-button {
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
    box-shadow: 0 10px 25px rgba(244, 180, 0, 0.24);
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

/* Preview */

.database-preview {
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.18);
    border-radius: 18px;
    background: var(--database-white);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.24);
    transform: rotate(1deg);
    transition: transform 0.25s ease;
}

.database-preview:hover {
    transform: rotate(0deg) translateY(-4px);
}

.preview-toolbar {
    min-height: 44px;
    padding: 0 15px;
    display: flex;
    align-items: center;
    gap: 7px;
    border-bottom: 1px solid var(--database-border);
    background: #f4f6f9;
}

.preview-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #cbd4df;
}

.preview-dot:first-child {
    background: #e26a5d;
}

.preview-dot:nth-child(2) {
    background: #e9b949;
}

.preview-dot:nth-child(3) {
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
    aspect-ratio: 16 / 10;
    overflow: hidden;
    background: #eef2f7;
}

.database-image {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: top center;
}

/* Access section */

.database-access-section {
    padding: 70px 0;
    background: var(--database-background);
}

.database-section-heading {
    max-width: 720px;
    margin-bottom: 35px;
}

.database-content-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--database-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.database-content-label::before {
    content: "";
    width: 25px;
    height: 3px;
    border-radius: 10px;
    background: var(--database-gold);
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

.database-layout {
    display: grid;
    grid-template-columns: minmax(260px, 330px) minmax(0, 1fr);
    gap: 28px;
    align-items: start;
}

/* Instructions */

.database-instructions {
    position: sticky;
    top: 100px;
    padding: 27px;
    border: 1px solid var(--database-border);
    border-radius: 18px;
    background: var(--database-white);
    box-shadow: 0 13px 32px rgba(11, 46, 89, 0.06);
}

.instruction-heading {
    padding-bottom: 20px;
    border-bottom: 1px solid var(--database-border);
}

.instruction-heading span {
    color: var(--database-blue);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.11em;
    text-transform: uppercase;
}

.instruction-heading h3 {
    margin: 6px 0 0;
    color: var(--database-navy);
    font-size: 25px;
    font-weight: 850;
    letter-spacing: -0.03em;
}

.instruction-list {
    display: grid;
    gap: 21px;
    margin-top: 23px;
}

.instruction-item {
    display: grid;
    grid-template-columns: 32px 1fr;
    gap: 12px;
    align-items: start;
}

.instruction-number {
    width: 32px;
    height: 32px;
    display: grid;
    place-items: center;
    border-radius: 9px;
    color: var(--database-navy);
    background: rgba(244, 180, 0, 0.19);
    font-size: 12px;
    font-weight: 900;
}

.instruction-item strong {
    display: block;
    margin-bottom: 4px;
    color: var(--database-navy);
    font-size: 13px;
    font-weight: 800;
}

.instruction-item p {
    margin: 0;
    color: var(--database-muted);
    font-size: 12px;
    line-height: 1.55;
}

.help-note {
    display: grid;
    grid-template-columns: 19px 1fr;
    gap: 9px;
    margin-top: 24px;
    padding: 13px;
    border-radius: 9px;
    color: var(--database-muted);
    background: #f1f6fc;
}

.help-note i {
    color: var(--database-blue);
}

.help-note p {
    margin: 0;
    font-size: 11px;
    line-height: 1.6;
}

/* Database card */

.database-card {
    min-width: 0;
    overflow: hidden;
    border: 1px solid var(--database-border);
    border-radius: 18px;
    background: var(--database-white);
    box-shadow: 0 13px 32px rgba(11, 46, 89, 0.08);
}

.database-card-header {
    min-height: 86px;
    padding: 19px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    border-bottom: 1px solid var(--database-border);
}

.database-card-header span {
    display: block;
    color: var(--database-blue);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.11em;
    text-transform: uppercase;
}

.database-card-header h3 {
    margin: 5px 0 0;
    color: var(--database-navy);
    font-size: 23px;
    font-weight: 850;
    letter-spacing: -0.025em;
}

.database-open-button {
    flex-shrink: 0;
    color: var(--database-white);
    background: var(--database-navy);
}

.database-open-button:hover {
    color: var(--database-white);
    background: var(--database-blue);
    transform: translateY(-2px);
}

.database-frame {
    position: relative;
    width: 100%;
    height: min(900px, calc(100vh - 115px));
    min-height: 680px;
    background: #f7f9fc;
}

.database-frame iframe {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    display: block;
    border: 0;
    background: var(--database-white);
}

.database-loading {
    position: absolute;
    inset: 0;
    display: grid;
    place-content: center;
    justify-items: center;
    gap: 12px;
    color: var(--database-muted);
    font-size: 13px;
}

.database-loaded .database-loading {
    display: none;
}

.database-spinner {
    width: 34px;
    height: 34px;
    border: 3px solid var(--database-border);
    border-top-color: var(--database-blue);
    border-radius: 50%;
    animation: database-spin 0.8s linear infinite;
}

@keyframes database-spin {
    to {
        transform: rotate(360deg);
    }
}

.database-card-footer {
    min-height: 48px;
    padding: 12px 21px;
    display: flex;
    align-items: center;
    gap: 9px;
    border-top: 1px solid var(--database-border);
    color: var(--database-muted);
    background: #fafbfd;
    font-size: 11px;
}

.database-card-footer i {
    color: var(--database-green);
    font-size: 16px;
}

/* Responsive */

@media (max-width: 991.98px) {
    .database-hero-grid,
    .database-layout {
        grid-template-columns: 1fr;
    }

    .database-hero-grid {
        gap: 40px;
    }

    .database-preview {
        max-width: 680px;
        transform: none;
    }

    .database-instructions {
        position: static;
    }

    .instruction-list {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 767.98px) {
    .database-hero {
        padding: 60px 0;
    }

    .database-hero h1 {
        font-size: clamp(42px, 12vw, 58px);
    }

    .database-hero-copy > p {
        font-size: 15px;
    }

    .database-access-section {
        padding: 45px 0;
    }

    .database-section-heading {
        margin-bottom: 26px;
    }

    .database-instructions {
        padding: 23px 20px;
        border-radius: 16px;
    }

    .database-card {
        border-radius: 16px;
    }

    .database-card-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 18px 19px;
    }

    .database-open-button {
        width: 100%;
    }

    .database-frame {
        height: 760px;
        min-height: 760px;
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

    .instruction-list {
        grid-template-columns: 1fr;
    }

    .database-frame {
        height: 680px;
        min-height: 680px;
    }
}
</style>

@endsection