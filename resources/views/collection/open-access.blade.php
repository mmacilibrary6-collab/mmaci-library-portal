@extends('layouts.app')

@section('title', 'Open Access Resources | MMACI Library Services Office')

@section('content')

<section class="open-access-hero">

    <div class="open-access-overlay"></div>

    <div class="container position-relative">

        <div class="open-access-hero-content">

            

            <h1>
                Open Access Resources
            </h1>

            <p>
                Explore freely accessible academic databases, digital
                libraries, e-book collections, journals, and research
                platforms.
            </p>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb justify-content-center mb-0">

                    <li class="breadcrumb-item">

                        <a href="{{ route('home') }}">
                            Home
                        </a>

                    </li>

                    <li
                        class="breadcrumb-item active"
                        aria-current="page">

                        Open Access Resources

                    </li>

                </ol>

            </nav>

        </div>

    </div>

</section>

<section class="open-access-intro">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-8 text-center">

                <span class="section-label">
                    Academic Resources
                </span>

                <h2 class="section-title">
                    Access Knowledge Beyond the Library
                </h2>

                <p class="section-description">
                    Select any resource below to visit its official website.
                    These platforms provide open educational materials,
                    research publications, books, journals, and scholarly
                    information.
                </p>

            </div>

        </div>

    </div>

</section>

<section class="resources-section">

    <div class="container">

        <div class="resources-toolbar">

            <div>

                <span>
                    Available Resources
                </span>

                <strong>
                    {{ $resources->count() }}
                    {{ \Illuminate\Support\Str::plural(
                        'platform',
                        $resources->count()
                    ) }}
                </strong>

            </div>

            <div class="resource-search-wrapper">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    id="resourceSearch"
                    class="form-control"
                    placeholder="Search resources...">

            </div>

        </div>

        <div
            class="row g-4"
            id="resourceGrid">

            @forelse ($resources as $resource)

                <div
                    class="col-xl-4 col-md-6 resource-item"
                    data-title="{{ strtolower(
                        $resource->title
                    ) }}"
                    data-description="{{ strtolower(
                        $resource->description ?? ''
                    ) }}"
                    data-aos="fade-up"
                    data-aos-delay="{{ (
                        $loop->index % 3
                    ) * 100 }}">

                    <article class="public-resource-card">

                        <div class="public-resource-logo">

                            <img
                                src="{{ $resource->image_url }}"
                                alt="{{ $resource->title }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('images/Opacc.jpg') }}';">

                        </div>

                        <div class="public-resource-body">

                            <span class="public-resource-category">
                                Open Access Platform
                            </span>

                            <h3>
                                {{ $resource->title }}
                            </h3>

                            <p>
                                {{ $resource->description
                                    ?: 'Explore freely accessible digital academic and educational resources.'
                                }}
                            </p>

                            <a
                                href="{{ $resource->website_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="public-resource-link">

                                Visit Resource

                                <i class="bi bi-arrow-up-right"></i>

                            </a>

                        </div>

                    </article>

                </div>

            @empty

                <div class="col-12">

                    <div class="resources-empty">

                        <i class="bi bi-globe2"></i>

                        <h3>
                            No Open Access Resources Available
                        </h3>

                        <p>
                            Resources added by the library administrator
                            will appear here.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

        <div
            class="resources-empty"
            id="noResourceResults"
            style="display: none;">

            <i class="bi bi-search"></i>

            <h3>
                No Matching Resource Found
            </h3>

            <p>
                Try searching with another title or keyword.
            </p>

        </div>

    </div>

</section>

<section class="resource-notice-section">

    <div class="container">

        <div class="resource-notice">

            <div>

                <span>
                    External Websites
                </span>

                <h2>
                    Resources open in a separate browser tab.
                </h2>

                <p>
                    The MMACI Library provides links to external academic
                    platforms. Availability and content are managed by their
                    respective providers.
                </p>

            </div>

        </div>

    </div>

</section>

<style>
:root {
    --mmaci-navy: #0B2E59;
    --mmaci-blue: #184B8C;
    --mmaci-yellow: #F4B400;
    --mmaci-light: #F5F7FB;
    --mmaci-text: #5E6878;
    --mmaci-border: #E2E8F0;
}

.open-access-hero {
    position: relative;
    min-height: 440px;
    display: grid;
    place-items: center;
    align-items: center;
    overflow: hidden;
    color: #ffffff;
    background-color: var(--mmaci-navy);
    background:
        linear-gradient(
            105deg,
            rgba(7, 30, 61, .86) 0%,
            rgba(11, 46, 89, .68) 55%,
            rgba(24, 75, 140, .52) 100%
        ),
        url("{{ asset('images/books1.jpg') }}") center / cover no-repeat;
}

.open-access-hero::before {
    content: "";
    position: absolute;
    top: -220px;
    right: -100px;
    width: 430px;
    height: 430px;
    border: 75px solid rgba(244, 180, 0, 0.09);
    border-radius: 50%;
}

.open-access-overlay {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(
            circle at 72% 25%,
            rgba(255, 255, 255, 0.10),
            transparent 30%
        );
}

.open-access-hero-content {
    position: relative;
    z-index: 2;
    max-width: 790px;
    margin: auto;
    padding: 95px 0 80px;
    text-align: center;
}

.open-access-label {
    
    align-items: center;
    gap: 8px;
    color: var(--mmaci-yellow);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
}

.open-access-label::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--mmaci-yellow);
    border-radius: 10px;
}

.open-access-hero h1 {
    margin: 14px 0;
    font-size: clamp(43px, 5.5vw, 64px);
    font-weight: 800;
    line-height: 1.05;
    letter-spacing: -0.045em;
}

