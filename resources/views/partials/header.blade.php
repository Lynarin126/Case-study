@php
    $khmerDate = \App\Helpers\KhmerDateHelper::format();
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Khmer Date in Header Bar -->
    <div class="d-none d-md-flex align-items-center mx-auto px-2">
        <div class="px-3 py-1 rounded shadow-none" style="background-color: #f8f9fa; border: 1px solid #e9ecef; font-size: 13.5px; color: #2b2b2b; white-space: nowrap;">
            <span id="khmer-header-date">
                <span class="khmer-lunar">{{ $khmerDate['lunar'] }}</span>
                <span class="text-muted mx-1" style="color: #8c98a4;">ត្រូវនឹង</span>
                <span class="khmer-solar">{{ $khmerDate['solar'] }}</span>
            </span>
        </div>
    </div>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="{{ asset('backend/dist/img/user.png') }}" class="img-circle" width="30" height="30" style="object-fit:cover;">
                <span class="ml-1">{{ Auth::user()->name ?? 'Admin' }}</span>
                <i class="fas fa-chevron-down text-xs ml-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow">
                <div class="dropdown-item text-center bg-primary text-white">
                    <strong>{{ Auth::user()->name ?? 'Admin' }}</strong><br>
                    <small>{{ Auth::user()->email ?? 'Dashboard User' }}</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user-circle mr-2 text-info"></i>
                    ប្រវត្តិរូប
                </a>
                <a href="{{ config('app.frontend_url', 'http://localhost:5173') }}" target="_blank" class="dropdown-item text-primary font-weight-bold">
                    <i class="fas fa-globe mr-2"></i>
                    ទស្សនាគេហទំព័រ
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-left">
                        <i class="fas fa-power-off mr-2"></i>
                        ចាកចេញ
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
