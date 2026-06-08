@extends('layouts.app')
@section('title', 'Rekap Absensi')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-800">Rekap Absensi</h1>

    {{-- Dropdown Export (Alpine.js) --}}
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
                class="bg-gray-700 text-white px-4 py-2 rounded text-sm hover:bg-gray-800 flex items-center gap-2">
            Export
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"/>
            </svg>
        </button>

        <div x-show="open" x-transition @click.outside="open = false"
             class="absolute right-0 mt-2 w-72 bg-white border rounded-lg shadow-xl p-4 z-20">
            <p class="text-xs font-semibold text-gray-400 mb-3 uppercase tracking-wide">Range Tanggal Export</p>
            <form method="GET" action="{{ route('export.excel') }}">
                <div class="mb-2">
                    <label class="text-xs text-gray-500 font-medium">Dari</label>
                    <input type="date" name="dari"
                           value="{{ now()->startOfMonth()->toDateString() }}"
                           class="w-full border rounded px-3 py-1.5 text-sm mt-1 focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label class="text-xs text-gray-500 font-medium">Sampai</label>
                    <input type="date" name="sampai"
                           value="{{ now()->toDateString() }}"
                           class="w-full border rounded px-3 py-1.5 text-sm mt-1 focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 bg-green-600 text-white py-2 rounded text-sm font-medium hover:bg-green-700">
                        📊 Excel
                    </button>
                    <button type="submit" formaction="{{ route('export.pdf') }}"
                            class="flex-1 bg-red-600 text-white py-2 rounded text-sm font-medium hover:bg-red-700">
                        📄 PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Filter Tanggal --}}
<form method="GET" action="{{ route('dashboard') }}" class="mb-6 flex items-end gap-3">
    <div>
        <label class="block text-xs text-gray-500 font-medium mb-1">Tanggal</label>
        <input type="date" name="tanggal" value="{{ $tanggal }}"
               class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
        Tampilkan
    </button>
    @if($tanggal !== now()->toDateString())
        <a href="{{ route('dashboard') }}"
           class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">
            Hari Ini
        </a>
    @endif
</form>

{{-- Summary Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border p-5 flex items-center gap-4">
        <div class="bg-blue-50 rounded-xl w-12 h-12 flex items-center justify-center text-2xl flex-shrink-0">
            👥
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Mahasiswa</p>
            <p class="text-3xl font-bold text-gray-800 leading-tight">{{ $summary['total'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-5 flex items-center gap-4">
        <div class="bg-green-50 rounded-xl w-12 h-12 flex items-center justify-center text-2xl flex-shrink-0">
            ✅
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Hadir</p>
            <p class="text-3xl font-bold text-green-600 leading-tight">{{ $summary['hadir'] }}</p>
            @if($summary['total'] > 0)
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ round(($summary['hadir'] / $summary['total']) * 100) }}% dari total
                </p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-5 flex items-center gap-4">
        <div class="bg-red-50 rounded-xl w-12 h-12 flex items-center justify-center text-2xl flex-shrink-0">
            ❌
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Tidak Hadir</p>
            <p class="text-3xl font-bold text-red-500 leading-tight">{{ $summary['tidak_hadir'] }}</p>
            @if($summary['total'] > 0)
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ round(($summary['tidak_hadir'] / $summary['total']) * 100) }}% dari total
                </p>
            @endif
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="px-5 py-4 border-b bg-gray-50 flex items-center justify-between">
        <h2 class="font-semibold text-gray-700 text-sm">
            Detail Kehadiran —
            <span class="text-blue-600">
                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
            </span>
        </h2>
        <span class="text-xs text-gray-400">{{ $summary['total'] }} mahasiswa</span>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">NIM</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Waktu Tap</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($rekapData as $i => $row)
            <tr class="{{ !$row->hadir ? 'bg-red-50' : '' }} hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3 text-gray-400 text-xs">{{ $i + 1 }}</td>
                <td class="px-5 py-3 font-medium text-gray-800">{{ $row->nama }}</td>
                <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ $row->nim }}</td>
                <td class="px-5 py-3 text-gray-600 font-mono text-xs">
                    {{ $row->hadir ? $row->waktu_scan->format('H:i:s') : '—' }}
                </td>
                <td class="px-5 py-3">
                    @if($row->hadir)
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                            ✅ Hadir
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-600 text-xs px-2.5 py-1 rounded-full font-medium">
                            ❌ Tidak Hadir
                        </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                    Belum ada data mahasiswa terdaftar
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection