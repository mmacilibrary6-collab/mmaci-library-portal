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

    /* Hero */
    .about-hero {
        position: relative;
        min-height: 560px;
        background: linear-gradient(120deg, #061c36 0%, var(--mmaci-navy) 50%, #15589b 100%);
        isolation: isolate;
    }

    /*
     * The following section sits in front of the students.
     * This hides the flat bottom edge of the cut-out image and makes
     * the people appear naturally positioned behind the page content.
     */
    #who-we-are {
        position: relative;
        z-index: 5;
        margin-top: -30px;
        padding-top: 126px;
        background: var(--mmaci-white);
        border-radius: 30px 30px 0 0;
        box-shadow: 0 -14px 35px rgba(6, 28, 54, .08);
    }

    .about-hero::after {
        position: absolute;
        inset: 0;
        z-index: -1;
        background-image: radial-gradient(rgba(255,255,255,.12) 1px, transparent 1px);
        background-size: 28px 28px;
        content: "";
        opacity: .22;
        mask-image: linear-gradient(to right, #000, transparent 72%);
    }

    .hero-copy {
        padding: 100px 0;
    }

    .hero-copy h1 {
        max-width: 760px;
        margin: 0;
        color: #fff;
        font-size: clamp(2.8rem, 6vw, 5.25rem);
        font-weight: 800;
        letter-spacing: -.055em;
        line-height: .98;
    }

    .hero-copy p {
        max-width: 650px;
        margin: 26px 0 34px;
        color: rgba(255,255,255,.76);
        font-size: 1.08rem;
        line-height: 1.8;
    }

    .hero-button,
    .cta-button {
        padding: 14px 24px;
        color: var(--mmaci-navy);
        font-weight: 800;
        background: var(--mmaci-gold);
        border: 0;
        border-radius: 12px;
        box-shadow: 0 14px 30px rgba(244,180,0,.22);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .hero-button:hover,
    .cta-button:hover {
        color: var(--mmaci-navy);
        background: #ffc629;
        transform: translateY(-3px);
        box-shadow: 0 18px 36px rgba(244,180,0,.3);
    }

    .hero-visual {
        position: relative;
        min-height: 560px;
    }

    .hero-image {
        position: absolute;
        right: -30px;
        bottom: -42px;
        z-index: 2;
        width: auto;
        height: 535px;
        max-width: none;
        object-fit: contain;
    }

    .hero-image-glow {
        position: absolute;
        right: -30px;
        bottom: 36px;
        width: 410px;
        height: 410px;
        background: rgba(244,180,0,.14);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 50%;
    }

    .hero-orb {
        position: absolute;
        z-index: -1;
        border-radius: 50%;
        filter: blur(2px);
    }

    .hero-orb-one {
        top: -130px;
        right: -80px;
        width: 360px;
        height: 360px;
        background: rgba(244,180,0,.10);
    }

    .hero-orb-two {
        bottom: -180px;
        left: 36%;
        width: 420px;
        height: 420px;
        background: rgba(255,255,255,.04);
    }

    /* About */
    .about-image-wrap {
        position: relative;
        padding: 20px 30px 38px 0;
    }

    .about-image {
        position: relative;
        z-index: 2;
        display: block;
        width: 100%;
        min-height: 390px;
        object-fit: contain;
        background: #fff;
        border: 1px solid var(--mmaci-border);
        border-radius: 24px;
        box-shadow: var(--mmaci-shadow);
    }

    .image-accent {
        position: absolute;
        top: 0;
        right: 4px;
        bottom: 18px;
        width: 55%;
        background: var(--mmaci-gold);
        border-radius: 24px;
    }

    .image-note {
        position: absolute;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        background: var(--mmaci-navy);
        border-radius: 16px;
        box-shadow: 0 16px 30px rgba(9,40,76,.22);
    }

    .image-note i {
        color: var(--mmaci-gold);
        font-size: 1.6rem;
    }

    .image-note strong,
    .image-note span {
        display: block;
    }

    .image-note strong { color: #fff; font-size: .92rem; }
    .image-note span { color: rgba(255,255,255,.62); font-size: .75rem; }

    .about-points {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px 18px;
        margin-top: 26px;
    }

    .about-point {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--mmaci-ink);
        font-size: .94rem;
        font-weight: 700;
    }

    .about-point i {
        display: grid;
        flex: 0 0 auto;
        width: 28px;
        height: 28px;
        place-items: center;
        color: var(--mmaci-navy);
        background: #ffedb5;
        border-radius: 50%;
    }

    /* Mission, vision, and objectives */
    .value-card {
        display: flex;
        gap: 25px;
        padding: 38px;
        border: 1px solid var(--mmaci-border);
        border-radius: 22px;
        box-shadow: var(--mmaci-shadow);
    }

    .mission-card { background: #fff; }
    .vision-card {
        color: #fff;
        background: linear-gradient(145deg, var(--mmaci-navy), var(--mmaci-blue));
        border-color: transparent;
    }

    .value-icon,
    .objective-icon {
        display: grid;
        flex: 0 0 auto;
        width: 62px;
        height: 62px;
        place-items: center;
        color: var(--mmaci-navy);
        font-size: 1.65rem;
        background: var(--mmaci-gold);
        border-radius: 17px;
    }

    .card-label {
        color: var(--mmaci-blue);
        font-size: .73rem;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .vision-card .card-label { color: #ffd86b; }

    .value-card h3 {
        margin: 8px 0 14px;
        font-size: 1.5rem;
        font-weight: 800;
    }

    .value-card p,
    .mission-list {
        margin-bottom: 0;
        color: var(--mmaci-muted);
        line-height: 1.75;
    }

    .vision-card p { color: rgba(255,255,255,.75); }

    .mission-list {
        display: grid;
        gap: 8px;
        margin-top: 18px;
        padding-left: 20px;
    }

    .mission-list li::marker { color: var(--mmaci-gold); }

    .objective-card {
        position: relative;
        padding: 34px;
        overflow: hidden;
        background: #fff;
        border: 1px solid var(--mmaci-border);
        border-radius: 20px;
        box-shadow: 0 14px 35px rgba(9,40,76,.07);
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }

    .objective-card:hover {
        border-color: rgba(244,180,0,.55);
        transform: translateY(-7px);
        box-shadow: var(--mmaci-shadow);
    }

    .objective-number {
        position: absolute;
        top: 20px;
        right: 24px;
        color: #edf1f6;
        font-size: 2.6rem;
        font-weight: 900;
    }

    .objective-card h3 {
        margin: 24px 0 12px;
        color: var(--mmaci-navy);
        font-size: 1.25rem;
        font-weight: 800;
    }

    .objective-card p {
        margin: 0;
        color: var(--mmaci-muted);
        line-height: 1.75;
    }

    /* Hours */
    .hours-section {
        position: relative;
        color: #fff;
        background:
            radial-gradient(circle at 10% 10%, rgba(244,180,0,.13), transparent 28%),
            linear-gradient(130deg, #061c36, var(--mmaci-navy) 62%, #10467e);
    }

    .hours-title {
        max-width: 520px;
        margin: 0;
        font-size: clamp(2.25rem, 5vw, 3.65rem);
        font-weight: 800;
        letter-spacing: -.045em;
        line-height: 1.08;
    }

    .hours-copy {
        margin: 22px 0;
        color: rgba(255,255,255,.68);
        line-height: 1.8;
    }

    .hours-reminder {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: rgba(255,255,255,.76);
        font-size: .88rem;
    }

    .hours-reminder i { margin-top: 2px; color: var(--mmaci-gold); }

    .schedule-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 24px;
        box-shadow: 0 30px 70px rgba(0,0,0,.25);
    }

    .schedule-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 25px 28px;
        color: #fff;
        background: rgba(255,255,255,.05);
        border-bottom: 1px solid rgba(255,255,255,.12);
        background-color: var(--mmaci-blue);
    }

    .schedule-card-head small {
        color: #ffd86b;
        font-weight: 800;
        letter-spacing: .12em;
    }

    .schedule-card-head h3 {
        margin: 4px 0 0;
        font-size: 1.45rem;
        font-weight: 800;
    }

    .clock-icon {
        display: grid;
        width: 52px;
        height: 52px;
        place-items: center;
        color: var(--mmaci-navy);
        font-size: 1.35rem;
        background: var(--mmaci-gold);
        border-radius: 15px;
    }

    .schedule-list { padding: 6px 28px; }

    .schedule-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 22px 0;
        border-bottom: 1px solid var(--mmaci-border);
    }

    .schedule-item:last-child { border-bottom: 0; }
    .schedule-item strong,
    .schedule-item span { display: block; }
    .schedule-item strong { color: var(--mmaci-ink); font-size: 1rem; }
    .schedule-item span { margin-top: 3px; color: var(--mmaci-muted); font-size: .82rem; }

    .schedule-item time {
        flex: 0 0 auto;
        padding: 8px 12px;
        color: var(--mmaci-navy);
        font-size: .9rem;
        font-weight: 800;
        background: #fff6d9;
        border-radius: 9px;
    }

    .schedule-item time.closed {
        color: #a43b46;
        background: #fff0f1;
    }

    /* Chart and CTA */
    .chart-card {
        max-width: 1050px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--mmaci-border);
        border-radius: 24px;
        box-shadow: var(--mmaci-shadow);
    }

    .chart-image {
        display: block;
        width: 100%;
        height: auto;
        border-radius: 14px;
    }

    .cta-section {
        padding: 0 0 96px;
        background: var(--mmaci-soft);
    }

    .cta-panel {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 36px;
        padding: 52px 58px;
        color: #fff;
        background:
            radial-gradient(circle at 90% 0, rgba(244,180,0,.16), transparent 25%),
            var(--mmaci-navy);
        border-radius: 26px;
        box-shadow: 0 24px 55px rgba(9,40,76,.2);
    }

    .cta-panel h2 {
        max-width: 760px;
        margin: 0;
        font-size: clamp(1.8rem, 4vw, 2.7rem);
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .cta-panel p {
        margin: 14px 0 0;
        color: rgba(255,255,255,.68);
    }

    .cta-button { flex: 0 0 auto; }

    /* Responsive */
    @media (max-width: 991.98px) {
        .section-space { padding: 76px 0; }
        .about-hero { text-align: center; }
        #who-we-are {
            margin-top: -24px;
            padding-top: 100px;
            border-radius: 24px 24px 0 0;
        }
        .hero-copy { padding: 76px 0 20px; }
        .hero-copy p { margin-right: auto; margin-left: auto; }
        .hero-visual { min-height: 400px; }
        .hero-image {
            right: 50%;
            bottom: -35px;
            height: 405px;
            max-width: 95%;
            transform: translateX(50%);
        }
        .hero-image-glow {
            right: 50%;
            bottom: 20px;
            width: 340px;
            height: 340px;
            transform: translateX(50%);
        }
        .value-card { padding: 32px; }
        .cta-panel {
            align-items: flex-start;
            flex-direction: column;
            padding: 44px;
        }
    }

    @media (max-width: 575.98px) {
        .section-space { padding: 62px 0; }
        #who-we-are {
            margin-top: -18px;
            padding-top: 80px;
            border-radius: 18px 18px 0 0;
        }
        .section-heading { margin-bottom: 34px; }
        .hero-copy { padding-top: 62px; }
        .hero-copy h1 { font-size: 2.7rem; }
        .hero-visual { min-height: 320px; }
        .hero-image { height: 325px; }
        .hero-image-glow { width: 270px; height: 270px; }
        .about-image-wrap { padding: 12px 12px 42px 0; }
        .about-image { min-height: 280px; }
        .image-note { right: -2px; padding: 13px 15px; }
        .about-points { grid-template-columns: 1fr; }
        .value-card { flex-direction: column; padding: 26px; }
        .objective-card { padding: 28px; }
        .schedule-card-head { padding: 21px; }
        .schedule-list { padding: 4px 21px; }
        .schedule-item {
            align-items: flex-start;
            flex-direction: column;
            gap: 12px;
            padding: 19px 0;
        }
        .chart-card { padding: 10px; border-radius: 18px; }
        .cta-section { padding-bottom: 62px; }
        .cta-panel { padding: 34px 26px; border-radius: 20px; }
        .cta-button { width: 100%; }
    }
</style>


<!-- =========================================================
     ABOUT PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    @keyframes aboutOrbFloatOne {
        0%, 100% {
            transform: translate3d(0, 0, 0) scale(1);
        }
        50% {
            transform: translate3d(-18px, 14px, 0) scale(1.04);
        }
    }

    @keyframes aboutOrbFloatTwo {
        0%, 100% {
            transform: translate3d(0, 0, 0) scale(1);
        }
        50% {
            transform: translate3d(16px, -18px, 0) scale(1.035);
        }
    }

    @keyframes aboutGlowPulse {
        0%, 100% {
            opacity: .82;
            transform: scale(1);
        }
        50% {
            opacity: 1;
            transform: scale(1.045);
        }
    }

    @keyframes aboutImageFloat {
        0%, 100% {
            translate: 0 0;
        }
        50% {
            translate: 0 -8px;
        }
    }

    @keyframes aboutIconPulse {
        0%, 100% {
            transform: scale(1) rotate(0deg);
        }
        50% {
            transform: scale(1.06) rotate(2deg);
        }
    }

    @keyframes aboutViewerEnter {
        from {
            opacity: 0;
            transform: translate3d(0, 18px, 0) scale(.98);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }
    }

    /* Decorative hero motion */
    .hero-orb-one {
        animation: aboutOrbFloatOne 8s ease-in-out infinite;
        will-change: transform;
    }

    .hero-orb-two {
        animation: aboutOrbFloatTwo 10s ease-in-out infinite;
        will-change: transform;
    }

    .hero-image-glow {
        animation: aboutGlowPulse 5.5s ease-in-out infinite;
        will-change: transform, opacity;
    }

    .hero-image {
        animation: aboutImageFloat 5.8s ease-in-out infinite;
        will-change: translate;
    }

    /* Avoid overriding the translateX centering used on tablet/mobile. */
    @media (max-width: 991.98px) {
        .hero-image {
            animation: none;
        }
    }

    /* Scroll reveal */
    .about-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
        transition:
            opacity .72s cubic-bezier(.22, 1, .36, 1),
            transform .72s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--about-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .about-motion-reveal.about-motion-left {
        transform: translate3d(-38px, 0, 0);
    }

    .about-motion-reveal.about-motion-right {
        transform: translate3d(38px, 0, 0);
    }

    .about-motion-reveal.about-motion-scale {
        transform: scale(.965);
    }

    .about-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* Hero / CTA arrows */
    .hero-button i,
    .cta-button i {
        transition: transform .25s ease;
    }

    .hero-button:hover i {
        transform: translateY(4px);
    }

    .cta-button:hover i {
        transform: translateX(5px);
    }

    /* About image panel */
    .about-image-wrap {
        transition: transform .35s cubic-bezier(.22, 1, .36, 1);
    }

    .about-image-wrap:hover {
        transform: translateY(-6px);
    }

    .about-image {
        transition:
            transform .42s cubic-bezier(.22, 1, .36, 1),
            box-shadow .42s ease;
    }

    .about-image-wrap:hover .about-image {
        transform: scale(1.012);
        box-shadow: 0 24px 60px rgba(9, 40, 76, .14);
    }

    .image-accent {
        transition:
            transform .4s cubic-bezier(.22, 1, .36, 1),
            opacity .4s ease;
    }

    .about-image-wrap:hover .image-accent {
        transform: translate3d(6px, -6px, 0);
    }

    .image-note {
        transition:
            transform .32s cubic-bezier(.22, 1, .36, 1),
            box-shadow .32s ease;
    }

    .about-image-wrap:hover .image-note {
        transform: translateY(-4px);
        box-shadow: 0 20px 36px rgba(9, 40, 76, .27);
    }

    /* About points */
    .about-point {
        transition:
            transform .25s ease,
            color .25s ease;
    }

    .about-point i {
        transition:
            transform .25s ease,
            background .25s ease;
    }

    .about-point:hover {
        transform: translateX(4px);
        color: var(--mmaci-navy);
    }

    .about-point:hover i {
        transform: scale(1.08);
        background: var(--mmaci-gold);
    }

    /* Mission / vision cards */
    .value-card {
        transition:
            transform .32s cubic-bezier(.22, 1, .36, 1),
            box-shadow .32s ease,
            border-color .32s ease;
    }

    .value-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 24px 58px rgba(9, 40, 76, .13);
        border-color: rgba(244, 180, 0, .34);
    }

    .value-icon,
    .objective-icon,
    .clock-icon {
        transition:
            transform .28s cubic-bezier(.22, 1, .36, 1),
            box-shadow .28s ease;
    }

    .value-card:hover .value-icon,
    .objective-card:hover .objective-icon,
    .schedule-card:hover .clock-icon {
        transform: translateY(-3px) scale(1.06);
        box-shadow: 0 12px 24px rgba(244, 180, 0, .2);
    }

    /* Objective cards */
    .objective-card {
        transition:
            transform .32s cubic-bezier(.22, 1, .36, 1),
            box-shadow .32s ease,
            border-color .32s ease;
    }

    .objective-number {
        transition:
            transform .32s ease,
            color .32s ease;
    }

    .objective-card:hover .objective-number {
        transform: translateY(-3px) scale(1.05);
        color: #e4eaf1;
    }

    /* Schedule */
    .schedule-card {
        transition:
            transform .34s cubic-bezier(.22, 1, .36, 1),
            box-shadow .34s ease;
    }

    .schedule-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 34px 80px rgba(0, 0, 0, .29);
    }

    .schedule-item {
        transition:
            transform .24s ease,
            background .24s ease,
            padding-left .24s ease,
            padding-right .24s ease;
    }

    .schedule-item:hover {
        transform: translateX(4px);
        background: rgba(18, 74, 134, .035);
    }

    .schedule-item time {
        transition:
            transform .24s ease,
            box-shadow .24s ease;
    }

    .schedule-item:hover time {
        transform: scale(1.035);
        box-shadow: 0 8px 18px rgba(9, 40, 76, .08);
    }

    /* Organizational chart */
    .chart-card {
        transition:
            transform .36s cubic-bezier(.22, 1, .36, 1),
            box-shadow .36s ease;
    }

    .chart-image {
        transition: transform .55s cubic-bezier(.22, 1, .36, 1);
    }

    .chart-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 28px 64px rgba(9, 40, 76, .14);
    }

    .chart-card:hover .chart-image {
        transform: scale(1.012);
    }

    /* CTA */
    .cta-panel {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .cta-panel:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 70px rgba(9, 40, 76, .24);
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



