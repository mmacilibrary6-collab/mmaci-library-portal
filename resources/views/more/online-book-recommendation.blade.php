@extends('layouts.app')

@section('title', 'Online Book Recommendation | MMACI Library Services Office')

@section('content')

@php
    $formUrl = $formUrl ?? 'https://docs.google.com/forms/d/e/1FAIpQLSfsg3Tn_nx3bf6KKQg46bhLVlPjvNre-mmHHKvFVh21_KBhmw/viewform';
    $embedUrl = $formUrl . '?embedded=true';
@endphp

<section class="ask-hero online-book-hero">
    <div class="ask-hero-overlay"></div>

    <div class="container position-relative">
        <div class="ask-hero-content">
            <span class="section-label">More Services</span>
            <h1>Online Book Recommendation</h1>
            <p>
                Suggest books you would like the library to consider for future
                purchase and collection development.
            </p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">More</li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Online Book Recommendation
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="recommendation-section section-space">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-4">
                <div class="recommendation-intro">
                    <span class="eyebrow">Tell us what you need</span>
                    <h2 class="section-title text-start">
                        Recommend a Book Online
                    </h2>
                    <p class="section-description">
                        Use the form on the right to submit your suggested book
                        title, author, and any helpful details for the library.
                    </p>

                    <div class="recommendation-points">
                        <div class="recommendation-point">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Easy to submit from any device</span>
                        </div>
                        <div class="recommendation-point">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Supports collection development requests</span>
                        </div>
                        <div class="recommendation-point">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Reviewed by the library team</span>
                        </div>
                    </div>

                    <a href="{{ $formUrl }}" target="_blank" rel="noopener noreferrer" class="text-action">
                        Open in Google Forms
                        <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="recommendation-form-card">
                    <div class="recommendation-form-header">
                        <div>
                            <span>Google Form</span>
                            <h3>Online Book Recommendation</h3>
                        </div>
                        <a href="{{ $formUrl }}" target="_blank" rel="noopener noreferrer" class="survey-button">
                            Open Form
                        </a>
                    </div>

                    <div class="recommendation-embed">
                        <iframe
                            src="{{ $embedUrl }}"
                            title="Online Book Recommendation Form"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .online-book-hero {
        background:
            radial-gradient(circle at 85% 20%, rgba(244, 180, 0, 0.30), transparent 28%),
            linear-gradient(135deg, var(--mmaci-navy), var(--mmaci-blue));
    }

    .recommendation-intro {
        background: #fff;
        border: 1px solid #e1e8f2;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 18px 40px rgba(15, 40, 75, 0.06);
    }

    .recommendation-points {
        display: grid;
        gap: 14px;
        margin: 28px 0;
    }

    .recommendation-point {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--mmaci-navy);
        font-weight: 600;
    }

    .recommendation-point i {
        color: var(--mmaci-gold);
        font-size: 18px;
    }

    .recommendation-form-card {
        overflow: hidden;
        border-radius: 24px;
        background: #fff;
        border: 1px solid #e1e8f2;
        box-shadow: 0 18px 40px rgba(15, 40, 75, 0.08);
    }

    .recommendation-form-header {
        padding: 22px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        border-bottom: 1px solid #edf2f7;
    }

    .recommendation-form-header span {
        display: block;
        color: var(--mmaci-muted);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .recommendation-form-header h3 {
        margin: 4px 0 0;
        color: var(--mmaci-navy);
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.03em;
    }

    .recommendation-embed {
        position: relative;
        width: 100%;
        min-height: 1100px;
        background: #f7f9fc;
    }

    .recommendation-embed iframe {
        display: block;
        width: 100%;
        min-height: 1100px;
        border: 0;
    }

    @media (max-width: 991px) {
        .recommendation-embed,
        .recommendation-embed iframe {
            min-height: 980px;
        }
    }
</style>
@endpush
