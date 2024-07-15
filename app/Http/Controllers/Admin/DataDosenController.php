<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DosenPembimbing;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class DataDosenController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'dosen')->paginate(10);

        return view('admin.page.data-dosen', compact('users'));
    }

    public function data()
    {
        $data = DosenPembimbing::all();
        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit' . $data->id_pembimbing . '">Edit</a>';
                $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $data->id_pembimbing . '">Delete</a>';
                return $btn;
            })
            ->addColumn('fotoprofile', function ($data) {
                return '<img src="' . ($data->profile ? asset('path/to/foto/' . $data->profile) : '../assets/img/blank-profile.png') . '" alt="Foto" width="75">';
            })
            ->editColumn('name', function ($data) {
                $nama = '<a href="' . route('detail-dosen', ['id_pembimbing' => $data->id_pembimbing]) . '">' . $data->dosen->name . '</a>';
                return $nama;
            })
            ->editColumn('asal_kampus', function ($data) {
                return $data->dosen->asal_kampus;
            })
            ->rawColumns(['action', 'name', 'fotoprofile'])
            ->make(true);
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
        // Ambil data dosen pembimbing dengan relasi dosen
        $dosen = DosenPembimbing::with('dosen')->where('id_pembimbing', $id)->firstOrFail();

        $pesertaMagang = User::where('role', 'magang')
            ->whereNull('dosen_id')
            ->get();

        $pesertaBimbingan = User::where('role', 'magang')
            ->where('dosen_id', $dosen->id_pembimbing)
            ->get();

        return view('admin.page.detail-dosen', compact('dosen', 'pesertaMagang', 'pesertaBimbingan'));
    }

    public function assignDosen(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:pembimbingdosen,id_pembimbing',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->dosen_id = $request->dosen_id;
        $user->save();

        return redirect()->back()->with('success', 'Peserta magang berhasil ditambahkan ke dosen.');
    }
}
