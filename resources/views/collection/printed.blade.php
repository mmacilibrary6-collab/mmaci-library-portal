@extends('layouts.app')

@section('title', 'Printed Collection | MMACI Library Services Office')

@section('content')

<!-- ================= HERO ================= -->

<section class="collection-hero">

    <div class="collection-hero-overlay"></div>

    <div class="container position-relative">

        <div class="collection-hero-content">

            <h1>
                Printed Collection
            </h1>

            <p>
                Explore the printed books, journals, references, and academic
                resources available at the MMACI Library Services Office.
            </p>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb mb-0">

                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            Home
                        </a>
                    </li>

                    <li class="breadcrumb-item active"
                        aria-current="page">
                        Printed Collection
                    </li>

                </ol>

            </nav>

        </div>

    </div>

</section>

<!-- ================= INTRODUCTION ================= -->

<section class="collection-introduction">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-9 text-center">

                <span class="section-label">
                    Browse Our Resources
                </span>

                <h2 class="section-title">
                    Discover Our Printed Materials
                </h2>

                <p class="section-description">
                    Our printed collection is organized according to academic
                    disciplines and resource types, making it easier for
                    students, faculty, researchers, and visitors to locate
                    relevant learning materials.
                </p>

            </div>

        </div>

    </div>

</section>

<!-- ================= SEARCH ================= -->

<section class="collection-search-section">

    <div class="container">

        <div class="collection-search-box">

            <div class="row align-items-center g-3">

                <div class="col-lg-8">

                    <div class="search-input-wrapper">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="collectionSearch"
                            class="form-control"
                            placeholder="Search printed collection..."
                            aria-label="Search printed collection">

                    </div>

                </div>

                <div class="col-lg-4">

                    <select
                        id="collectionFilter"
                        class="form-select"
                        aria-label="Filter collection">

                        <option value="all">
                            All Collections
                        </option>

                        <option value="academic">
                            Academic Collections
                        </option>

                        <option value="general">
                            General Collections
                        </option>

                        <option value="special">
                            Special Resources
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= COLLECTION CARDS ================= -->

