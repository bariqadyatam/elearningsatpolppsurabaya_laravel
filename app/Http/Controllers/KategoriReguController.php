<?php

namespace App\Http\Controllers;

use App\Models\KategoriKelas;
use App\Models\KategoriRegu;
use Illuminate\Http\Request;

class KategoriReguController extends Controller
{
    public function index()
    {
        $kategori_regus = KategoriRegu::withCount('personels')->get();
        $kategori_kelas = KategoriKelas::all();
        $title = "Kategori Regu";
        return view('kategori_regu', compact('kategori_regus', 'title', 'kategori_kelas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_kelas_id' => 'required|exists:kategori_kelas,id',
            'keterangan' => 'nullable|string'
        ]);

        KategoriRegu::create($request->only('nama', 'keterangan', 'kategori_kelas_id'));

        return redirect()->back()->with('success', 'Kategori regu berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_kelas_id' => 'required|exists:kategori_kelas,id',
            'keterangan' => 'nullable|string'
        ]);

        $kategori = KategoriRegu::findOrFail($id);
        $kategori->update($request->only('nama', 'keterangan', 'kategori_kelas_id'));

        return redirect()->back()->with('success', 'Kategori regu berhasil diperbarui');
    }


    public function destroy($id)
    {
        $kategori = KategoriRegu::findOrFail($id);

        if ($kategori->personels()->count() > 0) {
            return redirect()->back()->with('error', 'Maaf data tidak dapat dihapus karena ada personel');
        }

        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori regu berhasil dihapus');
    }
}
