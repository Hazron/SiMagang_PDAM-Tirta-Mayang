@include('Admin.layout.header')
@include('magang.Layout.sidebar')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Magang / Data Logbook /</span>
            {{ auth()->user()->name }}</h4>
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Daftar Kegiatan Magang
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableMagangLogbook">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi Kegiatan</th>
                                    <th>Dokumentasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Logbook Modal -->
    <div class="modal fade" id="addLogbookModal" tabindex="-1" aria-labelledby="addLogbookModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLogbookModalLabel">Tambah Logbook</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addLogbookForm">
                        <div class="mb-3">
                            <label for="tanggalLogbook" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggalLogbook" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsiKegiatan" class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control" id="deskripsiKegiatan" name="deskripsi_kegiatan" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dokumentasi" class="form-label">Dokumentasi</label>
                            <input type="file" class="form-control" id="dokumentasi" name="dokumentasi">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="editLogbookModal" tabindex="-1" aria-labelledby="editLogbookModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLogbookModalLabel">Edit Logbook</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editLogbookForm">
                        <div class="mb-3">
                            <label for="editDeskripsiKegiatan" class="form-label">Deskripsi Kegiatan</label>
                            <textarea class="form-control" id="editDeskripsiKegiatan" name="deskripsi_kegiatan" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editDokumentasi" class="form-label">Dokumentasi</label>
                            <input type="file" class="form-control" id="editDokumentasi" name="dokumentasi">
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Admin.Layout.footer')

<script>
    $(document).ready(function() {
        var table = $('#dataTableMagangLogbook').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('magang.logbook.data') }}',
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'hari',
                    name: 'hari'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'deskripsi_kegiatan',
                    name: 'deskripsi_kegiatan'
                },
                {
                    data: 'dokumentasi',
                    name: 'dokumentasi'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [2, 'asc']
            ]
        });

        // Add logbook
        $('#addLogbookForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('magang.logbook.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#addLogbookModal').modal('hide');
                    table.ajax.reload();
                    alert(response.success);
                },
                error: function(response) {
                    console.log(response);
                    alert('Failed to add logbook.');
                }
            });
        });
    });

    // Edit logbook
    $('#dataTableMagangLogbook').on('click', '.editLogbookBtn', function() {
        var logbookId = $(this).data('id');
        var tanggal = $(this).data('tanggal');
        var deskripsi = $(this).data('deskripsi');
        var dokumentasi = $(this).data('dokumentasi');

        $('#editLogbookModal').modal('show');
        $('#editLogbookForm').attr('data-id', logbookId);
        $('#editDeskripsiKegiatan').val(deskripsi);
        $('#editDokumentasi').val('');

        $('#editLogbookForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var id = $(this).attr('data-id');

            $.ajax({
                url: '{{ route('magang.logbook.update', '') }}/' + id,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editLogbookModal').modal('hide');
                    table.ajax.reload();
                    alert(response.success);
                },
                error: function(response) {
                    console.log(response);
                    alert('Failed to update logbook.');
                }
            });
        });
    });
</script>