<section class="collection-grid-section">

    <div class="container">

        @php
            $collections = [
                [
                    'title' => 'College of Criminology Collection',
                    'category' => 'academic',
                    'description' => 'Resources covering criminology, criminal justice, law enforcement, and public safety.',
                    'icon' => 'bi-shield-check',
                    'image' => asset('images/criminology.png')
                ],
                [
                    'title' => 'College of Maritime Education Collection',
                    'category' => 'academic',
                    'description' => 'Printed materials for navigation, marine engineering, seamanship, and maritime studies.',
                    'icon' => 'bi-water',
                    'image' => asset('images/maritime.png')
                ],
                [
                    'title' => 'Bachelor of Library and Information Science',
                    'category' => 'academic',
                    'description' => 'Books and references on librarianship, information organization, cataloging, archives, and library management.',
                    'icon' => 'bi-book-fill',
                    'image' => asset('images/BLIS.jpg')
                ],
                [
                    'title' => 'Bachelor of Science in Psychology',
                    'category' => 'academic',
                    'description' => 'Learning resources covering human behavior, cognition, development, counseling, and psychological research.',
                    'icon' => 'bi-person-hearts',
                    'image' => asset('images/BSPSYCH.jpg')
                ],
                [
                    'title' => 'Bachelor of Science in Information Systems',
                    'category' => 'academic',
                    'description' => 'Books and references on information systems, programming, databases, business processes, and technology.',
                    'icon' => 'bi-pc-display-horizontal',
                    'image' => asset('images/BSIS.jpg')
                ],
                [
                    'title' => 'Bachelor of Science in Public Administration',
                    'category' => 'academic',
                    'description' => 'Resources on public governance, policy, administrative systems, leadership, and public service.',
                    'icon' => 'bi-building',
                    'image' => asset('images/BPA.jpg')
                ],
                [
                    'title' => 'Bachelor of Science in Tourism Management',
                    'category' => 'academic',
                    'description' => 'References covering tourism planning, hospitality, travel operations, destinations, and sustainable tourism.',
                    'icon' => 'bi-airplane-fill',
                    'image' => asset('images/BSTM.jpg')
                ],
                [
                    'title' => 'Bachelor of Science in Entrepreneurship',
                    'category' => 'academic',
                    'description' => 'Books on business planning, innovation, marketing, finance, enterprise development, and management.',
                    'icon' => 'bi-briefcase-fill',
                    'image' => asset('images/BSENTREP.jpg')
                ],
                [
                    'title' => 'Bachelor of Physical Education',
                    'category' => 'academic',
                    'description' => 'Learning materials on physical fitness, sports science, coaching, movement, health, and teaching methods.',
                    'icon' => 'bi-trophy-fill',
                    'image' => asset('images/BPED.jpg')
                ],
                [
                    'title' => 'Bachelor of Technical-Vocational Teacher Education',
                    'category' => 'academic',
                    'description' => 'Resources for technical-vocational instruction, curriculum development, assessment, and teaching practice.',
                    'icon' => 'bi-tools',
                    'image' => asset('images/BTVTED.jpg')
                ],
                [
                    'title' => 'Fiction Collection',
                    'category' => 'general',
                    'description' => 'Novels, short stories, literary classics, and contemporary works for recreational reading.',
                    'icon' => 'bi-book-half',
                    'image' => asset('images/Fiction.png')
                ],
                [
                    'title' => 'General Education – Filipiniana',
                    'category' => 'general',
                    'description' => 'Books and references about Philippine history, literature, culture, society, and national identity.',
                    'icon' => 'bi-map-fill',
                    'image' => asset('images/Filipiniana.png')
                ],
                [
                    'title' => 'General Education – Foreign Collection',
                    'category' => 'general',
                    'description' => 'Foreign-authored academic resources covering a broad range of general education subjects.',
                    'icon' => 'bi-globe2',
                    'image' => asset('images/foreign.png')
                ],
                [
                    'title' => 'Journals and Periodicals',
                    'category' => 'special',
                    'description' => 'Academic journals, magazines, newsletters, and periodicals for study and research.',
                    'icon' => 'bi-journal-richtext',
                    'image' => asset('images/journals.png')
                ],
                [
                    'title' => 'Special Collection',
                    'category' => 'special',
                    'description' => 'Specialized materials, institutional publications, rare resources, and archival references.',
                    'icon' => 'bi-collection-fill',
                    'image' => asset('images/specialcol.png')
                ],
                [
                    'title' => 'New Arrivals',  
                    'category' => 'special',
                    'description' => 'Recently acquired books and printed materials added to the library collection.',
                    'icon' => 'bi-stars',
                    'image' => asset('images/newa.png'),
                    'is_new_arrivals' => true
                ]
            ];
        @endphp

        <div class="row g-4"
             id="collectionGrid">

            @foreach ($collections as $collection)

                <div class="col-xl-4 col-md-6 collection-item"
                     data-title="{{ strtolower($collection['title']) }}"
                     data-category="{{ $collection['category'] }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ ($loop->index % 3) * 100 }}">

                    <article class="collection-card">

                        <div class="collection-image-wrapper">

                            <img
                                src="{{ $collection['image'] }}"
                                class="collection-image"
                                alt="{{ $collection['title'] }}"
                                loading="lazy">

                            <div class="collection-image-overlay"></div>

                            <div class="collection-icon">

                                <i class="bi {{ $collection['icon'] }}"></i>

                            </div>

                            <span class="collection-number">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>

                        </div>

                        <div class="collection-card-body">

                            <h3>
                                {{ $collection['title'] }}
                            </h3>

                            <p>
                                {{ $collection['description'] }}
                            </p>

                            @if ($collection['is_new_arrivals'] ?? false)

                                <button
                                    type="button"
                                    class="collection-link"
                                    data-bs-toggle="modal"
                                    data-bs-target="#newArrivalsModal">

                                    View Collection

                                    <i class="bi bi-arrow-right"></i>

                                </button>

                            @else

                                <button
                                    type="button"
                                    class="collection-link"
                                    data-bs-toggle="modal"
                                    data-bs-target="#collectionModal"
                                    data-collection-title="{{ $collection['title'] }}"
                                    data-collection-description="{{ $collection['description'] }}"
                                    data-collection-image="{{ $collection['image'] }}">

                                    View Collection

                                    <i class="bi bi-arrow-right"></i>

                                </button>

                            @endif

                        </div>

                    </article>

                </div>

            @endforeach

        </div>

        <!-- No Search Result -->

        <div class="no-results"
             id="noResults">

            <div class="no-results-icon">
                <i class="bi bi-search"></i>
            </div>

            <h3>
                No collection found
            </h3>

            <p>
                Try using a different search term or collection category.
            </p>

        </div>

    </div>

</section>

<!-- ================= INFORMATION SECTION ================= -->

<section class="collection-information">

    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-6"
                 data-aos="fade-right">

                <span class="section-label">
                    Using the Collection
                </span>

                <h2 class="section-title text-start">
                    Find the Resources You Need
                </h2>

                <p class="information-description">
                    Library users may browse the shelves, consult the library
                    staff, or use the library catalog to locate printed
                    materials. Borrowing privileges and usage policies may
                    depend on the type of resource and user classification.
                </p>

                <a href="{{ route('more.ask-librarian') }}"
                   class="btn btn-warning rounded-pill px-4 py-3 fw-semibold">

                    <i class="bi bi-chat-left-text-fill me-2"></i>

                    Ask the Librarian

                </a>

            </div>

            <div class="col-lg-6"
                 data-aos="fade-left">

                <div class="information-list">

                    <div class="information-item">

                        <div class="information-icon">
                            <i class="bi bi-search"></i>
                        </div>

                        <div>

                            <h4>
                                Locate Materials
                            </h4>

                            <p>
                                Search by title, author, subject, or collection
                                category.
                            </p>

                        </div>

                    </div>

                    <div class="information-item">

                        <div class="information-icon">
                            <i class="bi bi-person-check-fill"></i>
                        </div>

                        <div>

                            <h4>
                                Request Assistance
                            </h4>

                            <p>
                                Consult library personnel when locating specific
                                books or references.
                            </p>

                        </div>

                    </div>

                    <div class="information-item">

                        <div class="information-icon">
                            <i class="bi bi-bookmark-check-fill"></i>
                        </div>

                        <div>

                            <h4>
                                Borrow Resources
                            </h4>

                            <p>
                                Present your valid identification and follow the
                                applicable borrowing policy.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= CALL TO ACTION ================= -->

