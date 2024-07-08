    @include('Admin.layout.header')
    @include('Admin.Layout.sidebar')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Data Peserta Magang</h4>
            <!-- Hoverable Table rows -->
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Daftar Peserta Magang
                    <button type="button" class="btn btn-info float-end">
                        <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Tambah Data
                    </button>
                </h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Status</th>
                                <th>Asal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong></strong>
                                </td>
                                <td>M.Hazron Redian</td>
                                <td>
                                    Departemen IT
                                </td>
                                <td><span class="badge bg-label-success me-1">Aktif</span></td>
                                <td>Universitas Jambi</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Hoverable Table rows -->
            <hr class="my-5" />


        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->

    @include('Admin.layout.footer')
