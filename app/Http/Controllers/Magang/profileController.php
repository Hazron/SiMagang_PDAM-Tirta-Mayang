<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function index()
    {
        return view('magang.page.profile');
    }
}
