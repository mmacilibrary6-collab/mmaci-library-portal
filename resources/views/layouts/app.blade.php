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

        }

        body {

            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--mmaci-text);
            background: var(--mmaci-white);

        }

        main {

            min-height: 70vh;

        }

        a {

            text-decoration: none;

        }

        img {

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

        @media (max-width: 991px) {

            .section-space {

                padding: 65px 0;

            }

            .page-hero {

                padding: 85px 0 70px;
                text-align: center;

            }

        }

    </style>

    @stack('styles')

</head>

<body>

    @include('partials.navbar')

    <main>

        @if (session('success'))

            <div class="container mt-4">

                <div class="alert alert-success alert-dismissible fade show shadow-sm">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            </div>

        @endif

        @if ($errors->any())

            <div class="container mt-4">

                <div class="alert alert-danger alert-dismissible fade show shadow-sm">

                    <strong>
                        Please correct the following:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

            </div>

        @endif

        @yield('content')

    </main>

    @include('partials.footer')

    <!-- Bootstrap JavaScript -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <!-- AOS JavaScript -->

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js">
    </script>

    <script>

        AOS.init({

            duration: 800,
            once: true,
            offset: 70

        });

    </script>

    @stack('scripts')

</body>

</html>