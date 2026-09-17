<style>
/* Shared visual rhythm for every public Collection page. */
:root {
    --collection-ink: #0b2e59;
    --collection-blue: #174f8f;
    --collection-gold: #fdbb16;
    --collection-muted: #65748c;
    --collection-line: #dce5f0;
    --collection-surface: #ffffff;
    --collection-canvas: #f4f7fb;
    --collection-radius: 22px;
    --collection-shadow: 0 16px 42px rgba(11, 46, 89, .09);
}

html,
body {
    max-width: 100%;
    overflow-x: clip;
}

.collection-hero,
.ebooks-hero,
.theses-hero,
.donated-hero,
.open-access-hero,
.database-hero,
.arrivals-hero {
    min-height: 320px;
    display: flex;
    align-items: center;
}

.collection-hero-content,
.ebooks-hero-content,
.theses-hero-content,
.donated-hero-content,
.open-access-hero-content,
.database-hero-content,
.arrivals-hero-content {
    width: min(760px, 100%);
}

.collection-hero-content h1,
.ebooks-hero-content h1,
.theses-hero-content h1,
.donated-hero-content h1,
.open-access-hero-content h1,
.database-hero-content h1,
.arrivals-hero-content h1 {
    font-size: clamp(2.35rem, 5vw, 4.4rem);
    line-height: .98;
    letter-spacing: -.045em;
    text-wrap: balance;
}

.collection-introduction,
.ebooks-intro,
.theses-intro,
.donated-content,
.open-access-intro,
.resources-section,
.database-access-section,
.programs-section {
    position: relative;
}

.section-title,
.ebooks-intro h2,
.theses-intro h2,
.donated-intro h2,
.open-access-intro h2 {
    font-size: clamp(2rem, 3.8vw, 3rem);
    line-height: 1.08;
    letter-spacing: -.035em;
    text-wrap: balance;
}

.section-description,
.ebooks-intro p,
.theses-intro p,
.donated-intro p,
.open-access-intro p {
    max-width: 760px;
    margin-inline: auto;
    color: var(--collection-muted);
    line-height: 1.75;
}

.collection-search-box,
.ebooks-search,
.program-search,
.periodical-control-panel,
.resources-toolbar,
.arrival-toolbar {
    width: min(100%, 980px);
    margin-inline: auto;
    border: 1px solid var(--collection-line);
    border-radius: 18px;
    background: rgba(255, 255, 255, .96);
    box-shadow: 0 12px 34px rgba(11, 46, 89, .07);
}

.collection-search-box,
.resources-toolbar,
.arrival-toolbar {
    padding: 18px;
}

.search-input-wrapper,
.ebooks-search,
.program-search,
.periodical-program-search,
.resource-search-wrapper,
.arrival-search-field {
    min-height: 54px;
}

.collection-card,
.ebook-card,
.program-card,
.donated-book-card,
.public-resource-card,
.arrival-card,
.access-card {
    height: 100%;
    overflow: hidden;
    border: 1px solid var(--collection-line);
    border-radius: var(--collection-radius);
    background: var(--collection-surface);
    box-shadow: var(--collection-shadow);
}

.collection-card,
.ebook-card,
.program-card,
.donated-book-card,
.public-resource-card,
.arrival-card {
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
}

.collection-card:hover,
.ebook-card:hover,
.program-card:hover,
.donated-book-card:hover,
.public-resource-card:hover,
.arrival-card:hover {
    transform: translateY(-5px);
    border-color: rgba(23, 79, 143, .24);
    box-shadow: 0 22px 48px rgba(11, 46, 89, .13);
}

.collection-image-wrapper,
.ebook-image,
.program-image,
.donated-book-cover,
.resource-card-image,
.arrival-cover {
    overflow: hidden;
    background: #eaf0f7;
}

.collection-image,
.ebook-image img,
.program-image img,
.donated-book-cover img,
.resource-card-image img,
.arrival-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.collection-card-body,
.ebook-content,
.program-content,
.donated-book-body,
.resource-card-body,
.arrival-card-body {
    min-width: 0;
}

.collection-card-body h3,
.ebook-content h3,
.program-content h3,
.donated-book-body h3,
.resource-card-body h3,
.arrival-card-body h3 {
    overflow-wrap: anywhere;
    text-wrap: balance;
}

.no-results,
.search-empty,
.program-search-empty,
.arrival-empty,
.arrival-no-results,
.resource-empty-state {
    width: min(100%, 760px);
    margin-inline: auto;
    padding: clamp(34px, 6vw, 64px) 24px;
    text-align: center;
    border: 1px dashed #c8d5e5;
    border-radius: var(--collection-radius);
    background: #f8fafd;
}

