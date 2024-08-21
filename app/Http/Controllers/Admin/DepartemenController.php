<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::with('user')->get();
        return view('admin.page.data-departemen', compact('departemens'));
    }

    public function detail($id_departemen)
    {
        $departemen = Departemen::find($id_departemen);
        $users = User::where('departemen_id', $id_departemen)->get();
        return view('admin.page.detail-departemen', compact('departemen', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'nama_pembimbing' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'no_telpon' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'role' => 'departemen',
                'name' => $validated['nama_pembimbing'],
                'nomor_induk' => $validated['nomor_induk'],
                'email' => $validated['email'],
                'no_telpon' => $validated['no_telpon'],
                'password' => Hash::make($validated['nomor_induk']),
                'status' => 'aktif',
                'alamat' => 'default alamat',
                'departemen_id' => null,
            ]);

            $departemen = Departemen::create([
                'nama_departemen' => $validated['nama_departemen'],
                'nama_pembimbing' => $validated['nama_pembimbing'],
                'user_id' => $user->id,
                'status' => 'aktif',
            ]);

            $user->update(['departemen_id' => $departemen->id_departemen]);

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

}
