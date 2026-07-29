@extends('layouts.app')

@section('title', 'MMACI Library Services Office')

@section('content')

<section class="home-hero">
    <div class="container">
        <div class="home-hero-content" data-aos="fade-up">
            <span class="eyebrow-light">Welcome to MMACI</span>

            <h1>Library Services Office</h1>

            <p>
                Supporting learning, teaching, research, and creative
                expression through accessible information resources and
                dependable library services.
            </p>

            <a href="{{ url('/collection/printed') }}" class="primary-action">
                Explore Collection
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

<section class="home-section home-section-soft">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">Stay Updated</span>
            <h2>News and events</h2>
            <p>
                View upcoming library activities and important dates in one
                organized place.
            </p>
        </header>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-6">
                <article class="content-panel h-100">
                    <div class="panel-header">
                        <div>
                            <span>Latest Schedule</span>
                            <h3>Upcoming Activities</h3>
                        </div>
                    </div>

                    <div class="event-list">
                        @forelse($events ?? [] as $event)
                            <div class="event-item">
                                <time class="event-date" datetime="{{ $event->event_date }}">
                                    <span>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                                    </span>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                                    </strong>
                                </time>

                                <div class="event-copy">
                                    <h4>{{ $event->title }}</h4>
                                    <span>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }}
                                    </span>
                                    <p>{{ $event->description }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <img
                                    src="{{ asset('images/Noevent.png') }}"
                                    alt="No events available">
                                <h4>No events available</h4>
                                <p>Please check again later for upcoming activities.</p>
                            </div>
                        @endforelse
                    </div>
                </article>
            </div>

            <div class="col-lg-6">
                <article class="content-panel calendar-panel h-100">
                    <div class="panel-header">
                        <div>
                            <span>Monthly View</span>
                            <h3>Library Calendar</h3>
                        </div>
                    </div>

                    <div id="calendar"></div>

                    <p class="calendar-note">
                        Select an event to view its complete details.
                    </p>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">Recently Added</span>
            <h2>New arrivals</h2>
            <p>
                Discover the newest printed books and learning resources
                available in the library.
            </p>
        </header>

        <div class="row g-4">
            @forelse($arrivals ?? [] as $book)
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up">
                    <article class="arrival-card">
                        <div class="arrival-cover">
                            <img
                                src="{{ $book->image_url }}"
                                alt="{{ $book->title }}"
                                loading="lazy">
                        </div>

                        <div class="arrival-body">
                            <h3>{{ $book->title }}</h3>
                            <span>{{ $book->author ?? 'Unknown Author' }}</span>
                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                    $book->description ?? 'No description available.',
                                    80
                                ) }}
                            </p>

                            <a href="{{ url('/collection/printed') }}">
                                View Collection
                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state empty-state-wide">
                        <h4>No new arrivals available</h4>
                        <p>Newly added library resources will appear here.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<section class="home-section home-section-soft">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                @php
                    $aboutSlides = [
                        'Personell.jpg',
                        'Studentslib.jpg',
                        'Studentslib2.jpg',
                        'Studentslib3.jpg',
                        'Studentslib4.jpg',
                        'Studentslib5.jpg',
                        'Studentslib6.jpg',
                        'Studentslib7.jpg',
                    ];
                @endphp

                <div
                    id="aboutLibraryCarousel"
                    class="carousel slide carousel-fade about-carousel"
                    data-bs-ride="carousel"
                    data-bs-interval="4500"
                    data-bs-pause="hover"
                    data-bs-touch="true">

                    <div class="carousel-indicators">
                        @foreach($aboutSlides as $slide)
                            <button
                                type="button"
                                data-bs-target="#aboutLibraryCarousel"
                                data-bs-slide-to="{{ $loop->index }}"
                                class="{{ $loop->first ? 'active' : '' }}"
                                aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                aria-label="Show library photo {{ $loop->iteration }}">
                            </button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        @foreach($aboutSlides as $slide)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img
                                    src="{{ asset('images/' . $slide) }}"
                                    alt="MMACI Library photo {{ $loop->iteration }}"
                                    loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/Studentslib.jpg') }}';">
                            </div>
                        @endforeach
                    </div>

                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#aboutLibraryCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-arrow">
                            <i class="bi bi-chevron-left" aria-hidden="true"></i>
                        </span>
                        <span class="visually-hidden">Previous photo</span>
                    </button>

                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#aboutLibraryCarousel"
                        data-bs-slide="next">
                        <span class="carousel-arrow">
                            <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        </span>
                        <span class="visually-hidden">Next photo</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-copy">
                    <span class="eyebrow">About the Library</span>
                    <h2>A welcoming place to learn and grow</h2>
                    <p>
                        The MMACI Library Services Office supports learning,
                        teaching, research, and creative expression by
                        providing timely and effective access to information.
                    </p>
                    <p>
                        We promote information literacy and provide quality
                        academic resources for students, faculty, and staff.
                    </p>

                    <a href="{{ url('/about') }}" class="text-action">
                        Learn More
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="library-summary">
    <div class="container">
        <div class="summary-panel">
            <div class="summary-copy">
                <span class="eyebrow eyebrow-light">Library at a Glance</span>
                <h2>Resources for the MMACI community</h2>
            </div>

            <div class="summary-grid">
                <div>
                    <strong>3,000+</strong>
                    <span>Printed Books</span>
                </div>
                <div>
                    <strong>100+</strong>
                    <span>E-Books</span>
                </div>
                <div>
                    <strong>2,000+</strong>
                    <span>Students Served</span>
                </div>
                <div>
                    <strong>100+</strong>
                    <span>Research Collections</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">What We Offer</span>
            <h2>Library services</h2>
            <p>
                Services designed to support learning, research, and
                academic success.
            </p>
        </header>

        <div class="row g-4">
            <div class="col-lg-4">
                <article class="service-card">
                    <span>01</span>
                    <h3>Book Borrowing</h3>
                    <p>
                        Borrow printed books and learning materials for
                        academic and research use.
                    </p>
                    <a href="{{ url('/services') }}">
                        Learn More
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </article>
            </div>

            <div class="col-lg-4">
                <article class="service-card">
                    <span>02</span>
                    <h3>Digital Library</h3>
                    <p>
                        Access e-books, online journals, open educational
                        resources, and digital databases.
                    </p>
                    <a href="{{ url('/collection/ebooks') }}">
                        Explore Resources
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </article>
            </div>

            <div class="col-lg-4">
                <article class="service-card">
                    <span>03</span>
                    <h3>Research Assistance</h3>
                    <p>
                        Get professional help finding and evaluating relevant
                        research materials.
                    </p>
                    <a href="{{ url('/ask-librarian') }}">
                        Ask a Librarian
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="home-section home-section-soft">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">Inside the Library</span>
            <h2>Library gallery</h2>
            <p>Take a closer look at our spaces and learning resources.</p>
        </header>

        <div class="gallery-grid">
            <figure class="gallery-card gallery-card-large" data-aos="fade-up">
                <img
                    src="{{ asset('images/Readingarea.jpg') }}"
                    alt="MMACI Library reading area"
                    loading="lazy">
                <figcaption>Reading Area</figcaption>
            </figure>

            <figure class="gallery-card" data-aos="fade-up">
                <img
                    src="{{ asset('images/librarycollect.jpg') }}"
                    alt="MMACI Library collection"
                    loading="lazy">
                <figcaption>Library Collection</figcaption>
            </figure>

            <figure class="gallery-card" data-aos="fade-up">
                <img
                    src="{{ asset('images/learningfacilities.jpg') }}"
                    alt="MMACI learning facilities"
                    loading="lazy">
                <figcaption>Learning Facilities</figcaption>
            </figure>
        </div>
    </div>
