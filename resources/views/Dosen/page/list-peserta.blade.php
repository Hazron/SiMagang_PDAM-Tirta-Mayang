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
                                <th>Tanggal Mulai & Tanggal Selesai Magang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peserta as $item)
                            <tr>
                                <td>
                                    @if ($item->fotoprofile)
                                        <img src="{{ asset('profilePicture/' . $item->fotoprofile) }}" alt="{{ $item->name }}"
                                            class="img-thumbnail" style="width: 100px; height: 100px;">
                                    @else
                                        <img src="{{ asset('assets/img/blank-profile.png') }}" alt="Default Image"
                                            class="img-thumbnail" style="width: 100px; height: 100px;">
                                    @endif
                                </td>
                                <td><a href="{{ route('detail-peserta-bimbingan-dosen', $item->id) }}">{{ $item->name }}</a></td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->asal_kampus }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d F Y') }}</td> 
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Admin.layout.footer')
