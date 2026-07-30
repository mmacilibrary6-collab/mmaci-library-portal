<nav class="admin-navbar navbar navbar-expand-lg">

    <div class="container-fluid">

        <!-- ================= LEFT SIDE ================= -->

        <div class="navbar-left">

            <!-- Mobile Sidebar Button -->

            <button
                class="sidebar-toggle d-lg-none"
                id="sidebarToggle"
                type="button"
                aria-label="Toggle sidebar">

                <i class="bi bi-list"></i>

            </button>

            <!-- Page Information -->

            <div class="page-information">

                <span class="page-eyebrow">
                    Administration
                </span>

                <h4 class="page-title">
                    Dashboard
                </h4>

            </div>

        </div>

        <!-- ================= RIGHT SIDE ================= -->

        <div class="navbar-right">

            <!-- Date -->

            <div class="navbar-date d-none d-md-flex">

                <div class="date-icon">

                    <i class="bi bi-calendar3"></i>

                </div>

                <div>

                    <strong>
                        {{ now()->format('F d, Y') }}
                    </strong>

                    <small>
                        {{ now()->format('l') }}
                    </small>

                </div>

            </div>

            <!-- Divider -->

            <div class="navbar-divider d-none d-md-block"></div>

            <!-- Administrator Dropdown -->

            <div class="dropdown">

                <button
                    class="admin-profile"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <div class="admin-avatar">

                        <i class="bi bi-person-fill"></i>

                    </div>

                    <div class="admin-details d-none d-sm-block">

                        <strong>Administrator</strong>

                        <small>
                            {{ Auth::user()->email ?? 'admin@mmaci.edu.ph' }}
                        </small>

                    </div>

                    <i class="bi bi-chevron-down profile-arrow d-none d-sm-block"></i>

                </button>

                <!-- Dropdown Menu -->

                <ul class="dropdown-menu dropdown-menu-end admin-dropdown">

                    <!-- User Information -->

                    <li>

                        <div class="dropdown-profile">

                            <div class="dropdown-avatar">

                                <i class="bi bi-person-fill"></i>

                            </div>

                            <div>

                                <strong>Administrator</strong>

                                <small>
                                    {{ Auth::user()->email ?? 'admin@mmaci.edu.ph' }}
                                </small>

                            </div>

                        </div>

                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Dashboard -->

                    <li>

                        <a class="dropdown-item"
                           href="{{ route('admin.dashboard') }}">

                            <span class="dropdown-item-icon">

                                <i class="bi bi-grid-fill"></i>

                            </span>

                            <span>Dashboard</span>

                        </a>

                    </li>

                    <!-- View Website -->

                    <li>

                        <a class="dropdown-item"
                           href="{{ route('home') }}"
                           target="_blank"
                           rel="noopener noreferrer">

                            <span class="dropdown-item-icon">

                                <i class="bi bi-globe2"></i>

                            </span>

                            <span>View Website</span>

                            <i class="bi bi-box-arrow-up-right external-link-icon"></i>

                        </a>

                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Logout -->

                    <li>

                        <form action="{{ route('logout') }}"
                              method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item logout-item">

                                <span class="dropdown-item-icon">

                                    <i class="bi bi-box-arrow-right"></i>

                                </span>

                                <span>Logout</span>

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>

<style>

:root {
    --navbar-navy: #0B2E59;
    --navbar-blue: #184B8C;
    --navbar-yellow: #F4B400;
    --navbar-background: #FFFFFF;
    --navbar-border: #E4EAF2;
    --navbar-muted: #748094;
    --navbar-red: #DC3545;
}

/* ================= NAVBAR ================= */

.admin-navbar {
    position: sticky;
    top: 0;
    z-index: 1020;
    min-height: 78px;
    padding: 0 25px;
    background: rgba(255, 255, 255, 0.96);
    border-bottom: 1px solid var(--navbar-border);
    box-shadow: 0 5px 22px rgba(11, 46, 89, 0.07);
    backdrop-filter: blur(14px);
}

.admin-navbar .container-fluid {
    min-height: 78px;
    padding: 0;
}

/* ================= LEFT SIDE ================= */

.navbar-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.sidebar-toggle {
    width: 43px;
    height: 43px;
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    color: var(--navbar-navy);
    background: #F1F5FA;
    border: 1px solid #DDE5EF;
    border-radius: 11px;
    font-size: 23px;
    cursor: pointer;
    transition:
        color 0.22s ease,
        background 0.22s ease,
        border-color 0.22s ease;
}

.sidebar-toggle:hover {
    color: var(--navbar-navy);
    background: var(--navbar-yellow);
    border-color: var(--navbar-yellow);
}

/* ================= PAGE INFORMATION ================= */

.page-information {
    min-width: 0;
}

.page-eyebrow {
    display: block;
    margin-bottom: 2px;
    color: var(--navbar-blue);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.13em;
    line-height: 1.2;
    text-transform: uppercase;
}

.page-title {
    margin: 0;
    overflow: hidden;
    color: var(--navbar-navy);
    font-size: 20px;
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: -0.02em;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* ================= RIGHT SIDE ================= */

.navbar-right {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-left: auto;
}

/* ================= DATE ================= */

.navbar-date {
    align-items: center;
    gap: 11px;
}

.date-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--navbar-blue);
    background: rgba(24, 75, 140, 0.08);
    border: 1px solid rgba(24, 75, 140, 0.10);
    border-radius: 10px;
    font-size: 16px;
}

