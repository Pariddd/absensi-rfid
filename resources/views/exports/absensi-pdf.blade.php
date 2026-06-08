<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 9px; margin: 15px; }
        h2 { text-align: center; font-size: 13px; margin: 0 0 4px; }
        .sub { text-align: center; color: #6b7280; margin-bottom: 12px; font-size: 9px; }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #1d4ed8; color: white;
            padding: 4px 5px; text-align: center; font-size: 8px;
        }
        th.left { text-align: left; }
        td { padding: 3px 5px; border-bottom: 1px solid #f3f4f6; }
        td.center { text-align: center; }
        tr:nth-child(even) td { background: #f9fafb; }
        .hadir { color: #16a34a; font-weight: bold; }
        .tidak { color: #dc2626; }
    </style>
</head>
<body>
    <h2>Rekap Absensi Mahasiswa</h2>
    <p class="sub">
        Periode: {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }}
        s/d {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}
    </p>

    <table>
        <thead>
            <tr>
                <th class="left" style="width:18px">#</th>
                <th class="left" style="min-width:100px">Nama</th>
                <th class="left" style="width:70px">NIM</th>
                @foreach($dates as $date)
                    <th style="width:22px">{{ \Carbon\Carbon::parse($date)->format('d/m') }}</th>
                @endforeach
                <th style="width:28px">Hadir</th>
                <th style="width:38px">Tdk Hadir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswas as $i => $mhs)
            @php $hadirCount = 0; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $mhs->nama }}</td>
                <td>{{ $mhs->nim }}</td>
                @foreach($dates as $date)
                    @php
                        $key   = $mhs->id . '_' . $date;
                        $hadir = isset($absensiMap[$key]);
                        if ($hadir) $hadirCount++;
                    @endphp
                    <td class="center {{ $hadir ? 'hadir' : 'tidak' }}">
                        {{ $hadir ? '✓' : '✗' }}
                    </td>
                @endforeach
                <td class="center hadir">{{ $hadirCount }}</td>
                <td class="center tidak">{{ count($dates) - $hadirCount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>