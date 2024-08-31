    @include('Admin.layout.header')
    @include('Admin.Layout.sidebar')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Data Magang /</span> Data Dosen
                Instasi</h4>
            <!-- Hoverable Table rows -->
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Daftar Dosen Instasi
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-info float-end" data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                            <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Tambah Data
                        </button>
                    </div>
                </h5>

                <div class="table-responsive">
                    <table id="dosenDataTables" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Asal Instasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>

                    <!--/ Hoverable Table rows -->
                    <hr class="my-5" />

                    <!-- Modal Tambah -->
                    <div class="modal fade text-left" id="modalTambah" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel1">Tambah Data Dosen</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('store-dosen') }}" method="POST">
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
                                            <label class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control"
                                                placeholder="Nomor yang dapat terhubung WhatsApp" name="no_telpon"
                                                required>
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
            <!-- Include jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <!-- Include DataTables JS -->
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

            <!-- Include SweetAlert -->
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

            <script>
                $(document).ready(function() {
                    var table = $('#dosenDataTables').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('datadosen') }}",
                        columns: [{
                                data: 'fotoprofile'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'asal_kampus',
                                name: 'asal_kampus'
                            },
                            {
                                data: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });

                    // Edit user (AJAX form submission for edit)
                    $('form[id^="editForm"]').on('submit', function(event) {
                        event.preventDefault();
                        var form = $(this);
                        var id = form.attr('id').replace('editForm', '');
                        var url = "{{ url('admin/edit-dosen') }}" + '/' + id;
                        var data = form.serialize();

                        $.ajax({
                            url: url,
                            type: 'PUT',
                            data: data,
                            success: function(response) {
                                swal("Status berhasil diupdate!", {
                                    icon: "success",
                                });
                                table.ajax.reload();
                                form.closest('.modal').modal('hide');
                            },
                            error: function(xhr) {
                                swal("Oops...", "Terjadi kesalahan saat mengupdate status!", "error");
                            }
                        });
                    });
                });

                function deleteDosen(id) {
                    swal({
                            title: "Apakah Anda yakin?",
                            text: "Setelah dihapus, Anda tidak akan dapat memulihkan data dosen ini!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: "{{ url('admin/delete-dosen') }}/" + id,
                                    type: 'DELETE',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                    },
                                    success: function(response) {
                                        swal("Data dosen berhasil dihapus!", {
                                            icon: "success",
                                        });
                                        $('#dosenDataTables').DataTable().ajax.reload();
                                    },
                                    error: function(xhr) {
                                        swal("Oops...", "Terjadi kesalahan saat menghapus data!", "error");
                                    }
                                });
                            }
                        });
                }
            </script>
