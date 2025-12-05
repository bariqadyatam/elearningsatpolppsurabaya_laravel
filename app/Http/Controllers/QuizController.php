<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Personel;
use App\Models\PersonelMateri;
use App\Models\Quiz;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_id'    => 'required|exists:tests,id',
            'durasi'     => 'required|numeric|min:10',
            'pertanyaan' => 'required|string',
            'opsi_a'     => 'required|string',
            'opsi_b'     => 'required|string',
            'opsi_c'     => 'required|string',
            'opsi_d'     => 'required|string',
            'jawaban'    => 'required|in:A,B,C,D',
        ], [
            'durasi.min' => 'Durasi minimal adalah 10 second.',
        ]);

        // Custom validation untuk duplikat opsi
        $validator->after(function ($validator) use ($request) {
            $opsi = [
                $request->input('opsi_a'),
                $request->input('opsi_b'),
                $request->input('opsi_c'),
                $request->input('opsi_d'),
            ];

            if (count($opsi) !== count(array_unique($opsi))) {
                $validator->errors()->add('opsi_a', 'Opsi A, B, C, dan D tidak boleh sama.');
            }
        });

        // Jika gagal
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Quiz::create($request->all());

        return back()->with('message', 'Quiz berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'pertanyaan' => 'required|string',
            'opsi_a'     => 'required|string',
            'opsi_b'     => 'required|string',
            'opsi_c'     => 'required|string',
            'opsi_d'     => 'required|string',
            'jawaban'    => 'required|in:A,B,C,D',
            'durasi'     => 'required|numeric|min:10',
        ]);

        // Cek apakah ada opsi yang sama
        $opsi = [
            $request->input('opsi_a'),
            $request->input('opsi_b'),
            $request->input('opsi_c'),
            $request->input('opsi_d'),
        ];

        if (count($opsi) !== count(array_unique($opsi))) {
            return back()
                ->withInput()
                ->withErrors(['opsi_a' => 'Opsi A, B, C, dan D tidak boleh sama.']);
        }


        $quiz->update($request->only(['pertanyaan', 'opsi_a', 'durasi', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban']));

        return back()->with('message', 'Quiz berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return back()->with('message', 'Quiz berhasil dihapus.');
    }

    public function kerjakan($test_id)
    {
        // Ambil personel berdasarkan user yang login
        $personel = Personel::where('user_id', Auth::id())->first();


        if (!$personel) {
            return redirect()->route('materi.index')->with('error', 'Data personel tidak ditemukan.');
        }

        // Cek apakah user sudah mengerjakan materi ini
        $sudah = PersonelMateri::where('personel_id', $personel->id)
            ->where('test_id', $test_id)
            ->first();

        if ($sudah && $sudah->sudah_mengerjakan) {
            return redirect()->route('materi.index')->with('message', 'Quiz sudah dikerjakan.');
        }

        // Ambil quiz berdasarkan materi
        $materi = Materi::with('kategori')->findOrFail(Test::findOrFail($test_id)->materi_id);
        $quiz = Quiz::where('test_id', $test_id)
            ->inRandomOrder()
            ->get();

        return view('quiz_kerjakan', [
            'materi' => $materi,
            'test' => Test::findOrFail($test_id),
            'quiz' => $quiz,
            'title' => "Kerjakan Quiz"
        ]);
    }

    public function submit(Request $request, $test_id)
    {
        $personel = Personel::where('user_id', Auth::id())->first(); // ganti ke 'id_user' jika field-nya itu

        if (!$personel) {
            return redirect()->back()->with('message', 'Personel tidak ditemukan.');
        }

        $jawaban = $request->input('jawaban', []);
        $jumlah = count($jawaban);
        $benar = 0;

        foreach ($jawaban as $quiz_id => $jawaban_user) {
            $quiz = Quiz::find($quiz_id);
            if ($quiz && $quiz->jawaban === $jawaban_user) {
                $benar++;
            }
        }

        $skor = $jumlah > 0 ? ($benar / $jumlah) * 100 : 0;

        // Simpan ke tabel pivot personel_materi
        PersonelMateri::updateOrCreate(
            [
                'personel_id' => $personel->id,
                'test_id' => $test_id,
            ],
            [
                'sudah_mengerjakan' => true,
                'skor' => $skor,
            ]
        );

        return redirect()->route('materi.index')->with('message', 'Quiz berhasil dikerjakan. Skor: ' . round($skor, 2) . '%');
    }
}
