<div class="admin-sidebar-wrapper">

    {{-- Brand --}}
    <div class="sidebar-brand">

        <a
            href="{{ route('admin.dashboard') }}"
            class="sidebar-brand-link">

            <div class="sidebar-logo">

                <img
                    src="{{ asset('images/logomml.png') }}"
                    alt="MMACI Logo">

            </div>

            <div class="sidebar-brand-text">

                <h5>
                    MMACI
                </h5>

                <small>
                    Admin Panel
                </small>

            </div>

        </a>

    </div>

    {{-- Navigation --}}
    <nav class="sidebar-navigation">

        {{-- Main Navigation --}}
        <span class="sidebar-label">
            Main Navigation
        </span>

        <a
            href="{{ route('admin.dashboard') }}"
            class="sidebar-link
                {{ request()->routeIs('admin.dashboard')
                    ? 'active'
                    : ''
                }}">

            <i class="bi bi-grid-fill"></i>

            <span>
                Dashboard
            </span>

        </a>

        {{-- Content Management --}}
        <span class="sidebar-label sidebar-section-label">
            Content Management
        </span>

        <a
            href="{{ route('admin.calendar.index') }}"
            class="sidebar-link
                {{ request()->routeIs('admin.calendar.*')
                    ? 'active'
                    : ''
                }}">

            <i class="bi bi-calendar-event-fill"></i>

            <span>
                Calendar Events
            </span>

        </a>

        <a
            href="{{ route('admin.new-arrivals.index') }}"
            class="sidebar-link
                {{ request()->routeIs('admin.new-arrivals.*')
                    ? 'active'
                    : ''
                }}">

            <i class="bi bi-book-fill"></i>

            <span>
                New Arrivals
            </span>

        </a>

        <a
            href="{{ route('admin.gallery.index') }}"
            class="sidebar-link
                {{ request()->routeIs('admin.gallery.*')
                    ? 'active'
                    : ''
                }}">

            <i class="bi bi-images"></i>

            <span>
                Gallery
            </span>

        </a>

        {{-- Digital Resources --}}
        <span class="sidebar-label sidebar-section-label">
            Digital Resources
        </span>

        <a
            href="{{ route('admin.ebook-programs.index') }}"
            class="sidebar-link
                {{ request()->routeIs('admin.ebook-programs.*')
                    ? 'active'
                    : ''
                }}">

            <i class="bi bi-mortarboard-fill"></i>

            <span>
                E-Book Programs
            </span>

        </a>

        <a
            href="{{ route('admin.ebook-folders.index') }}"
            class="sidebar-link
                {{ request()->routeIs('admin.ebook-folders.*')
                    ? 'active'
                    : ''
                }}">

            <i class="bi bi-folder-fill"></i>

            <span>
                E-Book Folders
            </span>

        </a>

        <a
            href="{{ route('admin.open-access-resources.index') }}"
            class="sidebar-link
                {{ request()->routeIs(
                    'admin.open-access-resources.*'
                )
                    ? 'active'
                    : ''
                }}">

            <i class="bi bi-globe-americas"></i>

            <span>
                Open Access Resources
            </span>

        </a>

        {{-- Website --}}
        <span class="sidebar-label sidebar-section-label">
            Website
        </span>

        <a
            href="{{ route('home') }}"
            class="sidebar-link"
            target="_blank"
            rel="noopener noreferrer">

            <i class="bi bi-display-fill"></i>

            <span>
                View Website
            </span>

            <i class="bi bi-box-arrow-up-right external-icon"></i>

        </a>

    </nav>

    {{-- Logout --}}
    <div class="sidebar-footer">

        <form
            action="{{ route('logout') }}"
            method="POST">

            @csrf

            <button
                type="submit"
                class="sidebar-logout">

                <i class="bi bi-box-arrow-right"></i>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</div>

<style>

:root {
    --sidebar-navy: #0b2e59;
    --sidebar-blue: #123f75;
    --sidebar-yellow: #f4b400;
    --sidebar-white: #ffffff;
}

/* Sidebar container */

.admin-sidebar-wrapper {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
    overflow-y: auto;
    color: var(--sidebar-white);
    background:
        radial-gradient(
            circle at top right,
            rgba(244, 180, 0, 0.16),
            transparent 28%
        ),
        linear-gradient(
            180deg,
            var(--sidebar-navy) 0%,
            var(--sidebar-blue) 100%
        );
    scrollbar-width: thin;
    scrollbar-color:
        rgba(255, 255, 255, 0.20)
        transparent;
}

.admin-sidebar-wrapper::before {
    content: "";
    position: absolute;
    right: -90px;
    bottom: 90px;
    width: 210px;
    height: 210px;
    border: 38px solid rgba(255, 255, 255, 0.025);
    border-radius: 50%;
    pointer-events: none;
}

/* Brand */

.sidebar-brand {
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    padding: 22px 20px;
    border-bottom:
        1px solid rgba(255, 255, 255, 0.10);
}

