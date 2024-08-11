<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class LogbookMagangController extends Controller
{
    public function index()
    {
        return view('magang.page.magang-logbook');
    }

    public function getData(Request $request)
    {
        $user = auth()->user();
        $start_date = Carbon::parse($user->tanggal_mulai);
        $end_date = Carbon::now();
        $dates = [];

        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        $logbooks = collect($dates)->map(function ($date) use ($user) {
            $logbook = Logbook::where('user_id', $user->id)->where('tanggal', $date)->first();
            return [
                'tanggal' => $date,
                'hari' => Carbon::parse($date)->locale('id')->isoFormat('dddd'),
                'deskripsi_kegiatan' => $logbook ? $logbook->deskripsi_kegiatan : 'Tidak ada kegiatan',
                'dokumentasi' => $logbook ? $logbook->dokumentasi : null,
                'status' => $logbook ? $logbook->status : 'menunggu persetujuan',
                'id_logbook' => $logbook ? $logbook->id_logbook : null,
            ];
        });

        return DataTables::of($logbooks)
            ->addIndexColumn()
            ->addColumn('dokumentasi', function ($logbook) {
                if ($logbook['dokumentasi']) {
                    return '<img src="' . asset('storage/' . $logbook['dokumentasi']) . '" alt="Dokumentasi" width="50">';
                }
                return 'Tidak ada';
            })
            ->addColumn('aksi', function ($logbook) {
                if ($logbook['id_logbook']) {
                    return '<button class="btn btn-primary editLogbookBtn" data-id="' . $logbook['id_logbook'] . '" data-tanggal="' . $logbook['tanggal'] . '" data-deskripsi="' . $logbook['deskripsi_kegiatan'] . '" data-dokumentasi="' . $logbook['dokumentasi'] . '">Edit</button>';
                } else {
                    return '<button class="btn btn-success tambahLogbookBtn" data-tanggal="' . $logbook['tanggal'] . '">Tambah</button>';
                }
            })
            ->rawColumns(['dokumentasi', 'aksi'])
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'deskripsi_kegiatan' => 'required|string',
            'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logbook = Logbook::findOrFail($id);
        $logbook->deskripsi_kegiatan = $request->deskripsi_kegiatan;

        if ($request->hasFile('dokumentasi')) {
            $filePath = $request->file('dokumentasi')->store('logbook_dokumentasi', 'public');
            $logbook->dokumentasi = $filePath;
        } else {
            $logbook->dokumentasi = 'Tidak ada';
        }

        $logbook->save();

        return response()->json(['success' => 'Logbook updated successfully.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi_kegiatan' => 'required|string',
            'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logbook = new Logbook();
        $logbook->tanggal = $request->input('tanggal');
        $logbook->deskripsi_kegiatan = $request->input('deskripsi_kegiatan');

        if ($request->hasFile('dokumentasi')) {
            $logbook->dokumentasi = $request->file('dokumentasi')->store('logbooks', 'public');
        }

        $logbook->user_id = auth()->user()->id;
        $logbook->save();

        return response()->json(['success' => 'Logbook added successfully!']);
    }
}
