<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index()
    {
        return view('pembeli', ['title'=>"Pembeli", 'pembeli' => Pembeli::all()]);
    }

    public function create()
    {
        return view('pembeli.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kontak' => 'nullable|string|max:255',
        ]);

        Pembeli::create([
            'nama_pembeli' => $request->nama_pembeli,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
        ]);

        return redirect()->route('pembeli.index')->with('message', 'Data pembeli berhasil disimpan!');
    }

    public function edit($id)
    {
        $pembeli = Pembeli::where('pembeli_id', $id)->firstOrFail();
        return view('pembeli.edit', ['data' => $pembeli]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kontak' => 'nullable|string|max:255',
        ]);

        $pembeli = Pembeli::where('pembeli_id', $id)->firstOrFail();
        $pembeli->update([
            'nama_pembeli' => $request->nama_pembeli,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
        ]);

        return redirect()->route('pembeli.index')->with('message', 'Data pembeli berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pembeli::where('pembeli_id', $id)->delete();
        return redirect()->route('pembeli.index')->with('message', 'Data pembeli berhasil dihapus!');
    }
}
