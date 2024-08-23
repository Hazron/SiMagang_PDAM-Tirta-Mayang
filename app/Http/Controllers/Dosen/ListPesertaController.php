<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ListPesertaController extends Controller
{
    public function index()
    {
        return view('dosen.page.list-peserta');
    }

    public function getData()
    {
        $dosen = Auth::user();
        $dosenId = $dosen->dosen_id;

        $peserta = User::where('dosen_id', $dosenId)
            ->where('role', 'magang')
            ->where('status', 'aktif');

        return DataTables::of($peserta)
            ->addColumn('foto', function ($user) {
                return $user->fotoprofile
                    ? '<img src="' . asset('storage/' . $user->fotoprofile) . '" alt="Foto Profil" class="img-thumbnail" width="50">'
                    : '<img src="' . asset('assets/img/blank-profile.png') . '" alt="Foto Default" class="img-thumbnail" width="65">';
            })
            ->addColumn('nama', function ($user) {
                return '<a href="' . '#' . '">' . $user->name . '</a>';
            })
            ->addColumn('status', function ($user) {
                return $user->status;
            })
            ->addColumn('asal', function ($user) {
                return $user->asal_kampus;
            })
            ->addColumn('tanggal_mulai', function ($user) {
                return Carbon::parse($user->tanggal_mulai)->format('d F Y') . ' / ' . Carbon::parse($user->tanggal_selesai)->format('d F Y');
            })
            ->rawColumns(['foto', 'nama'])
            ->make(true);
    }
}
