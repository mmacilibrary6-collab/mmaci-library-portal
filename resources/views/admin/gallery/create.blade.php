@extends('layouts.admin')

@section('title', 'Add Gallery Folder')
@section('page-title', 'Add Gallery Folder')

@section('content')

<div class="container-fluid gallery-create-page">

    <div class="gallery-page-container">

        <section class="gallery-page-header">

            <div class="gallery-header-content">

                <span class="gallery-header-icon">
                    <i class="bi bi-image-fill"></i>
                </span>

                <div>
                    <span class="gallery-header-eyebrow">
                        Gallery Management
                    </span>

                    <h2>Add Gallery Folder</h2>

                    <p>
                        Create a new folder for photos in the public library gallery.
                    </p>
                </div>

            </div>

            <a
                href="{{ route('admin.gallery.index') }}"
                class="gallery-back-button">

                <i class="bi bi-arrow-left"></i>
                <span>Back to Gallery</span>

            </a>

        </section>

        @if ($errors->any())

            <div class="gallery-form-alert" role="alert">

                <span class="gallery-alert-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </span>

                <div class="gallery-alert-content">

                    <strong>Please check the form</strong>

                    <p>Some information is missing or invalid.</p>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            </div>

        @endif

        <form
            action="{{ route('admin.gallery.store') }}"
            method="POST"
            enctype="multipart/form-data"
            novalidate>

            @include('admin.gallery._form')

        </form>

    </div>

</div>

@endsection

@push('styles')
<style>
    .gallery-create-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        padding: 24px;
    }

    .gallery-page-container {
        width: min(100%, 1120px);
        margin: 0 auto;
    }

    .gallery-page-header {
        position: relative;
        min-height: 142px;
        margin-bottom: 20px;
        padding: 27px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(244, 180, 0, .22),
                transparent 28%
            ),
            linear-gradient(125deg, var(--navy), var(--blue));
        border-radius: 22px;
        box-shadow: 0 16px 36px rgba(11, 46, 89, .15);
    }

    .gallery-page-header::after {
        content: "";
        position: absolute;
        right: 16%;
        bottom: -86px;
        width: 180px;
        height: 180px;
        border: 27px solid rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .gallery-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .gallery-header-icon {
        width: 60px;
        height: 60px;
        flex: 0 0 60px;
        display: grid;
        place-items: center;
        color: var(--navy);
        background: var(--gold);
        border-radius: 17px;
        font-size: 25px;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .14);
    }

    .gallery-header-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .gallery-page-header h2 {
        margin: 0 0 5px;
        font-size: clamp(23px, 3vw, 30px);
        font-weight: 800;
    }

    .gallery-page-header p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
    }

    .gallery-back-button {
        position: relative;
        z-index: 1;
        min-height: 44px;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #fff;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 11px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        backdrop-filter: blur(8px);
        transition: .2s ease;
    }

    .gallery-back-button:hover {
        color: var(--navy);
        background: #fff;
        border-color: #fff;
        transform: translateY(-1px);
    }

    .gallery-form-alert {
        margin-bottom: 18px;
        padding: 16px 18px;
        display: flex;
        align-items: flex-start;
        gap: 13px;
        color: #883535;
        background: #fff7f7;
        border: 1px solid #f1caca;
        border-left: 4px solid #d84b4b;
        border-radius: 14px;
    }

    .gallery-alert-icon {
        width: 37px;
        height: 37px;
        flex: 0 0 37px;
        display: grid;
        place-items: center;
        color: #cf4242;
        background: #fde4e4;
        border-radius: 10px;
    }

    .gallery-alert-content strong {
        display: block;
        margin-bottom: 2px;
        font-size: 13px;
    }

    .gallery-alert-content p {
        margin: 0;
        color: #a35b5b;
        font-size: 11px;
    }

    .gallery-alert-content ul {
        margin: 9px 0 0;
        padding-left: 18px;
        color: #9a4b4b;
        font-size: 11px;
    }

    @media (max-width: 767.98px) {
        .gallery-create-page {
            padding: 16px 10px;
        }

        .gallery-page-header {
            padding: 23px 20px;
            align-items: flex-start;
            flex-direction: column;
            border-radius: 18px;
        }

        .gallery-header-icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
            font-size: 22px;
        }

        .gallery-back-button {
            width: 100%;
        }
    }
</style>
@endpush
