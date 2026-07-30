@extends('layouts.app')

@section('title', 'Library Services | MMACI Library Services Office')

@section('content')

<section class="services-hero">
    <div class="container">
        <div class="services-hero-content">
            <span class="eyebrow eyebrow-light">Library Services</span>

            <h1>Everything you need to use the library well.</h1>

            <p>
                Find service hours, borrowing privileges, available services,
                library rules, and electronic access in one place.
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
                        Overview
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<section class="services-intro">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Supporting Learning</span>
            <h2>Helpful services for the MMACI community</h2>
            <p>
                The Library Services Office provides learning resources,
                technology, facilities, and guidance for students, faculty,
                personnel, and authorized visitors.
            </p>
        </div>
    </div>
</section>

<section class="service-hours" id="service-hours">
    <div class="container">
        <div class="hours-panel">
            <div class="hours-intro">
                <span class="panel-kicker">Operating Schedule</span>
                <h2>Library service hours</h2>
                <p>
                    Schedule changes may apply during holidays, examinations,
                    and institutional activities.
                </p>
            </div>

            <div class="hours-list">
                @foreach($serviceHours as $schedule)
                    <div class="hours-row">
                        <strong>{{ $schedule['days'] }}</strong>

                        @if($schedule['status'] === 'Closed')
                            <span class="status-closed">Closed</span>
                        @else
                            <span class="hours-time">
                                {{ $schedule['opening'] }}
                                <span aria-hidden="true">—</span>
                                {{ $schedule['closing'] }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="available-services" id="available-services">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Available Services</span>
            <h2>Services you can use</h2>
            <p>
                Practical library support for research, learning, recreation,
                and school-related work.
            </p>
        </div>

        @php
            $serviceImages = [
                asset('images/opac.png'),
                asset('images/chesz.jpg'),
                asset('images/laptops.jpg'),
            ];
        @endphp

        <div class="row g-4">
            @foreach($services as $service)
                @php
                    $serviceImage = $serviceImages[$loop->index]
                        ?? asset('images/readingarea.jpg');
                @endphp

                <div class="col-lg-4 col-md-6">
                    <article class="service-card">
                        <div class="service-card-photo">
                            <img
                                src="{{ $serviceImage }}"
                                alt="{{ $service['title'] }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">
                        </div>

                        <div class="service-card-body">
                            <span class="card-kicker">
                                {{ $service['short_title'] }}
                            </span>

                            <h3>{{ $service['title'] }}</h3>
                            <p>{{ $service['description'] }}</p>

                            <ul class="feature-list">
                                @foreach($service['features'] as $feature)
                                    <li>
                                        <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="borrowing-section" id="borrowing-policies">
    <div class="container">
        <div class="section-heading">
            <span class="eyebrow">Circulation Services</span>
            <h2>Borrowing privileges</h2>
            <p>
                Loan limits and borrowing periods depend on the library
                user’s classification.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <article class="borrowing-card">
                    <div class="borrowing-title">
                        <span>For enrolled</span>
                        <h3>Students</h3>
                    </div>

                    <div class="borrowing-stats">
                        <div>
                            <strong>3</strong>
                            <span>Books</span>
                        </div>
                        <div>
                            <strong>2 days</strong>
                            <span>Loan period</span>
                        </div>
                        <div>
                            <strong>2</strong>
                            <span>Renewals</span>
                        </div>
                    </div>

                    <ul class="policy-list">
                        @foreach($studentBorrowingPolicies as $policy)
                            <li>
                                <i class="bi bi-check2" aria-hidden="true"></i>
                                <span>{{ $policy }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>
            </div>

            <div class="col-lg-6">
                <article class="borrowing-card borrowing-card-gold">
                    <div class="borrowing-title">
                        <span>For teaching</span>
                        <h3>Faculty Members</h3>
                    </div>

                    <div class="borrowing-stats">
                        <div>
                            <strong>10</strong>
                            <span>Books</span>
                        </div>
                        <div>
                            <strong>1 month</strong>
                            <span>Loan period</span>
                        </div>
                        <div>
                            <strong>2</strong>
                            <span>Renewals</span>
                        </div>
                    </div>

                    <ul class="policy-list">
                        @foreach($facultyBorrowingPolicies as $policy)
                            <li>
                                <i class="bi bi-check2" aria-hidden="true"></i>
                                <span>{{ $policy }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>
            </div>
        </div>

        <div class="borrowing-note">
            <strong>Return materials on time.</strong>
            <p>
                Borrowers must return or renew items on or before the due date.
                Applicable fines may be charged for overdue materials.
            </p>
        </div>
    </div>
</section>

<section class="rules-section" id="library-rules">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-4">
                <div class="rules-intro">
                    <span class="eyebrow">Library Conduct</span>
                    <h2>Rules and regulations</h2>
                    <p>
                        These guidelines help maintain a safe, quiet,
                        organized, and productive environment for everyone.
                    </p>

                    <div class="rules-note">
                        All visitors are expected to follow these rules while
                        using library spaces and resources.
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="rules-list">
                    @foreach($rules as $rule)
                        <div class="rule-item">
                            <span class="rule-number">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <p>{{ $rule }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="electronic-service" id="electronic-service">
    <div class="container">
        <article class="electronic-card">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-6">
                    <div class="electronic-photo">
                        <img
                            src="{{ asset('images/laptops.jpg') }}"
                            alt="Library laptop service"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="electronic-content">
                        <span class="panel-kicker">Electronic Service</span>
                        <h2>Laptop access for academic work</h2>
                        <p>
                            Library patrons may borrow a Library Services
                            Office laptop for one hour to research, access
                            learning resources, and complete school activities.
                        </p>

                        <ul>
                            <li>One-hour usage</li>
                            <li>For research and school-related work</li>
                            <li>Subject to approval and availability</li>
                        </ul>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>

<section class="services-help">
    <div class="container">
        <div class="help-card">
            <div>
                <span>Need assistance?</span>
                <h2>Ask our library personnel for help.</h2>
                <p>
                    Get assistance with borrowing, research, OPAC searches,
                    and electronic library services.
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
    --service-navy: #0b2e59;
    --service-blue: #184b8c;
    --service-gold: #f4b400;
    --service-ink: #17243a;
    --service-muted: #647187;
    --service-bg: #f4f7fb;
    --service-line: #dfe6ef;
    --service-white: #ffffff;
    --service-green: #278b5a;
}

html {
    scroll-behavior: smooth;
}

#service-hours,
#available-services,
#borrowing-policies,
#library-rules,
#electronic-service {
    scroll-margin-top: 95px;
}

.services-hero {
    position: relative;
    min-height: 440px;
    display: grid;
    place-items: center;
    overflow: hidden;
    isolation: isolate;
    color: var(--service-white);
    background-color: var(--service-navy);
    background:
        linear-gradient(
            105deg,
            rgba(7, 30, 61, .86) 0%,
            rgba(11, 46, 89, .68) 55%,
            rgba(24, 75, 140, .52) 100%
        ),
        url("{{ asset('images/services-placeholder.jpg') }}") center center / cover no-repeat;
}

.services-hero::after {
    content: "";
    position: absolute;
    right: -130px;
    bottom: -210px;
    width: 430px;
    height: 430px;
    border: 58px solid rgba(244, 180, 0, .1);
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
}

.services-hero-content {
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
    color: var(--service-blue);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.eyebrow::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--service-gold);
    border-radius: 10px;
}

.eyebrow-light {
    color: var(--service-gold);
}

.services-hero h1 {
    max-width: 720px;
    margin: 18px auto;
    font-size: clamp(42px, 6vw, 66px);
    font-weight: 800;
    line-height: 1.06;
    letter-spacing: -.045em;
}

.services-hero p {
    max-width: 650px;
    margin: 0 auto 27px;
    color: rgba(255, 255, 255, .78);
    font-size: 17px;
    line-height: 1.75;
}

.services-hero .breadcrumb {
    font-size: 13px;
}

.services-hero .breadcrumb-item,
.services-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, .6);
}

