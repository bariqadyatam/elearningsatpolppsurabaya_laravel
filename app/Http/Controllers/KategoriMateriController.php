<?php

namespace App\Http\Controllers;

use App\Models\KategoriKelas;
use App\Models\KategoriMateri;
use App\Models\Materi;
use App\Models\Personel;
use App\Models\PersonelMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KategoriMateriController extends Controller
{
    public function index()
    {
        $title = "Kategori Materi";
        $kategori_materis = KategoriMateri::with('materis')->get();
        return view('kategori_materi', compact('title', 'kategori_materis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        KategoriMateri::create($request->only('nama', 'keterangan'));

        return redirect()->back()->with('success', 'Kategori materi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string'
        ]);

        $kategori = KategoriMateri::findOrFail($id);
        $kategori->update($request->only('nama', 'keterangan'));

        return redirect()->back()->with('success', 'Kategori materi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = KategoriMateri::findOrFail($id);

        if ($kategori->materis()->count() > 0) {
            return redirect()->back()->with('error', 'Maaf data tidak dapat dihapus karena ada materi yang gunakan');
        }

        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori materi berhasil dihapus');
    }

    public function list(Request $request, $id)
    {
        $search = $request->input('search');

        if (Auth::user()->role == "Admin") {
            // $materis = Materi::with('kategori')
            //     ->when($search, function ($query, $search) {
            //         return $query->where('judul', 'like', "%{$search}%");
            //     })
            //     ->where('kategori_materi_id', $id)
            //     ->get();

            // $kategori_materi = KategoriMateri::all();
            // $title = "Materi";
            // $kategori_kelas = KategoriKelas::all();
            // $idkategorimateri = $id;

            // return view('materi', compact('materis', 'kategori_materi', 'kategori_kelas', 'title', 'idkategorimateri'));

            $materis = Materi::with(['kategori', 'kelas'])
                ->when($search, function ($query, $search) {
                    return $query->where('judul', 'like', "%{$search}%");
                })
                ->where('kategori_materi_id', $id)
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
            $title = "Materi";
            $idkategorimateri = $id;

            return view('materi', compact('materis', 'kategori_materi', 'kategori_kelas', 'title', 'idkategorimateri'));
        } else {
            // Filter berdasarkan rentang tanggal untuk personel
            $today = now()->toDateString();

            $materis = Materi::with(['kategori', 'tests'])
                ->when($search, function ($query, $search) {
                    return $query->where('judul', 'like', "%{$search}%");
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('start_date')->orWhere('start_date', '<=', $today);
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
                })
                ->get();

            $kategori_materi = KategoriMateri::all();
            $title = "Materi";
            $personel = Personel::where('user_id', Auth::id())->first();

            foreach ($materis as $m) {
                $n = 0;
                $skor = 0;
                if ($personel && $m->tests) {
                    foreach ($m->tests as $test) {
                        $pivot = PersonelMateri::where('personel_id', $personel->id)
                            ->where('test_id', $test->id)
                            ->first();
                        $n++;
                        $test->status = $pivot && $pivot->sudah_mengerjakan ? 'Sudah Dikerjakan' : null;
                        $test->skor = $pivot && $pivot->skor !== null ? $pivot->skor : 0;
                        $skor += $test->skor;
                    }
                } elseif ($m->tests) {
                    foreach ($m->tests as $test) {
                        $test->status = '-';
                        $test->skor = 0;
                    }
                }

                $m->skor = $n == 0 ? "-" : ($skor / $n);
            }

            return view('materi_personel', compact('materis', 'kategori_materi', 'title'));
        }
    }
}
