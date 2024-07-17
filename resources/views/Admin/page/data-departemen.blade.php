@include('Admin.layout.header')
@include('Admin.Layout.sidebar')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Data Departemen /</span> Data
            Pembimbing Departemen</h4>
        <!-- Hoverable Table rows -->
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Daftar Departemen PDAM
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Tambah Data
                    </button>
                </div>
            </h5>

            <div class="table-responsive">
                <table id="departemenDataTables" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Departemen</th>
                            <th>Nama Pembimbing Departemen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($departemens) == 0)
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data departemen</td>
                            </tr>
                        @else
                            @foreach ($departemens as $departemen)
                                <tr>
                                    <td><a
                                            href="{{ route('deatil-departemen', ['id_departemen' => $departemen->id_departemen]) }}">{{ $departemen->nama_departemen }}</a>
                                    </td>
                                    <td>{{ $departemen->nama_pembimbing }}</td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <!--/ Hoverable Table rows -->
                <hr class="my-5" />

                <!-- Modal Tambah -->
                <div class="modal fade text-left" id="modalTambah" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel1">Tambah Data Departemen</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('store-departemen') }}" method="post">
                                    @csrf
                                    <div class="mb-1">
                                        <label class="form-label">Nama Departemen</label>
                                        <input type="text" class="form-control" placeholder="Nama Lengkap"
                                            name="nama_departemen" required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Nama Pembimbing</label>
                                        <input type="text" class="form-control" placeholder="Nomor Induk"
                                            name="nama_pembimbing" required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Nomor Induk</label> <!-- UNTUK TABEL USER -->
                                        <input type="text" class="form-control" placeholder="Nomor Induk"
                                            name="nomor_induk" required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Email</label> <!-- UNTUK TABEL USER -->
                                        <input type="email" class="form-control" placeholder="Nomor Induk"
                                            name="email" required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Nomor Telepon</label> <!-- UNTUK TABEL USER -->
                                        <input type="text" class="form-control"
                                            placeholder="Nomor yang dapat terhubung WhatsApp" name="no_telpon" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal Tambah -->
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
        @include('Admin.layout.footer')
    </div>
</div>
