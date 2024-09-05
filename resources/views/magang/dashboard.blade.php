@include('Admin.layout.header')
@include('magang.Layout.sidebar')

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
                                <h5 class="card-title text-primary">Selamat Datang di SiMagang Tirta Mayang, sebagai
                                    {{ $user->role }}</h5>
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
        </div>
        {{-- Alert Messages --}}
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="row">
            @php
                use Carbon\Carbon;

                $tanggal = Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('ddd D MMM Y');
                $hariIni = Carbon::now('Asia/Jakarta')->isoFormat('ddd');
                $isHoliday = $hariIni == 'Sun' || $hariIni == 'Sat';
                $statusPresensi = $isHoliday
                    ? 'Anda tidak dapat melakukan presensi pada hari libur'
                    : 'Presensi hari ini tersedia';
            @endphp
            <div class="col-lg-4 col-md-8 order-1">
                <div class="card mb-4 me-4" style="width: 100%;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-lg rounded">
                                    <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                        class="rounded" />
                                </div>
                            </div>
                            <div class="col text-start">
                                <h5>PRESENSI HARI INI</h5>
                                <p>{{ $statusPresensi }}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            @if ($presensiExists)
                                <button type="button" class="btn btn-success w-100" disabled>
                                    <span class="tf-icons bx bx-check-circle"></span>&nbsp; Anda Sudah Melakukan
                                    Presensi Hari Ini
                                </button>
                            @elseif(!$presensiExists && !$isHoliday)
                                <button type="button" class="btn btn-primary w-100" id="presensiButton"
                                    onclick="getLocation(this)">
                                    <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Lakukan Presensi Hari Ini
                                </button>
                            @endif
                            @if ($canPresensiPulang && $presensiExists && !$isHoliday)
                                <button type="button" class="btn btn-primary w-100 mt-3"
                                    onclick="window.location.href='{{ route('magang.presensi') }}'">
                                    <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Lakukan Presensi Pulang
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- LOGBOOK --}}
            <div class="col-lg-4 col-md-8 order-1">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-lg rounded">
                                    <img src="../assets/img/icons/unicons/chart.png" alt="chart-line" class="rounded" />
                                </div>
                            </div>
                            <div class="col text-start">
                                @if ($isHoliday)
                                    <h5 class="card-title">LOGBOOK HARI INI</h5>
                                    <p class="mb-0">Anda tidak dapat melakukan presensi pada hari libur</p>
                                @elseif (!$logbookToday)
                                    <h5 class="card-title">Anda Belum Melakukan Logbook Hari Ini</h5>
                                    <p class="mb-0">Mohon isi logbook anda sebelum pulang</p>
                                @else
                                    <h5 class="card-title">Anda Telah Mengisi Logbook Hari Ini</h5>
                                    <p class="mb-0">Terima kasih telah mengisi logbook hari ini</p>
                                @endif
                            </div>
                        </div>
                        @if (!$logbookToday && !$isHoliday)
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary w-100" id="logbookButton"
                                    data-bs-toggle="modal" data-bs-target="#logbookModal">
                                    <span class="tf-icons bx bx-edit-alt"></span>&nbsp; Buat Logbook Hari Ini
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="logbookModal" tabindex="-1" aria-labelledby="logbookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('logbook.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="logbookModalLabel">Logbook Harian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_kegiatan" class="form-label">Deskripsi
                            Kegiatan</label>
                        <textarea class="form-control" id="deskripsi_kegiatan" name="deskripsi_kegiatan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="dokumentasi" class="form-label">Dokumentasi
                            (Opsional)</label>
                        <input type="file" class="form-control" id="dokumentasi" name="dokumentasi"
                            accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@include('Admin.layout.footer')

<form action="{{ route('presensi-magang.store') }}" method="POST" id="form-presensi" style="display: none;">
    @csrf
    <input type="hidden" id="latitude" name="latitude" value="">
    <input type="hidden" id="longitude" name="longitude" value="">
    <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
</form>

<script>
    function getLocation(button) {
        console.log('getLocation called');
        if (navigator.geolocation) {
            console.log('Geolocation is supported');
            navigator.geolocation.getCurrentPosition(function(position) {
                showPosition(position);
                button.disabled = true; // Disable the button
                button.innerHTML =
                    '<span class="tf-icons bx bx-check-circle"></span>&nbsp; Presensi sedang diproses...'; // Change button text
            }, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        console.log('showPosition called');
        console.log('Latitude: ' + position.coords.latitude + ', Longitude: ' + position.coords.longitude);
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
        document.getElementById('form-presensi').submit();
    }

    function showError(error) {
        console.log('showError called');
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }

    function getLocationPulang(button) {
        console.log('getLocationPulang called');
        if (navigator.geolocation) {
            console.log('Geolocation is supported');
            navigator.geolocation.getCurrentPosition(function(position) {
                showPositionPulang(position);
                button.disabled = true;
                button.innerHTML =
                    '<span class="tf-icons bx bx-check-circle"></span>&nbsp; Presensi Pulang sedang diproses...'; // Change button text
            }, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPositionPulang(position) {
        console.log('showPositionPulang called');
        console.log('Latitude: ' + position.coords.latitude + ', Longitude: ' + position.coords.longitude);
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
        document.getElementById('form-presensi').submit();
    }
</script>
