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
                                onerror="this.onerror=null;this.src='{{ asset('images/image-fallback.svg') }}';">
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
                    <a href="{{ route('more.ask-librarian') }}">
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
                    src="{{ asset('images/readingarea.jpg') }}"
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
                    src="https://www.youtube.com/embed/G683Hi_NdGo"
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

    function formatEventDateRange(event) {
        if (!event || !event.start) {
            return 'Date not specified';
        }

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
    }

    function openEventModal(event) {
        const modalElement = document.getElementById('eventDetailsModal');

        if (!modalElement) {
            return;
        }

        const properties = event.extendedProps || {};

        document.getElementById('eventModalTitle').textContent =
            event.title || 'Untitled Event';
        document.getElementById('eventModalDate').textContent =
            formatEventDateRange(event);
        document.getElementById('eventModalLocation').textContent =
            properties.location || 'Location not specified';
        document.getElementById('eventModalDescription').textContent =
            properties.description || 'No description provided.';

        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalElement).show();
            return;
        }

        modalElement.hidden = false;
        modalElement.classList.add('show');
        modalElement.style.display = 'block';
        modalElement.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    }

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
            openEventModal(info.event);
        },

        dateClick: function (info) {
            /*
             * Compare YYYY-MM-DD values instead of raw timestamps.
             * This avoids timezone / daylight-saving offsets and makes
             * clicking any date covered by a multi-day event reliable.
             */
            const clickedDate = info.dateStr;

            const event = calendar.getEvents().find(function (calendarEvent) {
                if (!calendarEvent.start) {
                    return false;
                }

                const toDateKey = function (date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');

                    return `${year}-${month}-${day}`;
                };

                const startDate = toDateKey(calendarEvent.start);

                let endDate = startDate;

                /*
                 * FullCalendar uses an exclusive end date for all-day events.
                 * Subtract one day so the visible final day remains clickable.
                 */
                if (calendarEvent.end) {
                    const inclusiveEnd = new Date(calendarEvent.end);
                    inclusiveEnd.setDate(inclusiveEnd.getDate() - 1);
                    endDate = toDateKey(inclusiveEnd);
                }

                return clickedDate >= startDate && clickedDate <= endDate;
            });

            if (event) {
                openEventModal(event);
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

/* Library updates */
.library-updates-section {
    overflow: hidden;
}

.library-updates-scroll {
    display: flex;
    gap: 20px;
    width: 100%;
    margin-top: 26px;
    padding: 4px 4px 18px;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-behavior: smooth;
    scroll-snap-type: x mandatory;
    overscroll-behavior-inline: contain;
    scrollbar-width: thin;
    scrollbar-color: var(--home-blue) var(--home-bg);
    -webkit-overflow-scrolling: touch;
}

.library-updates-scroll::-webkit-scrollbar {
    height: 8px;
}

.library-updates-scroll::-webkit-scrollbar-track {
    background: var(--home-bg);
    border-radius: 999px;
}

.library-updates-scroll::-webkit-scrollbar-thumb {
    background: var(--home-blue);
    border: 2px solid var(--home-bg);
    border-radius: 999px;
}

.library-update-card {
    flex: 0 0 clamp(235px, 21vw, 285px);
    scroll-snap-align: start;
    padding: 0;
    overflow: hidden;
    color: inherit;
    text-align: left;
    background: var(--home-white);
    border: 1px solid var(--home-line);
    border-radius: 18px;
    box-shadow: 0 10px 24px rgba(11, 46, 89, .08);
    cursor: pointer;
    transition: transform .25s ease, box-shadow .25s ease;
}

.library-update-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 30px rgba(11, 46, 89, .13);
}

.library-update-card:focus-visible {
    outline: 3px solid rgba(244, 180, 0, .55);
    outline-offset: 3px;
}

.library-update-image {
    width: 100%;
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: var(--home-bg);
}

.library-update-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: center;
    transition: transform .35s ease;
}

.library-update-card:hover .library-update-image img {
    transform: scale(1.025);
}

.library-update-content {
    padding: 16px 17px 18px;
}

.library-update-badge {
    display: inline-flex;
    margin-bottom: 9px;
    padding: 5px 10px;
    color: var(--home-navy);
    background: rgba(244, 180, 0, .14);
    border-radius: 999px;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.library-update-content h3 {
    display: -webkit-box;
    overflow: hidden;
    margin: 0 0 8px;
    color: var(--home-navy);
    font-size: 16px;
    font-weight: 800;
    line-height: 1.35;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.library-update-content p {
    display: -webkit-box;
    overflow: hidden;
    min-height: 58px;
    margin: 0 0 14px;
    color: #556983;
    font-size: 12px;
    line-height: 1.6;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

.view-update-text {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--home-blue);
    font-size: 11px;
    font-weight: 800;
}

/* Library update modal viewer */
.library-update-viewer {
    position: fixed;
    inset: 0;
    z-index: 1065;
    display: none;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100vh;
    height: 100dvh;
    padding: 16px;
    overflow: hidden;
}

.library-update-viewer.is-open {
    display: flex;
}

.library-update-viewer-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(3, 14, 29, .92);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.library-update-viewer-dialog {
    position: relative;
    z-index: 2;
    width: min(1280px, 100%);
    height: min(900px, calc(100vh - 32px));
    height: min(900px, calc(100dvh - 32px));
    min-height: 0;
    display: grid;
    grid-template-columns: minmax(0, 1.7fr) minmax(320px, .78fr);
    overflow: hidden;
    background: #07101d;
    border: 1px solid rgba(255, 255, 255, .14);
    border-radius: 22px;
    box-shadow: 0 30px 90px rgba(0, 0, 0, .48);
    pointer-events: auto;
}

.viewer-image-panel {
    position: relative;
    min-width: 0;
    min-height: 0;
    width: 100%;
    height: 100%;
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #030810;
}

.viewer-image-panel img {
    width: 100%;
    height: 100%;
    max-width: 100%;
    max-height: 100%;
    display: block;
    object-fit: contain;
    object-position: center;
    background: #030810;
}

.viewer-content-panel {
    min-width: 0;
    min-height: 0;
    height: 100%;
    display: flex;
    flex-direction: column;
    padding: 28px;
    overflow-y: auto;
    overscroll-behavior: contain;
    color: var(--home-white);
    background:
        radial-gradient(circle at 100% 0, rgba(244, 180, 0, .09), transparent 32%),
        linear-gradient(165deg, #0b2e59, #071f3e);
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, .32) rgba(255, 255, 255, .06);
}

.viewer-content-panel::-webkit-scrollbar {
    width: 7px;
}

.viewer-content-panel::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, .06);
}

.viewer-content-panel::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, .32);
    border-radius: 999px;
}

.viewer-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-right: 48px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, .12);
}

.viewer-brand img {
    width: 46px;
    height: 46px;
    flex: 0 0 46px;
    object-fit: contain;
    background: #fff;
    border-radius: 50%;
}

.viewer-brand strong,
.viewer-brand span {
    display: block;
}

.viewer-brand strong {
    color: #fff;
    font-size: 13px;
    font-weight: 800;
    line-height: 1.35;
}

.viewer-brand span {
    margin-top: 3px;
    color: rgba(255, 255, 255, .58);
    font-size: 10px;
}

.viewer-copy {
    padding: 28px 0;
}

