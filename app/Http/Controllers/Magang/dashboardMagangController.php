<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardMagangController extends Controller
{
    public function index()
    {
        return view('magang.dashboard');
    }
}
