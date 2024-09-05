<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\Auth;


class PresensiMagangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $startDate = Carbon::parse($user->tanggal_mulai);
        $endDate = Carbon::now();

        $presensiData = Presensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        $presensi = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            if (isset($presensiData[$formattedDate])) {
                $presensi[] = [
                    'tanggal' => $date,
                    'jam_masuk' => $presensiData[$formattedDate]->jam_masuk,
                    'jam_keluar' => $presensiData[$formattedDate]->jam_keluar,
                    'status' => $presensiData[$formattedDate]->status,
                ];
            } else {
                $presensi[] = [
                    'tanggal' => $formattedDate,
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                    'status' => 'tidak hadir',
                ];
            }
        }

        return view('magang.page.magang-presensi', compact('presensi'));

    }

    public function getData(Request $request)
    {
        $user = auth()->user();
        $start_date = Carbon::parse($user->tanggal_mulai);
        $end_date = Carbon::now();
        $dates = [];

        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            if ($date->isWeekend()) {
                continue;
            }
            $dates[] = $date->format('Y-m-d');
        }

        $presensis = collect($dates)->map(function ($date) use ($user) {
            $presensi = Presensi::where('user_id', $user->id)->where('tanggal', $date)->first();
            return [
                'tanggal' => $date,
                'hari' => Carbon::parse($date)->locale('id')->isoFormat('dddd'),
                'status' => $presensi ? $presensi->status : 'tidak hadir',
                'jam_masuk' => $presensi ? $presensi->jam_masuk : null,
                'jam_keluar' => $presensi ? $presensi->jam_keluar : null,
            ];
        });

        return DataTables::of($presensis)
            ->addColumn('aksi', function ($data) use ($user) {
                $current_date = Carbon::now()->isoFormat('dddd');
                if ($current_date != $data['hari']) {
                    return '-';
                }
                if ($data['jam_masuk'] && !$data['jam_keluar']) {
                    $current_time = Carbon::now();
                    $jam_selesai = $user->jam_selesai ? Carbon::parse($user->jam_selesai) : null;

                    if ($jam_selesai) {
                        $jam_masuk = Carbon::parse($data['jam_masuk']);
                        $class = $current_time->isBefore($jam_selesai) ? 'disabled' : '';
                        $title = $current_time->isBefore($jam_selesai) ? 'Anda sudah melakukan presensi pulang' : 'Lakukan presensi pulang';

                        return '<button class="btn btn-primary presensiPulangBtn ' . $class . '" data-tanggal="' . $data['tanggal'] . '" title="' . $title . '">Presensi Pulang</button>';
                    } else {
                        return '<button class="btn btn-primary presensiPulangBtn" data-tanggal="' . $data['tanggal'] . '">Presensi Pulang</button>';
                    }
                } else {
                    return '-';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function presensiPulang(Request $request)
    {
        $user = auth()->user();
        $tanggal = $request->input('tanggal');

        $presensi = Presensi::where('user_id', $user->id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($presensi) {
            $presensi->update([
                'jam_keluar' => Carbon::now('Asia/Jakarta')->format('H:i:s')
            ]);

            return response()->json(['success' => true, 'message' => 'Presensi pulang berhasil.']);
        }

        return response()->json(['success' => false, 'message' => 'Presensi tidak ditemukan.']);
    }
}
