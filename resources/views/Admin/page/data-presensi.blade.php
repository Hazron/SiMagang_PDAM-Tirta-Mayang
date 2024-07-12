    @include('Admin.layout.header')
    @include('Admin.Layout.sidebar')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Data Presensi /</span> Data Presensi
                Peserta</h4>
            <!-- Hoverable Table rows -->
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Daftar Presensi Peserta Magang
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted">Waktu Sekarang: <span id="clock"></span></span>
                    </div>
                </h5>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status Presensi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                        </tbody>
                    </table>

                    <!--/ Hoverable Table rows -->
                    <hr class="my-5" />




                </div>
                <!-- / Content -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
            <script>
                function startTime() {
                    var today = new Date();
                    var h = today.getHours();
                    var m = today.getMinutes();
                    var s = today.getSeconds();
                    m = checkTime(m);
                    s = checkTime(s);
                    document.getElementById('clock').innerHTML =
                        h + ":" + m + ":" + s;
                    var t = setTimeout(startTime, 500);
                }

                function checkTime(i) {
                    if (i < 10) {
                        i = "0" + i
                    };
                    return i;
                }
                startTime();
            </script>
            @include('Admin.layout.footer')
