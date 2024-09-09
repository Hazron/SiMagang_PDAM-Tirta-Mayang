@include('Admin.layout.header')
@include('magang.Layout.sidebar')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Magang / Profile Peserta / Set Password</span>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </h4>

        <div class="row">
            <div class="col-lg-4 mb-4 order-0">
                <div class="card text-center">
                    <h5 class="card-header">
                        Profile User
                    </h5>
                    <hr class="m-0">
                    <div class="card-body">
                        <form action="{{ route('profilePicture-magang.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="text-center">
                                        <img src="{{ $userMagang->fotoprofile ? asset('profilePicture/' . $userMagang->fotoprofile) : asset('assets/img/blank-profile.png') }}"
                                            class="rounded-circle img-thumbnail" width="250" height="250"
                                            style="object-fit: cover; border-radius: 50%; overflow: hidden;"
                                            alt="{{ $userMagang->name }}">
                                        <h5 class="mt-3">Nama : {{ $userMagang->name }}</h5>
                                        <h5 class="mt-3"> Nomor Induk : {{ $userMagang->nomor_induk }}</h5>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('password-magang.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password Lama</label>
                                        <input class="form-control" type="password" id="password" name="password"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Password Baru</label>
                                        <input class="form-control" type="password" id="new_password"
                                            name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password
                                            Baru</label>
                                        <input class="form-control" type="password" id="new_password_confirmation"
                                            name="new_password_confirmation" required>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Admin.layout.footer')