@media (max-width: 991.98px) {
    .collection-hero,
    .ebooks-hero,
    .theses-hero,
    .donated-hero,
    .open-access-hero,
    .database-hero,
    .arrivals-hero {
        min-height: 285px;
    }

    .database-hero-grid,
    .database-access-grid {
        grid-template-columns: 1fr;
    }

    .resources-toolbar,
    .arrival-toolbar {
        gap: 12px;
    }
}

@media (max-width: 767.98px) {
    .collection-hero,
    .ebooks-hero,
    .theses-hero,
    .donated-hero,
    .open-access-hero,
    .database-hero,
    .arrivals-hero {
        min-height: 250px;
        padding-block: 44px;
        background-position: center;
    }

    .collection-hero-content h1,
    .ebooks-hero-content h1,
    .theses-hero-content h1,
    .donated-hero-content h1,
    .open-access-hero-content h1,
    .database-hero-content h1,
    .arrivals-hero-content h1 {
        font-size: clamp(2.05rem, 10vw, 3rem);
    }

    .collection-hero-content p,
    .ebooks-hero-content p,
    .theses-hero-content p,
    .donated-hero-content p,
    .open-access-hero-content p,
    .database-hero-content p,
    .arrivals-hero-content p {
        max-width: 34rem;
        font-size: .98rem;
        line-height: 1.65;
    }

    .collection-introduction,
    .ebooks-intro,
    .theses-intro,
    .open-access-intro {
        padding-block: 42px 26px;
    }

    .collection-search-section,
    .collection-grid-section,
    .ebooks-section,
    .programs-section,
    .resources-section,
    .database-access-section,
    .donated-content {
        padding-block: 22px 52px;
    }

    .collection-search-box,
    .ebooks-search,
    .program-search,
    .periodical-control-panel,
    .resources-toolbar,
    .arrival-toolbar {
        padding: 14px;
        border-radius: 16px;
    }

    .resources-toolbar,
    .arrival-toolbar {
        display: grid;
        grid-template-columns: 1fr;
    }

    .filter-chip-group {
        width: 100%;
        justify-content: flex-start;
        overflow-x: auto;
        overscroll-behavior-inline: contain;
        scrollbar-width: thin;
    }

    .filter-chip {
        flex: 0 0 auto;
    }

    .collection-card,
    .ebook-card,
    .program-card,
    .donated-book-card,
    .public-resource-card,
    .arrival-card {
        border-radius: 18px;
    }

    .collection-image-wrapper,
    .ebook-image,
    .program-image,
    .resource-card-image,
    .arrival-cover {
        min-height: 190px;
        max-height: 230px;
    }

    .donated-book-cover {
        height: 250px;
        min-height: 250px;
    }

    .collection-card-body,
    .ebook-content,
    .program-content,
    .donated-book-body,
    .resource-card-body,
    .arrival-card-body {
        padding: 22px;
    }

    .collection-card-body h3,
    .ebook-content h3,
    .program-content h3,
    .donated-book-body h3,
    .resource-card-body h3,
    .arrival-card-body h3 {
        font-size: 1.2rem;
        line-height: 1.25;
    }
}

@media (max-width: 430px) {
    .container {
        --bs-gutter-x: 2rem;
    }

    .collection-hero,
    .ebooks-hero,
    .theses-hero,
    .donated-hero,
    .open-access-hero,
    .database-hero,
    .arrivals-hero {
        min-height: 235px;
        padding-block: 36px;
    }

    .section-title,
    .ebooks-intro h2,
    .theses-intro h2,
    .donated-intro h2,
    .open-access-intro h2 {
        font-size: 1.85rem;
    }

    .collection-search-box,
    .ebooks-search,
    .program-search,
    .periodical-control-panel,
    .resources-toolbar,
    .arrival-toolbar {
        padding: 12px;
    }

    .search-input-wrapper,
    .ebooks-search,
    .program-search,
    .periodical-program-search,
    .resource-search-wrapper,
    .arrival-search-field {
        min-height: 50px;
    }

    .collection-card-body,
    .ebook-content,
    .program-content,
    .donated-book-body,
    .resource-card-body,
    .arrival-card-body {
        padding: 19px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .collection-card,
    .ebook-card,
    .program-card,
    .donated-book-card,
    .public-resource-card,
    .arrival-card {
        transition: none;
    }
}
</style>
