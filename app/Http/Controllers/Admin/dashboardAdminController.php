<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardAdminController extends Controller
{
    public function index()
    {
        return view('admin.page.dashboard-admin');
    }
}
