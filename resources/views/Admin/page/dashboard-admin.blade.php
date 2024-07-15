@include('Admin.layout.header')

@include('Admin.Layout.sidebar')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang di SiMagang Tirta
                                    Mayang</h5>
                                <p class="mb-4">
                                    Semangat terus beraktifitas
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-8 order-1">
                <div class="card mb-4 me-4" style="width: 100%;">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        @php
                            $countMagang = App\Models\User::where('role', 'magang')->where('status', 'aktif')->count();
                        @endphp

                        @if ($countMagang > 0)
                            <span class="fw-semibold d-block mb-1">Data Peserta Magang Aktif</span>
                            <h3 class="card-title mb-2">{{ $countMagang }} Peserta</h3>
                        @else
                            <span class="fw-semibold d-block mb-1">Data Peserta Magang Aktif</span>
                            <h3 class="card-title mb-2">Tidak Ada Peserta Magang</h3>
                        @endif
                        <button type="button" class="btn btn-primary">
                            <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Selengkapnya
                        </button>
                    </div>
                </div>
            </div>
            @php
                $countDosen = App\Models\User::where('role', 'dosen')->where('status', 'aktif')->count();
            @endphp

            <div class="col-lg-3 col-md-6 order-1">
                <div class="card mb-4" style="width: 100%;">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                    class="rounded" />
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Data Dosen Instasi</span>
                        <h3 class="card-title mb-2">{{ $countDosen }} Dosen</h3>
                        <button type="button" class="btn btn-primary">
                            <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Selengkapnya
                        </button>
                    </div>
                </div>
            </div>
            <!-- List Kehadiran Magang -->
            <div class="col-lg-5 col-md-8 order-1">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Kehadiran Per-{{ \Carbon\Carbon::now()->format('l, d F Y') }}
                        </h5>
                    </div>
                    <div class="card-body scrollable-card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <!-- FOTO -->
                                    <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">M.Hazron Redian</h6>
                                        <span class="text-muted">Departemen IT</span>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">Hadir</h6>
                                        <span class="text-muted">07.45</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">M.Hazron Redian</h6>
                                        <span class="text-muted">Departemen IT</span>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">Hadir</h6>
                                        <span class="text-muted">07.45</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">M.Hazron Redian</h6>
                                        <span class="text-muted">Departemen IT</span>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">Hadir</h6>
                                        <span class="text-muted">07.45</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">M.Hazron Redian</h6>
                                        <span class="text-muted">Departemen IT</span>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-success">Hadir</h6>
                                        <span class="text-muted">07.45</span>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../assets/img/icons/unicons/paypal.png" alt="User"
                                        class="rounded" />
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">RTS Nuraini</h6>
                                        <span class="text-muted">Departemen </span>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0 text-danger">Tidak/Belum Hadir</h6>
                                        <span class="text-muted"></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- BATAS CONTENT   -->

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @include('admin.layout.footer')
