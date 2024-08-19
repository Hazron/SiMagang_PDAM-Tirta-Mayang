<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Logbook;
use Carbon\Carbon;

use Illuminate\Http\Request;

class DashboardDepartemenController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $departemenId = $user->departemen_id;

        $siswaMagang = User::where('departemen_id', $departemenId)
            ->where('role', 'magang')
            ->where('status', 'aktif')
            ->with([
                'presensi' => function ($query) {
                    $query->whereDate('tanggal', Carbon::today());
                },
                'logbook' => function ($query) {
                    $query->whereDate('tanggal', Carbon::today());
                }
            ])
            ->get();

        return view('Departemen.Page.Dashboard', compact('user', 'siswaMagang'));
    }
}
