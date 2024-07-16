<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class dashboardAdminController extends Controller
{
    public function index()
    {
        $users = User::with(['presensi' => function ($query) {
            $query->whereDate('tanggal', Carbon::today());
        }])
            ->where('role', 'magang')
            ->get();

        return view('admin.page.dashboard-admin', compact('users'));
    }
}
