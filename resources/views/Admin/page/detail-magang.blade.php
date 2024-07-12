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

            <img src="{{ asset('assets/img/blank-profile.png') }}" class="img-fluid rounded-circle position-absolute"
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
                                <td>{{ $peserta->departemen }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $peserta->alamat }}</td>
                            </tr>
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
                                <tr>
                                    <td>1 Juli 2024</td>
                                    <td>07.30</td>
                                    <td>16.00</td>
                                    <td style="color: green;">Hadir</td>
                                </tr>
                                <tr>
                                    <td>1 Juli 2024</td>
                                    <td>07.30</td>
                                    <td>16.00</td>
                                    <td style="color: green;">Hadir</td>
                                </tr>
                                <tr>
                                    <td>1 Juli 2024</td>
                                    <td>07.30</td>
                                    <td>16.00</td>
                                    <td style="color: green;">Hadir</td>
                                </tr>
                                <tr>
                                    <td>1 Juli 2024</td>
                                    <td>07.30</td>
                                    <td>16.00</td>
                                    <td style="color: green;">Hadir</td>
                                </tr>
                                <tr>
                                    <td>1 Juli 2024</td>
                                    <td>07.30</td>
                                    <td>16.00</td>
                                    <td style="color: green;">Hadir</td>
                                </tr>
                                <tr>
                                    <td>1 Juli 2024</td>
                                    <td>07.30</td>
                                    <td>16.00</td>
                                    <td style="color: green;">Hadir</td>
                                </tr>
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
                                <tr>
                                    <th>1 Juli 2024</th>
                                    <th>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, voluptatum hic!
                                        Numquam eaque sequi necessitatibus, pariatur, praesentium cumque suscipit eius
                                        velit vitae nobis laudantium.</th>
                                    <th>
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="" width="50"
                                            height="50">
                                    </th>
                                </tr>
                                <tr>
                                    <th>1 Juli 2024</th>
                                    <th>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, voluptatum hic!
                                        Numquam eaque sequi necessitatibus, pariatur, praesentium cumque suscipit eius
                                        velit vitae nobis laudantium.</th>
                                    <th>
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt=""
                                            width="50" height="50">
                                    </th>
                                </tr>
                                <tr>
                                    <th>1 Juli 2024</th>
                                    <th>Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, voluptatum hic!
                                        Numquam eaque sequi necessitatibus, pariatur, praesentium cumque suscipit eius
                                        velit vitae nobis laudantium.</th>
                                    <th>
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt=""
                                            width="50" height="50">
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.Layout.footer')
</div>
