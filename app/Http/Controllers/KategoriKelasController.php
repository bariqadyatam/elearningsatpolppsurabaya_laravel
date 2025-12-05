<?php

namespace App\Http\Controllers;

use App\Models\KategoriKelas;
use Illuminate\Http\Request;

class KategoriKelasController extends Controller
{
    public function index()
    {
        $kategori_kelas = KategoriKelas::withCount(['kategoriRegus', 'materis'])->get();
        $title = "Kategori Kelas";
        return view('kategori_kelas', compact('kategori_kelas', 'title'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        KategoriKelas::create($request->only('nama', 'keterangan'));

        return redirect()->back()->with('success', 'Kategori kelas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        $kategori = KategoriKelas::findOrFail($id);
        $kategori->update($request->only('nama', 'keterangan'));

        return redirect()->back()->with('success', 'Kategori kelas berhasil diperbarui');
    }


    public function destroy($id)
    {
        $kategori = KategoriKelas::findOrFail($id);


        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori kelas berhasil dihapus');
    }
}
