@extends('layouts.admin')

@section('title', 'Edit E-Book Folder')
@section('page-title', 'Edit E-Book Folder')

@section('content')
<div class="container-fluid folder-edit-page">
    <div class="edit-page-container">

        <section class="edit-header">
            <div class="header-content">
                <span class="header-icon">
                    <i class="bi bi-pencil-square"></i>
                </span>

                <div>
                    <span class="header-eyebrow">E-Book Management</span>
                    <h2>Edit E-Book Folder</h2>
                    <p>
                        Update the details and access settings for
                        <strong>{{ $ebookFolder->title }}</strong>.
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.ebook-folders.index') }}" class="back-button">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Folders</span>
            </a>
        </section>

        @if($errors->any())
            <div class="form-error-alert" role="alert">
                <span class="error-alert-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </span>

                <div class="error-alert-content">
                    <strong>Please check the form</strong>
                    <p>Some information is missing or invalid.</p>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form
            action="{{ route('admin.ebook-folders.update', $ebookFolder) }}"
            method="POST"
            novalidate>
            @csrf
            @method('PUT')

            @include('admin.ebooks.folders._form')
        </form>

    </div>
</div>
@endsection

@push('styles')
<style>
    .folder-edit-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        padding: 24px;
    }

    .edit-page-container {
        width: min(100%, 1120px);
        margin: 0 auto;
    }

    .edit-header {
        position: relative;
        overflow: hidden;
        min-height: 142px;
        margin-bottom: 20px;
        padding: 27px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        border-radius: 22px;
        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(244, 180, 0, .23),
                transparent 28%
            ),
            linear-gradient(125deg, var(--navy), var(--blue));
        color: #fff;
        box-shadow: 0 16px 36px rgba(11, 46, 89, .15);
    }

    .edit-header::after {
        content: "";
        position: absolute;
        right: 16%;
        bottom: -86px;
        width: 180px;
        height: 180px;
        border: 27px solid rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .header-icon {
        width: 60px;
        height: 60px;
        flex: 0 0 60px;
        display: grid;
        place-items: center;
        border-radius: 17px;
        background: var(--gold);
        color: var(--navy);
        font-size: 24px;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .14);
    }

    .header-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .edit-header h2 {
        margin: 0 0 5px;
        font-size: clamp(23px, 3vw, 30px);
        font-weight: 800;
    }

    .edit-header p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
    }

    .edit-header p strong {
        color: #fff;
        font-weight: 700;
    }

    .back-button {
        position: relative;
        z-index: 1;
        min-height: 44px;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 11px;
        background: rgba(255, 255, 255, .1);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        backdrop-filter: blur(8px);
        transition: .2s ease;
    }

    .back-button:hover {
        border-color: #fff;
        background: #fff;
        color: var(--navy);
        transform: translateY(-1px);
    }

    .form-error-alert {
        margin-bottom: 18px;
        padding: 16px 18px;
        display: flex;
        align-items: flex-start;
        gap: 13px;
        border: 1px solid #f1caca;
        border-left: 4px solid #d84b4b;
        border-radius: 14px;
        background: #fff7f7;
        color: #883535;
    }

    .error-alert-icon {
        width: 37px;
        height: 37px;
        flex: 0 0 37px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: #fde4e4;
        color: #cf4242;
    }

    .error-alert-content strong {
        display: block;
        margin-bottom: 2px;
        font-size: 13px;
    }

    .error-alert-content p {
        margin: 0;
        color: #a35b5b;
        font-size: 11px;
    }

    .error-alert-content ul {
        margin: 9px 0 0;
        padding-left: 18px;
        color: #9a4b4b;
        font-size: 11px;
    }

    @media (max-width: 767.98px) {
        .folder-edit-page {
            padding: 16px 10px;
        }

        .edit-header {
            padding: 23px 20px;
            align-items: flex-start;
            flex-direction: column;
            border-radius: 18px;
        }

        .header-icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
            font-size: 21px;
        }

        .back-button {
            width: 100%;
        }
    }

    @media (max-width: 420px) {
        .header-content {
            align-items: flex-start;
        }
    }
</style>
@endpush