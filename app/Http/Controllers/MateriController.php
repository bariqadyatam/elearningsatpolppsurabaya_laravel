<?php

namespace App\Http\Controllers;

use App\Models\KategoriKelas;
use App\Models\KategoriMateri;
use App\Models\Link;
use App\Models\Materi;
use App\Models\Personel;
use App\Models\PersonelMateri;
use App\Models\Quiz;
use App\Models\Sertifikat;
use App\Models\Test;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if (Auth::user()->role == "Admin") {
            // $materis = Materi::with('kategori')
            //     ->when($search, function ($query, $search) {
            //         return $query->where('judul', 'like', "%{$search}%");
            //     })
            //     ->get();

            // $kategori_materi = KategoriMateri::all();
            // $kategori_kelas = KategoriKelas::all();
            // $title = "Materi";
            // return view('materi', compact('materis', 'kategori_materi', 'kategori_kelas', 'title'));

            $materis = Materi::with(['kategori', 'kelas'])
                ->when($search, function ($query, $search) {
                    return $query->where('judul', 'like', "%{$search}%");
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
            $title = "Materi";

            return view('materi', compact('materis', 'kategori_materi', 'kategori_kelas', 'title'));
        } else {
            $today = now()->toDateString();
            $personel = Personel::where('user_id', Auth::id())->first();

            // Default query materi
            $materisQuery = Materi::with(['kategori', 'tests'])
                ->when($search, function ($query, $search) {
                    return $query->where('judul', 'like', "%{$search}%");
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('start_date')->orWhere('start_date', '<=', $today);
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
                });

            // Jika personel ditemukan, filter materi sesuai kelas personel
            if ($personel) {
                $kategoriRegu = DB::table('kategori_regus')->where('id', $personel->id_kategori_regu)->first();

                if ($kategoriRegu) {
                    $materisQuery->where('kategori_kelas_id', $kategoriRegu->kategori_kelas_id);
                }
            }

            $materis = $materisQuery->get();

            // Hitung skor dan status pengerjaan
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

            $kategori_materi = KategoriMateri::all();
            $title = "Materi";

            return view('materi_personel', compact('materis', 'kategori_materi', 'title'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_materi_id' => 'required|exists:kategori_materis,id',
            'kategori_kelas_id' => 'required|exists:kategori_kelas,id',
            'isi' => 'required|string',
            'video' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Simpan thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Simpan foto tanda tangan
        $fotoTandaTanganPath = null;
        if ($request->hasFile('foto_tanda_tangan')) {
            $fotoTandaTanganPath = $request->file('foto_tanda_tangan')->store('foto_tanda_tangan', 'public');
        }

        // Simpan banyak gambar (JSON array)
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('materi_images', 'public'); // konsisten
                $imagePaths[] = $path;
            }
        }

        // Simpan ke database
        Materi::create([
            'judul' => $request->judul,
            'kategori_materi_id' => $request->kategori_materi_id,
            'kategori_kelas_id' => $request->kategori_kelas_id,
            'isi' => $request->isi,
            'no_sertif' => $request->no_sertif,
            'pernyataan_sertifikat' => $request->pernyataan_sertifikat,
            'keterangan_sertifikat' => $request->keterangan_sertifikat,
            'foto_tanda_tangan' => $fotoTandaTanganPath,
            'video' => $request->video,
            'thumbnail' => $thumbnailPath,
            'images' => json_encode($imagePaths),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return back()->with('message', 'Materi berhasil ditambahkan!');
    }

    public function storeBatch(Request $request)
    {
        foreach ($request->data as $row) {
            Sertifikat::updateOrCreate(
                [
                    'personel_id' => $row['personel_id'],
                    'materi_id' => $row['materi_id']
                ],
                [
                    'number' => $row['number'],
                    'durasi' => $row['durasi']
                ]
            );
        }

        return back()->with('success', 'Sertifikat berhasil disimpan!');
    }

    public function show($id)
    {
        $data = Materi::findOrFail($id);

        // Blokir personel bila di luar rentang tanggal
        if (Auth::user()->role != "Admin") {
            $today = now()->toDateString();
            if (
                ($data->start_date && $today < $data->start_date) ||
                ($data->end_date && $today > $data->end_date)
            ) {
                abort(403, 'Materi tidak tersedia.');
            }
        }

        if (Auth::user()->role == "Admin") {
            // $test = Test::where('materi_id', $id)->get();
            $test = Test::where('materi_id', $id)
                ->withCount(['personelMateri as sudah_dikerjakan' => function ($q) {
                    $q->where('sudah_mengerjakan', true);
                }])
                ->get();

            $link = Link::where('materi_id', $id)->get();
            $title = "Materi";

            $test_ids = $test->pluck('id');

            $personel_selesai = PersonelMateri::with('personel')
                ->selectRaw('personel_id, MAX(skor) as skor')
                ->whereIn('test_id', $test_ids)
                ->where('sudah_mengerjakan', true)
                ->groupBy('personel_id')
                ->get();

            $personel_belum_mengerjakan = PersonelMateri::with('personel')
                ->selectRaw('personel_id')
                ->whereIn('test_id', $test_ids)
                ->where('sudah_mengerjakan', false)
                ->groupBy('personel_id')
                ->get();

            return view('materi_show', compact(
                'data',
                'title',
                'test',
                'link',
                'personel_selesai',
                'personel_belum_mengerjakan'
            ));
        } else {
            $kategori_materi = KategoriMateri::all();
            $title = "Materi";
            $status = "Belum Selesai";

            $personel = Personel::where('user_id', Auth::id())->first();

            $materi_belum_selesai = [];

            if ($personel && $data->tests) {
                foreach ($data->tests as $test) {
                    $pivot = PersonelMateri::where('personel_id', $personel->id)
                        ->where('test_id', $test->id)
                        ->first();

                    $test->status = $pivot && $pivot->sudah_mengerjakan ? 'Sudah Dikerjakan' : null;
                    $test->skor = $pivot && $pivot->skor !== null ? $pivot->skor : '-';

                    if ($pivot && $pivot->skor !== null) {
                        $status = "Sudah Dikerjakan";
                    }
                    if (!$pivot) {
                        $status = "Belum Selesai";
                    }
                }
            } elseif ($data->tests) {
                foreach ($data->tests as $test) {
                    $test->status = '-';
                    $test->skor = '-';
                }
            }

            // Materi lain yang belum selesai (opsional: juga bisa difilter tanggal aktif)
            $all_materi = Materi::where('id', '!=', $id)->get();
            foreach ($all_materi as $materi) {
                $is_belum_selesai = false;

                foreach ($materi->tests as $test) {
                    $pivot = PersonelMateri::where('personel_id', $personel->id)
                        ->where('test_id', $test->id)
                        ->first();

                    if (!$pivot || !$pivot->sudah_mengerjakan) {
                        $is_belum_selesai = true;
                        break;
                    }
                }

                if ($is_belum_selesai) {
                    $materi_belum_selesai[] = $materi;
                }
            }

            return view('materi_personel_show', compact(
                'data',
                'kategori_materi',
                'personel',
                'title',
                'status',
                'materi_belum_selesai'
            ));
        }
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_materi_id' => 'required|exists:kategori_materis,id',
            'kategori_kelas_id' => 'required|exists:kategori_kelas,id',
            'isi' => 'required|string',
            'video' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $request->only(
            'judul',
            'kategori_materi_id',
            'kategori_kelas_id',
            'isi',
            'video',
            'number',
            'durasi',
            'huruf',
            'no_sertif',
            'pernyataan_sertifikat',
            'keterangan_sertifikat',
            'start_date',
            'end_date'
        );

        // Update foto tanda tangan jika ada
        if ($request->hasFile('foto_tanda_tangan')) {
            if ($materi->foto_tanda_tangan && \Storage::disk('public')->exists($materi->foto_tanda_tangan)) {
                \Storage::disk('public')->delete($materi->foto_tanda_tangan);
            }
            $data['foto_tanda_tangan'] = $request->file('foto_tanda_tangan')->store('foto_tanda_tangan', 'public');
        }

        // Update thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            if ($materi->thumbnail && \Storage::disk('public')->exists($materi->thumbnail)) {
                \Storage::disk('public')->delete($materi->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Update multiple images jika ada
        if ($request->hasFile('images')) {
            // Hapus gambar lama jika ada
            if ($materi->images) { // FIX: sebelumnya typo iamges
                foreach (json_decode($materi->images, true) as $oldImage) {
                    if (\Storage::disk('public')->exists($oldImage)) {
                        \Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('materi_images', 'public'); // konsisten
                $imagePaths[] = $path;
            }

            $data['images'] = json_encode($imagePaths);
        }

        $materi->update($data);

        return back()->with('message', 'Materi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);
        $materi->delete();

        return back()->with('message', 'Materi berhasil dihapus!');
    }

    public function generate(Request $request)
    {
        $nama = $request->input('nama', 'Nama Peserta');
        $judul_materi = $request->input('materi', 'Telah Mengikuti e-Learning');
        $tanggal = $request->input('tanggal', now());
        $personelId = $request->input('personel_id');
        $materiId = $request->input('materi_id');

        $materi = Materi::findOrFail($materiId);

        // cari/buat sertifikat
        $sertifikat = Sertifikat::firstOrCreate(
            [
                'personel_id' => $personelId,
                'materi_id'   => $materiId,
            ],
            [
                'number'    => $materi->no_sertif,
                'durasi'    => $materi->durasi,
                'unique_id' => str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT),
            ]
        );

        // Nomor sertifikat final
        $nomor_sertifikat = $sertifikat->unique_id . '-' . $sertifikat->number;

        $pernyataan_sertifikat = $materi->pernyataan_sertifikat;
        $keterangan_sertifikat = $materi->keterangan_sertifikat;
        $foto_tanda_tangan = $materi->foto_tanda_tangan;
        $kategori = $materi->kategori->nama;
        $durasi = $materi->durasi;

        // Convert image ke base64
        $path = public_path('storage/' . $foto_tanda_tangan);
        if ($foto_tanda_tangan && file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $ttd_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            $ttd_base64 = '';
        }

        $pdf = Pdf::loadView('sertifikat', compact(
            'nama',
            'kategori',
            'durasi',
            'judul_materi',
            'tanggal',
            'nomor_sertifikat',
            'pernyataan_sertifikat',
            'keterangan_sertifikat',
            'ttd_base64'
        ))->setPaper([0, 0, 1950, 1270]);

        return $pdf->download('sertifikat-' . $nama . '.pdf');
    }
}