<section class="collection-cta">

    <div class="container">

        <div class="collection-cta-box">

            <div>

                <span>
                    Need help finding a resource?
                </span>

                <h2>
                    Let our library staff assist you.
                </h2>

            </div>

            <a href="{{ route('more.ask-librarian') }}"
               class="btn btn-light rounded-pill px-4 py-3 fw-semibold">

                Contact a Librarian

                <i class="bi bi-arrow-right ms-2"></i>

            </a>

        </div>

    </div>

</section>

<!-- ================= COLLECTION MODAL ================= -->

<div class="modal fade"
     id="collectionModal"
     tabindex="-1"
     aria-labelledby="collectionModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content collection-modal">

            <button
                type="button"
                class="btn-close modal-close"
                data-bs-dismiss="modal"
                aria-label="Close">
            </button>

            <img
                src=""
                id="modalCollectionImage"
                class="modal-collection-image"
                alt="Collection preview">

            <div class="modal-body p-4 p-md-5">

                <span class="section-label">
                    Printed Collection
                </span>

                <h2 id="modalCollectionTitle"
                    class="mt-3">
                </h2>

                <p id="modalCollectionDescription"
                   class="mb-0">
                </p>

            </div>

        </div>

    </div>

</div>

<!-- ================= NEW ARRIVALS MODAL ================= -->

@php
    $arrivalItems = $newArrivals ?? collect();
@endphp

<div class="modal fade"
     id="newArrivalsModal"
     tabindex="-1"
     aria-labelledby="newArrivalsModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">

        <div class="modal-content new-arrivals-modal">

            <div class="modal-header new-arrivals-modal-header">

                <div>

                    <span class="new-arrivals-modal-label">
                        Recently Acquired
                    </span>

                    <h2 class="modal-title"
                        id="newArrivalsModalLabel">
                        New Arrivals
                    </h2>

                    <p>
                        Newly added printed books and learning materials.
                    </p>

                </div>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body new-arrivals-modal-body">

                @if ($arrivalItems->isNotEmpty())

                    <div class="new-arrivals-grid">

                        @foreach ($arrivalItems as $arrival)

                            @php
                                $arrivalCover = $arrival->image_url;

                                $arrivalDate = filled($arrival->arrival_date)
                                    ? \Illuminate\Support\Carbon::parse(
                                        $arrival->arrival_date
                                    )->format('F d, Y')
                                    : 'Not specified';
                            @endphp

                            <article class="new-arrival-card">

                                <div class="new-arrival-cover-wrapper">

                                    <img
                                        src="{{ $arrivalCover }}"
                                        alt="{{ $arrival->title }}"
                                        class="new-arrival-cover"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ asset('images/readingarea.jpg') }}';">

                                    <span class="new-arrival-badge">
                                        New
                                    </span>

                                </div>

                                <div class="new-arrival-card-body">

                                    @if (filled($arrival->category))

                                        <span class="new-arrival-category">
                                            {{ $arrival->category }}
                                        </span>

                                    @endif

                                    <h3>
                                        {{ $arrival->title }}
                                    </h3>

                                    <div class="new-arrival-meta">

                                        <div>
                                            <i class="bi bi-person"></i>

                                            <span>
                                                Author
                                            </span>

                                            <strong>
                                                {{ filled($arrival->author)
                                                    ? $arrival->author
                                                    : 'None' }}
                                            </strong>
                                        </div>

                                        <div>
                                            <i class="bi bi-calendar-check"></i>

                                            <span>
                                                Date of Arrival
                                            </span>

                                            <strong>
                                                {{ $arrivalDate }}
                                            </strong>
                                        </div>

                                    </div>

                                    @if (filled($arrival->description))

                                        <p class="new-arrival-description">
                                            {{ \Illuminate\Support\Str::limit(
                                                $arrival->description,
                                                100
                                            ) }}
                                        </p>

                                    @endif

                                </div>

                            </article>

                        @endforeach

                    </div>

                @else

                    <div class="new-arrivals-empty">

                        <i class="bi bi-journal-x"></i>

                        <h3>No New Arrivals Yet</h3>

                        <p>
                            Newly added printed materials will appear here.
                        </p>

                    </div>

                @endif

            </div>

            <div class="modal-footer">

                <span class="new-arrivals-total">
                    {{ $arrivalItems->count() }}
                    {{ \Illuminate\Support\Str::plural(
                        'material',
                        $arrivalItems->count()
                    ) }}
                </span>

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Close
                </button>

            </div>

        </div>

    </div>

