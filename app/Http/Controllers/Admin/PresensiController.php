<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Presensi;
use Yajra\DataTables\DataTables;

class PresensiController extends Controller
{
    public function index()
    {

        return view('admin.page.data-presensi');
    }

    public function datatables(Request $request)
    {
        // Mendapatkan rentang tanggal dari request
        $start_date = $request->start_date ? Carbon::parse($request->start_date) : null;
        $end_date = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Mendapatkan semua user dengan role 'magang'
        $users = User::where('role', 'magang')->get();

        $data = [];

        foreach ($users as $user) {
            // Iterasi dari tanggal mulai hingga tanggal sekarang
            $tanggalMulai = $user->tanggal_mulai ? Carbon::parse($user->tanggal_mulai) : null;
            if (!$tanggalMulai) {
                continue;
            }

            for ($date = $tanggalMulai; $date->lte($end_date); $date->addDay()) {
                if ($start_date && $date->lt($start_date)) {
                    continue;
                }

                // Cek apakah user sudah melakukan presensi pada tanggal tersebut
                $presensi = Presensi::where('user_id', $user->id)
                    ->whereDate('tanggal', $date->format('Y-m-d'))
                    ->first();

                // Jika belum melakukan presensi, maka statusnya 'tidak hadir'
                if (!$presensi) {
                    $data[] = [
                        'nama' => $user->name,
                        'tanggal' => $date->format('Y-m-d'),
                        'jam_masuk' => '-',
                        'jam_keluar' => '-',
                        'status' => 'Tidak Hadir',
                        'user_id' => $user->id,
                    ];
                } else {
                    $data[] = [
                        'nama' => $user->name,
                        'tanggal' => $presensi->tanggal,
                        'jam_masuk' => $presensi->jam_masuk,
                        'jam_keluar' => $presensi->jam_keluar,
                        'status' => ucfirst($presensi->status),
                        'user_id' => $user->id,
                    ];
                }
            }
        }
        $data = collect($data);
        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return '<button class="btn btn-info">Detail</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
