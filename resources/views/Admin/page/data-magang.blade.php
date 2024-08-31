@include('Admin.layout.header')
@include('Admin.Layout.sidebar')

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Data Magang /</span> Data Peserta Magang
        </h4>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

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
                <table id="pesertaTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Status</th>
                            <th>Asal</th>
                            <th>Durasi Magang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
        <div class="form-text">
            PASTIKAN SUDAH MEMILIKI DATA DEPARTEMEN, AGAR DAPAT MEMILIH DEPARTEMEN SETIAP PESERTA MAGANG
        </div>
    </div>
</div>


<!-- Modal Tambah -->
<div class="modal fade text-left" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Tambah Data</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('store-peserta') }}" method="POST">
                    @csrf
                    <div class="mb-1">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Nama Lengkap" name="name" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Nomor Induk</label>
                        <input type="text" class="form-control" placeholder="Nomor Induk" name="nomor_induk"
                            required>
                        <div class="form-text">Nomor Induk digunakan untuk password login. pastikan nomor induk dengan
                            benar dimiliki peserta magang</div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Asal Instasi</label>
                        <input type="text" class="form-control" placeholder="Asal Instasi" name="asal" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Jurusan</label>
                        <input type="text" class="form-control" placeholder="Jurusan Instasi" name="jurusan"
                            required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="number" class="form-control" placeholder="Nomor yang dapat terhubung WhatsApp"
                            name="no_telpon" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Departemen</label>
                        <select class="form-select" name="departemen_id" required>
                            <option value="">Pilih Departemen</option>
                            @foreach ($departemens as $departemen)
                                <option value="{{ $departemen->id_departemen }}">{{ $departemen->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Tanggal Mulai Magang</label>
                        <input type="date" class="form-control" placeholder="Asal" name="tanggal_mulai" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Tanggal Selesai Magang</label>
                        <input type="date" class="form-control" placeholder="Asal" name="tanggal_selesai" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Jam Selesai Magang</label>
                        <input type="time" class="form-control" placeholder="Jam Selesai magang"
                            name="jam_selesai" required>
                        <div class="form-text">Jam Selesai Magang digunakan untuk menentukan Waktu Presensi Pulang
                            peserta Magang</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah -->

@foreach ($users as $user)
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Edit Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update-peserta', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status{{ $user->id }}" class="form-label">Status</label>
                            <select class="form-select" id="status{{ $user->id }}" name="status" required>
                                <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak aktif" {{ $user->status == 'tidak aktif' ? 'selected' : '' }}>
                                    Tidak Aktif</option>
                                <option value="selesai" {{ $user->status == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Edit -->
@endforeach

@include('Admin.layout.footer')

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#pesertaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('datapeserta') }}',
            columns: [{
                    data: 'fotoprofile',
                    render: function(data, type, row) {
                        let fotoUrl = data ?
                            `{{ asset('assets/img/fotoprofile_user/') }}/${data}` :
                            '../assets/img/blank-profile.png';
                        return `<img src="${fotoUrl}" alt="Foto" width="75">`;
                    }
                },
                {
                    data: 'nama',
                },
                {
                    data: 'departemen',
                    name: 'departemen'
                },
                {
                    data: 'status'
                },
                {
                    data: 'asal_kampus'
                },
                {
                    data: 'durasi_magang'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#pesertaTable').on('click', '.delete', function() {
            var id = $(this).data('id');
            var url = "{{ url('admin/delete-peserta') }}" + '/' + id;

            swal({
                    title: "Apakah Anda yakin?",
                    text: "Data akan dihapus secara permanen!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                swal("Data berhasil dihapus!", {
                                    icon: "success",
                                });
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                swal("Oops...",
                                    "Terjadi kesalahan saat menghapus data!",
                                    "error");
                            }
                        });
                    } else {
                        swal("Data batal dihapus!");
                    }
                });
        });
    });
</script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<!-- Include SweetAlert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