</section>

<section class="home-section video-section">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">Watch and Discover</span>
            <h2>Featured video</h2>
            <p>
                See how our library spaces, services, and community support
                learning and academic success.
            </p>
        </header>

        <div class="video-frame" data-aos="fade-up">
            <div class="ratio ratio-16x9">
                <iframe
                    src="https://www.youtube.com/embed/0ySUHcWgcFM"
                    title="MMACI Library Featured Video"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-panel">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-5">
                    <div class="contact-copy">
                        <span class="eyebrow eyebrow-light">Contact Us</span>
                        <h2>Connect with the library</h2>
                        <p>
                            Visit, call, email, or reach us through our
                            official Facebook page.
                        </p>

                        <div class="contact-list">
                            <div>
                                <small>Facebook</small>
                                <strong>MMACI Library Services Office</strong>
                            </div>
                            <div>
                                <small>Phone</small>
                                <strong>+63 948 553 2601</strong>
                            </div>
                            <div>
                                <small>Email</small>
                                <a href="mailto:librarymmaci@gmail.com">
                                    librarymmaci@gmail.com
                                </a>
                            </div>
                            <div>
                                <small>Address</small>
                                <strong>
                                    North Montilla Boulevard, Brgy. Ong-Yiu,
                                    Butuan City 8600
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="library-map-wrapper">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox=125.5345096%2C8.9496933%2C125.5465096%2C8.9616933&layer=mapnik&marker=8.9556933%2C125.5405096"
                            class="library-map"
                            loading="lazy"
                            allowfullscreen
                            title="MMACI Library Services Office location">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-cta">
    <div class="container">
        <div class="cta-panel">
            <div>
                <span>Start exploring</span>
                <h2>Expand your knowledge today.</h2>
                <p>
                    Browse printed and digital learning resources available
                    through the MMACI Library Services Office.
                </p>
            </div>

            <a href="{{ url('/collection/printed') }}" class="primary-action">
                Browse Collection
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

