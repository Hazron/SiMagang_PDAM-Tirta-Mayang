@include('Admin.Layout.header')
@include('Departemen.Layout.sidebar')

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
                                <h5 class="card-title text-primary">
                                    Selamat Datang di SiMagang Tirta Mayang, sebagai {{ $user->role }}
                                    di {{ Auth::user()->departemens->nama_departemen }}
                                </h5>
                                <p class="mb-4">Ayo Semangat terus beraktifitas</p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../assets/img/logopdam.png" height="140" alt="View Badge User" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENT 1 DONE --}}
            <div class="col-lg-5 col-md-8 order-1">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Kehadiran Hari Ini -
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</h5>
                    </div>
                    <div class="card-body scrollable-card-body">
                        <ul class="p-0 m-0">
                            @foreach ($siswaMagang as $pesertaMagang)
                                @php
                                    $presensi = $pesertaMagang->presensi->first();
                                    $status = $presensi ? 'Hadir' : 'Tidak Hadir';
                                    $jamMasuk = $presensi ? $presensi->jam_masuk : '-';
                                @endphp
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <!-- FOTO -->
                                        <img src="{{ $pesertaMagang->foto_url ?? '../assets/img/blank-profile.png' }}"
                                            alt="User" class="rounded" width="50" height="50" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $pesertaMagang->name }}</h6>
                                            <span
                                                class="text-muted">{{ $pesertaMagang->departemen->nama_departemen }}</span>
                                        </div>
                                        <div class="user-progress d-flex align-items-center gap-1">
                                            <h6 class="mb-0 text-{{ $status === 'Hadir' ? 'success' : 'danger' }}">
                                                {{ $status }}</h6>
                                            <span class="text-muted">{{ $jamMasuk }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            {{-- END CONTENT 1 --}}

            <!-- Content for Logbook Hari Ini -->
            <div class="col-lg-7 col-md-8 order-1">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Logbook Peserta Magang Hari Ini -
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </h5>
                    </div>
                    <div class="card-body scrollable-card-body">
                        <ul class="p-0 m-0">
                            @foreach ($siswaMagang as $pesertaMagang)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <!-- FOTO -->
                                        <img src="{{ $pesertaMagang->foto_url ?? '../assets/img/blank-profile.png' }}"
                                            alt="User" class="rounded" width="50" height="50" />
                                    </div>
                                    <div
                                        class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $pesertaMagang->name }}</h6>
                                            <span
                                                class="text-muted">{{ $pesertaMagang->departemen->nama_departemen }}</span>
                                        </div>
                                        <div class="user-progress d-flex flex-column align-items-start gap-1">
                                            @php
                                                $logbook = $pesertaMagang->logbook->first();
                                            @endphp
                                            @if ($logbook)
                                                <h6 class="mb-0 text-success">Sudah Membuat Logbook</h6>
                                                <span class="text-muted">{{ $logbook->status }}</span>
                                            @else
                                                <h6 class="mb-0 text-danger">Tidak/Belum membuat Logbook</h6>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('Admin.layout.footer')
