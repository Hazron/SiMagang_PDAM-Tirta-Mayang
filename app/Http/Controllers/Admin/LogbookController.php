<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class LogbookController extends Controller
{
    public function index()
    {
        return view('admin.page.data-logbook');
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

                $logbook = Logbook::where('user_id', $user->id)
                    ->whereDate('tanggal', $date->format('Y-m-d'))
                    ->first();

                if (!$logbook) {
                    $data[] = [
                        'tanggal' => $date->format('Y-m-d'),
                        'nama' => $user->name,
                        'departemen' => $user->departemen->nama_departemen,
                        'jam_input' => '-',
                        'status_logbook' => 'Tidak Ada',
                        'user_id' => $user->id,
                    ];
                } else {
                    $data[] = [
                        'tanggal' => $logbook->tanggal,
                        'nama' => $user->name,
                        'departemen' => $user->departemen->nama_departemen,
                        'jam_input' => $logbook->jam_input,
                        'status_logbook' => ucfirst($logbook->status),
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