.viewer-eyebrow {
    display: inline-flex;
    margin-bottom: 14px;
    padding: 6px 10px;
    color: var(--home-navy);
    background: var(--home-gold);
    border-radius: 999px;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.viewer-copy h3 {
    margin: 0 0 18px;
    color: #fff;
    font-size: clamp(25px, 3vw, 38px);
    font-weight: 900;
    line-height: 1.15;
    overflow-wrap: anywhere;
}

.viewer-copy p {
    margin: 0;
    color: rgba(255, 255, 255, .78);
    font-size: 14px;
    line-height: 1.85;
    white-space: pre-line;
    overflow-wrap: anywhere;
}

.viewer-footer {
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, .12);
}

.viewer-footer span,
.viewer-footer small {
    display: block;
}

.viewer-footer span {
    color: var(--home-gold);
    font-size: 11px;
    font-weight: 800;
}

.viewer-footer small {
    margin-top: 4px;
    color: rgba(255, 255, 255, .5);
    font-size: 9px;
}

.viewer-close-button,
.viewer-navigation {
    position: absolute;
    z-index: 4;
    display: grid;
    place-items: center;
    color: #fff;
    background: rgba(7, 31, 62, .82);
    border: 1px solid rgba(255, 255, 255, .2);
    cursor: pointer;
    transition: background .2s ease, transform .2s ease;
}

.viewer-close-button:hover,
.viewer-navigation:hover:not(:disabled) {
    background: rgba(24, 75, 140, .96);
}

.viewer-close-button {
    top: 16px;
    right: 16px;
    width: 42px;
    height: 42px;
    border-radius: 12px;
}

.viewer-navigation {
    top: 50%;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    transform: translateY(-50%);
    pointer-events: auto;
}

.viewer-navigation:hover:not(:disabled) {
    transform: translateY(-50%) scale(1.05);
}

.viewer-previous {
    left: 16px;
}

.viewer-next {
    right: 16px;
}

.viewer-navigation:disabled {
    opacity: .32;
    cursor: not-allowed;
}

body.update-viewer-open {
    overflow: hidden;
}

@media (max-width: 991.98px) {
    .library-update-card {
        flex-basis: 250px;
    }

    .library-update-viewer {
        padding: 10px;
    }

    .library-update-viewer-dialog {
        width: min(760px, 100%);
        height: calc(100vh - 20px);
        height: calc(100dvh - 20px);
        grid-template-columns: 1fr;
        grid-template-rows: minmax(0, 58%) minmax(0, 42%);
        border-radius: 18px;
    }

    .viewer-image-panel {
        width: 100%;
        height: 100%;
        padding: 16px;
    }

    .viewer-content-panel {
        width: 100%;
        height: 100%;
        padding: 22px 20px;
    }

    .viewer-previous {
        left: 14px;
    }

    .viewer-navigation {
        top: 29%;
    }
}

@media (max-width: 767.98px) {
    .library-updates-scroll {
        gap: 15px;
        margin-top: 21px;
        padding-right: 15px;
    }

    .library-update-card {
        flex-basis: min(72vw, 245px);
        border-radius: 16px;
    }

    .library-update-viewer {
        padding: 0;
    }

    .library-update-viewer-dialog {
        width: 100%;
        height: 100vh;
        height: 100dvh;
        grid-template-rows: minmax(0, 55%) minmax(0, 45%);
        border: 0;
        border-radius: 0;
    }

    .viewer-image-panel {
        padding: 12px;
    }

    .viewer-content-panel {
        padding: 20px 18px 24px;
    }

    .viewer-brand {
        padding-right: 46px;
        padding-bottom: 15px;
    }

    .viewer-brand img {
        width: 40px;
        height: 40px;
        flex-basis: 40px;
    }

    .viewer-copy {
        padding: 20px 0;
    }

    .viewer-copy h3 {
        font-size: 25px;
    }

    .viewer-copy p {
        font-size: 13px;
        line-height: 1.7;
    }

    .viewer-close-button {
        top: 10px;
        right: 10px;
        width: 40px;
        height: 40px;
    }

    .viewer-navigation {
        width: 40px;
        height: 40px;
    }

    .viewer-previous {
        left: 10px;
    }

    .viewer-next {
        right: 10px;
    }
}

