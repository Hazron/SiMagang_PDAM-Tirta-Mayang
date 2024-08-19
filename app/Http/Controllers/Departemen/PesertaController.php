<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


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
                    : '<img src="' . asset('assets/img/blank-profile.png') . '" alt="Foto Default" class="img-thumbnail" width="65">';
            })
            ->addColumn('nama', function ($user) {
                return '<a href="' . route('profile-departemen', $user->id) . '">' . $user->name . '</a>';
            })
            ->addColumn('status', function ($user) {
                return $user->status;
            })
            ->addColumn('asal', function ($user) {
                return $user->asal_kampus;
            })
            ->addColumn('pembimbing', function ($user) {
                return $user->dosen ? $user->dosen->nama : 'Belum ditentukan';
            })
            ->addColumn('tanggal_mulai', function ($user) {
                return Carbon::parse($user->tanggal_mulai)->format('d F Y') . ' / ' . Carbon::parse($user->tanggal_selesai)->format('d F Y');
            })
            ->rawColumns(['foto', 'nama'])
            ->make(true);
    }
    public function detailView($id)
    {
        $peserta = User::with(['departemen', 'dosen'])->findOrFail($id);

        if ($peserta->role !== 'magang') {
            return redirect()->back();
        }

        $currentUser = auth()->user();
        if ($peserta->departemen_id !== $currentUser->departemen_id) {
            return redirect()->back();
        }

        $startDate = Carbon::parse($peserta->tanggal_mulai);
        $endDate = $peserta->tanggal_selesai ? Carbon::parse($peserta->tanggal_selesai) : Carbon::now();
        $endDate = min($endDate, Carbon::now());

        $presensi = $peserta->presensi()
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->tanggal)->format('Y-m');
            });

        $logbook = $peserta->logbook()
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->tanggal)->format('Y-m');
            });

        $monthRange = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addMonth()) {
            $monthRange[] = $date->format('Y-m');
        }

        return view('Departemen.Page.detailpeserta', compact('peserta', 'presensi', 'logbook', 'monthRange', 'startDate', 'endDate'));
    }

}