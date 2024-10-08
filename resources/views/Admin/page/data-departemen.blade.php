@include('Admin.layout.header')
@include('Admin.Layout.sidebar')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Data Departemen /</span> Data
            Pembimbing Departemen</h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" data-bs-dismiss="alert"
                data-bs-delay="5000">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $departemen->id_departemen }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete({{ $departemen->id_departemen }}, '{{ $departemen->nama_departemen }}', {{ $departemen->user_id }})">
                                            Hapus
                                        </button>

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
                                        <input type="text" class="form-control"
                                            placeholder="Nama Departemen pada PDAM Tirta Mayang" name="nama_departemen"
                                            required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Nama Pembimbing</label>
                                        <input type="text" class="form-control"
                                            placeholder="Nama Pembimbing di Departemen" name="nama_pembimbing" required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Nomor Induk</label>
                                        <input type="text" class="form-control" placeholder="Nomor Induk"
                                            name="nomor_induk" required>
                                        <div class="form-text">Nomor Induk digunakan untuk password login</div>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" placeholder="Nomor Induk"
                                            name="email" required>
                                        <div class="form-text">Email digunakan untuk login</div>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Nomor Telepon</label>
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

                {{-- MODAL EDIT --}}
                @foreach ($departemens as $departemen)
                    <div class="modal fade" id="editModal{{ $departemen->id_departemen }}" tabindex="-1"
                        aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Data
                                        Departemen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('update-departemen', $departemen->id_departemen) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="nama_departemen" class="form-label">Nama
                                                Departemen</label>
                                            <input type="text" class="form-control" id="nama_departemen"
                                                name="nama_departemen" value="{{ $departemen->nama_departemen }}"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_pembimbing" class="form-label">Nama
                                                Pembimbing</label>
                                            <input type="text" class="form-control" id="nama_pembimbing"
                                                name="nama_pembimbing" value="{{ $departemen->nama_pembimbing }}"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor_induk">Nomor Induk</label>
                                            <input type="text" class="form-control" id="nomor_induk"
                                                name="nomor_induk" value="{{ $departemen->user->nomor_induk }}" required>
                                            <div class="form-text">Nomor Induk digunakan untuk password login</div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan
                                            Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
        </div>

        <!-- Content wrapper -->

        <script>
            function confirmDelete(id_departemen, nama_departemen, user_id) {
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Anda akan menghapus " + nama_departemen +
                        " dan peserta magang akan kehilangan data departemennya!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Konfirmasi Akhir",
                            text: "Penghapusan ini tidak dapat dibatalkan!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ya, hapus!"
                        }).then((result2) => {
                            if (result2.isConfirmed) {
                                $.ajax({
                                    url: '/admin/delete-departemen/' + id_departemen + '/' + user_id,
                                    type: 'DELETE',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success: function(response) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.success || 'Departemen berhasil dihapus.',
                                            'success'
                                        ).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    },
                                    error: function(xhr) {
                                        var errorMessage = 'Terjadi kesalahan saat menghapus data!';
                                        if (xhr.responseJSON && xhr.responseJSON.error) {
                                            errorMessage = xhr.responseJSON.error;
                                        }
                                        Swal.fire(
                                            'Oops...',
                                            errorMessage,
                                            'error'
                                        );
                                    }
                                });
                            }
                        });
                    }
                });
            }
        </script>

        @include('Admin.layout.footer')
    </div>
</div>