</div>

<style>

:root {
    --mmaci-navy: #0B2E59;
    --mmaci-blue: #184B8C;
    --mmaci-yellow: #F4B400;
    --mmaci-light: #F4F7FC;
    --mmaci-text: #5B6472;
}

/* Hero */

.collection-hero {
    position: relative;
    min-height: 390px;
    display: flex;
    align-items: center;
    overflow: hidden;
    color: #ffffff;
    background:
        linear-gradient(90deg, rgba(6, 31, 64, 0.96) 0%,
                              rgba(11, 46, 89, 0.86) 48%,
                              rgba(11, 46, 89, 0.55) 100%),
        url("{{ asset('images/librarycollect.jpg') }}");
    background-position: center;
    background-size: cover;
}

.collection-hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    background: var(--mmaci-yellow);
}

.collection-hero::after {
    content: "";
    position: absolute;
    right: -80px;
    bottom: -140px;
    width: 330px;
    height: 330px;
    border: 55px solid rgba(255, 255, 255, 0.045);
    border-radius: 50%;
}

.collection-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.04), rgba(0, 0, 0, 0.18));
}

.collection-hero-content {
    position: relative;
    z-index: 2;
    max-width: 760px;
    padding: 82px 0 68px;
}

.section-label {
    display: inline-block;
    color: var(--mmaci-navy);
    background: var(--mmaci-yellow);
    border-radius: 50px;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.collection-hero h1 {
    position: relative;
    margin: 0 0 22px;
    padding-bottom: 20px;
    font-size: clamp(44px, 5.5vw, 68px);
    font-weight: 800;
    line-height: 1.08;
    letter-spacing: -0.035em;
}

.collection-hero h1::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 72px;
    height: 5px;
    background: var(--mmaci-yellow);
    border-radius: 50px;
}

.collection-hero p {
    max-width: 650px;
    margin: 0 0 24px;
    color: rgba(255, 255, 255, 0.86);
    font-size: 17px;
    line-height: 1.75;
}

.collection-hero .breadcrumb-item,
.collection-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.65);
}

.collection-hero .breadcrumb-item a {
    color: var(--mmaci-yellow);
    text-decoration: none;
}

.collection-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.50);
}

/* General */

.collection-introduction {
    padding: 90px 0 45px;
    background: #ffffff;
}

.section-label {
    padding: 8px 18px;
}

.section-title {
    margin: 18px 0;
    color: var(--mmaci-navy);
    font-size: clamp(32px, 4vw, 48px);
    font-weight: 800;
}

.section-description {
    max-width: 820px;
    margin: auto;
    color: var(--mmaci-text);
    font-size: 17px;
    line-height: 1.9;
}

/* Search */

.collection-search-section {
    padding-bottom: 45px;
    background: #ffffff;
}

.collection-search-box {
    padding: 22px;
    background: #ffffff;
    border: 1px solid #E5EAF2;
    border-radius: 20px;
    box-shadow: 0 15px 45px rgba(11, 46, 89, 0.09);
}

.search-input-wrapper {
    position: relative;
}

.search-input-wrapper i {
    position: absolute;
    top: 50%;
    left: 20px;
    z-index: 2;
    color: var(--mmaci-blue);
    font-size: 18px;
    transform: translateY(-50%);
}

.search-input-wrapper .form-control {
    min-height: 56px;
    padding-left: 54px;
}

.collection-search-box .form-control,
.collection-search-box .form-select {
    min-height: 56px;
    color: var(--mmaci-navy);
    border: 1px solid #DDE4EF;
    border-radius: 13px;
    box-shadow: none;
}

.collection-search-box .form-control:focus,
.collection-search-box .form-select:focus {
    border-color: var(--mmaci-yellow);
    box-shadow: 0 0 0 4px rgba(244, 180, 0, 0.15);
}

/* Collection Grid */

.collection-grid-section {
    padding: 60px 0 100px;
    background: var(--mmaci-light);
}

.collection-card {
    height: 100%;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid rgba(11, 46, 89, 0.06);
    border-radius: 22px;
    box-shadow: 0 12px 35px rgba(11, 46, 89, 0.08);
    transition:
        transform 0.35s ease,
        box-shadow 0.35s ease;
}

.collection-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 22px 48px rgba(11, 46, 89, 0.16);
}

.collection-image-wrapper {
    position: relative;
    height: 270px;
    overflow: hidden;
}

.collection-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.collection-card:hover .collection-image {
    transform: scale(1.08);
}

.collection-image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        180deg,
        transparent 35%,
        rgba(11, 46, 89, 0.65)
    );
}

