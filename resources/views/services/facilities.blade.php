@extends('layouts.app')

@section('title', 'Library Facilities | MMACI Library Services Office')

@section('content')

<section class="facilities-hero">
    <div class="container">
        <div class="facilities-hero-content">

            <h1>Spaces made for better learning.</h1>

            <p>
                Discover comfortable, practical spaces for reading, research,
                collaboration, and focused academic work.
            </p>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('services.index') }}">Services</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Facilities
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="facilities-intro">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Our Learning Spaces</span>
            <h2>Find the right space for the way you study</h2>
            <p>
                Each facility is arranged to give students and faculty a
                comfortable place to read, work, meet, and learn.
            </p>
        </div>
    </div>
</section>

<section class="facilities-list">
    <div class="container">
        @forelse (($facilities ?? []) as $facility)
            @php
                $facilityTitle = $facility['title'] ?? 'Library Facility';
                $facilityImage = $facility['image'] ?? asset('images/readingarea.jpg');
                $facilityCapacity = $facility['capacity'] ?? 'Contact the Library';
                $facilityDescription = $facility['description']
                    ?? 'Facility information is currently unavailable.';
            @endphp

            <article class="facility-card" data-aos="fade-up">
                <div class="row g-0 align-items-stretch">
                    <div class="col-lg-6 {{ $loop->even ? 'order-lg-2' : '' }}">
                        <div class="facility-photo">
                            <img
                                src="{{ $facilityImage }}"
                                alt="{{ $facilityTitle }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">
                        </div>
                    </div>

                    <div class="col-lg-6 {{ $loop->even ? 'order-lg-1' : '' }}">
                        <div class="facility-details">
                            <span class="facility-kicker">MMACI Library Facility</span>
                            <h2>{{ $facilityTitle }}</h2>
                            <p>{{ $facilityDescription }}</p>

                            <div class="capacity-card">
                                <span class="capacity-icon" aria-hidden="true">
                                    <i class="bi bi-people"></i>
                                </span>

                                <span>
                                    <small>Available capacity</small>
                                    <strong>{{ $facilityCapacity }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <span class="empty-state-icon" aria-hidden="true">
                    <i class="bi bi-building"></i>
                </span>
                <h2>Facility information is coming soon</h2>
                <p>
                    Please check again later or contact the Library Services
                    Office for current facility availability.
                </p>
            </div>
        @endforelse
    </div>
</section>

<section class="facilities-summary">
    <div class="container">
        <div class="summary-panel">
            <div class="summary-heading">
                <span class="eyebrow eyebrow-light">At a Glance</span>
                <h2>Spaces available for the MMACI community</h2>
            </div>

            <div class="summary-grid">
                <div class="summary-item">
                    <strong>1</strong>
                    <span>Discussion Room</span>
                </div>
                <div class="summary-item">
                    <strong>54</strong>
                    <span>Reading Seats</span>
                </div>
                <div class="summary-item">
                    <strong>4</strong>
                    <span>Reading Cubicles</span>
                </div>
                <div class="summary-item">
                    <strong>1</strong>
                    <span>Faculty Lounge</span>
                </div>
                <div class="summary-item">
                    <strong>2</strong>
                    <span>Audio Visual Room (AVR)</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="facility-guidelines">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-5">
                <div class="guidelines-intro">
                    <span class="eyebrow">Using the Facilities</span>
                    <h2>Help keep every space welcoming</h2>
                    <p>
                        A few simple habits help everyone enjoy a clean,
                        comfortable, and productive library environment.
                    </p>

                    <a href="{{ route('services.index') }}" class="guidelines-link">
                        View library guidelines
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="guidelines-list">
                    <div class="guideline">
                        <span class="guideline-number">01</span>
                        <div>
                            <h3>Keep noise at a considerate level</h3>
                            <p>Speak quietly and avoid disturbing nearby library users.</p>
                        </div>
                    </div>

                    <div class="guideline">
                        <span class="guideline-number">02</span>
                        <div>
                            <h3>Leave your space clean</h3>
                            <p>Dispose of waste properly and organize the area after use.</p>
                        </div>
                    </div>

                    <div class="guideline">
                        <span class="guideline-number">03</span>
                        <div>
                            <h3>Handle equipment with care</h3>
                            <p>Use furniture, outlets, and library equipment responsibly.</p>
                        </div>
                    </div>

                    <div class="guideline">
                        <span class="guideline-number">04</span>
                        <div>
                            <h3>Observe the room capacity</h3>
                            <p>Follow the posted limits for rooms, cubicles, and shared spaces.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="facilities-help">
    <div class="container">
        <div class="help-card">
            <div class="help-copy">
                <span>Need assistance?</span>
                <h2>Check facility availability before your visit.</h2>
                <p>
                    Our library personnel can help with room availability,
                    capacity information, and usage guidelines.
                </p>
            </div>

            <a href="{{ route('more.ask-librarian') }}" class="help-button">
                Ask the Librarian
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

<style>
:root {
    --facility-navy: #0b2e59;
    --facility-blue: #184b8c;
    --facility-gold: #f4b400;
    --facility-ink: #17243a;
    --facility-muted: #647187;
    --facility-bg: #f4f7fb;
    --facility-line: #dfe6ef;
    --facility-white: #ffffff;
}

.facilities-hero {
    position: relative;
    min-height: 440px;
    display: grid;
    place-items: center;
    overflow: hidden;
    background:
        linear-gradient(110deg, rgba(7, 32, 65, .94), rgba(11, 46, 89, .86)),
        url("{{ asset('images/AVR.jpg') }}") center / cover no-repeat;
    color: var(--facility-white);
}

.facilities-hero::after {
    content: "";
    position: absolute;
    right: -120px;
    bottom: -210px;
    width: 430px;
    height: 430px;
    border: 58px solid rgba(244, 180, 0, .1);
    border-radius: 50%;
}

.facilities-hero-content {
    position: relative;
    z-index: 1;
    max-width: 790px;
    margin: auto;
    padding: 95px 0 80px;
    text-align: center;
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--facility-blue);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.eyebrow::before {
    content: "";
    width: 28px;
    height: 3px;
    border-radius: 10px;
    background: var(--facility-gold);
}

.eyebrow-light {
    color: var(--facility-gold);
}

.facilities-hero h1 {
    max-width: 720px;
    margin: 18px auto;
    font-size: clamp(42px, 6vw, 67px);
    font-weight: 800;
    line-height: 1.05;
    letter-spacing: -.045em;
}

.facilities-hero p {
    max-width: 650px;
    margin: 0 auto 27px;
    color: rgba(255, 255, 255, .78);
    font-size: 17px;
    line-height: 1.75;
}

.facilities-hero .breadcrumb {
    font-size: 13px;
}

.facilities-hero .breadcrumb-item,
.facilities-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, .62);
}

