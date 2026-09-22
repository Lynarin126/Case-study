```blade
@php
    $khmerDate = \App\Helpers\KhmerDateHelper::format();
@endphp

<style>
    :root {
        --school-green: #10b981;
        --school-green-dark: #047857;
        --school-green-soft: #ecfdf5;
        --school-border: #e5e7eb;
        --school-text: #374151;
        --school-muted: #6b7280;
        --school-bg: #f8fafc;
    }
    .school-header {
        min-height: 64px;
        background: #ffffff !important;
        border-bottom: 1px solid var(--school-border);
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        z-index: 1030;
    }
    .school-header .nav-link {
        color: #4b5563 !important;
        min-height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }

    .school-header .nav-link:hover {
        color: var(--school-green-dark) !important;
        background: var(--school-green-soft);
    }

    .school-header .nav-link:focus {
        outline: none;
        box-shadow: none;
    }
    .school-header .header-icon-link {
        width: 52px;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .school-header .header-icon-link i {
        font-size: 15px;
    }

    .school-header-date {
        background: #f8fafc;
        border: 1px solid var(--school-border);
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 13px;
        line-height: 1.4;
        color: var(--school-text);
        white-space: nowrap;
    }

    .school-header-date .khmer-lunar {
        color: var(--school-green-dark);
        font-weight: 600;
    }

    .school-header-date .date-separator {
        color: #9ca3af;
        margin: 0 6px;
    }

    .school-header-date .khmer-solar {
        color: var(--school-text);
        font-weight: 500;
    }

    .school-user-link {
        padding: 0 16px !important;
        gap: 8px;
        color: var(--school-text) !important;
    }

    .school-user-link:hover {
        background: #f8fafc !important;
    }

    .school-user-avatar {
        width: 32px;
        height: 32px;
        object-fit: cover;
        border: 2px solid #d1fae5;
    }

    .school-user-name {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .school-user-chevron {
        font-size: 9px;
        color: #9ca3af;
    }

    .school-header .dropdown-menu {
        min-width: 250px;
        margin-top: 4px;
        padding: 6px;
        border: 1px solid var(--school-border);
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.10);
    }

    .school-profile-header {
        background: var(--school-green-soft);
        border-radius: 7px;
        padding: 12px 14px;
        color: var(--school-green-dark);
    }

    .school-profile-header strong {
        font-size: 14px;
        font-weight: 600;
    }

    .school-profile-header small {
        font-size: 12px;
        color: var(--school-muted);
        word-break: break-word;
    }

    .school-header .dropdown-divider {
        margin: 6px 0;
        border-top-color: #eef0f2;
    }

    .school-header .dropdown-item {
        border-radius: 7px;
        padding: 9px 11px;
        font-size: 13.5px;
        color: var(--school-text);
        transition: all 0.15s ease;
    }

    .school-header .dropdown-item:hover {
        background: #f8fafc;
        color: var(--school-green-dark);
    }

    .school-header .dropdown-item i {
        width: 18px;
        text-align: center;
    }

    .school-header .profile-link i {
        color: var(--school-green) !important;
    }

    .school-header .website-link {
        color: var(--school-green-dark) !important;
    }

    .school-header .logout-button {
        color: #dc2626 !important;
        cursor: pointer;
    }

    .school-header .logout-button:hover {
        background: #fef2f2 !important;
        color: #b91c1c !important;
    }
    @media (max-width: 767.98px) {
        .school-header {
            min-height: 58px;
        }

        .school-header .nav-link {
            min-height: 58px;
        }

        .school-header .header-icon-link {
            width: 46px;
        }

        .school-user-link {
            padding: 0 10px !important;
        }

        .school-user-name {
            display: none;
        }

        .school-user-chevron {
            display: none;
        }

        .school-header .dropdown-menu {
            position: absolute;
            right: 5px;
            min-width: 235px;
        }
    }

    @media (max-width: 575.98px) {
        .school-header .navbar-nav.ml-auto {
            margin-left: auto !important;
        }

        .school-user-avatar {
            width: 30px;
            height: 30px;
        }
    }
</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top school-header">

    {{-- Left: Sidebar Toggle --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a
                class="nav-link header-icon-link"
                data-widget="pushmenu"
                href="#"
                role="button"
                aria-label="Toggle sidebar"
            >
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    {{-- Center: Khmer Date --}}
    <div class="d-none d-md-flex align-items-center mx-auto px-2">
        <div class="school-header-date">
            <span id="khmer-header-date">
                <span class="khmer-lunar">
                    {{ $khmerDate['lunar'] }}
                </span>

                <span class="date-separator">
                    ត្រូវនឹង
                </span>

                <span class="khmer-solar">
                    {{ $khmerDate['solar'] }}
                </span>
            </span>
        </div>
    </div>

    {{-- Right: User Controls --}}
    <ul class="navbar-nav ml-auto">

        {{-- Fullscreen --}}
        <li class="nav-item">
            <a
                class="nav-link header-icon-link"
                data-widget="fullscreen"
                href="#"
                role="button"
                aria-label="Fullscreen"
            >
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        {{-- User Dropdown --}}
        <li class="nav-item dropdown">

            <a
                class="nav-link school-user-link"
                href="#"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <img
                    src="{{ asset('backend/dist/img/user.png') }}"
                    class="img-circle school-user-avatar"
                    alt="User"
                >

                <span class="school-user-name">
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>

                <i class="fas fa-chevron-down school-user-chevron"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                {{-- User Information --}}
                <div class="school-profile-header text-center">
                    <strong>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </strong>

                    <br>

                    <small>
                        {{ Auth::user()->email ?? 'Dashboard User' }}
                    </small>
                </div>

                <div class="dropdown-divider"></div>

                {{-- Profile --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="dropdown-item profile-link"
                >
                    <i class="fas fa-user-circle mr-2"></i>
                    ប្រវត្តិរូប
                </a>

                {{-- Website --}}
                <a
                    href="{{ config('app.frontend_url', 'http://localhost:5173') }}"
                    target="_blank"
                    class="dropdown-item website-link"
                >
                    <i class="fas fa-globe mr-2"></i>
                    ទស្សនាគេហទំព័រ
                </a>

                <div class="dropdown-divider"></div>

                {{-- Logout --}}
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="d-inline m-0"
                >
                    @csrf

                    <button
                        type="submit"
                        class="dropdown-item logout-button border-0 bg-transparent w-100 text-left"
                    >
                        <i class="fas fa-power-off mr-2"></i>
                        ចាកចេញ
                    </button>
                </form>

            </div>
        </li>

    </ul>
</nav>
```
