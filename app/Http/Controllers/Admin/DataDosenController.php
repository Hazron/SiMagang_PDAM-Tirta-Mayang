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
        // Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'asal' => 'required|string|max:255',
        ]);

        // Buat pengguna baru di tabel users
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

        return redirect()->route('data.dosen')->with('success', 'Dosen berhasil ditambahkan');
    }
}