<div
    class="modal fade"
    id="eventDetailsModal"
    tabindex="-1"
    aria-labelledby="eventDetailsModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content event-modal">
            <div class="modal-header">
                <div>
                    <span>Library Event</span>
                    <h5 class="modal-title" id="eventDetailsModalLabel">
                        Event Details
                    </h5>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <h4 id="eventModalTitle"></h4>

                <dl class="event-information">
                    <div>
                        <dt>Date</dt>
                        <dd id="eventModalDate">Not specified</dd>
                    </div>
                    <div>
                        <dt>Location</dt>
                        <dd id="eventModalLocation">Not specified</dd>
                    </div>
                </dl>

                <div class="event-description">
                    <span>Description</span>
                    <p id="eventModalDescription">No description provided.</p>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn modal-close-button"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarElement = document.getElementById('calendar');

    if (!calendarElement || typeof FullCalendar === 'undefined') {
        return;
    }

    const calendarEvents = [
        @foreach (($events ?? []) as $event)
            {
                id: @json($event->id ?? ''),
                title: @json($event->title ?? 'Untitled Event'),
                start: @json($event->event_date ?? null),
                allDay: true,
                extendedProps: {
                    description: @json($event->description ?? ''),
                    location: @json($event->location ?? '')
                }
            }{{ !$loop->last ? ',' : '' }}
        @endforeach
    ];

    const calendar = new FullCalendar.Calendar(calendarElement, {
        initialView: 'dayGridMonth',
        height: 'auto',
        fixedWeekCount: false,
        showNonCurrentDates: true,
        dayMaxEvents: 2,
        displayEventTime: false,
        navLinks: false,

        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },

        buttonText: {
            today: 'Today'
        },

        events: calendarEvents,

        eventDidMount: function (info) {
            info.el.setAttribute('title', info.event.title);
        },

        eventClick: function (info) {
            info.jsEvent.preventDefault();

            const event = info.event;
            const properties = event.extendedProps;
            const formattedDate = event.start
                ? event.start.toLocaleDateString('en-PH', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                })
                : 'Date not specified';

            document.getElementById('eventModalTitle').textContent =
                event.title || 'Untitled Event';
            document.getElementById('eventModalDate').textContent =
                formattedDate;
            document.getElementById('eventModalLocation').textContent =
                properties.location || 'Location not specified';
            document.getElementById('eventModalDescription').textContent =
                properties.description || 'No description provided.';

            const modalElement = document.getElementById('eventDetailsModal');

            if (typeof bootstrap !== 'undefined' && modalElement) {
                bootstrap.Modal.getOrCreateInstance(modalElement).show();
            }
        }
    });

    calendar.render();
});
</script>

<style>
:root {
    --home-navy: #0b2e59;
    --home-blue: #184b8c;
    --home-gold: #f4b400;
    --home-ink: #17243a;
    --home-muted: #647187;
    --home-bg: #f4f7fb;
    --home-line: #dfe6ef;
    --home-white: #ffffff;
    --home-green: #278b5a;
}

.home-hero {
    position: relative;
    min-height: 620px;
    display: grid;
    place-items: center;
    overflow: hidden;
    color: var(--home-white);
    background:
        linear-gradient(105deg, rgba(7, 32, 65, .95), rgba(11, 46, 89, .78)),
        url("{{ asset('images/readingarea.jpg') }}") center / cover no-repeat;
}

