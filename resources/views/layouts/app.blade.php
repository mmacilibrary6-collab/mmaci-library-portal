<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @yield('title', 'MMACI Library Services Office')
    </title>

    <!-- Google Fonts -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link rel="preconnect"
          href="https://cdn.jsdelivr.net">

    <link rel="preconnect"
          href="https://unpkg.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <!-- AOS Animation -->

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css"
          rel="stylesheet">

    <style>

        :root {

            --mmaci-navy: #0B2E59;
            --mmaci-blue: #184B8C;
            --mmaci-yellow: #F4B400;
            --mmaci-white: #FFFFFF;
            --mmaci-light: #F5F8FC;
            --mmaci-text: #26384D;
            --mmaci-muted: #6C7A89;

        }

        * {

            box-sizing: border-box;

        }

        html {

            scroll-behavior: smooth;
            max-width: 100%;
            overflow-x: hidden;

        }

        body {

            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--mmaci-text);
            background: var(--mmaci-white);
            overflow-x: clip;
            max-width: 100%;

        }

        .site-loader {
            position: fixed;
            inset: 0;
            z-index: 100000;
            display: grid;
            place-items: center;
            padding: 24px;
            color: #ffffff;
            background:
                radial-gradient(circle at 50% 42%, rgba(24, 75, 140, 0.9), transparent 34%),
                #0b2e59;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }

        .site-loader.is-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .site-loader-card {
            display: grid;
            justify-items: center;
            gap: 16px;
            text-align: center;
        }

        .site-loader-mark {
            position: relative;
            display: grid;
            width: 112px;
            height: 112px;
            place-items: center;
            padding: 7px;
            background: #ffffff;
            border: 3px solid rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            box-shadow:
                0 20px 55px rgba(0, 0, 0, 0.3),
                0 0 0 8px rgba(244, 180, 0, 0.12);
        }

        .site-loader-mark::before {
            content: "";
            position: absolute;
            inset: -12px;
            border: 3px solid #f4b400;
            border-radius: 50%;
            border-left-color: rgba(244, 180, 0, 0.18);
            border-bottom-color: rgba(244, 180, 0, 0.18);
            animation: site-loader-spin 1.15s linear infinite;
        }

        .site-loader-logo {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .site-loader-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .site-loader-status {
            margin: -8px 0 0;
            color: rgba(255, 255, 255, 0.72);
            font-size: 13px;
        }

        .site-loader-progress {
            width: min(220px, 64vw);
            height: 4px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.16);
            border-radius: 999px;
        }

        .site-loader-progress::after {
            content: "";
            display: block;
            width: 42%;
            height: 100%;
            background: #f4b400;
            border-radius: inherit;
            animation: site-loader-slide 1.1s ease-in-out infinite;
        }

        @keyframes site-loader-spin {
            to { transform: rotate(360deg); }
        }

        @keyframes site-loader-slide {
            from { transform: translateX(-110%); }
            to { transform: translateX(350%); }
        }

        main {

            min-height: 70vh;

        }

        a {

            text-decoration: none;

        }

        img {

            max-width: 100%;
            height: auto;

        }

        iframe {

            max-width: 100%;

        }

        .section-space {

            padding: 90px 0;

        }

        .section-title {

            color: var(--mmaci-navy);
            font-weight: 800;
            letter-spacing: -0.02em;

        }

        .section-description {

            color: var(--mmaci-muted);
            line-height: 1.8;

        }

        .section-badge {

            display: inline-block;
            padding: 8px 18px;
            border-radius: 50px;
            background: rgba(244, 180, 0, 0.18);
            color: #7C5A00;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;

        }

        .page-hero {

            position: relative;
            overflow: hidden;
            padding: 110px 0 90px;
            color: white;
            background:
                radial-gradient(
                    circle at 85% 20%,
                    rgba(244, 180, 0, 0.30),
                    transparent 28%
                ),
                linear-gradient(
                    135deg,
                    var(--mmaci-navy),
                    var(--mmaci-blue)
                );

        }

        .page-hero::after {

            content: "";
            position: absolute;
            inset: 0;

            background-image:
                radial-gradient(
                    rgba(255, 255, 255, 0.13) 1px,
                    transparent 1px
                );

            background-size: 24px 24px;
            opacity: 0.45;

        }

        .page-hero .container {

            position: relative;
            z-index: 1;

        }

        .page-hero h1 {

            font-weight: 800;
            letter-spacing: -0.04em;

        }

        .page-hero p {

            color: rgba(255, 255, 255, 0.82);
            line-height: 1.8;
            max-width: 760px;

        }

        .modern-card {

            background: white;
            border: 1px solid rgba(11, 46, 89, 0.08);
            border-radius: 22px;
            box-shadow:
                0 14px 35px rgba(11, 46, 89, 0.10);

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;

        }

        .modern-card:hover {

            transform: translateY(-7px);

            box-shadow:
                0 22px 45px rgba(11, 46, 89, 0.16);

        }

        .btn-mmaci {

            background: var(--mmaci-yellow);
            border: 1px solid var(--mmaci-yellow);
            color: #17212B;
            font-weight: 700;
            border-radius: 50px;
            padding: 12px 25px;

        }

        .btn-mmaci:hover {

            background: #DDA500;
            border-color: #DDA500;
            color: #17212B;

        }

        .btn-outline-mmaci {

            color: var(--mmaci-navy);
            border: 2px solid var(--mmaci-navy);
            border-radius: 50px;
            font-weight: 700;
            padding: 10px 24px;

        }

        .btn-outline-mmaci:hover {

            background: var(--mmaci-navy);
            color: white;

        }

        .flash-messages-auth {
            max-width: 820px;
            margin: 18px auto 0;
            padding-left: 16px;
            padding-right: 16px;
        }

        .flash-messages-auth .alert {
            margin-bottom: 0;
            border-radius: 16px;
            box-shadow: 0 10px 28px rgba(11, 46, 89, 0.12);
        }

        .form-control,
        .form-select {

            min-height: 48px;
            border-radius: 12px;
            border-color: #DCE4EE;

        }

        textarea.form-control {

            min-height: 140px;

        }

        .form-control:focus,
        .form-select:focus {

            border-color: var(--mmaci-yellow);

            box-shadow:
                0 0 0 0.22rem rgba(244, 180, 0, 0.18);

        }

        .alert {

            border-radius: 14px;

        }

        .table-responsive {

            -webkit-overflow-scrolling: touch;

        }

        .page-hero,
        .modern-card,
        .card,
        .modal-content,
        .dropdown-menu {

            word-break: break-word;

        }


        /* =========================================================
           GLOBAL LAYOUT ANIMATIONS
           Safe, additive motion for shared layout elements.
        ========================================================= */

        @keyframes appPageEnter {

            from {

                opacity: 0;
                transform: translate3d(0, 10px, 0);

            }

            to {

                opacity: 1;
                transform: translate3d(0, 0, 0);

            }

        }


        @keyframes appHeroPatternDrift {

            0%,
            100% {

                background-position: 0 0;

            }

            50% {

                background-position: 12px 12px;

            }

        }


        @keyframes appFlashEnter {

            from {

                opacity: 0;
                transform: translate3d(0, -10px, 0);

            }

            to {

                opacity: 1;
                transform: translate3d(0, 0, 0);

            }

        }


        main {

            animation:
                appPageEnter
                .45s
                cubic-bezier(.22, 1, .36, 1)
                both;

        }


        .page-hero::after {

            animation:
                appHeroPatternDrift
                14s
                ease-in-out
                infinite;

        }


        main > .container.mt-4 .alert,
        main > .container .alert {

            animation:
                appFlashEnter
                .35s
                cubic-bezier(.22, 1, .36, 1)
                both;

        }


        .btn,
        .btn-mmaci,
        .btn-outline-mmaci {

            transition:
                transform .22s ease,
                box-shadow .22s ease,
                background-color .22s ease,
                border-color .22s ease,
                color .22s ease;

        }


        .btn:hover,
        .btn-mmaci:hover,
        .btn-outline-mmaci:hover {

            transform: translateY(-2px);

        }


        .btn:active,
        .btn-mmaci:active,
        .btn-outline-mmaci:active {

            transform: translateY(0) scale(.985);

        }


        .dropdown-menu {

            transform-origin: top center;

        }


        .dropdown-menu.show {

            animation:
                appDropdownEnter
                .2s
                cubic-bezier(.22, 1, .36, 1)
                both;

        }


        @keyframes appDropdownEnter {

            from {

                opacity: 0;
                transform: translate3d(0, -7px, 0) scale(.985);

            }

            to {

                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);

            }

        }


        .modal.show .modal-content {

            animation:
                appModalEnter
                .24s
                cubic-bezier(.22, 1, .36, 1)
                both;

        }


        @keyframes appModalEnter {

            from {

                opacity: 0;
                transform: translate3d(0, 10px, 0) scale(.985);

            }

            to {

                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);

            }

        }


        .form-control,
        .form-select {

            transition:
                border-color .22s ease,
                box-shadow .22s ease,
                background-color .22s ease,
                transform .22s ease;

        }


        .form-control:focus,
        .form-select:focus {

            transform: translateY(-1px);

        }


        a:not(.btn):not(.navbar-brand):not(.dropdown-item) {

            transition:
                color .2s ease,
                opacity .2s ease;

        }

        /*
         * Local scroll-reveal fallback for data-aos elements.
         * This keeps animations working even if the CDN script fails to load.
         */

        [data-aos] {

            opacity: 0;
            will-change: opacity, transform;
            transition:
                opacity .75s cubic-bezier(.22, 1, .36, 1),
                transform .75s cubic-bezier(.22, 1, .36, 1);

        }

        [data-aos="fade-up"] {

            transform: translate3d(0, 26px, 0);

        }

        [data-aos="fade-down"] {

            transform: translate3d(0, -26px, 0);

        }

        [data-aos="fade-left"] {

            transform: translate3d(26px, 0, 0);

        }

        [data-aos="fade-right"] {

            transform: translate3d(-26px, 0, 0);

        }

        [data-aos].aos-visible {

            opacity: 1;
            transform: translate3d(0, 0, 0);

        }

        [data-aos].aos-visible[data-aos="fade-up"],
        [data-aos].aos-visible[data-aos="fade-down"],
        [data-aos].aos-visible[data-aos="fade-left"],
        [data-aos].aos-visible[data-aos="fade-right"] {

            transform: translate3d(0, 0, 0);

        }

        /*
         * Shared CSS-only entrance motion for public pages.
         * This avoids depending on JavaScript to make content visible.
         */

        @keyframes appSectionEnter {

            from {

                opacity: 0;
                transform: translate3d(0, 22px, 0);

            }

            to {

                opacity: 1;
                transform: translate3d(0, 0, 0);

            }

        }

        @keyframes appSectionEnterLeft {

            from {

                opacity: 0;
                transform: translate3d(-22px, 0, 0);

            }

            to {

                opacity: 1;
                transform: translate3d(0, 0, 0);

            }

        }

        @keyframes appSectionEnterRight {

            from {

                opacity: 0;
                transform: translate3d(22px, 0, 0);

            }

            to {

                opacity: 1;
                transform: translate3d(0, 0, 0);

            }

        }

        @keyframes appSectionEnterScale {

            from {

                opacity: 0;
                transform: scale(.97);

            }

            to {

                opacity: 1;
                transform: scale(1);

            }

        }

        main > .page-hero,
        main > section,
        main .modern-card,
        main .content-panel,
        main .service-card,
        main .gallery-card,
        main .library-update-card,
        main .arrival-card,
        main .summary-panel,
        main .contact-panel,
        main .video-frame,
        main .about-carousel,
        main .about-copy,
        main .cta-panel {

            animation: appSectionEnter .6s cubic-bezier(.22, 1, .36, 1) both;

        }

        main > section:nth-of-type(3n + 1),
        main .content-panel:nth-child(3n + 1),
        main .service-card:nth-child(3n + 1),
        main .gallery-card:nth-child(3n + 1),
        main .library-update-card:nth-child(3n + 1),
        main .arrival-card:nth-child(3n + 1) {

            animation-name: appSectionEnterLeft;

        }

        main > section:nth-of-type(3n + 2),
        main .content-panel:nth-child(3n + 2),
        main .service-card:nth-child(3n + 2),
        main .gallery-card:nth-child(3n + 2),
        main .library-update-card:nth-child(3n + 2),
        main .arrival-card:nth-child(3n + 2) {

            animation-name: appSectionEnterRight;

        }

        main > section:nth-of-type(3n),
        main .content-panel:nth-child(3n),
        main .service-card:nth-child(3n),
        main .gallery-card:nth-child(3n),
        main .library-update-card:nth-child(3n),
        main .arrival-card:nth-child(3n) {

            animation-name: appSectionEnterScale;

        }


        @media (max-width: 991px) {

            .section-space {

                padding: 65px 0;

            }

            .page-hero {

                padding: 85px 0 70px;
                text-align: center;

            }

            .mmaci-navbar .navbar-collapse {

                margin-top: 14px;
                padding: 14px;
                border-radius: 18px;
                background: rgba(9, 40, 76, 0.96);
                box-shadow: 0 18px 30px rgba(0, 0, 0, 0.18);

            }

            .mmaci-navbar .navbar-nav {

                gap: 6px;
                align-items: stretch !important;

            }

            .mmaci-navbar .nav-link,
            .mmaci-navbar .dropdown-item,
            .mmaci-navbar .btn {

                width: 100%;

            }

            .mmaci-navbar .dropdown-menu {

                min-width: 100%;
                margin-top: 8px;

            }

        }

        @media (max-width: 767.98px) {

            .section-space {

                padding: 70px 0;

            }

            .page-hero {

                padding: 72px 0 58px;

            }

            .page-hero h1 {

                font-size: clamp(30px, 8vw, 44px);

            }

            .page-hero p {

                font-size: 15px;
                line-height: 1.75;

            }

            .page-hero .container {

                padding-left: 18px;
                padding-right: 18px;

            }

            .navbar-brand {

                max-width: calc(100% - 72px);

            }

            .brand-title {

                font-size: 18px;

            }

            .brand-subtitle {

                font-size: 10px;

            }

        }

        @media (max-width: 575.98px) {

            .section-space {

                padding: 58px 0;

            }

            .page-hero {

                padding: 64px 0 50px;

            }

            .page-hero .container,
            .section-space .container {

                padding-left: 16px;
                padding-right: 16px;

            }

            .btn-mmaci,
            .btn-outline-mmaci {

                width: 100%;

            }

            .flash-messages-auth {
                margin-top: 12px;
                padding-left: 12px;
                padding-right: 12px;
            }

            .flash-messages-auth .alert {
                padding: 14px 16px;
            }

            .section-title {

                font-size: clamp(1.5rem, 6.5vw, 2rem);

            }

            .modern-card {

                border-radius: 18px;

            }

            .modal-dialog {

                margin: 12px;

            }

            .dropdown-menu {

                border-radius: 16px;

            }

        }

    </style>

    @stack('styles')

