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
        $users = User::where('departemen_id', $id_departemen)
            ->where('role', 'magang')
            ->get();

        $getDepartemen = User::where('role', 'magang')
            ->whereNull('departemen_id')
            ->get();
        return view('admin.page.detail-departemen', compact('departemen', 'users', 'getDepartemen'));
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

    public function assignDepartemen(Request $request, $departemen_id)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Cari user berdasarkan user_id
        $user = User::findOrFail($request->input('user_id'));

        // Pastikan user memiliki role 'magang'
        if ($user->role !== 'magang') {
            return redirect()->back()->withErrors(['error' => 'Hanya peserta magang yang bisa ditugaskan ke departemen.']);
        }

        // Update departemen_id pada user
        $user->departemen_id = $departemen_id;
        $user->save();

        return redirect()->back()->with('success', 'Peserta magang berhasil ditugaskan ke departemen.');
    }
    public function update(Request $request, $id_departemen)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:255',
            'nama_pembimbing' => 'required|string|max:255',
            'nomor_induk' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $departemen = Departemen::findOrFail($id_departemen);
            $departemen->update([
                'nama_departemen' => $validated['nama_departemen'],
                'nama_pembimbing' => $validated['nama_pembimbing'],
            ]);

            $user = User::findOrFail($departemen->user_id);
            $user->update([
                'nomor_induk' => $validated['nomor_induk'],
                'password' => Hash::make($validated['nomor_induk']),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id_departemen, $user_id)
    {
        DB::beginTransaction();

        try {
            $departemen = Departemen::find($id_departemen);
            if ($departemen) {
                $departemen->delete();
            }

            $user = User::find($user_id);
            if ($user) {
                $user->delete();
            }

            User::where('departemen_id', $id_departemen)
                ->where('role', 'magang')
                ->update(['departemen_id' => null]);

            DB::commit();

            return response()->json(['success' => 'Departemen dan User berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

}