.collection-icon {
    position: absolute;
    bottom: 18px;
    left: 20px;
    width: 58px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--mmaci-navy);
    background: var(--mmaci-yellow);
    border: 4px solid rgba(255, 255, 255, 0.35);
    border-radius: 17px;
    font-size: 25px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.16);
}

.collection-number {
    position: absolute;
    top: 18px;
    right: 18px;
    padding: 7px 12px;
    color: #ffffff;
    background: rgba(11, 46, 89, 0.80);
    border: 1px solid rgba(255, 255, 255, 0.20);
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    backdrop-filter: blur(8px);
}

.collection-card-body {
    padding: 28px;
}

.collection-card-body h3 {
    min-height: 58px;
    margin-bottom: 13px;
    color: var(--mmaci-navy);
    font-size: 20px;
    font-weight: 750;
    line-height: 1.45;
}

.collection-card-body p {
    min-height: 82px;
    margin-bottom: 22px;
    color: var(--mmaci-text);
    font-size: 14px;
    line-height: 1.75;
}

.collection-link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 0;
    color: var(--mmaci-blue);
    background: transparent;
    border: 0;
    font-weight: 700;
    transition: gap 0.25s ease, color 0.25s ease;
}

.collection-link:hover {
    gap: 14px;
    color: var(--mmaci-navy);
}

.no-results {
    display: none;
    padding: 70px 20px;
    color: var(--mmaci-navy);
    text-align: center;
}

.no-results-icon {
    width: 90px;
    height: 90px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 22px;
    color: var(--mmaci-navy);
    background: rgba(244, 180, 0, 0.22);
    border-radius: 50%;
    font-size: 38px;
}

.no-results h3 {
    font-weight: 800;
}

.no-results p {
    color: var(--mmaci-text);
}

/* Information */

.collection-information {
    padding: 100px 0;
    background: #ffffff;
}

.information-description {
    margin-bottom: 30px;
    color: var(--mmaci-text);
    font-size: 16px;
    line-height: 1.9;
}

.information-list {
    padding: 35px;
    background: var(--mmaci-light);
    border-radius: 25px;
}

.information-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding-bottom: 25px;
    margin-bottom: 25px;
    border-bottom: 1px solid #DCE4EF;
}

.information-item:last-child {
    padding-bottom: 0;
    margin-bottom: 0;
    border-bottom: 0;
}

.information-icon {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--mmaci-navy);
    background: var(--mmaci-yellow);
    border-radius: 17px;
    font-size: 25px;
}

.information-item h4 {
    margin-bottom: 7px;
    color: var(--mmaci-navy);
    font-size: 18px;
    font-weight: 750;
}

.information-item p {
    margin: 0;
    color: var(--mmaci-text);
    line-height: 1.7;
}

/* CTA */

.collection-cta {
    padding: 0 0 90px;
    background: #ffffff;
}

.collection-cta-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
    padding: 50px;
    color: #ffffff;
    background:
        radial-gradient(
            circle at top right,
            rgba(244, 180, 0, 0.28),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            var(--mmaci-navy),
            var(--mmaci-blue)
        );
    border-radius: 28px;
    box-shadow: 0 20px 50px rgba(11, 46, 89, 0.20);
}

.collection-cta-box span {
    color: var(--mmaci-yellow);
    font-weight: 700;
}

.collection-cta-box h2 {
    margin: 8px 0 0;
    font-weight: 800;
}

/* Modal */

.collection-modal {
    overflow: hidden;
    border: 0;
    border-radius: 24px;
    box-shadow: 0 25px 70px rgba(11, 46, 89, 0.28);
}

.modal-close {
    position: absolute;
    top: 18px;
    right: 18px;
    z-index: 3;
    padding: 12px;
    background-color: #ffffff;
    border-radius: 50%;
    opacity: 1;
}

.modal-collection-image {
    width: 100%;
    height: 330px;
    object-fit: cover;
}

.collection-modal h2 {
    color: var(--mmaci-navy);
    font-weight: 800;
}

.collection-modal p {
    color: var(--mmaci-text);
    line-height: 1.8;
}

/* New Arrivals Modal */

.new-arrivals-modal {
    overflow: hidden;
    border: 0;
    border-radius: 24px;
    box-shadow: 0 25px 70px rgba(11, 46, 89, 0.28);
}

.new-arrivals-modal-header {
    align-items: flex-start;
    padding: 30px 34px;
    color: #ffffff;
    background:
        radial-gradient(
            circle at top right,
            rgba(244, 180, 0, 0.32),
            transparent 34%
        ),
        linear-gradient(
            135deg,
            var(--mmaci-navy),
            var(--mmaci-blue)
        );
    border: 0;
}

.new-arrivals-modal-label {
    display: inline-block;
    margin-bottom: 8px;
    color: var(--mmaci-yellow);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
}

.new-arrivals-modal-header h2 {
    margin-bottom: 6px;
    font-weight: 800;
}

.new-arrivals-modal-header p {
    margin: 0;
    color: rgba(255, 255, 255, 0.75);
}

