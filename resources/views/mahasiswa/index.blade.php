@extends('layouts.app')
@section('title', 'Manajemen Mahasiswa')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-xl font-bold text-gray-800">Manajemen Mahasiswa</h1>
    <a href="{{ route('mahasiswa.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
        + Tambah Mahasiswa
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIM</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">UID Kartu</th>
                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($mahasiswas as $i => $mhs)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-3 text-gray-400 text-xs">{{ $mahasiswas->firstItem() + $i }}</td>
                <td class="px-5 py-3 font-medium text-gray-800">{{ $mhs->nama }}</td>
                <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ $mhs->nim }}</td>
                <td class="px-5 py-3">
                    <span class="bg-gray-100 text-gray-600 font-mono text-xs px-2 py-1 rounded">
                        {{ $mhs->uid }}
                    </span>
                </td>
                <td class="px-5 py-3 flex gap-3">
                    <a href="{{ route('mahasiswa.edit', $mhs) }}"
                       class="text-blue-600 hover:underline text-xs font-medium">Edit</a>
                    <form method="POST" action="{{ route('mahasiswa.destroy', $mhs) }}"
                          onsubmit="return confirm('Hapus {{ addslashes($mhs->nama) }}?\nSemua data absensi akan ikut terhapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-xs font-medium">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                    Belum ada mahasiswa terdaftar.
                    <a href="{{ route('mahasiswa.create') }}" class="text-blue-600 hover:underline ml-1">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $mahasiswas->links() }}</div>
@endsection