.facilities-hero .breadcrumb-item a {
    color: var(--facility-white);
    font-weight: 600;
    text-decoration: none;
}

.facilities-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, .38);
}

.facilities-intro {
    padding: 88px 0 48px;
    background: var(--facility-bg);
}

.section-heading {
    max-width: 760px;
}

.section-heading h2,
.guidelines-intro h2 {
    margin: 15px 0;
    color: var(--facility-navy);
    font-size: clamp(31px, 4vw, 46px);
    font-weight: 800;
    line-height: 1.14;
    letter-spacing: -.035em;
}

.section-heading p,
.guidelines-intro p {
    margin: 0;
    color: var(--facility-muted);
    font-size: 16px;
    line-height: 1.8;
}

.facilities-list {
    padding: 20px 0 88px;
    background: var(--facility-bg);
}

.facility-card {
    margin-bottom: 30px;
    overflow: hidden;
    background: var(--facility-white);
    border: 1px solid var(--facility-line);
    border-radius: 22px;
    box-shadow: 0 14px 38px rgba(11, 46, 89, .07);
}

.facility-card:last-child {
    margin-bottom: 0;
}

.facility-photo {
    position: relative;
    min-height: 430px;
    height: 100%;
    overflow: hidden;
    background: #dfe6ef;
}

.facility-photo img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}

.facility-card:hover .facility-photo img {
    transform: scale(1.025);
}

.facility-details {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 55px;
}

