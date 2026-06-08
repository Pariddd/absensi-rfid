<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());

        $mahasiswas = Mahasiswa::with(['absensis' => function ($q) use ($tanggal) {
            $q->whereDate('waktu_scan', $tanggal);
        }])->orderBy('nama')->get();

        $rekapData = $mahasiswas->map(function ($mhs) {
            $absen = $mhs->absensis->first();
            return (object)[
                'nama'       => $mhs->nama,
                'nim'        => $mhs->nim,
                'waktu_scan' => $absen ? $absen->waktu_scan : null,
                'hadir'      => $absen !== null,
            ];
        });

        $summary = [
            'total'       => $rekapData->count(),
            'hadir'       => $rekapData->where('hadir', true)->count(),
            'tidak_hadir' => $rekapData->where('hadir', false)->count(),
        ];

        return view('dashboard.index', compact('rekapData', 'summary', 'tanggal'));
    }
}
