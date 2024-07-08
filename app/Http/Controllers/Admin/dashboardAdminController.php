<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class dashboardAdminController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('admin.page.dashboard-admin', compact('users'));
    }
}