.services-hero .breadcrumb-item a {
    color: var(--service-white);
    font-weight: 600;
    text-decoration: none;
}

.services-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, .36);
}

.services-intro {
    padding: 88px 0 48px;
    background: var(--service-bg);
}

.section-heading {
    max-width: 760px;
    margin-bottom: 42px;
}

.services-intro .section-heading {
    margin-bottom: 0;
}

.section-heading h2,
.rules-intro h2 {
    margin: 15px 0;
    color: var(--service-navy);
    font-size: clamp(31px, 4vw, 45px);
    font-weight: 800;
    line-height: 1.14;
    letter-spacing: -.035em;
}

.section-heading p,
.rules-intro > p {
    margin: 0;
    color: var(--service-muted);
    font-size: 16px;
    line-height: 1.8;
}

.service-hours {
    padding: 20px 0 95px;
    background: var(--service-bg);
}

.hours-panel {
    display: grid;
    grid-template-columns: minmax(270px, .8fr) minmax(420px, 1.2fr);
    overflow: hidden;
    background: var(--service-white);
    border: 1px solid var(--service-line);
    border-radius: 22px;
    box-shadow: 0 15px 40px rgba(11, 46, 89, .08);
}

.hours-intro {
    padding: 42px;
    color: var(--service-white);
    background: var(--service-navy);
}

