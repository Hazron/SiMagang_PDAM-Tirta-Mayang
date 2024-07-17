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
                                <th>Jam Input</th>
                                <th>Status Logbook</th>
                                <th>Aksi</th> <!-- JUST NULL -->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Admin.layout.footer')

<script>
    $(document).ready(function() {
        $('#logbookTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('datatables-Logbook') }}",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
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
                    data: 'jam_input',
                    name: 'jam_input'
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
            $('#logbookTable').DataTable().draw();
        });
    });
</script>