@media (max-width: 480px) {
    .library-update-card {
        flex-basis: min(78vw, 230px);
    }

    .library-update-viewer-dialog {
        grid-template-rows: minmax(0, 52%) minmax(0, 48%);
    }

    .viewer-navigation {
    }

    .viewer-copy h3 {
        font-size: 22px;
    }
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

.arrivals-scroll {
    display: flex;
    align-items: stretch;
    gap: 24px;
    padding: 4px 4px 18px;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-snap-type: x proximity;
    scroll-behavior: smooth;
    overscroll-behavior-inline: contain;
    scrollbar-width: thin;
    scrollbar-color: var(--home-blue) var(--home-bg);
    -webkit-overflow-scrolling: touch;
}

.arrival-search-wrap {
    display: flex;
    justify-content: flex-end;
    margin: 10px 0 20px;
}

.arrival-search-field {
    width: min(100%, 480px);
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 18px;
    border: 1px solid var(--home-line);
    border-radius: 18px;
    background: var(--home-white);
    box-shadow: 0 10px 28px rgba(11, 46, 89, .05);
}

.arrival-search-field i {
    color: var(--home-blue);
    font-size: 17px;
}

.arrival-search-field input {
    width: 100%;
    border: 0;
    outline: none;
    background: transparent;
    color: var(--home-text);
    font-size: 14px;
}

.arrival-search-field input::placeholder {
    color: #8c97a8;
}

.arrivals-scroll::-webkit-scrollbar {
    height: 9px;
}

.arrivals-scroll::-webkit-scrollbar-track {
    background: var(--home-bg);
    border-radius: 999px;
}

.arrivals-scroll::-webkit-scrollbar-thumb {
    background: var(--home-blue);
    border: 2px solid var(--home-bg);
    border-radius: 999px;
}

.arrival-item {
    flex: 0 0 clamp(270px, 23vw, 345px);
    display: flex;
    align-self: stretch;
    scroll-snap-align: start;
}

.arrival-empty {
    flex: 0 0 100%;
}


.arrival-card {
    width: 100%;
    height: 100%;
    min-height: 570px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: var(--home-white);
    border: 1px solid var(--home-line);
    border-radius: 19px;
    box-shadow: 0 10px 28px rgba(11, 46, 89, .06);
    transition: transform .3s ease, box-shadow .3s ease;
}

.arrival-card-button {
    width: 100%;
    padding: 0;
    border: 0;
    text-align: left;
    cursor: pointer;
}

.arrival-card-button:focus-visible {
    outline: 3px solid rgba(244, 180, 0, .45);
    outline-offset: 3px;
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
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 23px;
}

.arrival-body h3 {
    display: -webkit-box;
    min-height: 73px;
    margin: 0 0 4px;
    overflow: hidden;
    color: var(--home-navy);
    font-size: 18px;
    font-weight: 800;
    line-height: 1.35;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

.arrival-body > span {
    display: -webkit-box;
    min-height: 34px;
    overflow: hidden;
    color: #8a95a5;
    font-size: 11px;
    line-height: 1.55;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.arrival-body p {
    display: -webkit-box;
    min-height: 66px;
    margin: 14px 0 0;
    overflow: hidden;
    color: var(--home-muted);
    font-size: 13px;
    line-height: 1.7;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

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

#eventDetailsModal {
    z-index: 1055;
}

#eventDetailsModal .modal-dialog {
    z-index: 2;
}

#eventDetailsModal .modal-content {
    pointer-events: auto;
}

#eventDetailsModal .modal-body {
    max-height: min(72vh, 760px);
    overflow-y: auto;
    overscroll-behavior: contain;
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

    .arrival-item {
        flex-basis: min(82vw, 320px);
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
        font-size: clamp(48px, 15vw, 66px);
    }

    .home-hero h2 {
        font-size: 19px;
    }

    .home-hero-label {
        font-size: 10px;
        letter-spacing: .1em;
    }

    .home-hero-label::before,
    .home-hero-label::after {
        width: 18px;
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

    .arrival-search-wrap {
        justify-content: stretch;
    }

    .arrival-search-field {
        width: 100%;
        padding: 13px 16px;
        border-radius: 16px;
    }
}
</style>

<div class="library-update-viewer" id="libraryUpdateViewer" aria-hidden="true">
    <div class="library-update-viewer-backdrop" data-close-update-viewer></div>

    <div
        class="library-update-viewer-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="libraryUpdateViewerTitle">

        <button
            type="button"
            class="viewer-close-button"
            data-close-update-viewer
            aria-label="Close library update">
            <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>

        <button
            type="button"
            class="viewer-navigation viewer-previous"
            id="libraryUpdatePrevious"
            aria-label="Previous library update">
            <i class="bi bi-chevron-left" aria-hidden="true"></i>
        </button>

        <div class="viewer-image-panel">
            <button
                type="button"
                class="viewer-navigation viewer-previous"
                id="libraryUpdatePrevious"
                aria-label="Previous library update">
                <i class="bi bi-chevron-left" aria-hidden="true"></i>
            </button>

            <img
                id="libraryUpdateViewerImage"
                    src="{{ asset('images/image-fallback.svg') }}"
                alt="Library update">

            <button
                type="button"
                class="viewer-navigation viewer-next"
                id="libraryUpdateNext"
                aria-label="Next library update">
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
            </button>
        </div>

        <aside class="viewer-content-panel">
            <div class="viewer-brand">
                <img
                    src="{{ asset('images/logomml.webp') }}"
                    alt="MMACI logo"
                    onerror="this.style.display='none';">

                <div>
                    <strong>MMACI Library Services Office</strong>
                    <span>Library Update</span>
                </div>
            </div>

            <div class="viewer-copy">
                <span class="viewer-eyebrow">Latest from the Library</span>
                <h3 id="libraryUpdateViewerTitle"></h3>
                <p id="libraryUpdateViewerDescription"></p>
            </div>

            <div class="viewer-footer">
                <span id="libraryUpdateViewerCounter"></span>
                <small>Use the arrow buttons or keyboard keys to browse.</small>
            </div>
        </aside>

    </div>
</div>

<div class="library-update-viewer" id="arrivalViewer" aria-hidden="true">
    <div class="library-update-viewer-backdrop" data-close-arrival-viewer></div>

    <div
        class="library-update-viewer-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="arrivalViewerTitle">

        <button
            type="button"
            class="viewer-close-button"
            data-close-arrival-viewer
            aria-label="Close arrival details">
            <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>

        <button
            type="button"
            class="viewer-navigation viewer-previous"
            id="arrivalPrevious"
            aria-label="Previous arrival">
            <i class="bi bi-chevron-left" aria-hidden="true"></i>
        </button>

        <div class="viewer-image-panel">
            <button
                type="button"
                class="viewer-navigation viewer-previous"
                id="arrivalPrevious"
                aria-label="Previous arrival">
                <i class="bi bi-chevron-left" aria-hidden="true"></i>
            </button>

            <img
                id="arrivalViewerImage"
                src="{{ asset('images/image-fallback.svg') }}"
                alt="New arrival">

            <button
                type="button"
                class="viewer-navigation viewer-next"
                id="arrivalNext"
                aria-label="Next arrival">
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
            </button>
        </div>

        <aside class="viewer-content-panel">
            <div class="viewer-brand">
                <img
                    src="{{ asset('images/logomml.webp') }}"
                    alt="MMACI logo"
                    onerror="this.style.display='none';">

                <div>
                    <strong>MMACI Library Services Office</strong>
                    <span>New Arrival</span>
                </div>
            </div>

            <div class="viewer-copy arrival-viewer-copy">
                <span class="viewer-eyebrow">Recently Added</span>

                <h3 id="arrivalViewerTitle"></h3>

                <div class="arrival-viewer-field arrival-viewer-author-field">
                    <span class="arrival-viewer-field-label">Author</span>
                    <strong id="arrivalViewerAuthor"></strong>
                </div>

                <div class="arrival-viewer-meta-grid">
                    <div class="arrival-viewer-field">
                        <span class="arrival-viewer-field-label">Accession Number</span>
                        <strong id="arrivalViewerAccession"></strong>
                    </div>

                    <div class="arrival-viewer-field">
                        <span class="arrival-viewer-field-label">Category</span>
                        <strong id="arrivalViewerCategory"></strong>
                    </div>

                    <div class="arrival-viewer-field arrival-viewer-optional" id="arrivalViewerYearWrap">
                        <span class="arrival-viewer-field-label">Publication Year</span>
                        <strong id="arrivalViewerYear"></strong>
                    </div>

                    <div class="arrival-viewer-field arrival-viewer-optional" id="arrivalViewerPublisherWrap">
                        <span class="arrival-viewer-field-label">Publisher</span>
                        <strong id="arrivalViewerPublisher"></strong>
                    </div>
                </div>

                <div class="arrival-viewer-description">
                    <span class="arrival-viewer-field-label">Description</span>
                    <p id="arrivalViewerDescription"></p>
                </div>
            </div>

            <div class="viewer-footer">
                <span id="arrivalViewerCounter"></span>
                <small>Click outside the card or press Escape to close.</small>
            </div>
        </aside>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewer = document.getElementById('libraryUpdateViewer');
    const cards = Array.from(document.querySelectorAll('.library-update-card'));

    if (!viewer || cards.length === 0) {
        return;
    }

    const image = document.getElementById('libraryUpdateViewerImage');
    const title = document.getElementById('libraryUpdateViewerTitle');
    const description = document.getElementById('libraryUpdateViewerDescription');
    const counter = document.getElementById('libraryUpdateViewerCounter');
    const previousButton = document.getElementById('libraryUpdatePrevious');
    const nextButton = document.getElementById('libraryUpdateNext');
    const closeButtons = viewer.querySelectorAll('[data-close-update-viewer]');

    let currentIndex = 0;
    let lastFocusedElement = null;

    function readCard(card) {
        const parseJson = function (value, fallback) {
            try {
                return JSON.parse(value);
            } catch (error) {
                return fallback;
            }
        };

        return {
            title: parseJson(card.dataset.updateTitle, 'Library Update'),
            description: parseJson(card.dataset.updateDescription, 'No description provided.'),
            image: parseJson(card.dataset.updateImage, '')
        };
    }

    function renderUpdate(index) {
        currentIndex = Math.max(0, Math.min(index, cards.length - 1));

        const update = readCard(cards[currentIndex]);

        image.src = update.image;
        image.alt = update.title;
        title.textContent = update.title;
        description.textContent = update.description;
        counter.textContent = `${currentIndex + 1} of ${cards.length}`;

        previousButton.disabled = cards.length <= 1;
        nextButton.disabled = cards.length <= 1;
    }

    function openViewer(index, trigger) {
        lastFocusedElement = trigger;
        renderUpdate(index);
        viewer.classList.add('is-open');
        viewer.setAttribute('aria-hidden', 'false');
        document.body.classList.add('update-viewer-open');

        window.setTimeout(function () {
            viewer.querySelector('.viewer-close-button')?.focus();
        }, 20);
    }

    function closeViewer() {
        viewer.classList.remove('is-open');
        viewer.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('update-viewer-open');

        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
    }

    function showPrevious() {
        const previousIndex = currentIndex === 0
            ? cards.length - 1
            : currentIndex - 1;

        renderUpdate(previousIndex);
    }

    function showNext() {
        const nextIndex = currentIndex === cards.length - 1
            ? 0
            : currentIndex + 1;

        renderUpdate(nextIndex);
    }

    cards.forEach(function (card, index) {
        card.addEventListener('click', function () {
            openViewer(index, card);
        });
    });

    closeButtons.forEach(function (button) {
        button.addEventListener('click', closeViewer);
    });

    previousButton.addEventListener('click', showPrevious);
    nextButton.addEventListener('click', showNext);

    image.addEventListener('error', function () {
        image.src = @json(asset('images/image-fallback.svg'));
    });

    document.addEventListener('keydown', function (event) {
        if (!viewer.classList.contains('is-open')) {
            return;
        }

        if (event.key === 'Escape') {
            closeViewer();
        }

        if (event.key === 'ArrowLeft') {
            showPrevious();
        }

        if (event.key === 'ArrowRight') {
            showNext();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('arrivalSearch');
    const arrivalCards = Array.from(document.querySelectorAll('.arrival-card-button'));
    const noResults = document.getElementById('arrivalNoResults');
    const viewer = document.getElementById('arrivalViewer');

    if (!viewer || arrivalCards.length === 0) {
        return;
    }

    const image = document.getElementById('arrivalViewerImage');
    const title = document.getElementById('arrivalViewerTitle');
    const author = document.getElementById('arrivalViewerAuthor');
    const accession = document.getElementById('arrivalViewerAccession');
    const category = document.getElementById('arrivalViewerCategory');
    const year = document.getElementById('arrivalViewerYear');
    const publisher = document.getElementById('arrivalViewerPublisher');
    const description = document.getElementById('arrivalViewerDescription');
    const yearWrap = document.getElementById('arrivalViewerYearWrap');
    const publisherWrap = document.getElementById('arrivalViewerPublisherWrap');
    const counter = document.getElementById('arrivalViewerCounter');
    const previousButton = document.getElementById('arrivalPrevious');
    const nextButton = document.getElementById('arrivalNext');
    const closeButtons = viewer.querySelectorAll('[data-close-arrival-viewer]');

    let currentIndex = 0;
    let lastFocusedElement = null;

    function readCard(card) {
        const parseJson = function (value, fallback) {
            try {
                return JSON.parse(value);
            } catch (error) {
                return fallback;
            }
        };

        return {
            title: parseJson(card.dataset.arrivalTitle, 'New Arrival'),
            author: parseJson(card.dataset.arrivalAuthor, 'Unknown Author'),
            accession: parseJson(card.dataset.arrivalAccession, 'Not assigned'),
            category: parseJson(card.dataset.arrivalCategory, 'Uncategorized'),
            year: parseJson(card.dataset.arrivalYear, ''),
            publisher: parseJson(card.dataset.arrivalPublisher, ''),
            description: parseJson(card.dataset.arrivalDescription, 'No description available.'),
            image: parseJson(card.dataset.arrivalImage, '')
        };
    }

    function renderArrival(index) {
        currentIndex = Math.max(0, Math.min(index, arrivalCards.length - 1));
        const arrival = readCard(arrivalCards[currentIndex]);

        image.src = arrival.image;
        image.alt = arrival.title;
        title.textContent = arrival.title;

        author.textContent = arrival.author || 'Unknown Author';
        accession.textContent = arrival.accession || 'Not assigned';
        category.textContent = arrival.category || 'Uncategorized';
        description.textContent = arrival.description || 'No description available.';

        if (arrival.year) {
            year.textContent = arrival.year;
            yearWrap.hidden = false;
        } else {
            year.textContent = '';
            yearWrap.hidden = true;
        }

        if (arrival.publisher) {
            publisher.textContent = arrival.publisher;
            publisherWrap.hidden = false;
        } else {
            publisher.textContent = '';
            publisherWrap.hidden = true;
        }

        counter.textContent = `${currentIndex + 1} of ${arrivalCards.length}`;

        previousButton.disabled = arrivalCards.length <= 1;
        nextButton.disabled = arrivalCards.length <= 1;
    }

    function openViewer(index, trigger) {
        lastFocusedElement = trigger;
        renderArrival(index);
        viewer.classList.add('is-open');
        viewer.setAttribute('aria-hidden', 'false');
        document.body.classList.add('update-viewer-open');

        window.setTimeout(function () {
            viewer.querySelector('.viewer-close-button')?.focus();
        }, 20);
    }

    function closeViewer() {
        viewer.classList.remove('is-open');
        viewer.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('update-viewer-open');

        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
    }

    function showPrevious() {
        const previousIndex = currentIndex === 0
            ? arrivalCards.length - 1
            : currentIndex - 1;

        renderArrival(previousIndex);
    }

    function showNext() {
        const nextIndex = currentIndex === arrivalCards.length - 1
            ? 0
            : currentIndex + 1;

        renderArrival(nextIndex);
    }

    function filterArrivals() {
        const term = (searchInput?.value || '').trim().toLowerCase();
        let visibleCount = 0;

        arrivalCards.forEach(function (card) {
            const haystack = [
                card.dataset.arrivalTitle,
                card.dataset.arrivalAuthor,
                card.dataset.arrivalAccession
            ].join(' ').toLowerCase();

            const match = !term || haystack.includes(term);
            const item = card.closest('.arrival-item');

            if (item) {
                item.style.display = match ? '' : 'none';
            }

            if (match) {
                visibleCount += 1;
            }
        });

        if (noResults) {
            noResults.classList.toggle('d-none', visibleCount !== 0);
        }
    }

    arrivalCards.forEach(function (card, index) {
        card.addEventListener('click', function () {
            openViewer(index, card);
        });
    });

    closeButtons.forEach(function (button) {
        button.addEventListener('click', closeViewer);
    });

    previousButton.addEventListener('click', showPrevious);
    nextButton.addEventListener('click', showNext);

    searchInput?.addEventListener('input', filterArrivals);

    image.addEventListener('error', function () {
        image.src = @json(asset('images/image-fallback.svg'));
    });

    document.addEventListener('keydown', function (event) {
        if (!viewer.classList.contains('is-open')) {
            return;
        }

        if (event.key === 'Escape') {
            closeViewer();
        }

        if (event.key === 'ArrowLeft') {
            showPrevious();
        }

        if (event.key === 'ArrowRight') {
            showNext();
        }
    });

    filterArrivals();
});
</script>

<!-- =========================================================
     HOME PAGE ANIMATIONS
     Additive only: existing layout/functionality is untouched.
========================================================= -->
<style>
    /* ---------- Hero entrance ---------- */
    @keyframes homeHeroFadeUp {
        from {
            opacity: 0;
            transform: translate3d(0, 28px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    @keyframes homeHeroBackgroundZoom {
        from {
            background-size: 105%;
        }
        to {
            background-size: 112%;
        }
    }

    @keyframes homeGoldRingFloat {
        0%, 100% {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }
        50% {
            transform: translate3d(-12px, -14px, 0) rotate(4deg);
        }
    }

    @keyframes homeButtonArrow {
        0%, 100% {
            transform: translateX(0);
        }
        50% {
            transform: translateX(5px);
        }
    }

    .home-hero-content {
        animation: homeHeroFadeUp .85s cubic-bezier(.22, 1, .36, 1) both;
    }

    .home-hero::after {
        animation: homeGoldRingFloat 7s ease-in-out infinite;
        will-change: transform;
    }

    .primary-action i,
    .text-action i,
    .service-card a i,
    .view-update-text i,
    .home-cta a i {
        transition: transform .25s ease;
    }

    .primary-action:hover i,
    .text-action:hover i,
    .service-card a:hover i,
    .library-update-card:hover .view-update-text i,
    .home-cta a:hover i {
        transform: translateX(5px);
    }

    /* ---------- Scroll reveal ---------- */
    .home-motion-reveal {
        opacity: 0;
        transform: translate3d(0, 30px, 0);
        transition:
            opacity .7s cubic-bezier(.22, 1, .36, 1),
            transform .7s cubic-bezier(.22, 1, .36, 1);
        transition-delay: var(--home-motion-delay, 0ms);
        will-change: opacity, transform;
    }

    .home-motion-reveal.home-motion-left {
        transform: translate3d(-34px, 0, 0);
    }

    .home-motion-reveal.home-motion-right {
        transform: translate3d(34px, 0, 0);
    }

    .home-motion-reveal.home-motion-scale {
        transform: scale(.965);
    }

    .home-motion-reveal.is-visible {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
    }

    /* ---------- Section heading accent ---------- */
    .section-heading .eyebrow::before,
    .about-copy .eyebrow::before,
    .contact-copy .eyebrow::before {
        transform-origin: left center;
        transition: transform .55s cubic-bezier(.22, 1, .36, 1);
    }

    .home-motion-reveal:not(.is-visible) .eyebrow::before {
        transform: scaleX(.25);
    }

    .home-motion-reveal.is-visible .eyebrow::before {
        transform: scaleX(1);
    }

    /* ---------- Panels/cards ---------- */
    .content-panel,
    .library-update-card,
    .arrival-card,
    .service-card,
    .gallery-card,
    .video-frame,
    .summary-panel,
    .contact-panel,
    .cta-panel {
        backface-visibility: hidden;
    }

    .content-panel {
        transition:
            transform .28s ease,
            box-shadow .28s ease,
            border-color .28s ease;
    }

    .content-panel:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 42px rgba(11, 46, 89, .11);
        border-color: rgba(24, 75, 140, .18);
    }

    /* ---------- Event rows ---------- */
    .event-item {
        transition:
            background .22s ease,
            transform .22s ease,
            padding-left .22s ease,
            padding-right .22s ease;
    }

    .event-item:hover {
        background: rgba(24, 75, 140, .035);
        transform: translateX(3px);
    }

    .event-date {
        transition:
            transform .24s ease,
            box-shadow .24s ease;
    }

    .event-item:hover .event-date {
        transform: scale(1.045);
        box-shadow: 0 8px 20px rgba(11, 46, 89, .10);
    }

    /* ---------- Library update cards ---------- */
    .library-update-card {
        transition:
            transform .3s cubic-bezier(.22, 1, .36, 1),
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .library-update-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 20px 38px rgba(11, 46, 89, .14);
        border-color: rgba(24, 75, 140, .18);
    }

    .library-update-card:hover .library-update-image img {
        transform: scale(1.055);
    }

    /* ---------- Arrival cards ---------- */
    .arrival-card {
        transition:
            transform .32s cubic-bezier(.22, 1, .36, 1),
            box-shadow .32s ease,
            border-color .32s ease;
    }

    .arrival-cover img {
        transition: transform .45s cubic-bezier(.22, 1, .36, 1);
    }

    .arrival-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 20px 42px rgba(11, 46, 89, .13);
        border-color: rgba(24, 75, 140, .18);
    }

    .arrival-card:hover .arrival-cover img {
        transform: scale(1.045);
    }

    .arrival-search-field {
        transition:
            border-color .22s ease,
            box-shadow .22s ease,
            transform .22s ease;
    }

    .arrival-search-field:focus-within {
        transform: translateY(-2px);
        border-color: rgba(24, 75, 140, .45);
        box-shadow: 0 14px 32px rgba(11, 46, 89, .10);
    }

    /* ---------- About carousel ---------- */
    .about-carousel {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .about-carousel:hover {
        transform: translateY(-5px);
        box-shadow: 0 22px 52px rgba(11, 46, 89, .16);
    }

    .about-carousel .carousel-item img {
        transition: transform 6s ease;
    }

    .about-carousel .carousel-item.active img {
        transform: scale(1.045);
    }

    /* ---------- Summary statistics ---------- */
    .summary-grid > div {
        transition:
            transform .26s ease,
            background .26s ease;
    }

    .summary-grid > div:hover {
        transform: translateY(-5px);
    }

    .summary-grid strong {
        display: inline-block;
        transition: transform .25s ease;
    }

    .summary-grid > div:hover strong {
        transform: scale(1.06);
    }

    /* ---------- Service cards ---------- */
    .service-card {
        transition:
            transform .3s cubic-bezier(.22, 1, .36, 1),
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .service-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 18px 38px rgba(11, 46, 89, .11);
        border-color: rgba(24, 75, 140, .18);
    }

    /* ---------- Gallery ---------- */
    .gallery-card {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .gallery-card img {
        transition: transform .55s cubic-bezier(.22, 1, .36, 1);
    }

    .gallery-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 38px rgba(11, 46, 89, .13);
    }

    .gallery-card:hover img {
        transform: scale(1.055);
    }

    .gallery-card figcaption {
        transition:
            transform .3s ease,
            background .3s ease;
    }

    .gallery-card:hover figcaption {
        transform: translateY(-2px);
    }

    /* ---------- Video ---------- */
    .video-frame {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .video-frame:hover {
        transform: translateY(-5px);
        box-shadow: 0 22px 50px rgba(11, 46, 89, .15);
    }

    /* ---------- Contact / CTA ---------- */
    .contact-panel,
    .cta-panel,
    .summary-panel {
        transition:
            transform .35s cubic-bezier(.22, 1, .36, 1),
            box-shadow .35s ease;
    }

    .contact-panel:hover,
    .cta-panel:hover,
    .summary-panel:hover {
        transform: translateY(-4px);
    }

    /* ---------- Modal/viewer entrance ---------- */
    @keyframes homeViewerEnter {
        from {
            opacity: 0;
            transform: translateY(16px) scale(.975);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .library-update-viewer.is-open .library-update-viewer-dialog {
        animation: homeViewerEnter .28s cubic-bezier(.22, 1, .36, 1) both;
    }

    .modal.show .event-modal {
        animation: homeViewerEnter .28s cubic-bezier(.22, 1, .36, 1) both;
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

<!-- =========================================================
     HOME MODAL SYSTEM FIX
     Calendar + Library Updates + New Arrivals
========================================================= -->
<style>
    /*
     * IMPORTANT:
     * app.blade.php animates <main> with transform. A transformed ancestor
     * changes the containing block used by position: fixed, which is why
     * full-screen viewers can be clipped or shifted down the page.
     *
     * Keep the Home page itself untransformed so every modal is positioned
     * against the browser viewport.
     */
    main {
        transform: none !important;
    }

    /* =========================================================
       SHARED MODAL SAFETY
    ========================================================= */

    body.modal-open,
    body.update-viewer-open {
        overflow: hidden !important;
    }

    #eventDetailsModal,
    #libraryUpdateViewer,
    #arrivalViewer {
        isolation: isolate;
    }

    /* =========================================================
       CALENDAR EVENT MODAL
    ========================================================= */

    #eventDetailsModal {
        position: fixed !important;
        inset: 0 !important;
        z-index: 10850 !important;
        padding: 18px !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
    }

    #eventDetailsModal .modal-dialog {
        width: min(560px, 100%) !important;
        max-width: 560px !important;
        min-height: calc(100% - 36px);
        margin: 18px auto !important;
        display: flex;
        align-items: center;
    }

    #eventDetailsModal .event-modal {
        width: 100%;
        max-height: calc(100dvh - 72px);
        overflow: hidden;
        border: 0;
        border-radius: 20px;
        box-shadow: 0 28px 80px rgba(0, 0, 0, .28);
    }

    #eventDetailsModal .modal-header {
        align-items: flex-start;
        padding: 22px 24px 18px;
        background:
            radial-gradient(circle at 100% 0, rgba(244, 180, 0, .15), transparent 35%),
            linear-gradient(135deg, #0b2e59, #184b8c);
        border: 0;
    }

    #eventDetailsModal .modal-header > div > span {
        display: block;
        margin-bottom: 4px;
        color: #f4b400;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    #eventDetailsModal .modal-title {
        color: #fff;
        font-size: 20px;
        font-weight: 800;
    }

    #eventDetailsModal .btn-close {
        flex: 0 0 auto;
        margin: 0;
        padding: 10px;
        background-color: rgba(255, 255, 255, .95);
        border-radius: 10px;
        opacity: 1;
    }

    #eventDetailsModal .modal-body {
        max-height: calc(100dvh - 220px);
        padding: 24px;
        overflow-y: auto;
        overscroll-behavior: contain;
        scrollbar-width: thin;
    }

    #eventDetailsModal .modal-body > h4 {
        margin: 0 0 18px;
        color: #0b2e59;
        font-size: clamp(20px, 3vw, 27px);
        font-weight: 850;
        line-height: 1.3;
        overflow-wrap: anywhere;
    }

    #eventDetailsModal .event-information {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin: 0 0 20px;
    }

    #eventDetailsModal .event-information > div {
        min-width: 0;
        padding: 13px 14px;
        background: #f6f8fc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    #eventDetailsModal .event-information dt {
        margin-bottom: 4px;
        color: #7d8999;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    #eventDetailsModal .event-information dd {
        margin: 0;
        color: #0b2e59;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    #eventDetailsModal .event-description {
        padding: 16px;
        background: #fffaf0;
        border: 1px solid #f4df9b;
        border-radius: 12px;
    }

    #eventDetailsModal .event-description > span {
        display: block;
        margin-bottom: 7px;
        color: #735500;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    #eventDetailsModal .event-description p {
        margin: 0;
        color: #536174;
        font-size: 13px;
        line-height: 1.7;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    #eventDetailsModal .modal-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e8edf3;
    }

    #eventDetailsModal .modal-close-button {
        min-width: 100px;
        padding: 10px 18px;
        color: #fff;
        background: #0b2e59;
        border: 0;
        border-radius: 10px;
        font-weight: 700;
    }

    /* Make calendar events and event-containing dates clearly interactive. */
    #calendar .fc-event,
    #calendar .fc-daygrid-event {
        cursor: pointer;
    }

    #calendar .fc-daygrid-day:has(.fc-event) {
        cursor: pointer;
    }

    /* =========================================================
       LIBRARY UPDATE + NEW ARRIVAL VIEWERS
    ========================================================= */

    .library-update-viewer {
        position: fixed !important;
        inset: 0 !important;
        z-index: 10800 !important;

        width: 100vw !important;
        height: 100vh !important;
        height: 100dvh !important;

        padding: clamp(12px, 2vh, 20px) !important;

        align-items: center !important;
        justify-content: center !important;

        overflow-x: hidden !important;
        overflow-y: auto !important;
    }

    .library-update-viewer-backdrop {
        position: fixed !important;
        inset: 0 !important;

        width: 100vw !important;
        height: 100vh !important;
        height: 100dvh !important;

        background: rgba(3, 14, 29, .84) !important;
        backdrop-filter: blur(7px);
        -webkit-backdrop-filter: blur(7px);
    }

    /*
     * Desktop target:
     * compact enough to see the entire modal without browser-height clipping.
     */
    .library-update-viewer-dialog {
        position: relative !important;
        z-index: 2 !important;

        width: min(980px, calc(100vw - 40px)) !important;
        height: auto !important;
        max-height: min(720px, calc(100dvh - 40px)) !important;

        grid-template-columns: minmax(0, 1.15fr) minmax(320px, .85fr) !important;
        grid-template-rows: minmax(0, 1fr) !important;

        margin: auto !important;

        overflow: hidden !important;

        border-radius: 20px !important;

        box-shadow:
            0 28px 80px
            rgba(0, 0, 0, .42) !important;
    }

    .viewer-image-panel {
        min-height: 0 !important;
        height: min(680px, calc(100dvh - 40px)) !important;

        padding: 18px !important;

        align-items: center !important;

        overflow: hidden !important;
    }

    .viewer-image-panel img {
        width: 100% !important;
        height: 100% !important;

        max-width: 100% !important;
        max-height: 100% !important;

        object-fit: contain !important;
        object-position: center !important;
    }

    .viewer-content-panel {
        min-height: 0 !important;
        height: min(680px, calc(100dvh - 40px)) !important;

        padding: 24px !important;

        overflow-y: auto !important;
        overflow-x: hidden !important;

        overscroll-behavior: contain;
        scrollbar-gutter: stable;
    }

    .viewer-brand {
        padding-right: 44px !important;
        padding-bottom: 16px !important;
    }

    .viewer-brand img {
        width: 42px !important;
        height: 42px !important;
        flex-basis: 42px !important;
    }

    .viewer-copy {
        padding: 20px 0 !important;
    }

    .viewer-copy h3 {
        margin-bottom: 14px !important;
        font-size: clamp(23px, 2.5vw, 34px) !important;
    }

    .viewer-copy p {
        font-size: 13px !important;
        line-height: 1.75 !important;
    }

    /*
     * The New Arrivals viewer currently renders author/details into two <p>s.
     * Give each one a readable compact information treatment.
     */
    #arrivalViewer .viewer-copy p {
        padding: 11px 13px;
        margin: 0 0 10px !important;
        color: rgba(255, 255, 255, .82) !important;
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 11px;
        white-space: pre-line;
    }

    #arrivalViewer #arrivalViewerAuthor {
        color: #fff !important;
        font-weight: 700;
    }

    .viewer-footer {
        padding-top: 16px !important;
    }

    .viewer-close-button {
        top: 12px !important;
        right: 12px !important;
        width: 40px !important;
        height: 40px !important;
    }

    .viewer-navigation {
        width: 42px !important;
        height: 42px !important;
    }

    .viewer-previous {
        left: 12px !important;
    }

    /*
     * Anchor the right arrow at the image/content split rather than a
     * percentage derived from the previous oversized modal.
     */
    .viewer-next {
        right: calc(34.8% + 12px) !important;
    }

    /* =========================================================
       SHORT LAPTOP / DESKTOP VIEWPORTS
    ========================================================= */

    @media (min-width: 769px) and (max-height: 760px) {
        .library-update-viewer {
            padding: 12px !important;
        }

        .library-update-viewer-dialog {
            width: min(920px, calc(100vw - 24px)) !important;
            max-height: calc(100dvh - 24px) !important;
            grid-template-columns: minmax(0, 1.08fr) minmax(300px, .92fr) !important;
        }

        .viewer-image-panel,
        .viewer-content-panel {
            height: calc(100dvh - 24px) !important;
        }

        .viewer-image-panel {
            padding: 14px !important;
        }

        .viewer-content-panel {
            padding: 20px !important;
        }

        .viewer-copy {
            padding: 16px 0 !important;
        }

        .viewer-copy h3 {
            font-size: 26px !important;
        }

        .viewer-copy p {
            font-size: 12px !important;
            line-height: 1.65 !important;
        }

        .viewer-next {
            right: calc(46.5% + 10px) !important;
        }

        #eventDetailsModal .event-modal {
            max-height: calc(100dvh - 36px);
        }

        #eventDetailsModal .modal-body {
            max-height: calc(100dvh - 190px);
        }
    }

    /* =========================================================
       TABLET
    ========================================================= */

    @media (max-width: 768px) {
        .library-update-viewer {
            padding: 10px !important;
            align-items: center !important;
        }

        .library-update-viewer-dialog {
            width: min(640px, 100%) !important;
            max-height: calc(100dvh - 20px) !important;

            display: grid !important;
            grid-template-columns: 1fr !important;
            grid-template-rows: minmax(240px, 44vh) minmax(0, 1fr) !important;

            border-radius: 18px !important;
        }

        .viewer-image-panel {
            width: 100% !important;
            height: 44vh !important;
            max-height: 380px !important;
            min-height: 220px !important;
            padding: 12px !important;
        }

        .viewer-content-panel {
            width: 100% !important;
            height: auto !important;
            max-height: calc(56dvh - 20px) !important;
            padding: 20px 18px 22px !important;
        }

        .viewer-navigation {
            top: 22vh !important;
        }

        .viewer-previous {
            left: 10px !important;
        }

        .viewer-next {
            right: 10px !important;
        }

        #eventDetailsModal {
            padding: 10px !important;
        }

        #eventDetailsModal .modal-dialog {
            min-height: calc(100% - 20px);
            margin: 10px auto !important;
        }

        #eventDetailsModal .event-modal {
            max-height: calc(100dvh - 20px);
            border-radius: 17px;
        }

        #eventDetailsModal .modal-body {
            max-height: calc(100dvh - 190px);
            padding: 20px;
        }
    }

    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 575.98px) {
        .library-update-viewer {
            padding: 8px !important;
            align-items: flex-end !important;
        }

        .library-update-viewer-dialog {
            width: 100% !important;
            max-height: calc(100dvh - 16px) !important;

            grid-template-rows: minmax(210px, 38vh) minmax(0, 1fr) !important;

            border: 1px solid rgba(255, 255, 255, .12) !important;
            border-radius: 18px !important;
        }

        .viewer-image-panel {
            height: 38vh !important;
            min-height: 200px !important;
            max-height: 320px !important;
            padding: 10px !important;
        }

        .viewer-content-panel {
            max-height: calc(62dvh - 16px) !important;
            padding: 17px 15px 20px !important;
        }

        .viewer-brand {
            gap: 9px !important;
            padding-right: 42px !important;
            padding-bottom: 13px !important;
        }

        .viewer-brand img {
            width: 36px !important;
            height: 36px !important;
            flex-basis: 36px !important;
        }

        .viewer-brand strong {
            font-size: 11px !important;
        }

        .viewer-copy {
            padding: 16px 0 !important;
        }

        .viewer-copy h3 {
            font-size: 22px !important;
            line-height: 1.2 !important;
        }

        .viewer-copy p {
            font-size: 12px !important;
            line-height: 1.65 !important;
        }

        .viewer-close-button {
            top: 8px !important;
            right: 8px !important;
            width: 38px !important;
            height: 38px !important;
        }

        .viewer-navigation {
            top: 19vh !important;
            width: 38px !important;
            height: 38px !important;
        }

        #eventDetailsModal .modal-header {
            padding: 18px 18px 15px;
        }

        #eventDetailsModal .modal-body {
            padding: 18px;
        }

        #eventDetailsModal .event-information {
            grid-template-columns: 1fr;
        }

        #eventDetailsModal .modal-footer {
            padding: 12px 16px;
        }

        #eventDetailsModal .modal-close-button {
            width: 100%;
        }
    }

    /* Tiny-height mobile landscape */
    @media (max-height: 520px) and (max-width: 900px) {
        .library-update-viewer {
            align-items: center !important;
        }

        .library-update-viewer-dialog {
            grid-template-columns: minmax(0, 1fr) minmax(260px, .8fr) !important;
            grid-template-rows: 1fr !important;
            max-height: calc(100dvh - 16px) !important;
        }

        .viewer-image-panel,
        .viewer-content-panel {
            height: calc(100dvh - 16px) !important;
            max-height: none !important;
            min-height: 0 !important;
        }

    .viewer-navigation {
    }

    .viewer-next {
        right: 12px !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    /*
     * Bootstrap modals normally work inside body-level content. Because this
     * page is rendered inside <main>, move the event modal to <body> after
     * load. This guarantees correct backdrop stacking and viewport positioning.
     */
    const eventModal = document.getElementById('eventDetailsModal');

    if (eventModal && eventModal.parentElement !== document.body) {
        document.body.appendChild(eventModal);
    }

    /*
     * Do the same for the two custom fixed viewers. This makes them independent
     * of any future transformed/overflow-hidden page containers.
     */
    ['libraryUpdateViewer', 'arrivalViewer'].forEach(function (id) {
        const viewer = document.getElementById(id);

        if (viewer && viewer.parentElement !== document.body) {
            document.body.appendChild(viewer);
        }
    });
});
</script>