.panel-kicker {
    color: var(--service-gold);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.hours-intro h2 {
    margin: 10px 0 13px;
    font-size: 31px;
    font-weight: 800;
    line-height: 1.2;
}

.hours-intro p {
    margin: 0;
    color: rgba(255, 255, 255, .7);
    font-size: 14px;
    line-height: 1.75;
}

.hours-list {
    padding: 15px 35px;
}

.hours-row {
    min-height: 82px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 22px;
    border-bottom: 1px solid var(--service-line);
}

.hours-row:last-child {
    border-bottom: 0;
}

.hours-row strong {
    color: var(--service-ink);
    font-size: 14px;
}

.hours-time {
    color: var(--service-navy);
    font-size: 14px;
    font-weight: 800;
}

.hours-time span {
    padding: 0 5px;
    color: var(--service-gold);
}

.status-closed {
    padding: 7px 12px;
    color: #a63838;
    background: #fcecec;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 800;
}

.available-services {
    padding: 95px 0;
    background: var(--service-white);
}

.service-card {
    height: 100%;
    overflow: hidden;
    background: var(--service-white);
    border: 1px solid var(--service-line);
    border-radius: 22px;
    box-shadow: 0 12px 32px rgba(11, 46, 89, .065);
    transition: transform .3s ease, box-shadow .3s ease;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 18px 38px rgba(11, 46, 89, .11);
}

.service-card-photo {
    height: 220px;
    overflow: hidden;
    background: #dfe6ef;
}

.service-card-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}

.service-card:hover .service-card-photo img {
    transform: scale(1.035);
}

.service-card-body {
    padding: 27px 28px 29px;
}

.card-kicker {
    color: var(--service-blue);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.service-card h3 {
    margin: 8px 0 12px;
    color: var(--service-navy);
    font-size: 22px;
    font-weight: 800;
    line-height: 1.3;
}

.service-card-body > p {
    min-height: 80px;
    margin: 0 0 18px;
    color: var(--service-muted);
    font-size: 14px;
    line-height: 1.75;
}

.feature-list,
.policy-list,
.electronic-content ul {
    margin: 0;
    padding: 18px 0 0;
    border-top: 1px solid var(--service-line);
    list-style: none;
}

.feature-list li {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin-bottom: 11px;
    color: var(--service-muted);
    font-size: 13px;
    line-height: 1.55;
}

.feature-list li:last-child {
    margin-bottom: 0;
}

.feature-list i {
    margin-top: 2px;
    color: var(--service-green);
    font-size: 13px;
}

.borrowing-section {
    padding: 100px 0;
    background: var(--service-bg);
}

.borrowing-card {
    position: relative;
    height: 100%;
    padding: 33px;
    overflow: hidden;
    background: var(--service-white);
    border: 1px solid var(--service-line);
    border-radius: 22px;
    box-shadow: 0 12px 32px rgba(11, 46, 89, .065);
}

.borrowing-card::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    height: 4px;
    background: var(--service-blue);
}

.borrowing-card-gold::before {
    background: var(--service-gold);
}

.borrowing-title span {
    color: var(--service-blue);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.borrowing-title h3 {
    margin: 5px 0 22px;
    color: var(--service-navy);
    font-size: 27px;
    font-weight: 800;
}

.borrowing-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    margin-bottom: 22px;
    padding: 18px 8px;
    background: var(--service-bg);
    border: 1px solid var(--service-line);
    border-radius: 13px;
}

.borrowing-stats > div {
    padding: 0 8px;
    text-align: center;
    border-right: 1px solid var(--service-line);
}

.borrowing-stats > div:last-child {
    border-right: 0;
}

.borrowing-stats strong,
.borrowing-stats span {
    display: block;
}

.borrowing-stats strong {
    color: var(--service-navy);
    font-size: 18px;
    font-weight: 800;
}

.borrowing-stats span {
    margin-top: 4px;
    color: var(--service-muted);
    font-size: 10px;
}

.policy-list {
    padding-top: 8px;
    border-top: 0;
}

.policy-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 11px 0;
    color: var(--service-muted);
    border-bottom: 1px solid #edf1f5;
    font-size: 14px;
    line-height: 1.6;
}

.policy-list li:last-child {
    border-bottom: 0;
}

.policy-list i {
    margin-top: 3px;
    color: var(--service-blue);
}

.borrowing-note {
    margin-top: 27px;
    padding: 19px 22px;
    background: #fff9e7;
    border: 1px solid #f0db91;
    border-left: 4px solid var(--service-gold);
    border-radius: 11px;
}

.borrowing-note strong {
    display: block;
    margin-bottom: 3px;
    color: #6f5200;
    font-size: 14px;
}

.borrowing-note p {
    margin: 0;
    color: #7d6727;
    font-size: 13px;
    line-height: 1.65;
}

.rules-section {
    padding: 100px 0;
    background: var(--service-white);
}

