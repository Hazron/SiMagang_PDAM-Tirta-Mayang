@include('admin.layout.header')
@include('admin.Layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Magang / </span>
            {{ $peserta->name }} | {{ $peserta->asal_kampus }}
        </h4>

        <div class="position-relative mb-5">
            <img src="{{ asset('assets/img/banner1.jpg') }}" class="img-fluid w-100 rounded"
                style="height:auto; max-height: 200px; filter: brightness(0.6);" alt="Banner Peserta" />

            <img src="{{ asset('assets/img/fotoprofile_user/' . $peserta->fotoprofile) }}"
                class="img-fluid rounded-circle position-absolute"
                style="width: 150px; height: 150px; bottom: -30px; left: 20px; border: 5px solid white;"
                alt="blank-profile" />

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
                        </table>
                    </div>
                </div>
            </div>
            <!-- Presensi -->
            <div class="tab-pane fade" id="presensi">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($presensi as $presensiItem)
                                    <tr>
                                        <td>{{ $presensiItem['tanggal']->translatedFormat('j F Y') }}</td>
                                        <td>{{ $presensiItem['jam_masuk'] ?? '-' }}</td>
                                        <td>{{ $presensiItem['jam_keluar'] ?? '-' }}</td>
                                        <td style="color: {{ $presensiItem['status'] == 'hadir' ? 'green' : 'red' }};">
                                            {{ ucfirst($presensiItem['status']) }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Logbook -->
            <div class="tab-pane fade" id="logbook">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal & Hari</th>
                                    <th>Deskripsi Kegiatan</th>
                                    <th>Dokumentasi (Opsional)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logbook as $entry)
                                    <tr>
                                        <td>{{ $entry['tanggal']->format('j F Y') }}</td>
                                        <td>{{ $entry['deskripsi_kegiatan'] }}</td>
                                        <td>
                                            @if ($entry['dokumentasi'])
                                                <img src="{{ asset('storage/' . $entry['dokumentasi']) }}"
                                                    alt="Dokumentasi" width="50" height="50">
                                            @else
                                                Tidak ada dokumentasi
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleVisibility(id) {
            var element = document.getElementById('noTelpon' + id);
            var button = element.nextElementSibling;

            if (element.style.display === 'none') {
                element.style.display = 'inline';
                button.innerText = 'Sembunyikan Nomor Telepon';
            } else {
                element.style.display = 'none';
                button.innerText = 'Lihat Nomor Telepon';
            }
        }
    </script>

    @include('admin.Layout.footer')
</div>
