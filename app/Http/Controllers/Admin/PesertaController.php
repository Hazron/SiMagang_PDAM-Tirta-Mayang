<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Presensi;
use App\Models\Logbook;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $data = User::where('role', 'magang')->get();

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit' . $data->id . '">Edit</a>';
                $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $data->id . '">Delete</a>';
                return $btn;
            })
            ->editColumn('durasi_magang', function ($user) {
                return Carbon::parse($user->tanggal_mulai)->diffInDays(Carbon::parse($user->tanggal_selesai)) . ' Hari';
            })
            ->addColumn('nama', function ($data) {
                $nama = '<a href="' . route('detail-peserta', ['id' => $data->id]) . '">' . $data->name . '</a>';
                return $nama;
            })
            ->addColumn('departemen', function ($data) {
                return $data->departemen ? $data->departemen->nama_departemen : 'Tidak ada departemen';
            })
            ->rawColumns(['action', 'nama'])
            ->make(true);
    }


    public function view()
    {
        $users = User::where('role', 'magang')->get();
        $departemens = Departemen::all();
        return view('admin.page.data-magang', compact('users', 'departemens'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_induk' => 'required|string',
            'departemen_id' => 'required|exists:departemen,id_departemen',
            'email' => 'required|string|email|unique:users',
            'no_telpon' => 'required|string',
            'asal' => 'required|string',
            'jurusan' => 'required|string',
            'alamat' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jam_selesai' => 'required|date_format:H:i',
        ]);

        $jamSelesai = Carbon::createFromFormat('H:i', $validatedData['jam_selesai'])->format('H:i');


        $user = User::create([
            'role' => 'magang',
            'name' => $validatedData['name'],
            'nomor_induk' => $validatedData['nomor_induk'],
            'asal_kampus' => $validatedData['asal'],
            'jurusan' => $validatedData['jurusan'],
            'alamat' => $validatedData['alamat'],
            'no_telpon' => $validatedData['no_telpon'],
            'email' => $validatedData['email'],
            'password' => Hash::make('magang'),
            'status' => 'aktif',
            'departemen_id' => $validatedData['departemen_id'],
            'tanggal_mulai' => $validatedData['tanggal_mulai'],
            'tanggal_selesai' => $validatedData['tanggal_selesai'],
            'jam_selesai' => $jamSelesai,
        ]);

        if ($user) {
            return redirect()->route('data-magang')->with('success', 'Data magang berhasil ditambahkan');
        }

        return back()->withInput()->with('error', 'Gagal menambahkan data magang');
    }


    public function detail($id)
    {
        $peserta = User::with('dosen')->findOrFail($id);
        $peserta = User::findOrFail($id);

        $tanggalMulai = Carbon::parse($peserta->tanggal_mulai);
        $tanggalSelesai = Carbon::now();

        $period = CarbonPeriod::create($tanggalMulai, $tanggalSelesai);

        $presensiData = Presensi::where('user_id', $id)->get()->keyBy('tanggal');
        $logbookData = Logbook::where('user_id', $id)->get()->keyBy('tanggal');

        $presensi = [];
        $logbook = [];

        foreach ($period as $date) {
            if ($date->isWeekend()) {
                continue;
            }

            $formattedDate = $date->format('Y-m-d');
            if (isset($presensiData[$formattedDate])) {
                $presensi[] = [
                    'tanggal' => $date,
                    'jam_masuk' => $presensiData[$formattedDate]->jam_masuk,
                    'jam_keluar' => $presensiData[$formattedDate]->jam_keluar,
                    'status' => 'hadir',
                ];
            } else {
                $presensi[] = [
                    'tanggal' => $date,
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                    'status' => 'tidak hadir',
                ];
            }

            if (isset($logbookData[$formattedDate])) {
                $logbook[] = [
                    'tanggal' => $date,
                    'deskripsi_kegiatan' => $logbookData[$formattedDate]->deskripsi_kegiatan,
                    'dokumentasi' => $logbookData[$formattedDate]->dokumentasi,
                ];
            } else {
                $logbook[] = [
                    'tanggal' => $date,
                    'deskripsi_kegiatan' => 'Tidak ada kegiatan tercatat',
                    'dokumentasi' => null,
                ];
            }
        }

        return view('admin.page.detail-magang', compact('peserta', 'presensi', 'logbook'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'Data berhasil dihapus!']);
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
