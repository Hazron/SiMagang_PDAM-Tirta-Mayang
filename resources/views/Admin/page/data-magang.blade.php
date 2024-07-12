    @include('Admin.layout.header')
    @include('Admin.Layout.sidebar')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Data Magang /</span> Data
                Peserta
                Magang</h4>
            <!-- Hoverable Table rows -->
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Daftar Peserta Magang
                    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Tambah Data
                    </button>
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Status</th>
                                <th>Asal</th>
                                <th>Durasi Magang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <!-- Perbaiki $user menjadi singular -->
                                <tr>
                                    <td>
                                        @if ($user->fotoprofile)
                                            <img src="{{ asset('path/to/foto/' . $user->fotoprofile) }}" alt="Foto"
                                                width="100">
                                        @else
                                            <img src="{{ asset('assets/img/blank-profile.png') }}" alt="Foto"
                                                width="100">
                                        @endif
                                    </td>
                                    <td><a href="{{ route('detail-peserta', $user->id) }}">{{ $user->name }}</a>
                                    </td>
                                    <td>{{ $user->departemen }}</td>
                                    <td>
                                        @if ($user->status == 'aktif')
                                            <span class="badge bg-label-success me-1">Aktif</span>
                                        @elseif ($user->status == 'selesai')
                                            <span class="badge bg-label-warning me-1">Selesai</span>
                                        @else
                                            <span class="badge bg-label-secondary me-1">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->asal_kampus }}</td>
                                    <td>{{ Carbon\Carbon::parse($user->tanggal_mulai)->diffInDays(Carbon\Carbon::parse($user->tanggal_selesai)) }}
                                        Hari</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item text-info" data-bs-toggle="modal"
                                                    data-bs-target="#modalEdit{{ $user->id }}">
                                                    <i class="bx bx-edit me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                    onclick="deleteUser('{{ $user->id }}')">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </a>
                                                <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('destroy-peserta', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $users->links() }} <!-- Tampilkan pagination links -->
                    </div>

                    <!--/ Hoverable Table rows -->
                    <hr class="my-5" />

                    <!-- Modal Tambah -->
                    <div class="modal fade text-left" id="modalTambah" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel1">Tambah Data</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('store-peserta') }}" method="POST">
                                        @csrf
                                        <div class="mb-1">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" placeholder="Nama Lengkap"
                                                name="name" required>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Nomor Induk</label>
                                            <input type="text" class="form-control" placeholder="Nomor Induk"
                                                name="nomor_induk" required>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="Email"
                                                name="email" required>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Asal Instasi</label>
                                            <input type="text" class="form-control" placeholder="Asal" name="asal"
                                                required>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Jurusan</label>
                                            <input type="text" class="form-control" placeholder="Asal" name="jurusan"
                                                required>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Alamat</label>
                                            <input type="text" class="form-control" placeholder="Alamat"
                                                name="alamat" required>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Departemen</label>
                                            <select class="form-select" name="departemen" required>
                                                <option value="">Pilih Departemen</option>
                                                <option value="Departemen IT">Departemen IT</option>
                                                <option value="Departemen K3">Departemen K3</option>
                                                <option value="Departemen Perencanaan">Departemen Perencanaan
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Tanggal Mulai Magang</label>
                                            <input type="date" class="form-control" placeholder="Asal"
                                                name="tanggal_mulai" required>
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label">Tanggal Selesai Magang</label>
                                            <input type="date" class="form-control" placeholder="Asal"
                                                name="tanggal_selesai" required>
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

                    {{-- <!-- Modal Edit --> --}}

                    <!-- Modal Edit -->
                    @foreach ($users as $user)
                        <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1"
                            aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel1">Edit Status</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('update-peserta', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="aktif"
                                                        {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="tidak aktif"
                                                        {{ $user->status == 'tidak aktif' ? 'selected' : '' }}>Tidak
                                                        Aktif</option>
                                                    <option value="selesai"
                                                        {{ $user->status == 'selesai' ? 'selected' : '' }}>Selesai
                                                    </option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- End Modal Edit -->


                    {{-- <!-- End Modal Edit --> --}}


                </div>
                <!-- / Content -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
            <script>
                function deleteUser(userId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + userId).submit();
                        }
                    })
                }
            </script>
            @include('Admin.layout.footer')
