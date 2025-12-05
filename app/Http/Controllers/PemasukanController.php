<?php
namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Barang;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    public function index() {
        $barang = Barang::all();
        return view('pemasukan', ['title' => 'Pemasukan','barang' => $barang,'pemasukan' => Pemasukan::all()]);
    }

    public function create() {
        $barang = Barang::all();
        return view('pemasukan.create');
    }

    public function store(Request $request) {
        $request->validate([
            'barang_id' => 'required',
            'tanggal_masuk' => 'required|date',
            'jumlah_masuk' => 'required|integer',
            'harga_satuan' => 'required|numeric'
        ]);
        Pemasukan::create($request->all());
        return redirect()->route('pemasukan.index');
    }

    public function edit($id) {
        $pemasukan = Pemasukan::findOrFail($id);
        $barang = Barang::all();
        return view('pemasukan.edit', compact('pemasukan', 'barang'));
    }

    public function update(Request $request, $id) {
        $pemasukan = Pemasukan::findOrFail($id);
        $pemasukan->update($request->all());
        return redirect()->route('pemasukan.index');
    }

    public function destroy($id) {
        Pemasukan::destroy($id);
        return redirect()->route('pemasukan.index');
    }
}

