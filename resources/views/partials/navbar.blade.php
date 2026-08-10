<nav class="navbar navbar-expand-lg navbar-dark sticky-top mmaci-navbar">

    <div class="container">

        <!-- Logo -->

        <a class="navbar-brand d-flex align-items-center"
           href="{{ route('home') }}">

            <div class="logo-box">

                <img src="{{ asset('images/logomml.png') }}"
                     alt="MMACI Logo"
                     class="logo-image">

            </div>

            <div class="ms-3">

                <span class="brand-title">
                    MMACI
                </span>

                <small class="brand-subtitle d-block">
                    Library Services Office
                </small>

            </div>

        </a>


        <!-- Mobile Button -->

        <button
            class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarMenu"
            aria-controls="navbarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>


        <div
            class="collapse navbar-collapse"
            id="navbarMenu">

            <ul class="navbar-nav ms-auto align-items-lg-center">


                <!-- Home -->

                <li class="nav-item">

                    <a
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">

                        Home

                    </a>

                </li>


                <!-- About -->

                <li class="nav-item">

                    <a
                        class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">

                        About

                    </a>

                </li>


                <!-- Collection -->

                <li class="nav-item dropdown">

                    <a
                        class="nav-link dropdown-toggle {{ request()->routeIs('collection.*') ? 'active' : '' }}"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        Collection

                    </a>

                    <ul class="dropdown-menu shadow border-0 rounded-4">

                        <!-- Printed Collection -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('collection.printed') }}">

                                <i class="bi bi-book me-2"></i>

                                Printed Collection

                            </a>

                        </li>


                        <!-- E-Books -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('collection.ebooks') }}">

                                <i class="bi bi-tablet me-2"></i>

                                E-Books

                            </a>

                        </li>


                        <!-- Thesis & Dissertation -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('collection.theses') }}">

                                <i class="bi bi-journal-text me-2"></i>

                                Thesis &amp; Dissertation

                            </a>

                        </li>


                        <!-- Donated Books -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('collection.donated-books') }}">

                                <i class="bi bi-gift me-2"></i>

                                Donated Books

                            </a>

                        </li>


                        <!-- Open Access Resources -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('collection.open-access') }}">

                                <i class="bi bi-globe2 me-2"></i>

                                Open Access Resources

                            </a>

                        </li>


                        <!-- Subscribed Online Database -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('collection.subscribed-database') }}">

                                <i class="bi bi-database me-2"></i>

                                Subscribed Online Database

                            </a>

                        </li>


                        <!-- Periodical Collection -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('collection.periodicals') }}">

                                <i class="bi bi-newspaper me-2"></i>

                                Periodical Collection

                            </a>

                        </li>


                        <!-- New Arrivals -->

                        <li>

                            <a
                                class="dropdown-item {{ request()->routeIs('collection.new-arrivals') ? 'active' : '' }}"
                                href="{{ route('collection.new-arrivals') }}">

                                <i class="bi bi-stars me-2" aria-hidden="true"></i>

                                New Arrivals

                            </a>

                        </li>

                    </ul>

                </li>


                <!-- Services & Facilities -->

                <li class="nav-item dropdown">

                    <a
                        class="nav-link dropdown-toggle {{ request()->routeIs('services.*') ? 'active' : '' }}"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        Services &amp; Facilities

                    </a>

                    <ul class="dropdown-menu shadow border-0 rounded-4">

                        <!-- Services -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('services.index') }}">

                                Services

                            </a>

                        </li>


                        <!-- Facilities -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('services.facilities') }}">

                                Facilities

                            </a>

                        </li>

                    </ul>

                </li>


                <!-- More -->

                <li class="nav-item dropdown">

                    <a
                        class="nav-link dropdown-toggle {{ request()->routeIs('more.*') ? 'active' : '' }}"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        More

                    </a>

                    <ul class="dropdown-menu shadow border-0 rounded-4">


                        <!-- Ask the Librarian -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('more.ask-librarian') }}">

                                Ask the Librarian

                            </a>

                        </li>


                        <!-- Gallery -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('more.gallery') }}">

                                Gallery

                            </a>

                        </li>


                        <!-- Online Book Recommendation -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('more.online-book-recommendation') }}">

                                Online Book Recommendation

                            </a>

                        </li>


                        <!-- Reserve AVR -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('more.reserve-avr') }}">

                                Reserve AVR

                            </a>

                        </li>


                        <!-- Visiting Users -->

                        <li>

                            <a
                                class="dropdown-item"
                                href="{{ route('more.visiting-users') }}">

                                Visiting Users

                            </a>

                        </li>

                    </ul>

                </li>


                <!-- Explore -->

                <li class="nav-item ms-lg-3">

                    <a
                        href="{{ route('collection.printed') }}"
                        class="btn btn-warning rounded-pill px-4 fw-semibold">

                        Explore

                    </a>

                </li>


                <!-- Hidden Admin Login -->

            </ul>

        </div>

    </div>