<!-- =========================================================
     EVENT MODAL VISUAL POLISH
     Compact, balanced, desktop/mobile friendly.
========================================================= -->
<style>
    #eventDetailsModal {
        --event-modal-navy: #0b2e59;
        --event-modal-blue: #184b8c;
        --event-modal-gold: #f4b400;
        --event-modal-text: #26384d;
        --event-modal-muted: #6c7a89;
        --event-modal-line: #e3e9f1;
        --event-modal-soft: #f6f8fb;
    }

    #eventDetailsModal .modal-dialog {
        width: min(520px, calc(100vw - 28px)) !important;
        max-width: 520px !important;
        min-height: 100% !important;
        margin: 0 auto !important;
        padding: 18px 0 !important;
        display: flex !important;
        align-items: center !important;
    }

    #eventDetailsModal .event-modal {
        width: 100% !important;
        max-height: calc(100dvh - 36px) !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
        background: #fff !important;
        border: 1px solid rgba(11, 46, 89, .08) !important;
        border-radius: 18px !important;
        box-shadow: 0 24px 70px rgba(0, 0, 0, .24) !important;
    }

    #eventDetailsModal .modal-header {
        position: relative !important;
        min-height: 88px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 18px !important;
        padding: 20px 22px !important;
        color: #fff !important;
        background:
            radial-gradient(circle at 100% 0, rgba(244, 180, 0, .13), transparent 34%),
            linear-gradient(135deg, #0b2e59 0%, #184b8c 100%) !important;
        border: 0 !important;
    }

    #eventDetailsModal .modal-header > div {
        min-width: 0 !important;
    }

    #eventDetailsModal .modal-header > div > span {
        display: block !important;
        margin: 0 0 4px !important;
        color: var(--event-modal-gold) !important;
        font-size: 9px !important;
        font-weight: 800 !important;
        letter-spacing: .11em !important;
        line-height: 1.2 !important;
        text-transform: uppercase !important;
    }

    #eventDetailsModal .modal-title {
        margin: 0 !important;
        color: #fff !important;
        font-size: 21px !important;
        font-weight: 800 !important;
        line-height: 1.2 !important;
        letter-spacing: -.02em !important;
    }

    #eventDetailsModal .btn-close {
        position: static !important;
        inset: auto !important;
        width: 38px !important;
        height: 38px !important;
        flex: 0 0 38px !important;
        margin: 0 !important;
        padding: 0 !important;
        background-color: rgba(255, 255, 255, .96) !important;
        background-size: 12px !important;
        border: 1px solid rgba(255, 255, 255, .45) !important;
        border-radius: 10px !important;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .12) !important;
        opacity: 1 !important;
        transition: transform .2s ease, background-color .2s ease !important;
    }

    #eventDetailsModal .btn-close:hover {
        transform: scale(1.05) !important;
        background-color: #fff !important;
    }

    #eventDetailsModal .modal-body {
        flex: 1 1 auto !important;
        max-height: none !important;
        padding: 22px !important;
        overflow-y: auto !important;
        background: #fff !important;
        scrollbar-width: thin !important;
        overscroll-behavior: contain !important;
    }

    #eventDetailsModal .modal-body > h4 {
        margin: 0 0 18px !important;
        color: var(--event-modal-navy) !important;
        font-size: clamp(22px, 4vw, 28px) !important;
        font-weight: 800 !important;
        line-height: 1.25 !important;
        letter-spacing: -.025em !important;
        overflow-wrap: anywhere !important;
    }

    /*
     * One-column information rows are deliberate:
     * event dates can be long, so this avoids the awkward wrapping shown
     * in the previous two-column layout.
     */
    #eventDetailsModal .event-information {
        display: grid !important;
        grid-template-columns: 1fr !important;
        gap: 9px !important;
        margin: 0 0 16px !important;
    }

    #eventDetailsModal .event-information > div {
        display: grid !important;
        grid-template-columns: 92px minmax(0, 1fr) !important;
        align-items: start !important;
        gap: 12px !important;
        min-width: 0 !important;
        padding: 12px 14px !important;
        background: var(--event-modal-soft) !important;
        border: 1px solid var(--event-modal-line) !important;
        border-radius: 11px !important;
    }

    #eventDetailsModal .event-information dt {
        margin: 1px 0 0 !important;
        color: #8491a2 !important;
        font-size: 9px !important;
        font-weight: 800 !important;
        letter-spacing: .07em !important;
        line-height: 1.45 !important;
        text-transform: uppercase !important;
    }

    #eventDetailsModal .event-information dd {
        margin: 0 !important;
        color: var(--event-modal-navy) !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        line-height: 1.55 !important;
        overflow-wrap: anywhere !important;
    }

    #eventDetailsModal .event-description {
        padding: 14px 15px !important;
        background: #fffaf0 !important;
        border: 1px solid rgba(244, 180, 0, .42) !important;
        border-radius: 11px !important;
    }

    #eventDetailsModal .event-description > span {
        display: block !important;
        margin-bottom: 6px !important;
        color: #785800 !important;
        font-size: 9px !important;
        font-weight: 800 !important;
        letter-spacing: .07em !important;
        text-transform: uppercase !important;
    }

    #eventDetailsModal .event-description p {
        margin: 0 !important;
        color: #59687c !important;
        font-size: 12.5px !important;
        line-height: 1.72 !important;
        white-space: pre-line !important;
        overflow-wrap: anywhere !important;
    }

    #eventDetailsModal .modal-footer {
        flex: 0 0 auto !important;
        justify-content: flex-end !important;
        padding: 13px 18px !important;
        background: #f8fafc !important;
        border-top: 1px solid var(--event-modal-line) !important;
    }

    #eventDetailsModal .modal-close-button {
        min-width: 92px !important;
        padding: 10px 17px !important;
        color: #fff !important;
        background: var(--event-modal-navy) !important;
        border: 0 !important;
        border-radius: 9px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        box-shadow: none !important;
    }

    #eventDetailsModal .modal-close-button:hover {
        color: #fff !important;
        background: var(--event-modal-blue) !important;
        transform: translateY(-1px) !important;
    }

    @media (max-width: 575.98px) {
        #eventDetailsModal {
            padding: 8px !important;
        }

        #eventDetailsModal .modal-dialog {
            width: 100% !important;
            min-height: 100% !important;
            padding: 8px 0 !important;
        }

        #eventDetailsModal .event-modal {
            max-height: calc(100dvh - 16px) !important;
            border-radius: 16px !important;
        }

        #eventDetailsModal .modal-header {
            min-height: 76px !important;
            padding: 16px 17px !important;
        }

        #eventDetailsModal .modal-title {
            font-size: 19px !important;
        }

        #eventDetailsModal .btn-close {
            width: 36px !important;
            height: 36px !important;
            flex-basis: 36px !important;
        }

        #eventDetailsModal .modal-body {
            padding: 18px 16px !important;
        }

        #eventDetailsModal .modal-body > h4 {
            margin-bottom: 15px !important;
            font-size: 22px !important;
        }

        #eventDetailsModal .event-information > div {
            grid-template-columns: 1fr !important;
            gap: 4px !important;
            padding: 11px 12px !important;
        }

        #eventDetailsModal .modal-footer {
            padding: 11px 14px !important;
        }

        #eventDetailsModal .modal-close-button {
            width: 100% !important;
        }
    }

    @media (max-height: 620px) and (min-width: 576px) {
        #eventDetailsModal .modal-dialog {
            padding: 10px 0 !important;
        }

        #eventDetailsModal .event-modal {
            max-height: calc(100dvh - 20px) !important;
        }

        #eventDetailsModal .modal-header {
            min-height: 72px !important;
            padding: 14px 18px !important;
        }

        #eventDetailsModal .modal-body {
            padding: 17px 20px !important;
        }

        #eventDetailsModal .modal-body > h4 {
            margin-bottom: 13px !important;
            font-size: 23px !important;
        }

        #eventDetailsModal .event-information {
            margin-bottom: 12px !important;
        }

        #eventDetailsModal .event-information > div {
            padding: 9px 12px !important;
        }

        #eventDetailsModal .event-description {
            padding: 11px 13px !important;
        }

        #eventDetailsModal .modal-footer {
            padding: 10px 16px !important;
        }
    }
