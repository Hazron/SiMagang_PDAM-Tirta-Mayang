@include('admin.layout.header')
@include('admin.Layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Magang / </span>
            {{ $peserta->name }} | {{ $peserta->asal_kampus }}
        </h4>

        <div class="position-relative mb-5">
            <img src="{{ asset('assets/img/banner1.jpg') }}" class="img-fluid w-100 rounded"
                style="height:auto; max-height: 200px; filter: brightness(0.6);" alt="Banner Peserta" />

            <img src="{{ asset('assets/img/blank-profile.png') }}" class="img-fluid rounded-circle position-absolute"
                style="width: 150px; height: 150px; bottom: -30px; left: 20px; border: 5px solid white;"
                alt="blank-profile" />

        </div>

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                List Presensi
                <div class="d-flex align-items-center gap-2">
                    <div class="me-2">
                        <input type="text" class="form-control" placeholder="Search..." id="search">
                    </div>
                </div>
            </h5>
            <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Durasi Magang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @include('admin.Layout.footer')
</div>