.new-arrivals-modal-body {
    padding: 28px;
    background: #f4f7fc;
}

.new-arrivals-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 22px;
}

.new-arrival-card {
    min-width: 0;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #e2e8f1;
    border-radius: 18px;
    box-shadow: 0 10px 28px rgba(11, 46, 89, 0.08);
}

.new-arrival-cover-wrapper {
    position: relative;
    height: 260px;
    overflow: hidden;
    background: #e8edf5;
}

.new-arrival-cover {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: center;
}

.new-arrival-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    padding: 7px 12px;
    color: var(--mmaci-navy);
    background: var(--mmaci-yellow);
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.new-arrival-card-body {
    padding: 22px;
}

.new-arrival-category {
    display: inline-block;
    margin-bottom: 9px;
    color: var(--mmaci-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

.new-arrival-card h3 {
    margin-bottom: 18px;
    color: var(--mmaci-navy);
    font-size: 19px;
    font-weight: 800;
    line-height: 1.4;
}

.new-arrival-meta {
    display: grid;
    gap: 12px;
}

.new-arrival-meta > div {
    display: grid;
    grid-template-columns: 24px 1fr;
    column-gap: 8px;
    align-items: center;
}

.new-arrival-meta i {
    grid-row: 1 / span 2;
    color: var(--mmaci-blue);
    font-size: 17px;
}

.new-arrival-meta span {
    color: #7b8797;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.new-arrival-meta strong {
    min-width: 0;
    overflow-wrap: anywhere;
    color: var(--mmaci-navy);
    font-size: 14px;
}

.new-arrival-description {
    margin: 17px 0 0;
    padding-top: 15px;
    color: var(--mmaci-text);
    border-top: 1px solid #edf0f5;
    font-size: 13px;
    line-height: 1.65;
}

@media (max-width: 991.98px) {
    .new-arrivals-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575.98px) {
    .new-arrivals-modal-header {
        padding: 24px 20px;
    }

    .new-arrivals-modal-body {
        padding: 16px;
    }

    .new-arrivals-grid {
        grid-template-columns: 1fr;
    }

    .new-arrival-cover-wrapper {
        height: 290px;
    }
}

.new-arrivals-empty {
    padding: 70px 25px;
    color: var(--mmaci-text);
    text-align: center;
}

.new-arrivals-empty i {
    display: block;
    margin-bottom: 18px;
    color: var(--mmaci-blue);
    font-size: 52px;
}

.new-arrivals-empty h3 {
    color: var(--mmaci-navy);
    font-weight: 800;
}

.new-arrivals-total {
    margin-right: auto;
    color: var(--mmaci-text);
    font-size: 14px;
    font-weight: 700;
}

/* Responsive */

@media (max-width: 991.98px) {

    .collection-hero {
        min-height: 360px;
    }

    .collection-hero-content {
        padding: 72px 0 60px;
    }

    .collection-cta-box {
        flex-direction: column;
        align-items: flex-start;
    }

}

@media (max-width: 767.98px) {

    .collection-introduction {
        padding-top: 70px;
    }

    .collection-grid-section,
    .collection-information {
        padding: 70px 0;
    }

    .collection-image-wrapper {
        height: 240px;
    }

    .collection-card-body h3,
    .collection-card-body p {
        min-height: auto;
    }

    .collection-cta-box {
        padding: 35px 25px;
    }

    .information-list {
        padding: 25px 20px;
    }

}

@media (max-width: 575.98px) {

    .collection-hero h1 {
        font-size: 42px;
    }

    .collection-hero p {
        font-size: 15px;
        line-height: 1.65;
    }

    .collection-search-box {
        padding: 16px;
    }

    .collection-card-body {
        padding: 23px;
    }

    .information-item {
        gap: 14px;
    }

    .information-icon {
        width: 52px;
        height: 52px;
        font-size: 21px;
    }

}

/* =========================================================
   MODERN PRINTED COLLECTION REDESIGN
========================================================= */

body {
    background: #f7f9fc;
}

.collection-hero {
    min-height: 520px;
    isolation: isolate;
    background:
        linear-gradient(115deg, rgba(7, 31, 64, 0.97) 0%, rgba(11, 46, 89, 0.91) 48%, rgba(24, 75, 140, 0.76) 100%),
        url("{{ asset('images/librarycollect.jpg') }}") center 42% / cover no-repeat;
}

.collection-hero::before {
    top: auto;
    bottom: -170px;
    left: -110px;
    width: 390px;
    height: 390px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.035);
}

.collection-hero::after {
    top: -190px;
    right: -90px;
    bottom: auto;
    width: 420px;
    height: 420px;
    border: 78px solid rgba(244, 180, 0, 0.08);
}

.collection-hero-overlay {
    z-index: -1;
    background:
        radial-gradient(circle at 72% 35%, rgba(255, 255, 255, 0.09), transparent 25%),
        linear-gradient(180deg, transparent 55%, rgba(4, 22, 46, 0.22));
}

.collection-hero-content {
    max-width: 900px;
    margin: 0 auto;
    padding: 118px 0 105px;
    text-align: center;
}

.collection-hero h1 {
    margin: 0 0 22px;
    padding: 0;
    font-size: clamp(50px, 6.5vw, 84px);
    font-weight: 800;
    line-height: 1.02;
    letter-spacing: -0.045em;
    text-shadow: 0 12px 35px rgba(0, 0, 0, 0.18);
}

.collection-hero h1::after {
    display: none;
}

.collection-hero p {
    max-width: 660px;
    margin: 0 auto 30px;
    color: rgba(255, 255, 255, 0.79);
    font-size: 17px;
    line-height: 1.75;
}

.collection-hero .breadcrumb {
    display: inline-flex;
    justify-content: center;
    padding: 10px 18px;
    background: rgba(255, 255, 255, 0.09);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 999px;
    backdrop-filter: blur(12px);
}

.collection-hero .breadcrumb-item,
.collection-hero .breadcrumb-item.active {
    font-size: 14px;
}

.collection-hero .breadcrumb-item a {
    color: #ffd55a;
    font-weight: 700;
}

.collection-introduction {
    padding: 94px 0 42px;
    background: #ffffff;
}

.section-label {
    padding: 8px 14px;
    color: var(--mmaci-blue);
    background: rgba(24, 75, 140, 0.08);
    border: 1px solid rgba(24, 75, 140, 0.10);
    border-radius: 8px;
    font-size: 11px;
    letter-spacing: 0.12em;
}

.section-title {
    margin: 18px 0 16px;
    font-size: clamp(31px, 4vw, 46px);
    line-height: 1.16;
    letter-spacing: -0.03em;
}

.section-description {
    max-width: 720px;
    font-size: 16px;
    line-height: 1.8;
}

.collection-search-section {
    padding: 18px 0 58px;
}

.collection-search-box {
    max-width: 1050px;
    margin: 0 auto;
    padding: 12px;
    border: 1px solid rgba(11, 46, 89, 0.09);
    border-radius: 16px;
    box-shadow: 0 18px 50px rgba(11, 46, 89, 0.10);
}

.collection-search-box .form-control,
.collection-search-box .form-select {
    min-height: 60px;
    border: 0;
    border-radius: 11px;
    background-color: #f6f8fc;
    font-size: 15px;
}

.collection-search-box .form-control:focus,
.collection-search-box .form-select:focus {
    background: #ffffff;
    box-shadow: inset 0 0 0 2px rgba(244, 180, 0, 0.75);
}

.collection-grid-section {
    padding: 80px 0 110px;
    background: #f5f7fb;
}

.collection-grid-section .row {
    --bs-gutter-x: 1.7rem;
    --bs-gutter-y: 1.7rem;
}

.collection-card {
    position: relative;
    border: 1px solid #e6ebf2;
    border-radius: 16px;
    box-shadow: 0 8px 26px rgba(11, 46, 89, 0.065);
    transition: transform 0.28s ease, border-color 0.28s ease, box-shadow 0.28s ease;
}

.collection-card:hover {
    transform: translateY(-6px);
    border-color: rgba(24, 75, 140, 0.18);
    box-shadow: 0 20px 42px rgba(11, 46, 89, 0.13);
}

.collection-image-wrapper {
    height: 235px;
}

.collection-image-overlay {
    background: linear-gradient(180deg, transparent 45%, rgba(6, 31, 64, 0.76));
}

.collection-card:hover .collection-image {
    transform: scale(1.045);
}

.collection-icon {
    bottom: 16px;
    left: 18px;
    width: 48px;
    height: 48px;
    color: #ffffff;
    background: rgba(255, 255, 255, 0.16);
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 12px;
    font-size: 21px;
    box-shadow: none;
    backdrop-filter: blur(12px);
}

.collection-number {
    display: none;
}

.collection-card-body {
    display: flex;
    min-height: 245px;
    flex-direction: column;
    padding: 25px 25px 23px;
}

.collection-card-body h3 {
    min-height: auto;
    margin-bottom: 11px;
    font-size: 19px;
    font-weight: 750;
    line-height: 1.4;
    letter-spacing: -0.015em;
}

.collection-card-body p {
    min-height: auto;
    margin-bottom: 21px;
    color: #687386;
    font-size: 14px;
    line-height: 1.68;
}

.collection-link {
    width: 100%;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 17px;
    border-top: 1px solid #edf0f5;
    font-size: 14px;
}

.collection-link:hover {
    gap: 9px;
    color: var(--mmaci-blue);
}

.collection-information {
    padding: 110px 0;
    overflow: hidden;
}

.collection-information .section-title {
    max-width: 560px;
}

.information-description {
    max-width: 590px;
    color: #687386;
    line-height: 1.8;
}

.collection-information .btn-warning {
    color: var(--mmaci-navy);
    border: 0;
    background: var(--mmaci-yellow);
    box-shadow: 0 10px 24px rgba(244, 180, 0, 0.22);
}

.information-list {
    position: relative;
    padding: 14px 34px;
    background: #f6f8fc;
    border: 1px solid #e6ebf2;
    border-radius: 18px;
}

.information-list::before {
    content: "";
    position: absolute;
    top: 24px;
    bottom: 24px;
    left: 0;
    width: 4px;
    background: var(--mmaci-yellow);
    border-radius: 0 8px 8px 0;
}

.information-item {
    gap: 18px;
    padding: 24px 0;
    margin: 0;
    border-bottom-color: #e1e6ef;
}

.information-icon {
    width: 48px;
    height: 48px;
    color: var(--mmaci-blue);
    background: #ffffff;
    border: 1px solid #e0e6ef;
    border-radius: 12px;
    font-size: 20px;
    box-shadow: 0 7px 18px rgba(11, 46, 89, 0.07);
}

.information-item h4 {
    margin-bottom: 5px;
    font-size: 17px;
}

.information-item p {
    color: #6c7687;
    font-size: 14px;
}

.collection-cta {
    padding: 0 0 100px;
}

.collection-cta-box {
    position: relative;
    overflow: hidden;
    padding: 46px 50px;
    background: linear-gradient(120deg, #08274d, var(--mmaci-navy) 56%, var(--mmaci-blue));
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 18px;
    box-shadow: 0 22px 55px rgba(11, 46, 89, 0.20);
}

.collection-cta-box::after {
    content: "";
    position: absolute;
    top: -110px;
    right: 15%;
    width: 260px;
    height: 260px;
    border: 48px solid rgba(244, 180, 0, 0.08);
    border-radius: 50%;
}

.collection-cta-box > * {
    position: relative;
    z-index: 1;
}

.collection-cta-box span {
    font-size: 13px;
    letter-spacing: 0.04em;
}

.collection-cta-box h2 {
    font-size: clamp(25px, 3vw, 36px);
    letter-spacing: -0.025em;
}

.collection-cta-box .btn-light {
    color: var(--mmaci-navy);
    border: 0;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.collection-cta-box .btn-light:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.16);
}

.collection-modal {
    border-radius: 18px;
}

@media (max-width: 991.98px) {
    .collection-hero {
        min-height: 460px;
    }

    .collection-hero-content {
        padding: 100px 0 90px;
    }

    .collection-information {
        padding: 85px 0;
    }
}

@media (max-width: 767.98px) {
    .collection-hero {
        min-height: 420px;
    }

    .collection-hero-content {
        padding: 82px 0 72px;
    }

    .collection-hero h1 {
        font-size: 48px;
    }

    .collection-introduction {
        padding: 70px 0 35px;
    }

    .collection-grid-section {
        padding: 65px 0 80px;
    }

    .collection-image-wrapper {
        height: 250px;
    }

    .collection-card-body {
        min-height: 0;
    }

    .collection-cta-box {
        padding: 36px 28px;
    }
}

@media (max-width: 575.98px) {
    .collection-hero {
        min-height: 390px;
    }

    .collection-hero-content {
        padding: 72px 0 62px;
    }

    .collection-hero h1 {
        font-size: 40px;
    }

    .collection-hero p {
        font-size: 15px;
    }

    .collection-hero .breadcrumb {
        padding: 8px 14px;
    }

    .collection-search-box {
        padding: 10px;
    }

    .information-list {
        padding: 10px 20px;
    }
}

</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('collectionSearch');
    const categoryFilter = document.getElementById('collectionFilter');
    const collectionItems = document.querySelectorAll('.collection-item');
    const noResults = document.getElementById('noResults');

    function filterCollections() {

        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedCategory = categoryFilter.value;
        let visibleItems = 0;

        collectionItems.forEach(function (item) {

            const title = item.dataset.title;
            const category = item.dataset.category;

            const matchesSearch = title.includes(searchTerm);

            const matchesCategory =
                selectedCategory === 'all' ||
                category === selectedCategory;

            if (matchesSearch && matchesCategory) {

                item.style.display = '';
                visibleItems++;

            } else {

                item.style.display = 'none';

            }

        });

        noResults.style.display =
            visibleItems === 0 ? 'block' : 'none';

    }

    searchInput.addEventListener('input', filterCollections);
    categoryFilter.addEventListener('change', filterCollections);

    const collectionModal =
        document.getElementById('collectionModal');

    if (collectionModal) {

        collectionModal.addEventListener('show.bs.modal', function (event) {

            const button = event.relatedTarget;

            if (!button) {
                return;
            }

            const title =
                button.getAttribute('data-collection-title');

            const description =
                button.getAttribute('data-collection-description');

            const image =
                button.getAttribute('data-collection-image');

            document.getElementById('modalCollectionTitle').textContent =
                title;

            document.getElementById('modalCollectionDescription').textContent =
                description;

            document.getElementById('modalCollectionImage').src =
                image;

            document.getElementById('modalCollectionImage').alt =
                title;

        });

    }

});

</script>

@endsection