.home-hero::after {
    content: "";
    position: absolute;
    right: -130px;
    bottom: -220px;
    width: 460px;
    height: 460px;
    border: 62px solid rgba(244, 180, 0, .1);
    border-radius: 50%;
}

.home-hero-content {
    position: relative;
    z-index: 1;
    max-width: 830px;
    margin: auto;
    padding: 120px 0 100px;
    text-align: center;
}

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--home-blue);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.eyebrow::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--home-gold);
    border-radius: 10px;
}

.eyebrow-light {
    color: var(--home-gold);
}

.home-hero h1 {
    margin: 19px 0;
    font-size: clamp(48px, 7vw, 78px);
    font-weight: 800;
    line-height: 1.03;
    letter-spacing: -.05em;
}

.home-hero p {
    max-width: 690px;
    margin: 0 auto 31px;
    color: rgba(255, 255, 255, .78);
    font-size: 17px;
    line-height: 1.8;
}

.primary-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 14px 21px;
    color: var(--home-navy);
    background: var(--home-gold);
    border-radius: 10px;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    transition: transform .2s ease, box-shadow .2s ease;
}

.primary-action:hover {
    color: var(--home-navy);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, .17);
}

.home-section {
    padding: 48px 0;
    background: var(--home-white);
}

.home-section-soft {
    background: var(--home-bg);
}

.section-heading {
    max-width: 730px;
    margin-bottom: 18px;
}

.section-heading h2,
.about-copy h2,
.contact-copy h2 {
    margin: 14px 0;
    color: var(--home-navy);
    font-size: clamp(32px, 4vw, 46px);
    font-weight: 800;
    line-height: 1.14;
    letter-spacing: -.035em;
}

.section-heading p,
.about-copy p {
    margin: 0;
    color: var(--home-muted);
    font-size: 16px;
    line-height: 1.8;
}

.content-panel {
    padding: 30px;
    background: var(--home-white);
    border: 1px solid var(--home-line);
    border-radius: 22px;
    box-shadow: 0 12px 32px rgba(11, 46, 89, .065);
}

.panel-header {
    margin-bottom: 8px;
    padding-bottom: 18px;
    border-bottom: 1px solid var(--home-line);
}

.panel-header span,
.card-kicker {
    color: var(--home-blue);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.panel-header h3 {
    margin: 4px 0 0;
    color: var(--home-navy);
    font-size: 22px;
    font-weight: 800;
}

.event-item {
    display: grid;
    grid-template-columns: 62px 1fr;
    gap: 17px;
    padding: 21px 0;
    border-bottom: 1px solid var(--home-line);
}

.event-item:last-child {
    border-bottom: 0;
}

.event-date {
    width: 62px;
    height: 66px;
    display: grid;
    place-items: center;
    align-content: center;
    color: var(--home-navy);
    background: #fff7d9;
    border: 1px solid #f2dc88;
    border-radius: 12px;
    text-decoration: none;
}

.event-date span {
    color: var(--home-blue);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.event-date strong {
    font-size: 23px;
    line-height: 1.1;
}

.event-copy h4 {
    margin: 0 0 4px;
    color: var(--home-ink);
    font-size: 16px;
    font-weight: 800;
}

.event-copy > span {
    color: #8a95a5;
    font-size: 11px;
}

.event-copy p {
    margin: 7px 0 0;
    color: var(--home-muted);
    font-size: 13px;
    line-height: 1.6;
}

.empty-state {
    padding: 50px 20px;
    text-align: center;
}

.empty-state img {
    width: 145px;
    max-width: 100%;
    margin-bottom: 18px;
}

.empty-state h4 {
    color: var(--home-navy);
    font-size: 19px;
    font-weight: 800;
}

.empty-state p {
    margin: 7px 0 0;
    color: var(--home-muted);
}

.empty-state-wide {
    background: var(--home-bg);
    border: 1px solid var(--home-line);
    border-radius: 18px;
}

.calendar-panel {
    overflow: hidden;
}

.calendar-note {
    margin: 18px 0 0;
    color: var(--home-muted);
    font-size: 12px;
    text-align: center;
}

.arrival-card {
    height: 100%;
    overflow: hidden;
    background: var(--home-white);
    border: 1px solid var(--home-line);
    border-radius: 19px;
    box-shadow: 0 10px 28px rgba(11, 46, 89, .06);
    transition: transform .3s ease, box-shadow .3s ease;
}

.arrival-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 17px 37px rgba(11, 46, 89, .11);
}

.arrival-cover {
    height: 310px;
    overflow: hidden;
    background: #e5eaf1;
}

.arrival-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.arrival-body {
    padding: 23px;
}

.arrival-body h3 {
    margin: 0 0 4px;
    color: var(--home-navy);
    font-size: 18px;
    font-weight: 800;
    line-height: 1.35;
}

.arrival-body > span {
    color: #8a95a5;
    font-size: 11px;
}

.arrival-body p {
    min-height: 66px;
    margin: 14px 0 18px;
    color: var(--home-muted);
    font-size: 13px;
    line-height: 1.7;
}

.arrival-body a,
.service-card a,
.text-action {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--home-blue);
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
}

