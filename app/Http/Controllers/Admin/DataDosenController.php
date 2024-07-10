<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DosenPembimbing;
use Illuminate\Support\Facades\Hash;

class DataDosenController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'dosen')->paginate(10);

        return view('admin.page.data-dosen', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'asal' => 'required|string|max:255',
        ]);

        $user = User::create([
            'role' => 'dosen',
            'name' => $request->name,
            'nomor_induk' => $request->nomor_induk,
            'email' => $request->email,
            'password' => Hash::make($request->nomor_induk),
            'status' => 'aktif',
            'asal_kampus' => $request->asal,
            'alamat' => '',
            'dosen_id' => null,
        ]);

        DosenPembimbing::create([
            'nama' => $request->name,
            'asal_kampus' => $request->asal,
            'user_id' => $user->id,
            'status' => 'aktif',
        ]);

        return redirect()->route('data-dosen')->with('success', 'Dosen berhasil ditambahkan');
    }

    public function detail($id)
    {
        $dosen = User::where('role', 'dosen')->findOrFail($id);
        $pesertaBimbingan = $dosen->pembimbingan;
        $pesertaMagang = User::where('role', 'magang')->where('dosen_id', null)->get();

        return view('admin.page.detail-dosen', compact('dosen', 'pesertaBimbingan', 'pesertaMagang'));
    }


    public function assignDosen(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->dosen_id = $request->dosen_id;
        $user->save();

        return redirect()->back()->with('success', 'Peserta magang berhasil ditambahkan ke dosen.');
    }
}
