@extends('layouts.app')

@section('title', 'Donated Books | MMACI Library Services Office')

@section('content')

<section class="donated-books-page">

    {{-- =========================================================
        HERO
    ========================================================== --}}
    <section class="donated-hero">

        <div class="donated-hero-overlay"></div>

        <div class="container">

            <div class="donated-hero-content">

                <span class="donated-eyebrow">
                    MMACI Library Collection
                </span>

                <h1>
                    Donated Books
                </h1>

                <p>
                    Explore books and learning materials generously donated to
                    the MMACI Library Services Office.
                </p>

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb justify-content-center mb-0">

                        <li class="breadcrumb-item">

                            <a href="{{ route('home') }}">
                                Home
                            </a>

                        </li>

                        <li class="breadcrumb-item">
                            Collection
                        </li>

                        <li
                            class="breadcrumb-item active"
                            aria-current="page">

                            Donated Books

                        </li>

                    </ol>

                </nav>

            </div>

        </div>

    </section>


    {{-- =========================================================
        CONTENT
    ========================================================== --}}
    <section class="donated-content">

        <div class="container">

            <div class="donated-intro donated-motion-reveal">

                <span class="section-label">
                    Donated Collection
                </span>

                <h2>
                    Shared knowledge for the MMACI community
                </h2>

                <p>
                    Donated books help expand the library collection and provide
                    additional learning resources for students, faculty,
                    researchers, and visitors.
                </p>

            </div>


            <div class="donated-empty donated-motion-reveal donated-motion-scale">

                <div class="donated-empty-icon">
                    <i class="bi bi-gift" aria-hidden="true"></i>
                </div>

                <h3>
                    Donated books will appear here
                </h3>

                <p>
                    Published donated-book records can be displayed in this
                    section once they are added to the library system.
                </p>

            </div>

        </div>

    </section>

</section>


<style>

:root {

    --donated-navy: #0b2e59;
    --donated-blue: #184b8c;
    --donated-gold: #f4b400;

    --donated-text: #17243a;
    --donated-muted: #647187;

    --donated-bg: #f4f7fb;
    --donated-border: #dfe6ef;
    --donated-white: #ffffff;

}


/* =============================================================
   HERO
============================================================= */

.donated-hero {

    position: relative;

    min-height: 430px;

    display: grid;
    place-items: center;

    overflow: hidden;

    color: var(--donated-white);

    background:

        linear-gradient(
            105deg,
            rgba(7, 30, 61, .91),
            rgba(11, 46, 89, .76),
            rgba(24, 75, 140, .58)
        ),

        url("{{ asset('images/books1.jpg') }}")
        center / cover no-repeat;

    isolation: isolate;

}


.donated-hero::after {

    content: "";

    position: absolute;

    right: -130px;
    bottom: -210px;

    width: 430px;
    height: 430px;

    border:
        58px solid
        rgba(244, 180, 0, .10);

    border-radius: 50%;

    pointer-events: none;

    z-index: 0;

}


.donated-hero-overlay {

    position: absolute;

    inset: 0;

    background:

        radial-gradient(
            circle at 70% 30%,
            rgba(255, 255, 255, .08),
            transparent 30%
        );

}


.donated-hero-content {

    position: relative;

    z-index: 2;

    width: 100%;
    max-width: 820px;

    margin: auto;

    padding:
        95px 15px
        80px;

    text-align: center;

}


.donated-eyebrow {

    display: inline-flex;
    align-items: center;

    gap: 8px;

    color:
        var(--donated-gold);

    font-size: 12px;
    font-weight: 800;

    letter-spacing: .12em;

    text-transform: uppercase;

}


.donated-eyebrow::before {

    content: "";

    width: 28px;
    height: 3px;

    background:
        var(--donated-gold);

    border-radius: 20px;

}


.donated-hero h1 {

    margin:
        18px 0
        16px;

    color:
        var(--donated-white);

    font-size:
        clamp(
            45px,
            6vw,
            70px
        );

    font-weight: 900;

    line-height: 1.04;

    letter-spacing: -.045em;

}


.donated-hero p {

    max-width: 680px;

    margin:
        0 auto
        26px;

    color:
        rgba(
            255,
            255,
            255,
            .80
        );

    font-size: 16px;

    line-height: 1.75;

}


.donated-hero .breadcrumb {

    font-size: 13px;

}


.donated-hero .breadcrumb-item,
.donated-hero .breadcrumb-item.active {

    color:
        rgba(
            255,
            255,
            255,
            .60
        );

}


.donated-hero .breadcrumb-item a {

    color:
        var(--donated-white);

    font-weight: 700;

    text-decoration: none;

}


.donated-hero .breadcrumb-item a:hover {

    color:
        var(--donated-gold);

}


.donated-hero
.breadcrumb-item
+
.breadcrumb-item::before {

    color:
        rgba(
            255,
            255,
            255,
            .38
        );

}


/* =============================================================
   CONTENT
============================================================= */

.donated-content {

    min-height: 420px;

    padding:
        70px 0
        85px;

    background:
        var(--donated-bg);

}


.donated-intro {

    max-width: 760px;

    margin-bottom: 34px;

}


.section-label {

    display: inline-flex;
    align-items: center;

    gap: 8px;

    color:
        var(--donated-blue);

    font-size: 11px;
    font-weight: 800;

    letter-spacing: .11em;

    text-transform: uppercase;

}


.section-label::before {

    content: "";

    width: 28px;
    height: 3px;

    background:
        var(--donated-gold);

    border-radius: 10px;

}