.about-carousel {
    overflow: hidden;
    border-radius: 22px;
    box-shadow: 0 15px 40px rgba(11, 46, 89, .12);
}

.about-carousel .carousel-item,
.about-carousel .carousel-item img {
    height: 470px;
}

.about-carousel .carousel-item img {
    width: 100%;
    display: block;
    object-fit: cover;
}

.about-carousel .carousel-indicators {
    right: auto;
    bottom: 16px;
    left: 20px;
    margin: 0;
}

.about-carousel .carousel-indicators button {
    width: 18px;
    height: 3px;
    margin: 0 3px;
    border: 0;
    border-radius: 5px;
    background: rgba(255, 255, 255, .55);
}

.about-carousel .carousel-indicators button.active {
    width: 31px;
    background: var(--home-gold);
}

.about-carousel .carousel-control-prev,
.about-carousel .carousel-control-next {
    width: 62px;
    opacity: 1;
}

.carousel-arrow {
    width: 38px;
    height: 38px;
    display: grid;
    place-items: center;
    color: var(--home-white);
    background: rgba(11, 46, 89, .75);
    border: 1px solid rgba(255, 255, 255, .22);
    border-radius: 10px;
}

.about-copy {
    max-width: 540px;
}

.about-copy p + p {
    margin-top: 13px;
}

.text-action {
    margin-top: 24px;
}

.library-summary {
    padding: 0 0 48px;
    background: var(--home-bg);
}

.summary-panel {
    display: grid;
    grid-template-columns: minmax(250px, 1.1fr) 2fr;
    gap: 40px;
    padding: 42px;
    color: var(--home-white);
    background: var(--home-navy);
    border-radius: 22px;
    box-shadow: 0 18px 45px rgba(11, 46, 89, .16);
}

.summary-copy h2 {
    margin: 13px 0 0;
    font-size: 28px;
    font-weight: 800;
    line-height: 1.25;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.summary-grid > div {
    padding: 8px 20px;
    border-left: 1px solid rgba(255, 255, 255, .14);
}

.summary-grid strong,
.summary-grid span {
    display: block;
}

.summary-grid strong {
    margin-bottom: 7px;
    color: var(--home-gold);
    font-size: 29px;
    font-weight: 800;
}

.summary-grid span {
    color: rgba(255, 255, 255, .7);
    font-size: 12px;
}

.service-card {
    position: relative;
    height: 100%;
    padding: 31px;
    background: var(--home-white);
    border: 1px solid var(--home-line);
    border-radius: 19px;
    box-shadow: 0 10px 28px rgba(11, 46, 89, .06);
}

.service-card > span {
    color: var(--home-gold);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .08em;
}

.service-card h3 {
    margin: 17px 0 11px;
    color: var(--home-navy);
    font-size: 22px;
    font-weight: 800;
}

.service-card p {
    margin: 0 0 22px;
    color: var(--home-muted);
    font-size: 14px;
    line-height: 1.75;
}

.gallery-grid {
    display: grid;
    grid-template-columns: 1.35fr 1fr;
    grid-template-rows: repeat(2, 230px);
    gap: 18px;
}

.gallery-card {
    position: relative;
    height: 100%;
    margin: 0;
    overflow: hidden;
    background: #dfe6ef;
    border-radius: 18px;
}

.gallery-card-large {
    grid-row: 1 / 3;
}

.gallery-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}

.gallery-card:hover img {
    transform: scale(1.035);
}