.rules-intro {
    position: sticky;
    top: 110px;
}

.rules-intro h2 {
    font-size: clamp(31px, 4vw, 42px);
}

.rules-note {
    margin-top: 25px;
    padding: 16px 17px;
    color: var(--service-navy);
    background: #fff8dd;
    border-left: 4px solid var(--service-gold);
    border-radius: 9px;
    font-size: 13px;
    line-height: 1.65;
}

.rules-list {
    border-top: 1px solid var(--service-line);
}

.rule-item {
    display: grid;
    grid-template-columns: 45px 1fr;
    gap: 16px;
    padding: 20px 0;
    border-bottom: 1px solid var(--service-line);
}

.rule-number {
    color: var(--service-gold);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .06em;
}

.rule-item p {
    margin: 0;
    color: var(--service-muted);
    font-size: 14px;
    line-height: 1.7;
}

.electronic-service {
    padding: 100px 0;
    background: var(--service-bg);
}

.electronic-card {
    overflow: hidden;
    color: var(--service-white);
    background: var(--service-navy);
    border-radius: 21px;
    box-shadow: 0 18px 45px rgba(11, 46, 89, .16);
}

.electronic-photo {
    min-height: 440px;
    height: 100%;
    background: #dfe6ef;
}

.electronic-photo img {
    width: 100%;
    height: 100%;
    min-height: 440px;
    object-fit: cover;
}

.electronic-content {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 48px;
}

.electronic-content h2 {
    margin: 11px 0 15px;
    font-size: clamp(30px, 4vw, 41px);
    font-weight: 800;
    line-height: 1.16;
    letter-spacing: -.03em;
}

.electronic-content > p {
    margin: 0;
    color: rgba(255, 255, 255, .72);
    line-height: 1.8;
}

.electronic-content ul {
    margin-top: 22px;
    border-color: rgba(255, 255, 255, .14);
}

.electronic-content li {
    position: relative;
    margin-bottom: 11px;
    padding-left: 19px;
    color: rgba(255, 255, 255, .78);
    font-size: 13px;
}

.electronic-content li::before {
    content: "";
    position: absolute;
    top: 7px;
    left: 0;
    width: 7px;
    height: 7px;
    background: var(--service-gold);
    border-radius: 50%;
}

.services-help {
    padding: 0 0 100px;
    background: var(--service-white);
}

.help-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 35px;
    padding: 43px 46px;
    color: var(--service-white);
    background: linear-gradient(115deg, var(--service-navy), var(--service-blue));
    border-radius: 21px;
}

.help-card > div {
    max-width: 700px;
}

.help-card span {
    color: var(--service-gold);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .11em;
    text-transform: uppercase;
}

.help-card h2 {
    margin: 8px 0;
    font-size: clamp(25px, 3vw, 33px);
    font-weight: 800;
}

.help-card p {
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
    color: var(--service-navy);
    background: var(--service-gold);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    transition: transform .2s ease, box-shadow .2s ease;
}

.help-button:hover {
    color: var(--service-navy);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, .17);
}

@media (max-width: 991.98px) {
    .hours-panel {
        grid-template-columns: 1fr;
    }

    .service-card-body > p {
        min-height: auto;
    }

    .rules-intro {
        position: static;
        max-width: 650px;
    }

    .electronic-photo,
    .electronic-photo img {
        min-height: 360px;
    }

    .help-card {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (max-width: 767.98px) {
    .services-hero {
        min-height: 400px;
    }

    .services-hero-content {
        padding: 82px 0 72px;
    }

    .services-intro {
        padding: 70px 0 38px;
    }

    .service-hours {
        padding-bottom: 75px;
    }

    .hours-intro {
        padding: 34px 28px;
    }

    .hours-list {
        padding: 10px 27px;
    }

    .available-services,
    .borrowing-section,
    .rules-section,
    .electronic-service {
        padding: 75px 0;
    }

    .borrowing-card {
        padding: 28px 23px;
    }

    .electronic-content {
        padding: 36px 28px;
    }

    .services-help {
        padding-bottom: 75px;
    }

    .help-card {
        padding: 34px 28px;
    }
}

@media (max-width: 575.98px) {
    .services-hero h1 {
        font-size: 39px;
    }

    .services-hero p {
        font-size: 15px;
    }

    .hours-row {
        min-height: 78px;
        align-items: flex-start;
        justify-content: center;
        flex-direction: column;
        gap: 6px;
    }

    .borrowing-stats {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .borrowing-stats > div {
        padding: 0 0 14px;
        border-right: 0;
        border-bottom: 1px solid var(--service-line);
    }

    .borrowing-stats > div:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .electronic-photo,
    .electronic-photo img {
        min-height: 280px;
    }

    .help-button {
        width: 100%;
    }
}
</style>

@endsection
