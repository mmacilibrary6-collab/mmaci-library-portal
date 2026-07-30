@extends('layouts.admin')

@section('title', 'Add E-Book Folder')
@section('page-title', 'Add E-Book Folder')

@section('content')
<div class="container-fluid folder-create-page">
    <div class="create-page-container">

        <section class="create-header">
            <div class="header-content">
                <span class="header-icon">
                    <i class="bi bi-folder-plus"></i>
                </span>

                <div>
                    <span class="header-eyebrow">E-Book Management</span>
                    <h2>Add E-Book Folder</h2>
                    <p>Create a resource folder and connect it to an academic program.</p>
                </div>
            </div>

            <a href="{{ route('admin.ebook-folders.index') }}" class="back-button">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Folders</span>
            </a>
        </section>
<form
            action="{{ route('admin.ebook-folders.store') }}"
            method="POST"
            novalidate>
            @csrf

            @include('admin.ebooks.folders._form')
        </form>

    </div>
</div>
@endsection

@push('styles')
<style>
    .folder-create-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        padding: 24px;
    }

    .create-page-container {
        width: min(100%, 1120px);
        margin: 0 auto;
    }

    .create-header {
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
                rgba(244, 180, 0, .22),
                transparent 28%
            ),
            linear-gradient(125deg, var(--navy), var(--blue));
        color: #fff;
        box-shadow: 0 16px 36px rgba(11, 46, 89, .15);
    }

    .create-header::after {
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
        font-size: 26px;
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

    .create-header h2 {
        margin: 0 0 5px;
        font-size: clamp(23px, 3vw, 30px);
        font-weight: 800;
    }

    .create-header p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
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

    @media (max-width: 767.98px) {
        .folder-create-page {
            padding: 16px 10px;
        }

        .create-header {
            padding: 23px 20px;
            align-items: flex-start;
            flex-direction: column;
            border-radius: 18px;
        }

        .header-icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
            font-size: 22px;
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
