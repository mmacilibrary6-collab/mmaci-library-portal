@extends('layouts.app')

@section('title', 'Subscribed Online Database | MMACI Library Services Office')

@section('content')

@php
    $embedUrl = $accessUrl . '&embedded=true';
@endphp

<section class="page-hero database-hero">
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-badge">Collection</span>
                <h1 class="display-5 fw-bold mt-3 mb-3">
                    Subscribed Online Database
                </h1>
                <p class="lead mb-4">
                    To access EBSCO resources, students must sign in using the
                    login credentials provided by the Circulation Staff. If
                    you have not yet received your username and password or
                    need assistance accessing your account, please visit the
                    Circulation Desk for support.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a
                        href="{{ $accessUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-mmaci">
                        Open EBSCO Login
                        <i class="bi bi-box-arrow-up-right ms-2"></i>
                    </a>

                    <a href="{{ route('collection.ebooks') }}" class="btn btn-outline-mmaci">
                        Browse E-Books
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="database-preview modern-card p-3 p-md-4">
                    <img
                        src="{{ asset('images/ebsco-signin.png') }}"
                        alt="EBSCO sign in screen"
                        class="database-image"
                        loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-space">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-4">
                <div class="modern-card p-4 h-100">
                    <span class="section-badge">Need Help?</span>
                    <h2 class="section-title mt-3">Access Instructions</h2>
                    <p class="section-description mb-0">
                        Use the credentials from the Circulation Staff to sign
                        in. If you are unable to access your account, visit the
                        Circulation Desk for assistance.
                    </p>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="modern-card overflow-hidden">
                    <div class="database-frame-header d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 p-md-4 border-bottom">
                        <div>
                            <span class="section-badge">EBSCO</span>
                            <h3 class="mb-0 mt-2">Online Access</h3>
                        </div>
                        <a href="{{ $accessUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-mmaci">
                            Open in New Tab
                        </a>
                    </div>

                    <div class="database-frame">
                        <iframe
                            src="{{ $embedUrl }}"
                            title="Subscribed Online Database"
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
    .database-hero .display-5 {
        letter-spacing: -0.04em;
        color: var(--mmaci-navy);
    }

    .database-hero .lead {
        color: var(--mmaci-muted);
        max-width: 720px;
        line-height: 1.8;
    }

    .database-preview {
        background: #fff;
    }

    .database-image {
        width: 100%;
        border-radius: 18px;
        display: block;
        box-shadow: 0 18px 35px rgba(11, 46, 89, 0.16);
    }

    .database-frame {
        min-height: 900px;
        background: #f7f9fc;
    }

    .database-frame iframe {
        width: 100%;
        min-height: 900px;
        border: 0;
        display: block;
    }

    @media (max-width: 991.98px) {
        .database-frame,
        .database-frame iframe {
            min-height: 760px;
        }
    }

    @media (max-width: 575.98px) {
        .database-frame,
        .database-frame iframe {
            min-height: 680px;
        }
    }
</style>
@endpush
