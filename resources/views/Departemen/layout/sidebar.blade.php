<div class="menu-inner-shadow"></div>

<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ request()->routeIs('dashboard-departemen') ? 'active' : '' }}">
        <a href="{{ route('dashboard-departemen') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <!-- Data Magang -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Data Peserta Magang</span>
    </li>
    <li class="menu-item {{ request()->routeIs('departemen.peserta') ? 'active' : '' }}">
        <a href="{{ route('departemen.peserta') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div data-i18n="Analytics">Peserta Magang</div>
        </a>
    </li>

    <!-- Data Departemen -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Logbook Peserta Magang</span>
    </li>
    <li class="menu-item {{ request()->routeIs('data-logbook-departemen') ? 'active' : '' }}">
        <a href="{{ route('data-logbook-departemen') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-collection"></i>
            <div data-i18n="Analytics">Data Logbook</div>
        </a>
    </li>

    <!-- Components -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Nilai</span></li>
    <!-- Cards -->
    <li class="menu-item {{ request()->routeIs('laporan-akhir') ? 'active' : '' }}">
        <a href="#" class="menu-link">
            <i class="menu-icon tf-icons bx bx-file"></i>
            <div data-i18n="Analytics">Laporan Akhir</div>
        </a>
    </li>

</ul>
</aside>

<!-- / Menu -->

<!-- Layout container -->
<div class="layout-page">
    <!-- Navbar -->

    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->

                <!-- User Profiles -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        style="margin-bottom: -30px">
                        <div class="avatar">
                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                class="w-px-40 h-auto rounded-circle" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                                class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                        <small class="text-muted">
                                            {{ Auth::user()->departemens->nama_departemen }}</small>
                                    </div>
                                </div>
                            </a></li>
                        <li><a class="dropdown-item" href="#">My Profile</a></li>
                        <li><a class="dropdown-item" href="#">Setting Password</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </nav>
    <!-- / Navbar -->
