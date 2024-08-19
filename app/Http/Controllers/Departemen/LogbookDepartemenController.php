<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Logbook;
use App\Models\User;
use Carbon\Carbon;

class LogbookDepartemenController extends Controller
{
    public function index()
    {
        return view('departemen.page.logbook-departemen');
    }

    public function datatables(Request $request)
    {
        $user = auth()->user();

        $start_date = $request->start_date ? Carbon::parse($request->start_date) : null;
        $end_date = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $users = User::where('role', 'magang')
            ->where('status', 'aktif')
            ->where('departemen_id', $user->departemen_id)
            ->get();

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

                $logbook = Logbook::where('user_id', $user->id)
                    ->whereDate('tanggal', $date->format('Y-m-d'))
                    ->first();

                if (!$logbook) {
                    $data[] = [
                        'tanggal' => $date->format('Y-m-d'),
                        'nama' => $user->name,
                        'departemen' => $user->departemen ? $user->departemen->nama_departemen : '',
                        'jam_input' => '-',
                        'status_logbook' => '<span class="badge bg-secondary">Tidak Ada Logbook</span>',
                        'user_id' => $user->id,
                    ];
                } else {
                    $statusBadge = $logbook->status === 'menunggu persetujuan'
                        ? '<span class="badge bg-warning text-dark">Menunggu Persetujuan</span>'
                        : '<span class="badge bg-success">Disetujui</span>';

                    $data[] = [
                        'tanggal' => $logbook->tanggal,
                        'nama' => $user->name,
                        'departemen' => $user->departemen ? $user->departemen->nama_departemen : '',
                        'jam_input' => '-', // Placeholder, sesuai kebutuhan
                        'status_logbook' => $statusBadge,
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
            ->rawColumns(['status_logbook', 'aksi'])
            ->make(true);
    }


    public function showModal($user_id, $tanggal)
    {
        $logbook = Logbook::where('user_id', $user_id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($logbook) {
            return response()->json([
                'tanggal' => $logbook->tanggal,
                'deskripsi' => $logbook->deskripsi_kegiatan,
                'dokumentasi' => $logbook->dokumentasi
            ]);
        }

        return response()->json([
            'tanggal' => $tanggal,
            'deskripsi' => 'Tidak ada deskripsi',
            'dokumentasi' => null
        ]);
    }

    public function approveLogbook(Request $request)
    {
        $logbook = Logbook::where('user_id', $request->user_id)
            ->whereDate('tanggal', $request->tanggal)
            ->first();

        if ($logbook) {
            $logbook->status = 'disetujui';
            $logbook->save();

            return response()->json(['success' => true, 'message' => 'Logbook berhasil disetujui.']);
        }

        return response()->json(['success' => false, 'message' => 'Logbook tidak ditemukan.']);
    }

}
