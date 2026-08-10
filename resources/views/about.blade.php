@extends('layouts.app')

@section('title', 'About | MMACI Library Services Office')

@section('content')

<div class="about-page">

    <!-- Hero -->
    <section class="about-hero">
        <div class="hero-orb hero-orb-one"></div>
        <div class="hero-orb hero-orb-two"></div>

        <div class="container position-relative">
            <div class="row align-items-center g-0">
                <div class="col-lg-7 hero-copy" data-aos="fade-right">
                    <span class="eyebrow eyebrow-light">
                        <i class="bi bi-book me-2"></i>About our library
                    </span>

                    <h1>MMACI Library<br>Services Office</h1>

                    <p>
                        Empowering students, faculty, and researchers through
                        quality learning resources, responsive services, and
                        reliable access to information.
                    </p>

                    <a href="#who-we-are" class="btn hero-button">
                        Discover our library
                        <i class="bi bi-arrow-down ms-2"></i>
                    </a>
                </div>

                <div class="col-lg-5 hero-visual" data-aos="fade-left">
                    <div class="hero-image-glow"></div>
                    <img
                        src="{{ asset('images/maamcherry.png') }}"
                        class="hero-image"
                        alt="MMACI Library Services Office representative">
                </div>
            </div>
        </div>
    </section>

    <!-- Who We Are -->
    <section class="section-space" id="who-we-are">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image-wrap">
                        <div class="image-accent"></div>
                        <img
                            src="{{ asset('images/logomml.png') }}"
                            class="about-image"
                            alt="MMACI Library logo">
                        <div class="image-note">
                            <i class="bi bi-mortarboard-fill"></i>
                            <div>
                                <strong>Learning for everyone</strong>
                                <span>Print and digital resources</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <span class="eyebrow">Get to know us</span>
                    <h2 class="section-title">Who We Are</h2>
                    <p class="section-lead">
                        The MMACI Library Services Office supports learning,
                        teaching, research, and creative expression by providing
                        timely and effective access to quality information.
                    </p>
                    <p class="body-copy">
                        We serve students, faculty, researchers, and the entire
                        academic community through modern library services,
                        carefully developed collections, and spaces that
                        encourage discovery and lifelong learning.
                    </p>

                    <div class="about-points">
                        <div class="about-point">
                            <i class="bi bi-check2"></i>
                            <span>Relevant academic resources</span>
                        </div>
                        <div class="about-point">
                            <i class="bi bi-check2"></i>
                            <span>Welcoming study spaces</span>
                        </div>
                        <div class="about-point">
                            <i class="bi bi-check2"></i>
                            <span>Reliable research support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission and Vision -->
    <section class="section-space soft-section">
        <div class="container">
            <div class="section-heading text-center">
                <span class="eyebrow">What guides us</span>
                <h2 class="section-title">Mission &amp; Vision</h2>
                <p>Our commitment to the MMACI academic community.</p>
            </div>

            <div class="row g-4 align-items-stretch">
                <div class="col-lg-7" data-aos="fade-up">
                    <article class="value-card mission-card h-100">
                        <div class="value-icon">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <div>
                            <span class="card-label">Our Mission</span>
                            <h3>Supporting learning and discovery</h3>
                            <p>
                                The Library Services Office supports learning,
                                teaching, research, and creative expression by
                                providing timely and effective access to
                                information for the entire academy.
                            </p>
                            <ul class="mission-list">
                                <li>Understand the research, teaching, and learning needs of users.</li>
                                <li>Build collections and tools that support academic work.</li>
                                <li>Create hospitable and conducive spaces for study and research.</li>
                            </ul>
                        </div>
                    </article>
                </div>

                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="100">
                    <article class="value-card vision-card h-100">
                        <div class="value-icon">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <div>
                            <span class="card-label">Our Vision</span>
                            <h3>A responsive, user-centered library</h3>
                            <p>
                                The MMACI Library Services Office envisions a
                                library responsive to the diverse needs and
                                expectations of the community, with users at
                                the center of everything it does.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Objectives -->
    <section class="section-space">
        <div class="container">
            <div class="section-heading text-center">
                <span class="eyebrow">Our priorities</span>
                <h2 class="section-title">Library Objectives</h2>
                <p>Focused services designed to support academic success.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <article class="objective-card h-100">
                        <span class="objective-number">01</span>
                        <div class="objective-icon"><i class="bi bi-book-half"></i></div>
                        <h3>Quality Resources</h3>
                        <p>
                            Provide current printed and digital resources that
                            meet the academic needs of the institution.
                        </p>
                    </article>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <article class="objective-card h-100">
                        <span class="objective-number">02</span>
                        <div class="objective-icon"><i class="bi bi-search"></i></div>
                        <h3>Research Support</h3>
                        <p>
                            Help students and faculty find reliable information
                            sources and navigate the research process.
                        </p>
                    </article>
                </div>

                <div class="col-md-6 col-lg-4 mx-md-auto" data-aos="fade-up" data-aos-delay="200">
                    <article class="objective-card h-100">
                        <span class="objective-number">03</span>
                        <div class="objective-icon"><i class="bi bi-laptop"></i></div>
                        <h3>Digital Access</h3>
                        <p>
                            Promote access to e-books, journals, databases,
                            and open-access learning resources.
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Library Hours -->
    <section class="hours-section section-space">
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <span class="eyebrow eyebrow-light">Opening schedule</span>
                    <h2 class="hours-title">Plan your visit to the library.</h2>
                    <p class="hours-copy">
                        Drop by during our regular operating hours for access
                        to collections, study areas, and library assistance.
                    </p>

                    <div class="hours-reminder">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>Schedules may change during holidays and special events.</span>
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-left">
                    <div class="schedule-card">
                        <div class="schedule-card-head">
                            <div>
                                <small>MMACI LIBRARY</small>
                                <h3>Operating Hours</h3>
                            </div>
                            <span class="clock-icon"><i class="bi bi-clock"></i></span>
                        </div>

                        <div class="schedule-list">
                            <div class="schedule-item">
                                <div>
                                    <strong>Monday – Friday</strong>
                                    <span>Regular weekdays</span>
                                </div>
                                <time>8:00 AM – 9:00 PM</time>
                            </div>
                            <div class="schedule-item">
                                <div>
                                    <strong>Saturday</strong>
                                    <span>Weekend schedule</span>
                                </div>
                                <time>8:00 AM – 5:00 PM</time>
                            </div>
                            <div class="schedule-item">
                                <div>
                                    <strong>Sunday</strong>
                                    <span>No library services</span>
                                </div>
                                <time class="closed">Closed</time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Organizational Chart -->
    <section class="section-space soft-section">
        <div class="container">
            <div class="section-heading text-center">
                <span class="eyebrow">Meet the structure</span>
                <h2 class="section-title">Organizational Chart</h2>
                <p>See how the MMACI Library Services Office is organized.</p>
            </div>

            <div class="chart-card" data-aos="zoom-in">
                <img
                    src="{{ asset('images/organizationalchart.png') }}"
                    class="chart-image"
                    alt="MMACI Library Services Office organizational chart">
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-panel" data-aos="fade-up">
                <div>
                    <span class="eyebrow eyebrow-light">Start exploring</span>
                    <h2>Find resources for your next study or research project.</h2>
                    <p>Browse books, journals, and digital learning materials available through MMACI.</p>
                </div>
                <a href="{{ url('/collection/printed') }}" class="btn cta-button">
                    Browse Collection
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

