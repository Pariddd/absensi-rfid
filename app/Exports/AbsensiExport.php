<?php

namespace App\Exports;

use App\Models\Absensi;
use App\Models\Mahasiswa;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
  protected $dari;
  protected $sampai;
  protected $dates = [];

  public function __construct($dari, $sampai)
  {
    $this->dari   = $dari;
    $this->sampai = $sampai;

    $current = Carbon::parse($dari);
    $end     = Carbon::parse($sampai);
    while ($current->lte($end)) {
      $this->dates[] = $current->toDateString();
      $current->addDay();
    }
  }

  public function collection()
  {
    $mahasiswas = Mahasiswa::orderBy('nama')->get();

    $absensiMap = Absensi::whereBetween('waktu_scan', [
      $this->dari . ' 00:00:00',
      $this->sampai . ' 23:59:59',
    ])->get()->groupBy(fn($item) => $item->mahasiswa_id . '_' . $item->waktu_scan->toDateString());

    $rows = [];
    foreach ($mahasiswas as $i => $mhs) {
      $row = [$i + 1, $mhs->nama, $mhs->nim];
      $hadirCount = 0;

      foreach ($this->dates as $date) {
        $hadir = isset($absensiMap[$mhs->id . '_' . $date]);
        $row[] = $hadir ? '✓' : '✗';
        if ($hadir) $hadirCount++;
      }

      $row[] = $hadirCount;
      $row[] = count($this->dates) - $hadirCount;
      $rows[] = $row;
    }

    return collect($rows);
  }

  public function headings(): array
  {
    $dateHeaders = array_map(
      fn($d) => Carbon::parse($d)->format('d/m'),
      $this->dates
    );

    return array_merge(['No', 'Nama', 'NIM'], $dateHeaders, ['Hadir', 'Tdk Hadir']);
  }

  public function styles(Worksheet $sheet)
  {
    return [
      1 => [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1D4ED8']],
        'alignment' => ['horizontal' => 'center'],
      ],
    ];
  }

  public function columnWidths(): array
  {
    return ['A' => 5, 'B' => 30, 'C' => 15];
  }

  public function title(): string
  {
    return "Absensi {$this->dari} sd {$this->sampai}";
  }
}
