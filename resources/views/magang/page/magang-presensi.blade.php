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
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Periode {{ \Carbon\Carbon::parse(auth()->user()->tanggal_mulai)->isoFormat('D MMMM YYYY') }} s/d {{ \Carbon\Carbon::parse(auth()->user()->tanggal_selesai)->isoFormat('D MMMM Y') }}
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableMagangPresensi">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk Presensi</th>
                                    <th>Jam Keluar Presensi</th>
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

    @include('Admin.Layout.footer')
    <script>
      $(document).ready(function() {
    var table = $('#dataTableMagangPresensi').DataTable({
        processing: true,
        serverSide: true,
        paging: true, // Aktifkan pagination // Batas 5 item per halaman
        ajax: {
            url: '{{ route('magang.presensi.data') }}',
            type: 'GET',
            data: function(d) {
                d.start_date = '{{ now()->startOfWeek()->format('Y-m-d') }}';
                d.end_date = '{{ now()->addDays(3)->format('Y-m-d') }}';
                d.page = d.start / d.length + 1; // Set halaman berdasarkan DataTables pagination
            }
        },
        columns: [
            { data: null, name: 'no', searchable: false, orderable: false },
            { data: 'hari', name: 'hari' },
            { data: 'status', name: 'status' },
            { data: 'tanggal', name: 'tanggal' },
            { data: 'jam_masuk', name: 'jam_masuk' },
            { data: 'jam_keluar', name: 'jam_keluar' },
            { data: 'aksi', name: 'aksi' }
        ],
        order: [[3, 'asc']],
        rowCallback: function(row, data, index) {
            var pageInfo = table.page.info();
            var page = pageInfo.page;
            var length = pageInfo.length;
            var number = page * length + index + 1;
            $('td:eq(0)', row).html(number);

            var status = data.status;
            var statusCell = $('td:eq(2)', row);
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

    $('#dataTableMagangPresensi').on('click', '.presensiPulangBtn', function() {
        var button = $(this);
        var tanggal = button.data('tanggal');

        button.prop('disabled', true).text('Sedang memproses...');

        $.ajax({
            url: '{{ route('magang.presensi.pulang') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                tanggal: tanggal
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    table.ajax.reload();
                } else {
                    alert(response.message);
                    button.prop('disabled', false).text('Presensi Pulang');
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan, silakan coba lagi.');
                button.prop('disabled', false).text('Presensi Pulang');
            }
        });
    });
});

    </script>
