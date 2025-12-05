<?php

namespace App\Http\Controllers;

use App\Models\KategoriKelas;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelajaranController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Pembelajaran';
        $kelasFilter = $request->get('kelas');
        $mingguFilter = $request->get('minggu');

        // Ambil semua kelas dan minggu untuk dropdown filter
        $kelasList = DB::table('kategori_kelas')->get();
        $mingguList = range(1, 15); // misal ada 12 minggu

        // Query pembelajaran join dengan tabel lain
        $pembelajaran = DB::table('pembelajarans')
            ->join('personels', 'pembelajarans.personel_id', '=', 'personels.id')
            ->join('kategori_regus', 'personels.id_kategori_regu', '=', 'kategori_regus.id')
            ->join('kategori_kelas', 'kategori_regus.kategori_kelas_id', '=', 'kategori_kelas.id')
            ->select(
                'pembelajarans.*',
                'personels.nama as nama_personel',
                'kategori_regus.nama as nama_regu',
                'kategori_kelas.nama as nama_kelas'
            )
            ->when($kelasFilter, fn($q) => $q->where('kategori_kelas.id', $kelasFilter))
            ->when($mingguFilter, fn($q) => $q->where('pembelajarans.mingguke', $mingguFilter))
            ->orderBy('pembelajarans.created_at', 'desc')
            ->get();

        return view('pembelajaran', compact('pembelajaran', 'kelasList', 'mingguList', 'kelasFilter', 'mingguFilter', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'personel_id' => 'required|exists:personels,id',
            'mingguke' => 'required|numeric|min:1',
            'catatan' => 'nullable|string'
        ]);

        DB::table('pembelajarans')->insert([
            'personel_id' => $request->personel_id,
            'mingguke' => $request->mingguke,
            'catatan' => $request->catatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Data pembelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mingguke' => 'required|numeric|min:1',
            'catatan' => 'nullable|string'
        ]);

        DB::table('pembelajarans')->where('id', $id)->update([
            'mingguke' => $request->mingguke,
            'catatan' => $request->catatan,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Data pembelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('pembelajarans')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data pembelajaran berhasil dihapus.');
    }
}