</head>

<body>

    <div class="site-loader" id="siteLoader" role="status" aria-live="polite" aria-label="Loading page">
        <div class="site-loader-card">
            <span class="site-loader-mark" aria-hidden="true">
                <img
                    class="site-loader-logo"
                    src="{{ asset('images/mmaci-loader-logo.jpg') }}"
                    alt=""
                    width="112"
                    height="112">
            </span>
            <p class="site-loader-title">MMACI Library</p>
            <p class="site-loader-status">Preparing your page...</p>
            <span class="site-loader-progress" aria-hidden="true"></span>
        </div>
    </div>

    <noscript>
        <style>.site-loader { display: none !important; }</style>
    </noscript>

    <script>
        (function () {
            const loader = document.getElementById('siteLoader');

            if (!loader) return;

            const minimumDisplayMs = 5000;
            let loaderShownAt = Date.now();
            let hideTimer = null;

            const hideLoader = function () {
                loader.classList.add('is-hidden');
                window.setTimeout(function () {
                    loader.setAttribute('hidden', '');
                }, 400);
            };

            const scheduleLoaderHide = function () {
                const elapsed = Date.now() - loaderShownAt;
                const remaining = Math.max(0, minimumDisplayMs - elapsed);

                window.clearTimeout(hideTimer);
                hideTimer = window.setTimeout(hideLoader, remaining);
            };

            const showLoader = function () {
                loaderShownAt = Date.now();
                window.clearTimeout(hideTimer);
                loader.removeAttribute('hidden');
                requestAnimationFrame(function () {
                    loader.classList.remove('is-hidden');
                });
            };

            document.addEventListener('DOMContentLoaded', scheduleLoaderHide, { once: true });
            window.addEventListener('pageshow', scheduleLoaderHide);
            scheduleLoaderHide();

            document.addEventListener('click', function (event) {
                const link = event.target.closest('a[href]');

                if (
                    !link ||
                    event.defaultPrevented ||
                    event.button !== 0 ||
                    event.metaKey || event.ctrlKey || event.shiftKey || event.altKey ||
                    link.target === '_blank' ||
                    link.hasAttribute('download') ||
                    link.getAttribute('href').startsWith('#') ||
                    link.origin !== window.location.origin
                ) {
                    return;
                }

                showLoader();
            });
        })();
    </script>

    @include('partials.navbar')

    <main>

        @unless(request()->routeIs('login', 'password.request', 'password.email', 'password.reset'))
            @include('partials.flash-messages', ['containerClass' => 'container mt-4'])
        @endunless

        @yield('content')

    </main>

    @include('partials.footer')

    <!-- Bootstrap JavaScript -->

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <!-- AOS JavaScript -->

    <script defer src="https://unpkg.com/aos@2.3.1/dist/aos.js">
    </script>

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                if (
                    typeof AOS !== 'undefined'
                ) {

                    AOS.init({

                        duration: 800,

                        once:
                            true,

                        offset:
                            70,

                        easing:
                            'ease-out-cubic',

                        disable: false

                    });

                }


                /*
                 * Fallback reveal observer for any element tagged with data-aos.
                 * If AOS is available, this still works as a safe backup; if it
                 * is blocked, elements will still animate into view.
                 */

                const aosElements =
                    Array.from(
                        document.querySelectorAll('[data-aos]')
                    );


                if (
                    aosElements.length === 0
                ) {

                    return;

                }


                if (
                    !('IntersectionObserver' in window)
                ) {

                    aosElements.forEach(function (element) {

                        element.classList.add('aos-visible');

                    });

                    return;

                }


                const aosObserver =
                    new IntersectionObserver(
                        function (entries, observer) {

                            entries.forEach(function (entry) {

                                if (
                                    !entry.isIntersecting
                                ) {

                                    return;

                                }


                                entry.target.classList.add(
                                    'aos-visible'
                                );
                                observer.unobserve(entry.target);

                            });

                        },
                        {
                            root: null,
                            threshold: 0.12,
                            rootMargin: '0px 0px -40px 0px'
                        }
                    );


                aosElements.forEach(function (element) {

                    aosObserver.observe(element);

                });


                /*
                 * Shared public-page reveal fallback.
                 * This gives non-AOS sections a consistent entrance animation.
                 */

                const appRevealTargets =
                    Array.from(
                        document.querySelectorAll(
                            'main .page-hero, main section, main .modern-card, main .content-panel, main .service-card, main .gallery-card, main .library-update-card, main .arrival-card, main .summary-panel, main .contact-panel, main .video-frame, main .about-carousel, main .about-copy, main .cta-panel'
                        )
                    ).filter(function (element) {

                        return !element.hasAttribute('data-aos');

                    });


                if (
                    appRevealTargets.length === 0
                ) {

                    return;

                }


                appRevealTargets.forEach(function (element, index) {

                    if (
                        element.classList.contains('app-reveal')
                    ) {

                        return;

                    }


                    element.classList.add('app-reveal');

                    if (
                        element.classList.contains('page-hero') ||
                        index === 0
                    ) {

                        element.classList.add('app-reveal-down');

                    } else if (
                        index % 4 === 1
                    ) {

                        element.classList.add('app-reveal-left');

                    } else if (
                        index % 4 === 2
                    ) {

                        element.classList.add('app-reveal-right');

                    } else if (
                        index % 4 === 3
                    ) {

                        element.classList.add('app-reveal-scale');

                    } else {

                        element.classList.add('app-reveal-up');

                    }

                });


                if (
                    !('IntersectionObserver' in window)
                ) {

                    appRevealTargets.forEach(function (element) {

                        element.classList.add('is-visible');

                    });

                    return;

                }


                const appRevealObserver =
                    new IntersectionObserver(
                        function (entries, observer) {

                            entries.forEach(function (entry) {

                                if (
                                    !entry.isIntersecting
                                ) {

                                    return;

                                }


                                entry.target.classList.add('is-visible');
                                observer.unobserve(entry.target);

                            });

                        },
                        {
                            root: null,
                            threshold: 0.12,
                            rootMargin: '0px 0px -40px 0px'
                        }
                    );


                appRevealTargets.forEach(function (element) {

                    appRevealObserver.observe(element);

                });


                /*
                 * Refresh AOS after images and dynamic Blade content settle.
                 * This helps prevent incorrect trigger positions on pages with
                 * image-heavy cards, galleries, and dynamically sized content.
                 */

                window.addEventListener(
                    'load',
                    function () {

                        if (
                            typeof AOS !== 'undefined'
                        ) {

                            AOS.refreshHard();

                        }

                    }
                );

            }
        );

    </script>

    @stack('scripts')

</body>

</html>
