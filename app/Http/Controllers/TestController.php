<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Quiz;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TestController extends Controller
{
    // public function show($id)
    // {
    //     $data = Test::findOrFail($id);
    //     $quiz = Quiz::where('test_id', $id)->get();
    //     $title = "Materi";
    //     return view('test_show', compact(
    //         'title',
    //         'data',
    //         'quiz',
    //     ));

    // }

    public function show($id)
    {
        $data = Test::withCount(['personelMateri as sudah_dikerjakan' => function ($q) {
            $q->where('sudah_mengerjakan', true);
        }])->findOrFail($id);

        $quiz = Quiz::where('test_id', $id)->get();
        $title = "Materi";

        return view('test_show', compact('title', 'data', 'quiz'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'materi_id'       => 'required|exists:materis,id',
            'nama_test'       => 'required|string',
        ]);

        Test::create([
            'materi_id'      => $request->materi_id,
            'nama_test'      => $request->nama_test,
        ]);

        return back()->with('message', 'File berhasil diunggah.');
    }


    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);

        $request->validate([
            'nama_test'       => 'required|string',
        ]);

        $test->nama_test = $request->nama_test;
        $test->save();

        return back()->with('message', 'File berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $test = Test::findOrFail($id);

        $test->delete();

        return back()->with('message', 'File berhasil dihapus.');
    }
}
