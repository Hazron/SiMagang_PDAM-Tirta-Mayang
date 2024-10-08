<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class dashboardMagangController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today('Asia/Jakarta');
        $now = Carbon::now('Asia/Jakarta');

        $presensiExists = Presensi::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->exists();

        $logbookToday = Logbook::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        $canPresensiPulang = $now->format('H:i:s') >= $user->jam_selesai;

        return view('magang.dashboard', compact('presensiExists', 'logbookToday', 'user', 'canPresensiPulang'));
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
                'tanggal' => Carbon::parse($request->tanggal, 'Asia/Jakarta'),
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => null,
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

    public function storeLogbook(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi_kegiatan' => 'required',
            'dokumentasi' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $logbook = new Logbook();
        $logbook->tanggal = Carbon::parse($request->tanggal, 'Asia/Jakarta');
        $logbook->deskripsi_kegiatan = $request->deskripsi_kegiatan;
        $logbook->user_id = Auth::user()->id;

        if ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            if ($file->getSize() <= 2048000) {
                $filename = time() . '_' . $file->getClientOriginalName();

                $path = public_path('imgLogbook');
                $file->move($path, $filename);

                $logbook->dokumentasi = $filename;
            } else {
                return redirect()->back()->with('error', 'Ukuran file dokumentasi melebihi 2MB.');
            }
        }

        $logbook->save();

        return redirect()->back()->with('success', 'Logbook berhasil disimpan');
    }
}
