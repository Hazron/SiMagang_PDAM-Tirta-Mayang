@include('Admin.layout.header')
@include('dosen.Layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Departemen / Data Magang /</span> Data Peserta
            Magang di Departemen {{ Auth::user()->departemens->nama_departemen }}
        </h4> --}}

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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Peserta Magang</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pesertaTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Asal</th>
                                <th>Tanggal Mulai Magang</th>
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
    $(function() {
        $('#pesertaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('peserta.data.dosen') }}",
            columns: [{
                    data: 'fotoprofile',
                    name: 'fotoprofile',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'asal',
                    name: 'asal'
                },
                {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai'
                }
            ]
        });
    });
</script>
