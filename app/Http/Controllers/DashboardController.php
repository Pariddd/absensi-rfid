<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function exportExcel(Request $request)
    {
        $dari   = $request->get('dari', Carbon::now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', Carbon::today()->toDateString());

        return Excel::download(
            new \App\Exports\AbsensiExport($dari, $sampai),
            "absensi_{$dari}_sd_{$sampai}.xlsx"
        );
    }

    public function exportPdf(Request $request)
    {
        $dari   = $request->get('dari', Carbon::now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', Carbon::today()->toDateString());

        $mahasiswas = Mahasiswa::orderBy('nama')->get();

        $dates   = [];
        $current = Carbon::parse($dari);
        $end     = Carbon::parse($sampai);
        while ($current->lte($end)) {
            $dates[] = $current->toDateString();
            $current->addDay();
        }

        $absensiMap = Absensi::whereBetween('waktu_scan', [
            $dari . ' 00:00:00',
            $sampai . ' 23:59:59',
        ])->get()->groupBy(function ($item) {
            return $item->mahasiswa_id . '_' . $item->waktu_scan->toDateString();
        });

        $pdf = Pdf::loadView(
            'exports.absensi-pdf',
            compact('mahasiswas', 'dates', 'absensiMap', 'dari', 'sampai')
        )->setPaper('a4', 'landscape');

        return $pdf->download("absensi_{$dari}_sd_{$sampai}.pdf");
    }
}