.gallery-card::after {
    content: "";
    position: absolute;
    inset: 45% 0 0;
    background: linear-gradient(transparent, rgba(7, 30, 61, .8));
}

.gallery-card figcaption {
    position: absolute;
    z-index: 1;
    right: 20px;
    bottom: 18px;
    left: 20px;
    color: var(--home-white);
    font-size: 16px;
    font-weight: 800;
}

.video-frame {
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
    overflow: hidden;
    background: #071f3e;
    border-radius: 20px;
    box-shadow: 0 17px 45px rgba(11, 46, 89, .15);
}

.video-frame iframe {
    border: 0;
}

.contact-section {
    padding: 48px 0;
    background: var(--home-bg);
}

.contact-panel {
    overflow: hidden;
    color: var(--home-white);
    background: var(--home-navy);
    border-radius: 22px;
    box-shadow: 0 18px 45px rgba(11, 46, 89, .16);
}

.contact-copy {
    height: 100%;
    padding: 44px;
}

.contact-copy h2 {
    color: var(--home-white);
}

.contact-copy > p {
    color: rgba(255, 255, 255, .7);
    line-height: 1.75;
}

.contact-list {
    margin-top: 27px;
    border-top: 1px solid rgba(255, 255, 255, .14);
}

.contact-list > div {
    padding: 14px 0;
    border-bottom: 1px solid rgba(255, 255, 255, .14);
}

.contact-list small,
.contact-list strong,
.contact-list a {
    display: block;
}

.contact-list small {
    margin-bottom: 3px;
    color: var(--home-gold);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.contact-list strong,
.contact-list a {
    color: rgba(255, 255, 255, .82);
    font-size: 13px;
    font-weight: 600;
    line-height: 1.55;
    text-decoration: none;
}

.library-map {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    display: block;
    border: 0;
}

.library-map-wrapper {
    position: relative;
    width: 100%;
    min-height: 610px;
    overflow: hidden;
    background: #dfe6ef;
}

.home-cta {
    padding: 0 0 48px;
    background: var(--home-bg);
}

.video-section {
    padding-top: 42px;
    padding-bottom: 48px;
}

.video-section .section-heading {
    margin-bottom: 16px;
}

.cta-panel {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 35px;
    padding: 43px 46px;
    color: var(--home-white);
    background: linear-gradient(115deg, var(--home-navy), var(--home-blue));
    border-radius: 22px;
}

.cta-panel > div {
    max-width: 700px;
}

.cta-panel > div > span {
    color: var(--home-gold);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .11em;
    text-transform: uppercase;
}

.cta-panel h2 {
    margin: 8px 0;
    font-size: clamp(26px, 3vw, 34px);
    font-weight: 800;
}

.cta-panel p {
    margin: 0;
    color: rgba(255, 255, 255, .7);
    line-height: 1.7;
}

.event-modal {
    overflow: hidden;
    border: 0;
    border-radius: 18px;
    box-shadow: 0 24px 70px rgba(11, 46, 89, .22);
}

.event-modal .modal-header {
    padding: 22px 24px;
    border-bottom: 1px solid var(--home-line);
}

.event-modal .modal-header span {
    color: var(--home-blue);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.event-modal .modal-title {
    margin-top: 3px;
    color: var(--home-navy);
    font-weight: 800;
}

.event-modal .modal-body {
    padding: 25px;
}

#eventModalTitle {
    margin: 0 0 20px;
    color: var(--home-navy);
    font-size: 23px;
    font-weight: 800;
}

.event-information {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin: 0 0 15px;
}

.event-information > div,
.event-description {
    padding: 15px;
    background: var(--home-bg);
    border: 1px solid var(--home-line);
    border-radius: 11px;
}

.event-information dt,
.event-description > span {
    margin-bottom: 4px;
    color: #8994a4;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.event-information dd {
    margin: 0;
    color: var(--home-ink);
    font-size: 13px;
    font-weight: 700;
}

.event-description p {
    margin: 6px 0 0;
    color: var(--home-muted);
    font-size: 13px;
    line-height: 1.7;
}

.event-modal .modal-footer {
    padding: 16px 24px;
    border-top: 1px solid var(--home-line);
}

.modal-close-button {
    padding: 10px 19px;
    color: var(--home-white);
    background: var(--home-navy);
    border-radius: 9px;
    font-size: 13px;
    font-weight: 700;
}

.fc {
    color: var(--home-ink);
    font-family: inherit;
    font-size: 12px;
}

.fc .fc-toolbar {
    margin: 19px 0 17px;
}

.fc .fc-toolbar-title {
    color: var(--home-navy);
    font-size: 16px;
    font-weight: 800;
}

.fc .fc-button {
    padding: 7px 10px !important;
    color: var(--home-white) !important;
    background: var(--home-navy) !important;
    border: 0 !important;
    border-radius: 7px !important;
    box-shadow: none !important;
    font-size: 11px !important;
    text-transform: capitalize !important;
}

.fc .fc-button-group {
    display: inline-flex !important;
    gap: 8px;
}

.fc .fc-button-group > .fc-button {
    margin-left: 0 !important;
}

.fc .fc-button:hover {
    background: var(--home-blue) !important;
}

.fc .fc-scrollgrid {
    overflow: hidden;
    border: 1px solid var(--home-line) !important;
    border-radius: 11px;
}

.fc-theme-standard td,
.fc-theme-standard th {
    border-color: var(--home-line) !important;
}

.fc .fc-col-header-cell {
    padding: 7px 0;
    background: var(--home-bg);
}

.fc .fc-col-header-cell-cushion,
.fc .fc-daygrid-day-number {
    color: var(--home-navy);
    text-decoration: none;
}

.fc .fc-col-header-cell-cushion {
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
}

.fc .fc-daygrid-day-number {
    padding: 6px;
    font-size: 10px;
    font-weight: 700;
}

.fc .fc-day-today {
    background: #fff8df !important;
}

.fc .fc-daygrid-event {
    padding: 2px 4px;
    overflow: hidden;
    color: var(--home-white) !important;
    background: var(--home-blue) !important;
    border: 0 !important;
    border-radius: 4px;
    font-size: 9px;
    cursor: pointer;
}

@media (max-width: 1199.98px) {
    .summary-panel {
        grid-template-columns: 1fr;
    }

    .summary-grid > div:first-child {
        border-left: 0;
    }
}

@media (max-width: 991.98px) {
    .home-hero {
        min-height: 540px;
    }

    .about-copy {
        max-width: 650px;
    }

    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px 0;
    }

    .summary-grid > div:nth-child(3) {
        border-left: 0;
    }

    .gallery-grid {
        grid-template-columns: 1fr;
        grid-template-rows: 340px 260px 260px;
    }

    .gallery-card-large {
        grid-row: auto;
    }

    .library-map {
        min-height: 420px;
    }

    .cta-panel {
        align-items: flex-start;
        flex-direction: column;
    }
}

