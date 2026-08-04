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

            data-bs-target="#navbarMenu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div

            class="collapse navbar-collapse"

            id="navbarMenu">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">

                    <a

                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"

                        href="{{ route('home') }}">

                        Home

                    </a>

                </li>

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

                        data-bs-toggle="dropdown">

                        Collection

                    </a>

                    <ul class="dropdown-menu shadow border-0 rounded-4">

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('collection.printed') }}">

                                <i class="bi bi-book me-2"></i>

                                Printed Collection

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('collection.ebooks') }}">

                                <i class="bi bi-tablet me-2"></i>

                                E-Books

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('collection.theses') }}">

                                <i class="bi bi-journal-text me-2"></i>

                                Thesis &amp; Dissertation

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('collection.donated-books') }}">

                                <i class="bi bi-gift me-2"></i>

                                Donated Books

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('collection.open-access') }}">

                                <i class="bi bi-globe2 me-2"></i>

                                Open Access Resources

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('collection.subscribed-database') }}">

                                <i class="bi bi-database me-2"></i>

                                Subscribed Online Database

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('collection.periodicals') }}">

                                <i class="bi bi-newspaper me-2"></i>

                                Periodical Collection

                            </a>

                        </li>

                    </ul>

                </li>

                <!-- Services -->

                <li class="nav-item dropdown">

                    <a

                        class="nav-link dropdown-toggle {{ request()->routeIs('services.*') ? 'active' : '' }}"

                        href="#"

                        data-bs-toggle="dropdown">

                        Services & Facilities

                    </a>

                    <ul class="dropdown-menu shadow border-0 rounded-4">

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('services.index') }}">

                                Services

                            </a>

                        </li>

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

                        data-bs-toggle="dropdown">

                        More

                    </a>

                    <ul class="dropdown-menu shadow border-0 rounded-4">

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('more.ask-librarian') }}">

                                Ask the Librarian

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('more.gallery') }}">

                                Gallery

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('more.online-book-recommendation') }}">

                                Online Book Recommendation

                            </a>

                        </li>

                        <li>

                            <a

                                class="dropdown-item"

                                href="{{ route('more.reserve-avr') }}">

                                Reserve AVR

                            </a>

                        </li>

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

.mmaci-navbar{

    background:#0B2E59;

    padding:14px 0;

    box-shadow:0 10px 30px rgba(0,0,0,.15);

}

.logo-box{

    width:52px;

    height:52px;

    background:;

    color:;

    border-radius:14px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:24px;

    font-weight:bold;

}

.brand-title{

    font-size:20px;

    font-weight:800;

    color:white;

    line-height:1;

}

.brand-subtitle{

    color:rgba(255,255,255,.75);

    font-size:11px;

}

.navbar .nav-link{

    color:rgba(255,255,255,.85)!important;

    font-weight:600;

    margin:0 4px;

    padding:10px 14px!important;

    border-radius:10px;

    transition:.3s;

}

.navbar .nav-link:hover,

.navbar .nav-link.active{

    color:white!important;

    background:rgba(255,255,255,.08);

}

.dropdown-menu{

    min-width:260px;

    padding:10px;

}

.dropdown-item{

    padding:10px 14px;

    border-radius:10px;

    transition:.3s;

}

.dropdown-item:hover{

    background:#FFF4D4;

    color:#0B2E59;

}

.admin-lock{

    width:42px;

    height:42px;

    border-radius:50%;

    border:1px solid rgba(244,180,0,.5);

    display:flex;

    justify-content:center;

    align-items:center;

    color:#F4B400;

    transition:.3s;

}

.admin-lock:hover{

    background:#F4B400;

    color:#0B2E59;

}

@media(max-width:991px){

    .navbar-nav{

        padding-top:20px;

    }

    .navbar .btn{

        width:100%;

        margin-top:15px;

    }

    .admin-lock{

        margin-top:15px;

        width:100%;

        border-radius:12px;

        height:45px;

    }

}

</style>
