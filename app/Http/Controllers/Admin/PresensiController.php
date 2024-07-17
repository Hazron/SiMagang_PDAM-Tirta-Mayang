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
        $start_date = $request->start_date ? Carbon::parse($request->start_date) : null;
        $end_date = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $users = User::where('role', 'magang')->get();

        $data = [];

        foreach ($users as $user) {
            $tanggalMulai = $user->tanggal_mulai ? Carbon::parse($user->tanggal_mulai) : null;
            if (!$tanggalMulai) {
                continue;
            }

            for ($date = $tanggalMulai; $date->lte($end_date); $date->addDay()) {
                if ($start_date && $date->lt($start_date)) {
                    continue;
                }

                $presensi = Presensi::where('user_id', $user->id)
                    ->whereDate('tanggal', $date->format('Y-m-d'))
                    ->first();

                if (!$presensi) {
                    $data[] = [
                        'tanggal' => $date->format('Y-m-d'),
                        'nama' => $user->name,
                        'jam_masuk' => '-',
                        'jam_keluar' => '-',
                        'status' => 'Tidak Hadir',
                        'user_id' => $user->id,
                    ];
                } else {
                    $data[] = [
                        'tanggal' => $presensi->tanggal,
                        'nama' => $user->name,
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