@media (max-width: 767.98px) {
    .home-hero {
        min-height: 490px;
    }

    .home-hero-content {
        padding: 95px 0 80px;
    }

    .home-section,
    .contact-section {
        padding: 42px 0;
    }

    .content-panel {
        padding: 24px 21px;
        border-radius: 18px;
    }

    .arrival-cover {
        height: 350px;
    }

    .about-carousel .carousel-item,
    .about-carousel .carousel-item img {
        height: 380px;
    }

    .library-summary,
    .home-cta {
        padding-bottom: 42px;
    }

    .summary-panel {
        padding: 32px 28px;
    }

    .contact-copy {
        padding: 35px 28px;
    }

    .cta-panel {
        padding: 35px 28px;
    }
}

@media (max-width: 575.98px) {
    .home-hero h1 {
        font-size: 43px;
    }

    .home-hero p {
        font-size: 15px;
    }

    .event-item {
        grid-template-columns: 55px 1fr;
        gap: 13px;
    }

    .event-date {
        width: 55px;
        height: 61px;
    }

    .fc .fc-toolbar {
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 8px;
    }

    .fc .fc-toolbar-chunk:nth-child(2) {
        order: -1;
        width: 100%;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .summary-grid > div {
        padding: 0 0 18px;
        border-left: 0;
        border-bottom: 1px solid rgba(255, 255, 255, .13);
    }

    .summary-grid > div:last-child {
        padding-bottom: 0;
        border-bottom: 0;
    }

    .gallery-grid {
        grid-template-rows: repeat(3, 250px);
    }

    .event-information {
        grid-template-columns: 1fr;
    }

    .primary-action {
        width: 100%;
    }
}
</style>

@endsection
