@extends('layouts.app')

@section('title', 'MMACI Library Services Office')

@section('content')

<section class="home-hero">
    <div class="container">
        <div class="home-hero-content" data-aos="fade-up">
           

            <h1>Welcome to MMACI</h1>

            <h2>Library Services Office</h2>

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
                            @php
                                $eventStart = $event->event_date;
                                $eventEnd = $event->event_end_date;
                            @endphp

                            <div class="event-item">
                                <time class="event-date" datetime="{{ $event->event_date }}">
                                    <span>
                                        {{ $eventStart->format('M') }}
                                    </span>
                                    <strong>
                                        {{ $eventStart->format('d') }}
                                    </strong>
                                </time>

                                <div class="event-copy">
                                    <h4>{{ $event->title }}</h4>
                                    <span>
                                        @if($eventEnd && $eventStart && $eventEnd > $eventStart)
                                            {{ $eventStart->format('F d') }} — {{ $eventEnd->format('F d, Y') }}
                                        @else
                                            {{ $eventStart->format('F d, Y') }}
                                        @endif
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

<section class="home-section library-updates-section">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">Latest from the Library</span>
            <h2 id="library-updates-heading">Library updates</h2>
            <p>
                Stay informed with announcements, highlights, and new
                moments from the MMACI Library Services Office.
            </p>
        </header>

        @if(($libraryUpdates ?? collect())->isNotEmpty())
            <section class="library-updates-scroll" aria-labelledby="library-updates-heading">
                @foreach($libraryUpdates as $update)
                    <button
                        type="button"
                        class="library-update-card"
                        data-update-index="{{ $loop->index }}"
                        data-update-title='@json($update->title)'
                        data-update-description='@json($update->description ?? "No description provided.")'
                        data-update-image='@json($update->image_url)'
                        aria-label="View {{ $update->title }}">

                        <div class="library-update-image">
                            <img
                                src="{{ $update->image_url }}"
                                alt="{{ $update->title }}"
                                loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">
                        </div>

                        <div class="library-update-content">
                            <span class="library-update-badge">Library Update</span>
                            <h3>{{ $update->title }}</h3>
                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                    $update->description ?? 'No description provided.',
                                    100
                                ) }}
                            </p>

                            <span class="view-update-text">
                                View update
                                <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                            </span>
                        </div>
                    </button>
                @endforeach
            </section>
        @else
            <div class="empty-state empty-state-wide">
                <h4>No library updates yet</h4>
                <p>Admin-added library updates will appear here.</p>
            </div>
        @endif
    </div>
</section>

<section class="home-section">
    <div class="container">
        <header class="section-heading">
            <span class="eyebrow">Recently Added</span>
            <h2 id="new-arrivals-heading">New arrivals</h2>
            <p>
                Discover the newest printed books and learning resources
                available in the library.
            </p>
        </header>

        @if(($arrivals ?? collect())->isNotEmpty())
            <div class="arrival-search-wrap">
                <label for="arrivalSearch" class="visually-hidden">
                    Search new arrivals by title, accession number, or author
                </label>

                <div class="arrival-search-field">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <input
                        type="search"
                        id="arrivalSearch"
                        placeholder="Search title, accession number, or author..."
                        autocomplete="off"
                        aria-label="Search new arrivals by title, accession number, or author">
                </div>
            </div>
        @endif

        <section class="arrivals-scroll" aria-labelledby="new-arrivals-heading">
            @forelse($arrivals ?? [] as $book)
                <div class="arrival-item" data-aos="fade-up">
                    <button
                        type="button"
                        class="arrival-card arrival-card-button"
                        data-arrival-index="{{ $loop->index }}"
                        data-arrival-title='@json($book->title)'
                        data-arrival-author='@json($book->author ?? "Unknown Author")'
                        data-arrival-accession='@json($book->accession_number ?? "Not assigned")'
                        data-arrival-category='@json($book->category ?? "Uncategorized")'
                        data-arrival-year='@json($book->publication_year ?? null)'
                        data-arrival-publisher='@json($book->publisher ?? null)'
                        data-arrival-description='@json($book->description ?? "No description available.")'
                        data-arrival-image='@json($book->image_url)'
                        aria-label="View {{ $book->title }}">
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
                        </div>
                    </button>
                </div>
            @empty
                <div class="arrival-empty">
                    <div class="empty-state empty-state-wide">
                        <h4>No new arrivals available</h4>
                        <p>Newly added library resources will appear here.</p>
                    </div>
                </div>
            @endforelse
        </section>

        @if(($arrivals ?? collect())->isNotEmpty())
            <div class="arrival-no-results d-none" id="arrivalNoResults">
                <div class="empty-state empty-state-wide">
                    <h4>No matching arrivals found</h4>
                    <p>Try searching by title, accession number, or author.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<section class="home-section home-section-soft">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                @php
                    if (!isset($aboutSlides) || !is_array($aboutSlides) || count($aboutSlides) === 0) {
                        $aboutSlides = [
                            'personell.jpg',
                            'Studentslib.jpg',
                            'Studentslib2.jpg',
                            'Studentslib3.jpg',
                            'Studentslib4.jpg',
                            'Studentslib5.jpg',
                            'Studentslib6.jpg',
                            'Studentslib7.jpg',
                            'Studentslib8.jpg',
                        ];
                    }
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

                    <a href="{{ url('/about') }}" class="text-action" aria-label="Learn more about the library">
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
                    <a href="{{ url('/services') }}" aria-label="Learn more about book borrowing services">
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
                end: @json($event->event_end_date ? \Carbon\Carbon::parse($event->event_end_date)->addDay()->format('Y-m-d') : null),
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
                ? (() => {
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };

                    const startDate = event.start.toLocaleDateString('en-PH', options);

                    if (event.end) {
                        const endDate = new Date(event.end.getTime() - 86400000);
                        return `${startDate} — ${endDate.toLocaleDateString('en-PH', options)}`;
                    }

                    return startDate;
                })()
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
    min-height: 440px;
    display: grid;
    place-items: center;
    overflow: hidden;
    isolation: isolate;
    color: var(--home-white);
    background-color: var(--home-navy);
    background:
        linear-gradient(
            105deg,
            rgba(7, 30, 61, .86) 0%,
            rgba(11, 46, 89, .68) 55%,
            rgba(24, 75, 140, .52) 100%
        ),
        url("{{ asset('images/libraryphotojpg.jpg') }}") center / cover no-repeat;
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
    max-width: 790px;
    margin: auto;
    padding: 95px 0 80px;
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

