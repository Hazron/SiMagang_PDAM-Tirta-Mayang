<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function index()
    {
        return view('Departemen.Page.listpeserta');
    }

    public function getData()
    {
        $user = Auth::user();
        $departemenId = $user->departemens->id_departemen;

        $peserta = User::where('departemen_id', $departemenId)
            ->where('role', 'magang')
            ->where('status', 'aktif');
        return DataTables::of($peserta)
            ->addColumn('foto', function ($user) {
                return $user->fotoprofile
                    ? '<img src="' . asset('storage/' . $user->fotoprofile) . '" alt="Foto Profil" class="img-thumbnail" width="50">'
                    : '<img src="' . asset('path/to/default/image.jpg') . '" alt="Foto Default" class="img-thumbnail" width="50">';
            })
            ->addColumn('nama', function ($user) {
                return $user->name;
            })
            ->addColumn('status', function ($user) {
                return $user->status;
            })
            ->addColumn('asal', function ($user) {
                return $user->asal_kampus;
            })
            ->addColumn('pembimbing', function ($user) {
                return $user->dosen ? $user->dosen->nama_pembimbing : 'Belum ditentukan';
            })
            ->addColumn('tanggal_mulai', function ($user) {
                return $user->tanggal_mulai;
            })
            ->rawColumns(['foto'])
            ->make(true);
    }
}