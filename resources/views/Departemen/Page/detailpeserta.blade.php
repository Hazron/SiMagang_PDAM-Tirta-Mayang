@include('admin.layout.header')
@include('departemen.Layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Departemen / Data Peserta / </span>
            {{ $peserta->name }} | {{ $peserta->asal_kampus }}
        </h4>

        <div class="position-relative mb-5">
            <img src="{{ asset('assets/img/banner1.jpg') }}" class="img-fluid w-100 rounded"
                style="height:auto; max-height: 200px; filter: brightness(0.6);" alt="Banner Peserta" />

            <img src="{{ $peserta->fotoprofile ? asset('assets/img/fotoprofile_user/' . $peserta->fotoprofile) : asset('assets/img/blank-profile.png') }}"
                class="img-fluid rounded-circle position-absolute"
                style="width: 150px; height: 150px; bottom: -30px; left: 20px; border: 5px solid white;"
                alt="Profile" />
        </div>

        <ul class="nav nav-pills mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="pill" href="#profile">Informasi Personal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#presensi">Presensi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="pill" href="#logbook">Logbook</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Profile -->
            <div class="tab-pane fade show active" id="profile">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Informasi Personal
                    </h5>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $peserta->name }}</td>
                            </tr>
                            <tr>
                                <td>Asal Kampus</td>
                                <td>:</td>
                                <td>{{ $peserta->asal_kampus }}</td>
                            </tr>
                            <tr>
                                <td>Jurusan</td>
                                <td>:</td>
                                <td>{{ $peserta->jurusan }}</td>
                            </tr>
                            <tr>
                                <td>Departemen</td>
                                <td>:</td>
                                <td>{{ $peserta->departemen->nama_departemen ?? 'Tidak ditentukan' }}</td>
                            </tr>
                            <tr>
                                <td>Departemen Pembimbing</td>
                                <td>:</td>
                                <td>{{ $peserta->departemen->nama_pembimbing ?? 'Tidak ditentukan' }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Telepon</td>
                                <td>:</td>
                                <td>
                                    <div id="noTelpon{{ $peserta->id }}" style="display: none;">
                                        {{ $peserta->no_telpon }}
                                    </div>
                                    <button class="btn btn-sm btn-secondary"
                                        onclick="toggleVisibility({{ $peserta->id }})">Lihat Nomor Telepon</button>
                                </td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $peserta->alamat }}</td>
                            </tr>
                            <tr>
                                <td>Dosen Pembimbing</td>
                                <td>:</td>
                                <td>{{ $peserta->dosen ? $peserta->dosen->nama : 'Tidak ada dosen pembimbing' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @php
                use Carbon\Carbon;
            @endphp
            <!-- Presensi -->
            <div class="tab-pane fade" id="presensi">
                <div class="card">
                    <div class="card-body">
                        @foreach ($monthRange as $month)
                            <h5>{{ Carbon::parse($month)->format('F Y') }}</h5>
                            <table class="table table-bordered mb-4">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($date = Carbon::parse($month); $date->format('Y-m') === $month && $date <= $endDate; $date->addDay())
                                        @if ($date >= $startDate)
                                            <tr>
                                                <td>{{ $date->format('d M Y (D)') }}</td>
                                                @if (isset($presensi[$month]) && $presensi[$month]->where('tanggal', $date->format('Y-m-d'))->first())
                                                    @php $p = $presensi[$month]->where('tanggal', $date->format('Y-m-d'))->first() @endphp
                                                    <td>{{ $p->jam_masuk }}</td>
                                                    <td>{{ $p->jam_keluar }}</td>
                                                    <td>{{ $p->status }}</td>
                                                @else
                                                    <td colspan="3" class="text-center">Tidak Hadir</td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endfor
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Logbook -->
            <div class="tab-pane fade" id="logbook">
                <div class="card">
                    <div class="card-body">
                        @foreach ($monthRange as $month)
                            <h5>{{ Carbon::parse($month)->format('F Y') }}</h5>
                            <table class="table table-bordered mb-4">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Deskripsi Kegiatan</th>
                                        <th>Dokumentasi (Opsional)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($date = Carbon::parse($month); $date->format('Y-m') === $month && $date <= $endDate; $date->addDay())
                                        @if ($date->isWeekday())
                                            @if ($date >= $startDate)
                                                <tr>
                                                    <td>{{ $date->format('d M Y (D)') }}</td>
                                                    @if (isset($logbook[$month]) && $logbook[$month]->where('tanggal', $date->format('Y-m-d'))->first())
                                                        @php $log = $logbook[$month]->where('tanggal', $date->format('Y-m-d'))->first() @endphp
                                                        <td>{{ $log->deskripsi_kegiatan }}</td>
                                                        <td>
                                                            @if ($log->dokumentasi)
                                                                <img src="{{ asset('path/to/dokumentasi/' . $log->dokumentasi) }}"
                                                                    alt="Dokumentasi" style="max-width: 100px;">
                                                            @else
                                                                Tidak ada dokumentasi
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td colspan="2" class="text-center">Tidak Membuat Logbook
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endif
                                        @endif
                                    @endfor
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.Layout.footer')
</div>

<script>
    function toggleVisibility(id) {
        var x = document.getElementById("noTelpon" + id);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