.home-hero-label {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: var(--home-gold);
    font-size: 13px;
    font-weight: 800;
    letter-spacing: .14em;
    text-transform: uppercase;
}

.home-hero-label::before,
.home-hero-label::after {
    content: "";
    width: 30px;
    height: 2px;
    border-radius: 10px;
    background: var(--home-gold);
}

.home-hero h1 {
    max-width: 980px;
    margin: 20px auto 8px;
    font-size: clamp(62px, 8.5vw, 112px);
    font-weight: 900;
    line-height: .94;
    letter-spacing: -.055em;
    text-wrap: balance;
}

.home-hero h2 {
    margin: 0 0 25px;
    color: var(--home-gold);
    font-size: clamp(20px, 2.4vw, 31px);
    font-weight: 700;
    letter-spacing: .02em;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
     * Adds reveal classes at runtime instead of rewriting the existing Blade
     * markup. This keeps all current Laravel directives and components intact.
     */
    const revealGroups = [
        {
            selector: '.home-section .section-heading, .video-section .section-heading',
            mode: ''
        },
        {
            selector: '.content-panel',
            mode: 'home-motion-scale'
        },
        {
            selector: '.library-update-card',
            mode: ''
        },
        {
            selector: '.arrival-search-wrap',
            mode: ''
        },
        {
            selector: '.arrival-item',
            mode: ''
        },
        {
            selector: '.about-carousel',
            mode: 'home-motion-left'
        },
        {
            selector: '.about-copy',
            mode: 'home-motion-right'
        },
        {
            selector: '.summary-panel',
            mode: 'home-motion-scale'
        },
        {
            selector: '.service-card',
            mode: ''
        },
        {
            selector: '.gallery-card',
            mode: 'home-motion-scale'
        },
        {
            selector: '.video-frame',
            mode: 'home-motion-scale'
        },
        {
            selector: '.contact-panel',
            mode: 'home-motion-scale'
        },
        {
            selector: '.home-cta .cta-panel',
            mode: ''
        }
    ];

    const revealElements = [];

    revealGroups.forEach(function (group) {
        document.querySelectorAll(group.selector).forEach(function (element, index) {
            /*
             * Do not stack custom reveal transforms on top of AOS.
             * Existing data-aos elements remain managed by AOS.
             */
            if (element.hasAttribute('data-aos')) {
                return;
            }

            element.classList.add('home-motion-reveal');

            if (group.mode) {
                element.classList.add(group.mode);
            }

            const stagger = Math.min((index % 6) * 70, 350);
            element.style.setProperty('--home-motion-delay', stagger + 'ms');

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