.navbar-date strong {
    display: block;
    color: var(--navbar-navy);
    font-size: 12px;
    font-weight: 700;
    line-height: 1.4;
}

.navbar-date small {
    display: block;
    color: var(--navbar-muted);
    font-size: 10px;
    line-height: 1.4;
}

/* ================= DIVIDER ================= */

.navbar-divider {
    width: 1px;
    height: 36px;
    background: var(--navbar-border);
}

/* ================= ADMIN PROFILE ================= */

.admin-profile {
    min-width: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 9px 6px 6px;
    color: inherit;
    background: transparent;
    border: 1px solid transparent;
    border-radius: 13px;
    cursor: pointer;
    text-align: left;
    transition:
        background 0.22s ease,
        border-color 0.22s ease;
}

.admin-profile:hover,
.admin-profile.show {
    background: #F4F7FB;
    border-color: var(--navbar-border);
}

.admin-avatar {
    width: 43px;
    height: 43px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--navbar-navy);
    background: linear-gradient(
        145deg,
        #FFD45A,
        var(--navbar-yellow)
    );
    border-radius: 12px;
    font-size: 18px;
    box-shadow: 0 7px 16px rgba(244, 180, 0, 0.20);
}

.admin-details {
    max-width: 170px;
    min-width: 0;
}

.admin-details strong {
    display: block;
    overflow: hidden;
    color: var(--navbar-navy);
    font-size: 12px;
    font-weight: 700;
    line-height: 1.4;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.admin-details small {
    display: block;
    overflow: hidden;
    color: var(--navbar-muted);
    font-size: 9px;
    line-height: 1.4;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.profile-arrow {
    color: #929EAF;
    font-size: 10px;
    transition: transform 0.22s ease;
}

.admin-profile[aria-expanded="true"] .profile-arrow {
    transform: rotate(180deg);
}

/* ================= DROPDOWN ================= */

.admin-dropdown {
    width: 290px;
    padding: 9px;
    margin-top: 10px !important;
    overflow: hidden;
    background: #FFFFFF;
    border: 1px solid var(--navbar-border);
    border-radius: 15px;
    box-shadow: 0 18px 48px rgba(11, 46, 89, 0.16);
}

/* Dropdown Profile */

.dropdown-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: linear-gradient(
        135deg,
        rgba(24, 75, 140, 0.07),
        rgba(244, 180, 0, 0.06)
    );
    border: 1px solid #E7ECF3;
    border-radius: 11px;
}

.dropdown-avatar {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--navbar-navy);
    background: var(--navbar-yellow);
    border-radius: 11px;
    font-size: 17px;
}

.dropdown-profile div:last-child {
    min-width: 0;
}

.dropdown-profile strong {
    display: block;
    overflow: hidden;
    color: var(--navbar-navy);
    font-size: 12px;
    line-height: 1.4;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.dropdown-profile small {
    display: block;
    overflow: hidden;
    color: var(--navbar-muted);
    font-size: 9px;
    line-height: 1.4;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Dropdown Divider */

.admin-dropdown .dropdown-divider {
    margin: 8px 4px;
    border-color: #E9EDF3;
}

/* Dropdown Items */

.admin-dropdown .dropdown-item {
    display: flex;
    align-items: center;
    gap: 11px;
    min-height: 44px;
    padding: 8px 10px;
    color: #405169;
    background: transparent;
    border: 0;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 600;
    transition:
        color 0.2s ease,
        background 0.2s ease;
}

.admin-dropdown .dropdown-item:hover {
    color: var(--navbar-navy);
    background: #F1F5FA;
}

.dropdown-item-icon {
    width: 31px;
    height: 31px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--navbar-blue);
    background: rgba(24, 75, 140, 0.08);
    border-radius: 8px;
    font-size: 13px;
}

.external-link-icon {
    margin-left: auto;
    color: #A2ACBA;
    font-size: 10px;
}

/* Logout */

.admin-dropdown form {
    margin: 0;
}

.admin-dropdown .logout-item {
    width: 100%;
    color: var(--navbar-red);
}

.admin-dropdown .logout-item:hover {
    color: #FFFFFF;
    background: var(--navbar-red);
}

.logout-item .dropdown-item-icon {
    color: var(--navbar-red);
    background: rgba(220, 53, 69, 0.09);
}

.logout-item:hover .dropdown-item-icon {
    color: #FFFFFF;
    background: rgba(255, 255, 255, 0.16);
}

/* ================= RESPONSIVE ================= */

@media (max-width: 767.98px) {

    .admin-navbar {
        min-height: 70px;
        padding: 0 16px;
    }

    .admin-navbar .container-fluid {
        min-height: 70px;
    }

    .navbar-right {
        gap: 8px;
    }

    .page-title {
        max-width: 200px;
        font-size: 17px;
    }

    .page-eyebrow {
        display: none;
    }

    .admin-profile {
        padding: 4px;
    }

    .admin-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
    }

}

@media (max-width: 480px) {

    .page-title {
        max-width: 145px;
        font-size: 15px;
    }

    .sidebar-toggle {
        width: 40px;
        height: 40px;
    }

    .admin-dropdown {
        width: min(285px, calc(100vw - 24px));
    }

}

</style>
