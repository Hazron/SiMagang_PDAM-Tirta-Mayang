<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Logbook;
use App\Models\Presensi;


class ListPesertaController extends Controller
{
    public function index()
    {
        $dosen = Auth::user();
        $dosenId = $dosen->dosen_id;

        $peserta = User::where('dosen_id', $dosenId)
            ->where('role', 'magang')
            ->where('status', 'aktif')
            ->get();

        return view('dosen.page.list-peserta', compact('peserta'));
    }

    public function detail($id)
    {
        $dosen = Auth::user();
        $dosenId = $dosen->dosen_id;

        $peserta = User::where('dosen_id', $dosenId)
            ->where('role', 'magang')
            ->where('status', 'aktif')
            ->where('id', $id)
            ->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Peserta tidak ditemukan.');
        }

        $startDate = Carbon::parse($peserta->tanggal_mulai);
        $endDate = Carbon::parse($peserta->tanggal_selesai);

        $monthRange = [];
        $currentDate = $startDate->copy()->startOfMonth();
        while ($currentDate->lte($endDate)) {
            $monthRange[] = $currentDate->format('Y-m');
            $currentDate->addMonth();
        }

        $logbook = Logbook::where('user_id', $peserta->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->tanggal)->format('Y-m');
            });

        // Fetch presensi data
        $presensi = Presensi::where('user_id', $peserta->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->tanggal)->format('Y-m');
            });

        return view('dosen.page.detail-peserta', compact('peserta', 'logbook', 'presensi', 'monthRange', 'startDate', 'endDate'));
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