</nav>


<style>

.mmaci-navbar {

    background: #0B2E59;

    padding: 14px 0;

    box-shadow:
        0 10px 30px rgba(0, 0, 0, .15);

}


/* =========================================
   LOGO
========================================= */

.logo-box {

    width: 52px;
    height: 52px;

    display: flex;

    justify-content: center;
    align-items: center;

    border-radius: 14px;

    overflow: hidden;

}


.logo-image {

    width: 100%;
    height: 100%;

    object-fit: contain;

}


.brand-title {

    font-size: 20px;

    font-weight: 800;

    color: white;

    line-height: 1;

}


.brand-subtitle {

    color:
        rgba(255, 255, 255, .75);

    font-size: 11px;

}


/* =========================================
   NAVIGATION LINKS
========================================= */

.navbar .nav-link {

    color:
        rgba(255, 255, 255, .85) !important;

    font-weight: 600;

    margin: 0 4px;

    padding:
        10px 14px !important;

    border-radius: 10px;

    transition: .3s;

}


.navbar .nav-link:hover,
.navbar .nav-link.active {

    color: white !important;

    background:
        rgba(255, 255, 255, .08);

}


/* =========================================
   DROPDOWNS
========================================= */

.mmaci-navbar .dropdown-menu {

    min-width: 260px;

    padding: 10px;

}


.mmaci-navbar .dropdown-item {

    padding:
        10px 14px;

    border-radius: 10px;

    transition: .3s;

}


.mmaci-navbar .dropdown-item:hover {

    background: #FFF4D4;

    color: #0B2E59;

}


.mmaci-navbar .dropdown-item.active,
.mmaci-navbar .dropdown-item:active {

    background: #FFF4D4;

    color: #0B2E59;

    font-weight: 700;

}


/* =========================================
   ADMIN LOCK
========================================= */

.admin-lock {

    width: 42px;
    height: 42px;

    border-radius: 50%;

    border:
        1px solid rgba(244, 180, 0, .5);

    display: flex;

    justify-content: center;
    align-items: center;

    color: #F4B400;

    transition: .3s;

}


.admin-lock:hover {

    background: #F4B400;

    color: #0B2E59;

}


/* =========================================
   TABLET / MOBILE
========================================= */

@media (max-width: 991px) {

    .navbar-nav {

        padding-top: 20px;

    }


    .navbar .btn {

        width: 100%;

        margin-top: 15px;

    }


    .admin-lock {

        margin-top: 15px;

        width: 100%;

        border-radius: 12px;

        height: 45px;

    }

}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 767.98px) {

    .mmaci-navbar .container {

        padding-left: 16px;
        padding-right: 16px;

    }


    .mmaci-navbar .navbar-collapse {

        margin-top: 14px;

        padding: 14px;

        border-radius: 18px;

        background:
            rgba(9, 40, 76, .96);

        box-shadow:
            0 18px 30px rgba(0, 0, 0, .18);

    }


    .mmaci-navbar .navbar-nav {

        gap: 6px;

        align-items:
            stretch !important;

    }


    .mmaci-navbar .nav-link,
    .mmaci-navbar .dropdown-item,
    .mmaci-navbar .btn {

        width: 100%;

        text-align: left;

    }


    .mmaci-navbar .dropdown-menu {

        min-width: 100%;

        margin-top: 8px;

    }


    .navbar-brand {

        max-width:
            calc(100% - 65px);

    }


    .brand-title {

        font-size: 18px;

    }


    .brand-subtitle {

        font-size: 10px;

    }

}


/* =========================================
   VERY SMALL PHONES
========================================= */

@media (max-width: 400px) {

    .logo-box {

        width: 44px;
        height: 44px;

    }


    .navbar-brand .ms-3 {

        margin-left:
            10px !important;

    }


    .brand-title {

        font-size: 16px;

    }


    .brand-subtitle {

        font-size: 9px;

    }

}

</style>
