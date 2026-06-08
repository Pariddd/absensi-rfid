<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
  public function scan(Request $request)
  {
    $request->validate([
      'uid' => 'required|string|max:20',
    ]);

    $uid = strtoupper(trim($request->uid));

    $mahasiswa = Mahasiswa::where('uid', $uid)->first();

    if (!$mahasiswa) {
      return response()->json([
        'status' => 'tidak_dikenal',
        'pesan'  => 'UID tidak terdaftar',
        'uid'    => $uid,
      ], 404);
    }

    $sudahAbsen = Absensi::where('mahasiswa_id', $mahasiswa->id)
      ->whereDate('waktu_scan', Carbon::today())
      ->first();

    if ($sudahAbsen) {
      return response()->json([
        'status' => 'sudah_absen',
        'pesan'  => 'Sudah absen hari ini',
        'nama'   => $mahasiswa->nama,
        'nim'    => $mahasiswa->nim,
        'waktu'  => $sudahAbsen->waktu_scan->format('H:i:s'),
      ], 200);
    }

    $waktu = Carbon::now();

    Absensi::create([
      'mahasiswa_id' => $mahasiswa->id,
      'uid'          => $uid,
      'waktu_scan'   => $waktu,
    ]);

    return response()->json([
      'status' => 'hadir',
      'pesan'  => 'Absensi berhasil dicatat',
      'nama'   => $mahasiswa->nama,
      'nim'    => $mahasiswa->nim,
      'waktu'  => $waktu->format('H:i:s'),
    ], 201);
  }

  public function index(Request $request)
  {
    $tanggal = $request->get('tanggal', Carbon::today()->toDateString());

    $mahasiswas = Mahasiswa::with(['absensis' => function ($q) use ($tanggal) {
      $q->whereDate('waktu_scan', $tanggal);
    }])->orderBy('nama')->get();

    $data = $mahasiswas->map(function ($mhs) {
      $absen = $mhs->absensis->first();
      return [
        'nama'       => $mhs->nama,
        'nim'        => $mhs->nim,
        'waktu_scan' => $absen ? $absen->waktu_scan->format('Y-m-d H:i:s') : null,
        'status'     => $absen ? 'hadir' : 'tidak_hadir',
      ];
    });

    return response()->json([
      'tanggal'     => $tanggal,
      'total'       => $data->count(),
      'hadir'       => $data->where('status', 'hadir')->count(),
      'tidak_hadir' => $data->where('status', 'tidak_hadir')->count(),
      'data'        => $data->values(),
    ]);
  }
}
