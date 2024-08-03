@include('Admin.layout.header')
@include('magang.Layout.sidebar')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Magang / Data Presensi /</span>
            {{ auth()->user()->name }}</h4>
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Daftar Kehadiran Magang
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableMagangPresensi">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk Presensi</th>
                                    <th>Jam Keluar Presensi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Content wrapper -->
    @include('Admin.Layout.footer')
    <script>
        $(document).ready(function() {
            var table = $('#dataTableMagangPresensi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('magang.presensi.data') }}',
                    type: 'GET'
                },
                columns: [{
                        data: null,
                        name: 'no',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'jam_masuk',
                        name: 'jam_masuk'
                    },
                    {
                        data: 'jam_keluar',
                        name: 'jam_keluar'
                    },
                ],
                order: [
                    [2, 'asc']
                ],
                rowCallback: function(row, data, index) {
                    var pageInfo = table.page.info();
                    var page = pageInfo.page;
                    var length = pageInfo.length;
                    var number = page * length + index + 1;
                    $('td:eq(0)', row).html(number);

                    // Add class for status
                    var status = data.status;
                    var statusCell = $('td:eq(1)', row);
                    if (status == 'hadir') {
                        statusCell.addClass('text-success');
                    } else if (status == 'tidak hadir') {
                        statusCell.addClass('text-danger');
                    } else if (status == 'izin') {
                        statusCell.addClass('text-warning');
                    } else if (status == 'terlambat') {
                        statusCell.addClass('text-info');
                    }
                }
            });
        });
    </script>
