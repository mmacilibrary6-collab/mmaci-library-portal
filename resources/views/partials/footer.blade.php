<footer class="footer">

    <div class="container">

        <div class="row gy-5">

            <!-- Library Info -->

            <div class="col-lg-4">

                <div class="d-flex align-items-center mb-3">

                    <div class="footer-logo">
                        <i class="bi bi-book-half"></i>
                    </div>

                    <div class="ms-3">

                        <h4 class="mb-0 text-white">
                            MMACI
                        </h4>

                        <small class="text-light">
                            Library Services Office
                        </small>

                    </div>

                </div>

                <p class="footer-text">
                    The MMACI Library Services Office supports learning,
                    teaching, research, and lifelong education by providing
                    quality library services and access to printed and digital
                    information resources.
                </p>

            </div>

            <!-- Quick Links -->

            <div class="col-lg-2 col-md-6">

                <h5 class="footer-heading">
                    Quick Links
                </h5>

                <ul class="footer-links">

                    <li>
                        <a href="{{ route('home') }}">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('about') }}">
                            About
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('collection.printed') }}">
                            Collections
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('services.index') }}">
                            Services
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('more.gallery') }}">
                            Gallery
                        </a>
                    </li>

                </ul>

            </div>

            <!-- Library Services -->

            <div class="col-lg-3 col-md-6">

                <h5 class="footer-heading">
                    Library Services
                </h5>

                <ul class="footer-links">

                    <li>
                        <a href="{{ route('collection.ebooks') }}">
                            E-Books
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('collection.open-access') }}">
                            Open Access
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('more.ask-librarian') }}">
                            Ask the Librarian
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('more.visiting-users') }}">
                            Visiting Users
                        </a>
                    </li>

                </ul>

            </div>

            <!-- Contact -->

            <div class="col-lg-3">

                <h5 class="footer-heading">
                    Contact Us
                </h5>

                <p class="footer-contact">
                    <i class="bi bi-geo-alt-fill"></i>
                    North Montilla Blvd.<br>
                    <span class="contact-indent">
                        Butuan City, Philippines
                    </span>
                </p>

                <p class="footer-contact">
                    <i class="bi bi-envelope-fill"></i>
                    <a href="mailto:librarymmaci@gmail.com">
                        librarymmaci@gmail.com
                    </a>
                </p>

                <p class="footer-contact">
                    <i class="bi bi-telephone-fill"></i>
                    +63 948 553 2601
                </p>

                <div class="social-icons mt-4">

                    <a href="#"
                       aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="mailto:librarymmaci@gmail.com"
                       aria-label="Email">
                        <i class="bi bi-envelope-fill"></i>
                    </a>

                    <a href="#"
                       aria-label="Website">
                        <i class="bi bi-globe"></i>
                    </a>

                </div>

            </div>

        </div>

        <hr class="footer-divider">

        <div class="row align-items-center gy-2">

            <div class="col-md-6">

                <small class="copyright">
                    © {{ date('Y') }} MMACI Library Services Office.
                    All Rights Reserved.
                </small>

            </div>

            <div class="col-md-6 text-md-end">

                <small class="copyright">
                    Developed by MMACI BSIS Intern 2026
                </small>

            </div>

        </div>

    </div>

</footer>

<style>

.footer {
    width: 100%;
    margin: 0;
    padding: 70px 0 25px;
    color: white;
    background: linear-gradient(
        135deg,
        #0B2E59,
        #184B8C
    );
}

.footer-logo {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0B2E59;
    background: #F4B400;
    border-radius: 15px;
    font-size: 28px;
}

.footer-heading {
    margin-bottom: 20px;
    color: white;
    font-weight: 700;
}

.footer-text {
    margin-bottom: 0;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.9;
}

.footer-links {
    padding: 0;
    margin: 0;
    list-style: none;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    display: inline-block;
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    transition: all 0.3s ease;
}

.footer-links a:hover {
    padding-left: 6px;
    color: #F4B400;
}

.footer-contact {
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.8;
}

.footer-contact i {
    width: 24px;
    display: inline-block;
    margin-right: 6px;
    color: #F4B400;
}

.footer-contact a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
}

.footer-contact a:hover {
    color: #F4B400;
}

.contact-indent {
    display: inline-block;
    margin-left: 34px;
}

.social-icons {
    display: flex;
    gap: 12px;
}

.social-icons a {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    font-size: 18px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icons a:hover {
    color: #0B2E59;
    background: #F4B400;
    transform: translateY(-5px);
}

.footer-divider {
    margin: 45px 0 25px;
    border-color: rgba(255, 255, 255, 0.15);
    opacity: 1;
}

.copyright {
    color: rgba(255, 255, 255, 0.7);
}

@media (max-width: 767.98px) {

    .footer {
        padding: 55px 0 25px;
        text-align: center;
    }

    .footer .d-flex.align-items-center {
        justify-content: center;
    }

    .social-icons {
        justify-content: center;
    }

    .contact-indent {
        margin-left: 0;
    }

}

</style>