.facility-kicker {
    color: var(--facility-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.facility-details h2 {
    margin: 12px 0 18px;
    color: var(--facility-navy);
    font-size: clamp(30px, 4vw, 43px);
    font-weight: 800;
    line-height: 1.12;
    letter-spacing: -.035em;
}

.facility-details > p {
    margin: 0 0 28px;
    color: var(--facility-muted);
    font-size: 16px;
    line-height: 1.85;
}

.capacity-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 15px 17px;
    background: var(--facility-bg);
    border: 1px solid var(--facility-line);
    border-radius: 13px;
}

.capacity-icon {
    width: 43px;
    height: 43px;
    display: grid;
    place-items: center;
    flex: 0 0 43px;
    color: var(--facility-white);
    background: var(--facility-navy);
    border-radius: 11px;
    font-size: 18px;
}

.capacity-card small,
.capacity-card strong {
    display: block;
}

.capacity-card small {
    margin-bottom: 2px;
    color: #8792a3;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.capacity-card strong {
    color: var(--facility-ink);
    font-size: 15px;
    font-weight: 800;
}

.empty-state {
    padding: 70px 24px;
    text-align: center;
    background: var(--facility-white);
    border: 1px solid var(--facility-line);
    border-radius: 20px;
}

.empty-state-icon {
    width: 62px;
    height: 62px;
    display: grid;
    place-items: center;
    margin: 0 auto 18px;
    color: var(--facility-navy);
    background: rgba(244, 180, 0, .18);
    border-radius: 15px;
    font-size: 26px;
}

.empty-state h2 {
    color: var(--facility-navy);
    font-size: 24px;
    font-weight: 800;
}

.empty-state p {
    max-width: 570px;
    margin: 10px auto 0;
    color: var(--facility-muted);
    line-height: 1.7;
}

.facilities-summary {
    padding: 0 0 96px;
    background: var(--facility-bg);
}

.summary-panel {
    display: grid;
    grid-template-columns: minmax(240px, 1.1fr) 2fr;
    gap: 45px;
    padding: 42px;
    color: var(--facility-white);
    background: var(--facility-navy);
    border-radius: 22px;
    box-shadow: 0 18px 45px rgba(11, 46, 89, .16);
}

.summary-heading h2 {
    margin: 13px 0 0;
    font-size: 27px;
    font-weight: 800;
    line-height: 1.25;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}

.summary-item {
    min-width: 0;
    padding: 8px 22px;
    border-left: 1px solid rgba(255, 255, 255, .14);
}

.summary-item:nth-child(odd) {
    border-left: 0;
}

.summary-item strong {
    display: block;
    margin-bottom: 7px;
    color: var(--facility-gold);
    font-size: 34px;
    font-weight: 800;
    line-height: 1;
}

.summary-item span {
    color: rgba(255, 255, 255, .7);
    font-size: 13px;
    line-height: 1.4;
}

.facility-guidelines {
    padding: 100px 0;
    background: var(--facility-white);
}

.guidelines-intro {
    position: sticky;
    top: 110px;
    max-width: 445px;
}

.guidelines-link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    margin-top: 27px;
    color: var(--facility-navy);
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
}

.guidelines-link i {
    color: var(--facility-blue);
    transition: transform .2s ease;
}

.guidelines-link:hover i {
    transform: translateX(4px);
}

.guidelines-list {
    border-top: 1px solid var(--facility-line);
}

.guideline {
    display: grid;
    grid-template-columns: 48px 1fr;
    gap: 20px;
    padding: 25px 0;
    border-bottom: 1px solid var(--facility-line);
}

.guideline-number {
    color: var(--facility-gold);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: .06em;
}

.guideline h3 {
    margin: 0 0 7px;
    color: var(--facility-ink);
    font-size: 18px;
    font-weight: 800;
}

.guideline p {
    margin: 0;
    color: var(--facility-muted);
    font-size: 14px;
    line-height: 1.7;
}

.facilities-help {
    padding: 0 0 100px;
    background: var(--facility-white);
}

.help-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 35px;
    padding: 45px 48px;
    background: linear-gradient(115deg, var(--facility-navy), var(--facility-blue));
    border-radius: 22px;
    color: var(--facility-white);
}

.help-copy {
    max-width: 720px;
}

