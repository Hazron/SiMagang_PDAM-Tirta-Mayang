<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $data = User::where('role', 'magang')->select('*')->get();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn .= ' <a href="javascript:void(0)" onclick="deleteUser(\'' . $data->id . '\')" class="delete btn btn-danger btn-sm" data-id="' . $data->id . '">Delete</a>';
                return $btn;
            })
            ->editColumn('durasi_magang', function ($user) {
                return Carbon::parse($user->tanggal_mulai)->diffInDays(Carbon::parse($user->tanggal_selesai)) . ' Hari';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function view()
    {
        $users = User::where('role', 'magang')->get();
        return view('admin.page.data-magang', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_induk' => 'required|string|unique:users',
            'departemen' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'asal' => 'required|string',
            'jurusan' => 'required|string',
            'alamat' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        User::create([
            'role' => 'magang',
            'name' => $data['name'],
            'nomor_induk' => $data['nomor_induk'],
            'asal_kampus' => $data['asal'],
            'jurusan' => $data['jurusan'],
            'alamat' => $data['alamat'],
            'email' => $data['email'],
            'password' => Hash::make($data['nomor_induk'] . $data['nomor_induk']),
            'status' => 'aktif',
            'departemen' => $data['departemen'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
        ]);

        return redirect()->route('data-magang')->with('success', 'Data magang berhasil ditambahkan');
    }

    public function detail($id)
    {
        $peserta = User::where('role', 'magang')->findOrFail($id);
        return view('admin.page.detail-magang', compact('peserta'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $peserta = User::findOrFail($id);
        $peserta->status = $request->status;
        $peserta->save();

        return redirect()->back()->with('success', 'Status peserta berhasil diupdate');
    }
}
