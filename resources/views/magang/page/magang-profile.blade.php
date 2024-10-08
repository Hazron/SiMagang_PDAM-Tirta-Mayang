@include('Admin.layout.header')
@include('Magang.layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Magang / Profile Peserta /</span>
            {{ auth()->user()->name }}</h4>
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
        </h4>
        <div class="row">
            <div class="col-lg-4 mb-4 order-0">
                <div class="card text-center">
                    <h5 class="card-header">
                        Profile Picture
                    </h5>
                    <hr class="m-0">
                    <div class="card-body">
                        <form action="{{ route('profilePicture-magang.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="text-center">
                                        <img src="{{ auth()->user()->fotoprofile ? asset('profilePicture/' . auth()->user()->fotoprofile) : asset('assets/img/blank-profile.png') }}"
                                            class="rounded-circle img-thumbnail" width="250" height="250"
                                            style="object-fit: cover; border-radius: 50%; overflow: hidden;"
                                            alt="{{ auth()->user()->name }}">

                                    </div>
                                    <div class="small font-italic text-muted mt-4">JPG dan PNG tidak lebih dari 3MB
                                    </div>
                                </div>
                                <input class="form-control mb-3 mt-4" type="file" id="formFile"
                                    name="fotoprofile" />
                                <button class="btn btn-primary" type="submit">Upload new image</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 mb-4">
                <div class="card text-center">
                    <h5 class="card-header">
                        Profile Peserta Magang
                    </h5>
                    <hr class="m-0">
                    <div class="card-body">
                        <form action="{{ route('profile-magang.update') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomor induk">Nomor Induk</label>
                                        <input type="text" class="form-control" id="nomor_induk" name="nomor_induk"
                                            value="{{ $user->nomor_induk }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp">No. HP</label>
                                        <input type="text" class="form-control" id="no_telpon" name="no_telpon"
                                            value="{{ auth()->user()->no_telpon }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="asal_kampus">Asal Kampus</label>
                                        <input type="text" class="form-control" id="asal_kampus" name="asal_kampus"
                                            value="{{ auth()->user()->asal_kampus }}" disabled>
                                    </div>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Jurusan">Jurusan</label>
                                        <input type="text" class="form-control" id="jurusan" name="jurusan"
                                            value="{{ $user->jurusan }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Dosen Pembimbing">Dosen Pembimbing</label>
                                        <input type="text" class="form-control" id="dosen_id" name="dosen_id"
                                            value="{{ $user->dosen_id ? $user->dosen->nama : 'Lapor ke SDM untuk memilih Dosen Pembimbing' }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Departemen">Departemen</label>
                                        <input type="text" class="form-control" id="departemen" name="departemen"
                                            value="{{ $user->departemen->nama_departemen ? $user->departemen->nama_departemen : 'Lapor ke SDM untuk memilih Departemen' }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Durasi Magang">Durasi Magang</label>
                                        <input type="text" class="form-control" id="durasi_magang"
                                            name="durasi_magang"
                                            value="{{ \Carbon\Carbon::parse($user->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($user->tanggal_selesai)->format('d-m-Y') }}"
                                            disabled>
                                    </div>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                            value="{{ $user->alamat }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Admin.Layout.footer')
