<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class profileMagangController extends Controller
{
    public function index()
    {
        return view('magang.page.magang-profile');
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'fotoprofile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    }
}
