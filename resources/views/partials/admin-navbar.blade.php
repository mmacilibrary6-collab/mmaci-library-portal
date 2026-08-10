<nav class="admin-navbar">
    <div class="admin-navbar-inner">

        <!-- LEFT -->
        <div class="admin-navbar-left">
            <button
                class="sidebar-toggle d-lg-none"
                id="sidebarToggle"
                type="button"
                aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>

            <h1 class="admin-navbar-title">Library Services Office</h1>
        </div>

        <!-- RIGHT -->
        <div class="admin-navbar-right">

            <div class="navbar-date d-none d-md-flex">
                <i class="bi bi-calendar3"></i>

                <div>
                    <strong>{{ now()->format('M d, Y') }}</strong>
                    <small>{{ now()->format('l') }}</small>
                </div>
            </div>

            <div class="dropdown">
                <button
                    class="admin-profile"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <span class="admin-avatar">
                        <i class="bi bi-person-fill"></i>
                    </span>

                    <span class="admin-details d-none d-sm-flex">
                        <strong>Administrator</strong>
                        <small>{{ Auth::user()->email ?? 'admin@mmaci.edu.ph' }}</small>
                    </span>

                    <i class="bi bi-chevron-down profile-arrow d-none d-sm-block"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end admin-dropdown">

                    <li>
                        <div class="dropdown-profile">
                            <span class="dropdown-avatar">
                                <i class="bi bi-person-fill"></i>
                            </span>

                            <div>
                                <strong>Administrator</strong>
                                <small>{{ Auth::user()->email ?? 'admin@mmaci.edu.ph' }}</small>
                            </div>
                        </div>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            <span class="dropdown-item-icon">
                                <i class="bi bi-grid-fill"></i>
                            </span>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a
                            class="dropdown-item"
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

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item logout-item">
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
    --navbar-border: #E5EAF1;
    --navbar-muted: #7A8798;
    --navbar-red: #DC3545;
}

.admin-navbar {
    position: sticky;
    top: 0;
    z-index: 1020;
    width: 100%;
    min-height: 72px;
    padding: 0 28px;
    background: rgba(255,255,255,.97);
    border-bottom: 1px solid var(--navbar-border);
    box-shadow: 0 4px 18px rgba(11,46,89,.045);
    backdrop-filter: blur(14px);
}

.admin-navbar-inner {
    min-height: 72px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.admin-navbar-left,
.admin-navbar-right {
    display: flex;
    align-items: center;
}

.admin-navbar-left {
    min-width: 0;
    gap: 12px;
}

.admin-navbar-right {
    margin-left: auto;
    gap: 14px;
}

.admin-navbar-title {
    margin: 0;
    color: var(--navbar-navy);
    font-size: 20px;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -.02em;
}

.sidebar-toggle {
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    color: var(--navbar-navy);
    background: #F5F8FC;
    border: 1px solid #DFE6EF;
    border-radius: 10px;
    font-size: 21px;
}

.sidebar-toggle:hover {
    background: var(--navbar-yellow);
    border-color: var(--navbar-yellow);
}

/* Date */
.navbar-date {
    align-items: center;
    gap: 9px;
    padding-right: 16px;
    border-right: 1px solid var(--navbar-border);
}

.navbar-date > i {
    color: var(--navbar-blue);
    font-size: 15px;
}

.navbar-date strong,
.navbar-date small {
    display: block;
    white-space: nowrap;
}

.navbar-date strong {
    color: var(--navbar-navy);
    font-size: 11px;
    font-weight: 800;
    line-height: 1.3;
}

.navbar-date small {
    margin-top: 1px;
    color: var(--navbar-muted);
    font-size: 9px;
    line-height: 1.3;
}

/* Profile */
.admin-profile {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 4px 6px 4px 4px;
    color: inherit;
    background: transparent;
    border: 1px solid transparent;
    border-radius: 12px;
    cursor: pointer;
    text-align: left;
}

.admin-profile:hover,
.admin-profile[aria-expanded="true"] {
    background: #F6F8FB;
    border-color: #E2E8F0;
}

.admin-avatar {
    width: 40px;
    height: 40px;
    flex: 0 0 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--navbar-navy);
    background: var(--navbar-yellow);
    border-radius: 10px;
    font-size: 16px;
}

.admin-details {
    max-width: 180px;
    min-width: 0;
    flex-direction: column;
}

.admin-details strong,
.admin-details small {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.admin-details strong {
    color: var(--navbar-navy);
    font-size: 11px;
    font-weight: 800;
    line-height: 1.3;
}

.admin-details small {
    color: var(--navbar-muted);
    font-size: 9px;
    line-height: 1.3;
}

.profile-arrow {
    color: #9AA5B3;
    font-size: 9px;
    transition: transform .2s ease;
}

.admin-profile[aria-expanded="true"] .profile-arrow {
    transform: rotate(180deg);
}

/* Dropdown */
.admin-dropdown {
    width: 285px;
    padding: 8px;
    margin-top: 9px !important;
    background: #fff;
    border: 1px solid var(--navbar-border);
    border-radius: 14px;
    box-shadow: 0 18px 45px rgba(11,46,89,.14);
}

.dropdown-profile {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px;
    background: #F7F9FC;
    border-radius: 10px;
}

.dropdown-avatar {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--navbar-navy);
    background: var(--navbar-yellow);
    border-radius: 9px;
    font-size: 15px;
}

.dropdown-profile > div {
    min-width: 0;
}

.dropdown-profile strong,
.dropdown-profile small {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.dropdown-profile strong {
    color: var(--navbar-navy);
    font-size: 11px;
    font-weight: 800;
}

.dropdown-profile small {
    margin-top: 2px;
    color: var(--navbar-muted);
    font-size: 9px;
}

.admin-dropdown .dropdown-divider {
    margin: 7px 4px;
    border-color: #E9EDF3;
}

.admin-dropdown .dropdown-item {
    min-height: 42px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 7px 9px;
    color: #405169;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
}

.admin-dropdown .dropdown-item:hover {
    color: var(--navbar-navy);
    background: #F2F5F9;
}

.dropdown-item-icon {
    width: 29px;
    height: 29px;
    flex: 0 0 29px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--navbar-blue);
    background: rgba(24,75,140,.08);
    border-radius: 7px;
    font-size: 12px;
}

.external-link-icon {
    margin-left: auto;
    color: #A2ACBA;
    font-size: 9px;
}

.admin-dropdown form {
    margin: 0;
}

.admin-dropdown .logout-item {
    width: 100%;
    color: var(--navbar-red);
}

.logout-item .dropdown-item-icon {
    color: var(--navbar-red);
    background: rgba(220,53,69,.08);
}

.admin-dropdown .logout-item:hover {
    color: #fff;
    background: var(--navbar-red);
}

.admin-dropdown .logout-item:hover .dropdown-item-icon {
    color: #fff;
    background: rgba(255,255,255,.16);
}

/* Responsive */
@media (max-width: 767.98px) {
    .admin-navbar {
        min-height: 66px;
        padding: 0 14px;
    }

    .admin-navbar-inner {
        min-height: 66px;
    }

    .admin-navbar-title {
        font-size: 17px;
    }

    .admin-navbar-right {
        gap: 7px;
    }

    .admin-profile {
        padding: 3px;
    }

    .admin-avatar {
        width: 38px;
        height: 38px;
        flex-basis: 38px;
    }
}

@media (max-width: 480px) {
    .admin-navbar-title {
        max-width: 145px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 15px;
    }

    .admin-dropdown {
        width: min(285px, calc(100vw - 20px));
    }
}
</style>