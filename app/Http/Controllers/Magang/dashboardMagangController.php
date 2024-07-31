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
            $jamMasuk = Carbon::now('Asia/Jakarta')->format('H:i');
            $status = ($jamMasuk <= '08:00') ? 'hadir' : 'terlambat';

            $presensi = Presensi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => Carbon::parse($request->tanggal),
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamMasuk,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $status,
            ]);

            Session::flash('success', 'Presensi berhasil disimpan');
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal menyimpan presensi: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function pulangPresensi(Request $request)
    {
        try {
            $user = Auth::user();
            $currentTime = Carbon::now('Asia/Jakarta')->format('H:i');
            $jamSelesai = $user->jam_selesai;

            if ($currentTime >= $jamSelesai) {
                $presensi = Presensi::where('user_id', $user->id)
                    ->whereDate('tanggal', Carbon::today())
                    ->first();

                if ($presensi) {
                    $jamPulang = Carbon::now('Asia/Jakarta')->format('H:i');

                    $presensi->update([
                        'jam_keluar' => $jamPulang,
                    ]);

                    Session::flash('success', 'Presensi berhasil diperbarui');
                } else {
                    Session::flash('error', 'Gagal memperbarui presensi: Data presensi tidak ditemukan');
                }
            } else {
                Session::flash('error', 'Gagal memperbarui presensi: Belum mencapai jam selesai');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Gagal memperbarui presensi: ' . $e->getMessage());
        }

        return redirect()->back();
    }
}