.open-access-hero p {
    max-width: 720px;
    margin: 0 auto 20px;
    color: rgba(255, 255, 255, 0.82);
    font-size: 17px;
    line-height: 1.8;
}

.open-access-hero .breadcrumb {
    display: inline-flex;
    font-size: 13px;
}

.open-access-hero .breadcrumb-item,
.open-access-hero .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.6);
    font-size: 13px;
}

.open-access-hero .breadcrumb-item a {
    color: #ffffff;
    font-weight: 600;
    text-decoration: none;
}

.open-access-hero .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.36);
}

.open-access-intro {
    padding: 48px 0 22px;
    background: var(--mmaci-light);
}

.open-access-intro .row {
    justify-content: flex-start !important;
}

.open-access-intro .col-xl-8 {
    text-align: left !important;
}

.section-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--mmaci-blue);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.11em;
    text-transform: uppercase;
}

.section-label::before {
    content: "";
    width: 28px;
    height: 3px;
    background: var(--mmaci-yellow);
    border-radius: 10px;
}

.section-title {
    margin: 11px 0;
    color: var(--mmaci-navy);
    font-size: clamp(32px, 4vw, 47px);
    font-weight: 800;
}

.section-description {
    max-width: 760px;
    margin: 0;
    color: var(--mmaci-text);
    font-size: 16px;
    line-height: 1.85;
}

.resources-section {
    padding: 18px 0 54px;
    background: var(--mmaci-light);
}

.resources-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
    min-height: 62px;
    padding: 10px 14px 10px 18px;
    margin-bottom: 20px;
    background: #ffffff;
    border: 1px solid var(--mmaci-border);
    border-radius: 12px;
}

.resources-toolbar > div:first-child span {
    display: block;
    color: #8A94A4;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
}

.resources-toolbar strong {
    color: var(--mmaci-navy);
}

.resource-search-wrapper {
    position: relative;
    width: 100%;
    max-width: 330px;
}

.resource-search-wrapper i {
    position: absolute;
    top: 50%;
    left: 16px;
    color: var(--mmaci-blue);
    transform: translateY(-50%);
}

.resource-search-wrapper input {
    min-height: 42px;
    padding-left: 45px;
    border: 1px solid #DDE4ED;
    border-radius: 9px;
}

.public-resource-card {
    height: 100%;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid var(--mmaci-border);
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(11, 46, 89, 0.06);
    transition: 0.3s ease;
}

.public-resource-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 44px rgba(11, 46, 89, 0.14);
}

.public-resource-logo {
    position: relative;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 26px;
    background: linear-gradient(
        145deg,
        #F7F9FC,
        #EAF0F8
    );
}

.public-resource-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.35s ease;
}

.public-resource-card:hover
.public-resource-logo img {
    transform: scale(1.06);
}

.public-resource-body {
    display: flex;
    flex-direction: column;
    padding: 20px;
}

.public-resource-category {
    color: var(--mmaci-blue);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.09em;
    text-transform: uppercase;
}

.public-resource-body h3 {
    margin: 7px 0 9px;
    color: var(--mmaci-navy);
    font-size: 20px;
    font-weight: 800;
}

.public-resource-body p {
    margin-bottom: 16px;
    color: var(--mmaci-text);
    font-size: 14px;
    line-height: 1.75;
}

.public-resource-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 13px;
    color: var(--mmaci-blue);
    border-top: 1px solid #EDF0F5;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
}

.public-resource-link:hover {
    color: var(--mmaci-navy);
}

.resources-empty {
    padding: 48px 24px;
    color: var(--mmaci-navy);
    text-align: center;
    background: #ffffff;
    border: 1px dashed #C9D3E1;
    border-radius: 20px;
}

.resources-empty > i {
    display: block;
    margin-bottom: 18px;
    font-size: 50px;
}

.resource-notice-section {
    padding: 0 0 54px;
    background: #ffffff;
}

.resource-notice {
    padding: 30px 34px;
    color: #ffffff;
    background: linear-gradient(
        135deg,
        var(--mmaci-navy),
        var(--mmaci-blue)
    );
    border-radius: 16px;
}

.resource-notice span {
    color: var(--mmaci-yellow);
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}

.resource-notice h2 {
    margin: 7px 0;
    font-size: clamp(22px, 3vw, 30px);
    font-weight: 800;
}

.resource-notice p {
    margin: 0;
    color: rgba(255, 255, 255, 0.75);
}

@media (max-width: 767.98px) {
    .resources-toolbar {
        align-items: flex-start;
        flex-direction: column;
    }

    .resource-search-wrapper {
        max-width: none;
    }

    .public-resource-logo {
        height: 175px;
    }
}

@media (max-width: 575.98px) {
    .open-access-hero h1 {
        font-size: 42px;
    }

    .resource-notice {
        padding: 27px 22px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput =
        document.getElementById('resourceSearch');

    const resourceItems =
        document.querySelectorAll('.resource-item');

    const noResults =
        document.getElementById('noResourceResults');

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener('input', function () {
        const searchValue =
            this.value.trim().toLowerCase();

        let visibleItems = 0;

        resourceItems.forEach(function (item) {
            const title =
                item.dataset.title || '';

            const description =
                item.dataset.description || '';

            const matches =
                title.includes(searchValue) ||
                description.includes(searchValue);

            item.style.display =
                matches ? '' : 'none';

            if (matches) {
                visibleItems++;
            }
        });

        if (noResults) {
            noResults.style.display =
                visibleItems === 0
                    ? 'block'
                    : 'none';
        }
    });
});
</script>

@endsection
