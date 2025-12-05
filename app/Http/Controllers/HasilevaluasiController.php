<?php

namespace App\Http\Controllers;

use App\Models\KategoriKelas;
use App\Models\KategoriMateri;
use App\Models\Materi;
use App\Models\PersonelMateri;
use App\Models\Test;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilevaluasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter_kelas = $request->input('filter_kelas');

        $materis = Materi::with(['kategori', 'kelas'])
            ->when($search, function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%");
            })
            ->when($filter_kelas, function ($query, $filter_kelas) {
                $query->where('kategori_kelas_id', $filter_kelas);
            })
            ->get();

        foreach ($materis as $materi) {
            // Jumlah kelas
            $materi->jumlah_kelas = $materi->kelas ? 1 : 0;

            // Hitung jumlah personel berdasarkan kategori_kelas_id
            $materi->jumlah_personel = DB::table('personels')
                ->join('kategori_regus', 'personels.id_kategori_regu', '=', 'kategori_regus.id')
                ->where('kategori_regus.kategori_kelas_id', $materi->kategori_kelas_id)
                ->count();
        }

        $kategori_materi = KategoriMateri::all();
        $kategori_kelas = KategoriKelas::all();
        $title = "Hasil Evaluasi";

        return view('hasilevaluasi', compact('materis', 'kategori_materi', 'kategori_kelas', 'title', 'filter_kelas'));
    }

    public function show($id)
    {
        // Ambil data materi
        $data = Materi::with(['kategori', 'kelas'])->findOrFail($id);

        // Ambil semua test yang terkait materi ini
        $test = Test::where('materi_id', $id)
            ->withCount(['personelMateri as sudah_dikerjakan' => function ($q) {
                $q->where('sudah_mengerjakan', true);
            }])
            ->get();

        // Ambil link tambahan (jika ada di tabel links)
        // $link = Link::where('materi_id', $id)->get();

        $title = "Detail Materi";

        return view('hasilevaluasi_show', compact(
            'data',
            'title',
            'test',
            // 'link'
        ));
    }

    public function evaluasishow($id)
    {
        // Ambil test dan materi terkait
        $test = Test::with('materi')->findOrFail($id);

        // Ambil hasil pengerjaan peserta
        $hasil = PersonelMateri::with(['personel.kategoriRegu.kelas'])
            ->where('test_id', $id)
            ->get();

        $title = "Hasil Evaluasi: " . $test->nama_test;

        return view('evaluasi_show', compact('test', 'hasil', 'title'));
    }

    public function evaluasicetak($id)
    {
        $test = Test::with('materi')->findOrFail($id);

        $hasil = PersonelMateri::with(['personel.kategoriRegu.kelas'])
            ->where('test_id', $id)
            ->get();

        $pdf = Pdf::loadView('evaluasi_pdf', compact('test', 'hasil'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Hasil_Evaluasi_' . $test->nama_test . '.pdf');
    }
}
