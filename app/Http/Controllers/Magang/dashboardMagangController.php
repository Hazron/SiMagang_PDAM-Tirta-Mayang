<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DashboardMagangController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $presensiExists = Presensi::where('user_id', Auth::user()->id)
            ->whereDate('created_at', $today)
            ->exists();

        return view('magang.dashboard', compact('presensiExists'));
    }

    public function storePresensi(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'tanggal' => 'required|date',
        ]);

        try {
            $presensi = Presensi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => Carbon::parse($request->tanggal),
                'jam_masuk' => Carbon::now('Asia/Jakarta')->format('H:i'),
                'jam_keluar' => Carbon::now('Asia/Jakarta')->format('H:i'),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 'hadir',
            ]);

            Session::flash('success', 'Presensi berhasil disimpan');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menyimpan presensi: ' . $e->getMessage());
        }

        return redirect()->back();
    }
}
