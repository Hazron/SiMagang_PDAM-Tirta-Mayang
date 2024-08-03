<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class PresensiMagangController extends Controller
{
    public function index()
    {
        return view('magang.page.magang-presensi');
    }

    public function getData(Request $request)
    {
        $user = auth()->user();
        $tanggalMulai = Carbon::parse($user->tanggal_mulai);
        $tanggalSekarang = Carbon::now();
        $dates = [];

        for ($date = $tanggalMulai; $date->lte($tanggalSekarang); $date->addDay()) {
            if (!$date->isWeekend()) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        $presensis = collect($dates)->map(function ($date) use ($user) {
            $presensi = Presensi::where('user_id', $user->id)->where('tanggal', $date)->first();
            return [
                'tanggal' => $date,
                'status' => $presensi ? $presensi->status : 'tidak hadir',
                'jam_masuk' => $presensi ? $presensi->jam_masuk : null,
                'jam_keluar' => $presensi ? $presensi->jam_keluar : null,
            ];
        });

        return DataTables::of($presensis)->make(true);
    }
}