</div>

<style>
    :root {
        --mmaci-navy: #09284c;
        --mmaci-blue: #124a86;
        --mmaci-gold: #f4b400;
        --mmaci-ink: #15243a;
        --mmaci-muted: #66758a;
        --mmaci-soft: #f5f8fc;
        --mmaci-border: #e5ebf2;
        --mmaci-white: #ffffff;
        --mmaci-shadow: 0 20px 55px rgba(9, 40, 76, .10);
    }

    .about-page {
        color: var(--mmaci-ink);
        background: var(--mmaci-white);
        overflow: hidden;
    }

    .section-space {
        padding: 96px 0;
    }

    .soft-section {
        background: var(--mmaci-soft);
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        margin-bottom: 14px;
        color: var(--mmaci-blue);
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .eyebrow-light {
        color: #ffd86b;
    }

    .section-title {
        margin: 0;
        color: var(--mmaci-navy);
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.12;
    }

    .section-heading {
        max-width: 680px;
        margin: 0 auto 48px;
    }

    .section-heading p,
    .body-copy {
        margin: 16px 0 0;
        color: var(--mmaci-muted);
        font-size: 1rem;
        line-height: 1.8;
    }

    .section-lead {
        margin: 24px 0 0;
        color: var(--mmaci-ink);
        font-size: 1.15rem;
        font-weight: 500;
        line-height: 1.8;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const revealGroups = [
        {
            selector: '.about-page .section-heading',
            mode: ''
        },
        {
            selector: '#who-we-are .about-image-wrap',
            mode: 'about-motion-left'
        },
        {
            selector: '#who-we-are .col-lg-6:last-child',
            mode: 'about-motion-right'
        },
        {
            selector: '.value-card',
            mode: 'about-motion-scale'
        },
        {
            selector: '.objective-card',
            mode: ''
        },
        {
            selector: '.hours-section .col-lg-5',
            mode: 'about-motion-left'
        },
        {
            selector: '.hours-section .schedule-card',
            mode: 'about-motion-right'
        },
        {
            selector: '.chart-card',
            mode: 'about-motion-scale'
        },
        {
            selector: '.cta-panel',
            mode: ''
        }
    ];

    const revealElements = [];

    revealGroups.forEach(function (group) {
        document.querySelectorAll(group.selector).forEach(function (element, index) {
            /*
             * Existing data-aos elements stay managed by AOS.
             * We only animate elements that don't already use AOS.
             */
            if (element.hasAttribute('data-aos')) {
                return;
            }

            const aosParent = element.closest('[data-aos]');
            if (aosParent && aosParent !== element) {
                return;
            }

            element.classList.add('about-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 6) * 75, 375);
            element.style.setProperty('--about-motion-delay', stagger + 'ms');

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


