@include('admin.layout.header')
@include('admin.Layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('data-dosen') }}" class="btn btn-secondary">
                <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Kembali
            </a>
        </div>
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Dosen / </span>
            {{ $dosen->dosen->name }} | {{ $dosen->asal_kampus }}
        </h4>

        <div class="position-relative mb-5">
            <img src="{{ asset('assets/img/banner1.jpg') }}" class="img-fluid w-100 rounded"
                style="height:auto; max-height: 200px; filter: brightness(0.6);" alt="Banner Dosen" />

            <img src="{{ asset('assets/img/blank-profile.png') }}" class="img-fluid rounded-circle position-absolute"
                style="width: 150px; height: 150px; bottom: -30px; left: 20px; border: 5px solid white;"
                alt="blank-profile" />
        </div>

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Daftar Peserta Bimbingan
                <div class="d-flex align-items-center gap-2">
                    <div class="me-2">
                        <input type="text" class="form-control" placeholder="Search..." id="search">
                    </div>
                    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Tambah Peserta
                    </button>
                </div>
            </h5>
            <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Asal Instansi</th>
                            <th>Jurusan</th>
                            <th>Departemen</th>
                            <th>Durasi Magang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($pesertaBimbingan as $user)
                            <tr>
                                <td>
                                    <img src="{{ $user->fotoprofile ? asset('profilePicture/' . $user->fotoprofile) : asset('assets/img/blank-profile.png') }}"
                                        alt="{{ $user->name }}" class="img-thumbnail"
                                        style="width: 100px; height: 100px;">
                                </td>
                                <td><a href="{{ route('detail-peserta', $user->id) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->asal_kampus }}</td>
                                <td>{{ $user->jurusan }}</td>
                                <td>{{ $user->departemen->nama_departemen ?? '-' }}</td>
                                <td title="{{ \Carbon\Carbon::parse($user->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($user->tanggal_selesai)) }} hari"
                                    data-bs-toggle="tooltip" data-bs-placement="top">
                                    {{ \Carbon\Carbon::parse($user->tanggal_mulai)->format('d-m-Y') }} s/d
                                    {{ \Carbon\Carbon::parse($user->tanggal_selesai)->format('d-m-Y') }}
                                </td>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" onclick="confirmCabut({{ $user->id }}, '{{ $user->name }}')">
                                        Cabut
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada peserta bimbingan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalTambahLabel">Daftar Peserta Magang</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Departemen</th>
                                    <th>Asal Instasi</th>
                                    <th>Durasi Magang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesertaMagang as $user)
                                    <tr>
                                        <td>{{ $user->name ?? '-' }}</td>
                                        <td>{{ $user->departemen->nama_departemen ?? '-' }}</td>
                                        <td>{{ $user->asal_kampus ?? '-' }}</td>
                                        <td>
                                            @php
                                                $startDate = Carbon\Carbon::parse($user->tanggal_mulai);
                                                $endDate = Carbon\Carbon::parse($user->tanggal_selesai);
                                                $diff = $startDate->diffInDays($endDate);
                                            @endphp
                                            {{ $diff }} Hari
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('assign.dosen', ['dosen_id' => $dosen->id_pembimbing, 'user_id' => $user->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Tambahkan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function confirmCabut(id, name) {
    Swal.fire({
        title: 'Cabut Dosen?',
        text: "Apakah kamu yakin ingin mencabut dosen pada peserta magang dengan nama " + name + "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Lanjutkan'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/cabut-dosen/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ _method: 'POST' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Sukses!', data.success, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.error, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Terjadi kesalahan saat mencoba menghapus peserta.', 'error');
            });
        }
    });
}

        </script>

    </div>
    @include('admin.Layout.footer')
</div>
