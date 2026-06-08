@extends('layouts.app')
@section('title', 'Edit Mahasiswa')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-4">
        <a href="{{ route('mahasiswa.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6">
        <h1 class="text-lg font-bold text-gray-800 mb-5">Edit Mahasiswa</h1>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required
                       class="w-full border rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-400 @enderror">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">NIM</label>
                <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required
                       class="w-full border rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nim') border-red-400 @enderror">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">UID Kartu RFID</label>
                <input type="text" name="uid" value="{{ old('uid', $mahasiswa->uid) }}" required maxlength="20"
                       style="text-transform: uppercase"
                       class="w-full border rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 @error('uid') border-red-400 @enderror">
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('mahasiswa.index') }}"
                   class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection