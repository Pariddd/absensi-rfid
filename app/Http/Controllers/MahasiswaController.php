<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::orderBy('nama')->paginate(20);
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'uid'  => 'required|string|max:20|unique:mahasiswas',
            'nama' => 'required|string|max:100',
            'nim'  => 'required|string|max:20|unique:mahasiswas',
        ], [
            'uid.unique'  => 'UID kartu sudah terdaftar.',
            'nim.unique'  => 'NIM sudah terdaftar.',
        ]);

        Mahasiswa::create([
            'uid'  => strtoupper(trim($request->uid)),
            'nama' => trim($request->nama),
            'nim'  => trim($request->nim),
        ]);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'uid'  => 'required|string|max:20|unique:mahasiswas,uid,' . $mahasiswa->id,
            'nama' => 'required|string|max:100',
            'nim'  => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
        ], [
            'uid.unique' => 'UID kartu sudah dipakai mahasiswa lain.',
            'nim.unique' => 'NIM sudah dipakai mahasiswa lain.',
        ]);

        $mahasiswa->update([
            'uid'  => strtoupper(trim($request->uid)),
            'nama' => trim($request->nama),
            'nim'  => trim($request->nim),
        ]);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