</style>



<style>
/* =========================================================
   NEW ARRIVALS VIEWER — DISTINCT BOOK INFORMATION
========================================================= */

#arrivalViewer .arrival-viewer-copy {
    padding: 28px 0 !important;
}

#arrivalViewer .arrival-viewer-copy > h3 {
    margin-bottom: 18px !important;
}

#arrivalViewer .arrival-viewer-field,
#arrivalViewer .arrival-viewer-description {
    min-width: 0;
    padding: 13px 15px;
    background: rgba(255, 255, 255, .075);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 13px;
}

#arrivalViewer .arrival-viewer-author-field {
    margin-bottom: 11px;
}

#arrivalViewer .arrival-viewer-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 11px;
    margin-bottom: 11px;
}

#arrivalViewer .arrival-viewer-field-label {
    display: block;
    margin-bottom: 5px;
    color: rgba(255, 255, 255, .56);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: .065em;
    line-height: 1.3;
    text-transform: uppercase;
}

#arrivalViewer .arrival-viewer-field strong {
    display: block;
    color: #fff;
    font-size: 13px;
    font-weight: 800;
    line-height: 1.45;
    overflow-wrap: anywhere;
}

#arrivalViewer .arrival-viewer-description {
    margin-top: 0;
}

#arrivalViewer .arrival-viewer-description p {
    margin: 0 !important;
    color: rgba(255, 255, 255, .78) !important;
    font-size: 12px !important;
    line-height: 1.7 !important;
    white-space: normal !important;
    overflow-wrap: anywhere;
}

#arrivalViewer .arrival-viewer-optional[hidden] {
    display: none !important;
}

@media (max-width: 767.98px) {
    #arrivalViewer .arrival-viewer-meta-grid {
        grid-template-columns: 1fr;
    }

    #arrivalViewer .arrival-viewer-field,
    #arrivalViewer .arrival-viewer-description {
        padding: 12px 13px;
    }
}
</style>

@include('components.lisa-chatbox')

@endsection
