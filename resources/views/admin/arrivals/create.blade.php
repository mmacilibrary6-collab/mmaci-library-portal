@extends('layouts.admin')

@section('title', 'Add New Arrival')
@section('page-title', 'Add New Arrival')

@section('content')
<div class="container-fluid arrival-editor-page">
    <section class="arrival-editor-hero">
        <div class="hero-copy">
            <span class="hero-icon">
                <i class="bi bi-book-half"></i>
            </span>

            <div>
                <span class="hero-eyebrow">
                    Collection Management
                </span>

                <h2>Add New Arrival</h2>

                <p>
                    Add a printed book or other newly acquired library material.
                </p>
            </div>
        </div>

        <a
            href="{{ route('admin.new-arrivals.index') }}"
            class="btn-back-list">

            <i class="bi bi-arrow-left"></i>
            Back to List
        </a>
    </section>

    <form
        action="{{ route('admin.new-arrivals.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @include('admin.arrivals._form')
    </form>
</div>
@endsection

@push('styles')
<style>
.arrival-editor-page {
    padding: 24px;
}

.arrival-editor-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 22px;
    padding: 28px 30px;
    overflow: hidden;
    color: #ffffff;
    background:
        radial-gradient(
            circle at 90% 10%,
            rgba(244, 180, 0, 0.20),
            transparent 28%
        ),
        linear-gradient(125deg, #0b2e59, #184b8c);
    border-radius: 22px;
    box-shadow: 0 16px 36px rgba(11, 46, 89, 0.16);
}

.arrival-editor-hero .hero-copy {
    display: flex;
    align-items: center;
    gap: 18px;
}

.arrival-editor-hero .hero-icon {
    width: 62px;
    height: 62px;
    flex: 0 0 62px;
    display: grid;
    place-items: center;
    color: #0b2e59;
    background: #f4b400;
    border-radius: 18px;
    font-size: 27px;
}

.arrival-editor-hero .hero-eyebrow {
    display: block;
    margin-bottom: 4px;
    color: #ffd96d;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.arrival-editor-hero h2 {
    margin: 0 0 5px;
    font-size: clamp(24px, 3vw, 32px);
    font-weight: 800;
}

.arrival-editor-hero p {
    margin: 0;
    color: rgba(255, 255, 255, 0.72);
    font-size: 12px;
}

.btn-back-list {
    min-height: 46px;
    padding: 0 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #0b2e59;
    background: #f4b400;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 800;
    text-decoration: none;
}

.btn-back-list:hover {
    color: #0b2e59;
    background: #ffc62b;
}

@media (max-width: 767.98px) {
    .arrival-editor-page {
        padding: 16px 10px;
    }

    .arrival-editor-hero {
        align-items: stretch;
        flex-direction: column;
        padding: 24px 20px;
        border-radius: 18px;
    }

    .arrival-editor-hero .hero-icon {
        width: 52px;
        height: 52px;
        flex-basis: 52px;
        font-size: 22px;
    }

    .btn-back-list {
        width: 100%;
    }
}
</style>
@endpush