@include('Admin.layout.header')
@include('Admin.layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Data Logbook /</span> Data Logbook Peserta
        </h4>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                Daftar Logbook Peserta Magang
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Dari Tanggal</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table id="logbookTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Status Logbook</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables will dynamically insert rows here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="logbookModal" tabindex="-1" role="dialog" aria-labelledby="logbookModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logbookModalLabel">Detail Logbook</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                <p><strong>Deskripsi:</strong> <span id="modalDeskripsi"></span></p>
                <p><strong>Dokumentasi:</strong> <span id="modalDokumentasi"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@include('Admin.layout.footer')

<script>
    $(document).ready(function() {
        var table = $('#logbookTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('logbook.datatables') }}',
                data: function(d) {
                    d.start_date = $('input[name=start_date]').val();
                    d.end_date = $('input[name=end_date]').val();
                }
            },
            columns: [{
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'departemen',
                    name: 'departemen'
                },
                {
                    data: 'status_logbook',
                    name: 'status_logbook'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            table.draw();
        });

        $('#logbookTable').on('click', '.btn-info', function() {
            var data = table.row($(this).parents('tr')).data();
            $.ajax({
                url: '/admin/logbook/' + data.user_id + '/' + data.tanggal,
                method: 'GET',
                success: function(response) {
                    $('#modalTanggal').text(response.tanggal);
                    $('#modalDeskripsi').text(response.deskripsi);
                    if (response.dokumentasi) {
                        $('#modalDokumentasi').html('<a href="/storage/' + response
                            .dokumentasi + '" target="_blank">Lihat Dokumentasi</a>');
                    } else {
                        $('#modalDokumentasi').text('Tidak ada dokumentasi');
                    }
                    $('#logbookModal').modal('show');
                }
            });
        });
    });
</script>