.help-copy > span {
    color: var(--facility-gold);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.help-copy h2 {
    margin: 8px 0 9px;
    font-size: clamp(25px, 3vw, 34px);
    font-weight: 800;
    letter-spacing: -.025em;
}

.help-copy p {
    margin: 0;
    color: rgba(255, 255, 255, .7);
    line-height: 1.7;
}

.help-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    flex-shrink: 0;
    padding: 14px 21px;
    color: var(--facility-navy);
    background: var(--facility-gold);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    transition: transform .2s ease, box-shadow .2s ease;
}

.help-button:hover {
    color: var(--facility-navy);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, .17);
}

@media (max-width: 991.98px) {
    .facility-photo {
        min-height: 390px;
    }

    .facility-details {
        padding: 42px;
    }

    .summary-panel {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .guidelines-intro {
        position: static;
        max-width: 650px;
    }

    .help-card {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (max-width: 767.98px) {
    .facilities-hero {
        min-height: 400px;
    }

    .facilities-hero-content {
        padding: 85px 0 70px;
    }

    .facilities-intro {
        padding: 70px 0 38px;
    }

    .facilities-list {
        padding-bottom: 70px;
    }

    .facility-card {
        border-radius: 17px;
    }

    .facility-photo {
        min-height: 330px;
    }

    .facility-details {
        padding: 35px 28px;
    }

    .facilities-summary {
        padding-bottom: 75px;
    }

    .summary-panel {
        padding: 32px 28px;
    }

    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px 0;
    }

    .summary-item {
        border-left: 0;
    }

    .facility-guidelines {
        padding: 75px 0;
    }

    .facilities-help {
        padding-bottom: 75px;
    }

    .help-card {
        padding: 35px 28px;
    }
}

@media (max-width: 575.98px) {
    .facilities-hero h1 {
        font-size: 40px;
    }

    .facilities-hero p {
        font-size: 15px;
    }

    .facility-photo {
        min-height: 280px;
    }

    .facility-details {
        padding: 30px 22px;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .summary-item {
        padding: 4px 0 18px;
        border-left: 0;
        border-bottom: 1px solid rgba(255, 255, 255, .12);
    }

    .summary-item:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .guideline {
        grid-template-columns: 38px 1fr;
        gap: 12px;
    }

    .help-button {
        width: 100%;
    }
}
</style>

    @include('components.lisa-chatbox')


<!-- =========================================================
     FACILITIES PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes facilitiesHeroEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 28px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes facilitiesHeroRingFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }
        50% {
            transform: translate3d(-14px, -12px, 0) rotate(4deg);
        }
    }

    .facilities-hero-content {
        animation: facilitiesHeroEnter .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    .facilities-hero::after {
        animation: facilitiesHeroRingFloat 7.5s ease-in-out infinite;
        will-change: transform;
    }

    /* Generic scroll reveal */
    .facilities-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
        transition:
            opacity .72s cubic-bezier(.22, 1, .36, 1),
            transform .72s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--facilities-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .facilities-motion-reveal.facilities-motion-left {
        transform: translate3d(-36px, 0, 0);
    }

    .facilities-motion-reveal.facilities-motion-right {
        transform: translate3d(36px, 0, 0);
    }

    .facilities-motion-reveal.facilities-motion-scale {
        transform: scale(.965);
    }

    .facilities-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Headings */
    .section-heading .eyebrow::before,
    .guidelines-intro .eyebrow::before {
        transform-origin: left center;
        transition: transform .55s cubic-bezier(.22, 1, .36, 1);
    }

    .facilities-motion-reveal:not(.is-visible) .eyebrow::before {
        transform: scaleX(.25);
    }

    .facilities-motion-reveal.is-visible .eyebrow::before {
        transform: scaleX(1);
    }

    /* Facility cards */
    .facility-card {
        transition:
            transform .34s cubic-bezier(.22, 1, .36, 1),
            box-shadow .34s ease,
            border-color .34s ease;
    }

    .facility-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 48px rgba(11, 46, 89, .13);
        border-color: rgba(24, 75, 140, .18);
    }

    .facility-photo img {
        transition: transform .55s cubic-bezier(.22, 1, .36, 1);
    }

    .facility-card:hover .facility-photo img {
        transform: scale(1.05);
    }

    .facility-details {
        transition: transform .32s ease;
    }

    .facility-card:hover .facility-details {
        transform: translateY(-2px);
    }

    .capacity-card {
        transition:
            transform .26s ease,
            box-shadow .26s ease,
            border-color .26s ease;
    }

    .capacity-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 26px rgba(11, 46, 89, .09);
        border-color: rgba(24, 75, 140, .18);
    }

    .capacity-icon {
        transition:
            transform .25s ease,
            background .25s ease;
    }

    .capacity-card:hover .capacity-icon {
        transform: scale(1.07);
        background: var(--facility-blue);
    }

    /* Empty state */
    .empty-state {
        transition:
            transform .3s ease,
            box-shadow .3s ease;
    }

    .empty-state:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 34px rgba(11, 46, 89, .09);
    }

    .empty-state-icon {
        transition: transform .26s ease;
    }

    .empty-state:hover .empty-state-icon {
        transform: scale(1.08);
    }

    /* Summary */
    .summary-panel {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .summary-panel:hover {
        transform: translateY(-5px);
        box-shadow: 0 26px 58px rgba(11, 46, 89, .2);
    }

    .summary-item {
        transition:
            transform .25s ease,
            background .25s ease;
    }

    .summary-item:hover {
        transform: translateY(-4px);
    }

    .summary-item strong {
        transition: transform .25s ease;
    }

    .summary-item:hover strong {
        transform: scale(1.07);
    }

    /* Guidelines */
    .guidelines-link i {
        transition: transform .25s ease;
    }

    .guidelines-link:hover i {
        transform: translateX(5px);
    }

    .guideline {
        transition:
            transform .24s ease,
            background .24s ease,
            padding-left .24s ease,
            padding-right .24s ease;
    }

    .guideline:hover {
        transform: translateX(5px);
        background: rgba(24, 75, 140, .025);
    }

    .guideline-number {
        display: inline-block;
        transition:
            transform .23s ease,
            color .23s ease;
    }

    .guideline:hover .guideline-number {
        transform: scale(1.08);
        color: var(--facility-blue);
    }

    /* Help CTA */
    .help-card {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .help-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 26px 58px rgba(11, 46, 89, .2);
    }

    .help-button i {
        transition: transform .25s ease;
    }

    .help-button:hover i {
        transform: translateX(5px);
    }

        .facilities-motion-reveal,
        .facilities-motion-reveal.facilities-motion-left,
        .facilities-motion-reveal.facilities-motion-right,
        .facilities-motion-reveal.facilities-motion-scale {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        .facility-card,
        .facility-photo img,
        .facility-details,
        .capacity-card,
        .capacity-icon,
        .empty-state,
        .empty-state-icon,
        .summary-panel,
        .summary-item,
        .summary-item strong,
        .guidelines-link i,
        .guideline,
        .guideline-number,
        .help-card,
        .help-button i {
            transition: none !important;
            animation: none !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const revealGroups = [
        { selector: '.facilities-intro .section-heading', mode: '' },
        { selector: '.facility-card', mode: '' },
        { selector: '.empty-state', mode: 'facilities-motion-scale' },
        { selector: '.summary-panel', mode: 'facilities-motion-scale' },
        { selector: '.guidelines-intro', mode: 'facilities-motion-left' },
        { selector: '.guidelines-list', mode: 'facilities-motion-right' },
        { selector: '.help-card', mode: '' }
    ];

    const revealElements = [];

    revealGroups.forEach(function (group) {
        document.querySelectorAll(group.selector).forEach(function (element, index) {
            /*
             * Existing data-aos elements stay managed by AOS.
             * We only add our custom reveal to elements without AOS.
             */
            if (element.hasAttribute('data-aos')) {
                return;
            }

            const aosParent = element.closest('[data-aos]');
            if (aosParent && aosParent !== element) {
                return;
            }

            element.classList.add('facilities-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 6) * 75, 375);
            element.style.setProperty('--facilities-motion-delay', stagger + 'ms');

            revealElements.push(element);
        });
    });

    if (!('IntersectionObserver' in window)) {
        revealElements.forEach(function (element) {
            element.classList.add('is-visible');
        });
        return;
    }

    const observer = new IntersectionObserver(function (entries, instance) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-visible');
            instance.unobserve(entry.target);
        });
    }, {
        root: null,
        threshold: 0.12,
        rootMargin: '0px 0px -45px 0px'
    });

    revealElements.forEach(function (element) {
        observer.observe(element);
    });
});
</script>


@endsection



