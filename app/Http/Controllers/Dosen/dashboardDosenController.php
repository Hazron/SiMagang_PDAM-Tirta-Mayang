<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Models\Logbook;
use Carbon\Carbon;

class dashboardDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::user();

        $siswaMagang = User::where('role', 'magang')
            ->where('dosen_id', $dosen->dosen_id)
            ->where('status', 'aktif')
            ->with([
                'presensi' => function ($query) {
                    $query->whereDate('tanggal', Carbon::today());
                },
                'logbook' => function ($query) {
                    $query->whereDate('tanggal', Carbon::today());
                },
                'departemen'
            ])
            ->get();

        return view('Dosen.dashboard-dosen', compact('siswaMagang'));
    }
}