.donated-intro h2 {

    margin:
        13px 0
        14px;

    color:
        var(--donated-navy);

    font-size:
        clamp(
            30px,
            4vw,
            44px
        );

    font-weight: 850;

    line-height: 1.15;

    letter-spacing: -.035em;

}


.donated-intro p {

    margin: 0;

    color:
        var(--donated-muted);

    font-size: 16px;

    line-height: 1.8;

}


/* =============================================================
   EMPTY STATE
============================================================= */

.donated-empty {

    padding:
        62px 28px;

    text-align: center;

    background:
        var(--donated-white);

    border:
        1px solid
        var(--donated-border);

    border-radius: 20px;

    box-shadow:
        0 12px 32px
        rgba(11, 46, 89, .07);

    transition:
        transform .30s ease,
        box-shadow .30s ease,
        border-color .30s ease;

}


.donated-empty:hover {

    transform:
        translateY(-5px);

    border-color:
        rgba(
            24,
            75,
            140,
            .18
        );

    box-shadow:
        0 20px 44px
        rgba(11, 46, 89, .11);

}


.donated-empty-icon {

    width: 72px;
    height: 72px;

    display: grid;
    place-items: center;

    margin:
        0 auto
        20px;

    color:
        var(--donated-navy);

    background:
        rgba(
            244,
            180,
            0,
            .18
        );

    border-radius: 18px;

    font-size: 30px;

    transition:
        transform .25s ease,
        background .25s ease;

}


.donated-empty:hover
.donated-empty-icon {

    transform:
        scale(1.07)
        rotate(2deg);

    background:
        rgba(
            244,
            180,
            0,
            .26
        );

}


.donated-empty h3 {

    margin:
        0 0
        9px;

    color:
        var(--donated-navy);

    font-size: 22px;
    font-weight: 850;

}


.donated-empty p {

    max-width: 620px;

    margin: auto;

    color:
        var(--donated-muted);

    font-size: 14px;

    line-height: 1.75;

}


/* =============================================================
   ANIMATIONS
============================================================= */

@keyframes donatedHeroEnter {

    from {

        opacity: 0;

        transform:
            translate3d(
                0,
                28px,
                0
            );

    }

    to {

        opacity: 1;

        transform:
            translate3d(
                0,
                0,
                0
            );

    }

}


@keyframes donatedHeroRingFloat {

    0%,
    100% {

        transform:
            translate3d(
                0,
                0,
                0
            )
            rotate(0deg);

    }

    50% {

        transform:
            translate3d(
                -14px,
                -13px,
                0
            )
            rotate(4deg);

    }

}


.donated-hero-content {

    animation:
        donatedHeroEnter
        .85s
        cubic-bezier(
            .22,
            1,
            .36,
            1
        )
        both;

}


.donated-hero::after {

    animation:
        donatedHeroRingFloat
        8s
        ease-in-out
        infinite;

    will-change:
        transform;

}


.donated-motion-reveal {

    opacity: 0;

    transform:
        translate3d(
            0,
            30px,
            0
        );

    transition:

        opacity
        .72s
        cubic-bezier(
            .22,
            1,
            .36,
            1
        ),

        transform
        .72s
        cubic-bezier(
            .22,
            1,
            .36,
            1
        );

    transition-delay:
        var(
            --donated-motion-delay,
            0ms
        );

    will-change:
        opacity,
        transform;

}


.donated-motion-reveal
.donated-motion-scale {

    transform:
        scale(.965);

}


.donated-motion-reveal.is-visible {

    opacity: 1;

    transform:
        translate3d(
            0,
            0,
            0
        )
        scale(1);

}


/* =============================================================
   RESPONSIVE
============================================================= */

@media (max-width: 767.98px) {

    .donated-hero {

        min-height: 360px;

    }


    .donated-hero-content {

        padding:
            78px 12px
            64px;

    }


    .donated-content {

        padding:
            52px 0
            65px;

    }


    .donated-empty {

        padding:
            45px 22px;

    }

}


@media (max-width: 575.98px) {

    .donated-hero {

        min-height: 330px;

    }


    .donated-hero h1 {

        font-size:
            42px;

    }


    .donated-hero p {

        font-size:
            14px;

    }


    .donated-hero .breadcrumb {

        display:
            none;

    }

}

    .donated-motion-reveal {

        opacity:
            1 !important;

        transform:
            none !important;

        transition:
            none !important;

    }


    .donated-empty,
    .donated-empty-icon {

        transition:
            none !important;

    }

}

</style>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const revealElements =
            document.querySelectorAll(
                '.donated-motion-reveal'
            );


        revealElements.forEach(
            function (
                element,
                index
            ) {

                element.style.setProperty(
                    '--donated-motion-delay',
                    Math.min(
                        index * 90,
                        270
                    ) + 'ms'
                );

            }
        );


        if (
            !(
                'IntersectionObserver'
                in window
            )
        ) {

            revealElements.forEach(
                function (element) {

                    element.classList.add(
                        'is-visible'
                    );

                }
            );

            return;

        }


        const observer =
            new IntersectionObserver(
                function (
                    entries,
                    instance
                ) {

                    entries.forEach(
                        function (entry) {

                            if (
                                !entry.isIntersecting
                            ) {

                                return;

                            }


                            entry.target.classList.add(
                                'is-visible'
                            );


                            instance.unobserve(
                                entry.target
                            );

                        }
                    );

                },
                {

                    threshold:
                        .12,

                    rootMargin:
                        '0px 0px -40px 0px'

                }
            );


        revealElements.forEach(
            function (element) {

                observer.observe(
                    element
                );

            }
        );

    }
);

</script>


@include('components.lisa-chatbox')

@endsection

@push('styles')

@endpush