.sidebar-brand-link {
    display: flex;
    align-items: center;
    gap: 14px;
    color: var(--sidebar-white);
    text-decoration: none;
}

.sidebar-brand-link:hover {
    color: var(--sidebar-white);
}

.sidebar-logo {
    width: 54px;
    height: 54px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.sidebar-logo img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: contain;
}

.sidebar-brand-text {
    min-width: 0;
}

.sidebar-brand-text h5 {
    margin: 0 0 3px;
    color: var(--sidebar-white);
    font-size: 23px;
    font-weight: 800;
    line-height: 1.1;
}

.sidebar-brand-text small {
    display: block;
    color: rgba(255, 255, 255, 0.68);
    font-size: 12px;
}

/* Administrator */

.sidebar-user {
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 11px;
    margin: 16px 13px 4px;
    padding: 12px;
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.10);
    border-radius: 13px;
}

.user-avatar {
    width: 41px;
    height: 41px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--sidebar-navy);
    background: var(--sidebar-yellow);
    border-radius: 11px;
    font-size: 17px;
    box-shadow:
        0 7px 16px rgba(244, 180, 0, 0.16);
}

.user-information {
    min-width: 0;
}

.user-information strong,
.user-information small {
    display: block;
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.user-information strong {
    color: var(--sidebar-white);
    font-size: 12px;
    font-weight: 700;
}

.user-information small {
    margin-top: 2px;
    color: rgba(255, 255, 255, 0.58);
    font-size: 10px;
}

/* Navigation */

.sidebar-navigation {
    position: relative;
    z-index: 1;
    flex: 1;
    padding: 16px 11px 20px;
}

.sidebar-label {
    display: block;
    margin-bottom: 7px;
    padding: 0 12px;
    color: rgba(255, 255, 255, 0.40);
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.13em;
    text-transform: uppercase;
}

.sidebar-section-label {
    margin-top: 20px;
}

.sidebar-link {
    position: relative;
    min-height: 44px;
    display: flex;
    align-items: center;
    gap: 11px;
    margin-bottom: 4px;
    padding: 9px 12px;
    color: rgba(255, 255, 255, 0.76);
    background: transparent;
    border: 1px solid transparent;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    transition:
        color 0.20s ease,
        background 0.20s ease,
        border-color 0.20s ease,
        transform 0.20s ease;
}

.sidebar-link > i:first-child {
    width: 21px;
    flex-shrink: 0;
    color: var(--sidebar-yellow);
    font-size: 15px;
    line-height: 1;
    text-align: center;
}

.sidebar-link:hover {
    color: var(--sidebar-white);
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.07);
    transform: translateX(3px);
}

.sidebar-link.active {
    color: var(--sidebar-navy);
    background: var(--sidebar-yellow);
    border-color: var(--sidebar-yellow);
    font-weight: 700;
    box-shadow:
        0 7px 18px rgba(244, 180, 0, 0.18);
}

.sidebar-link.active > i:first-child {
    color: var(--sidebar-navy);
}

.sidebar-link.active::before {
    content: "";
    position: absolute;
    top: 8px;
    left: -12px;
    width: 4px;
    height: 27px;
    background: var(--sidebar-yellow);
    border-radius: 0 5px 5px 0;
}

/* External icon */

.external-icon {
    width: auto !important;
    margin-left: auto;
    color:
        rgba(255, 255, 255, 0.42) !important;
    font-size: 11px !important;
}

/* Logout */

.sidebar-footer {
    position: relative;
    z-index: 1;
    flex-shrink: 0;
    padding: 14px 14px 18px;
    border-top:
        1px solid rgba(255, 255, 255, 0.10);
}

.sidebar-footer form {
    margin: 0;
}

.sidebar-logout {
    width: 100%;
    min-height: 44px;
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 9px 13px;
    color: rgba(255, 255, 255, 0.80);
    background: rgba(255, 255, 255, 0.055);
    border:
        1px solid rgba(255, 255, 255, 0.13);
    border-radius: 10px;
    font-family: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition:
        color 0.20s ease,
        background 0.20s ease,
        border-color 0.20s ease;
}

.sidebar-logout:hover {
    color: var(--sidebar-white);
    background: #dc3545;
    border-color: #dc3545;
}

.sidebar-logout i {
    width: 21px;
    flex-shrink: 0;
    font-size: 16px;
    line-height: 1;
    text-align: center;
}

/* Scrollbar */

.admin-sidebar-wrapper::-webkit-scrollbar {
    width: 5px;
}

.admin-sidebar-wrapper::-webkit-scrollbar-track {
    background: transparent;
}

.admin-sidebar-wrapper::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.20);
    border-radius: 20px;
}

.admin-sidebar-wrapper::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.32);
}

/* Responsive */

@media (max-width: 991.98px) {

    .admin-sidebar-wrapper {
        height: auto;
        min-height: 100vh;
    }

    .sidebar-brand {
        padding: 19px;
    }

    .sidebar-logo {
        width: 49px;
        height: 49px;
    }

    .sidebar-brand-text h5 {
        font-size: 20px;
    }

}

</style>
