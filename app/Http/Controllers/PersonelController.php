<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Personel;
use App\Models\KategoriRegu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PersonelController extends Controller
{
    public function index(Request $request)
    {
        $query = Personel::with('user', 'kategoriRegu');

        // Jika ada pencarian nama
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $personels = $query->get();
        $kategori_regus = KategoriRegu::all();
        $title = "Personel";

        return view('personel', compact('personels', 'kategori_regus', 'title'))
            ->with('search', $request->search);
    }

    public function create()
    {
        $kategoriRegus = KategoriRegu::all();
        return view('personel.create', compact('kategoriRegus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
            'kategori_regu_id' => 'nullable|exists:kategori_regus,id',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|max:2048'
        ]);

        // Simpan user
        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'Personel'
        ]);

        // Simpan foto (pakai default kalau tidak upload)
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('personel/foto', 'public');
        } else {
            $fotoPath = 'personel/foto/default.jpg'; // default disimpan di storage/app/public/personel/foto/
        }

        // Simpan personel
        Personel::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'id_kategori_regu' => $request->kategori_regu_id,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto' => $fotoPath
        ]);

        return redirect()->route('personel.index')->with('message', 'Personel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $personel = Personel::with('user')->findOrFail($id);
        $kategoriRegus = KategoriRegu::all();

        return view('personel.edit', compact('personel', 'kategoriRegus'));
    }

    public function update(Request $request, $id)
    {
        $personel = Personel::with('user')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $personel->user_id,
            'password' => 'nullable|string|min:6',
            'kategori_regu_id' => 'nullable|exists:kategori_regus,id',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|max:2048'
        ]);

        // Update user
        $personel->user->update([
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $personel->user->password,
        ]);

        // Handle foto
        if ($request->hasFile('foto')) {
            if ($personel->foto && $personel->foto !== 'personel/foto/default.jpg') {
                Storage::disk('public')->delete($personel->foto);
            }
            $fotoPath = $request->file('foto')->store('personel/foto', 'public');
        } else {
            $fotoPath = $personel->foto ?? 'personel/foto/default.jpg';
        }

        // Update personel
        $personel->update([
            'nama' => $request->nama,
            'id_kategori_regu' => $request->kategori_regu_id,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto' => $fotoPath
        ]);

        return redirect()->route('personel.index')->with('message', 'Personel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $personel = Personel::findOrFail($id);

        // Hapus foto jika bukan default
        if ($personel->foto && $personel->foto !== 'personel/foto/default.jpg') {
            Storage::disk('public')->delete($personel->foto);
        }

        // Hapus user (akan otomatis hapus personel jika pakai foreign cascade)
        $personel->user()->delete();

        return redirect()->route('personel.index')->with('message', 'Personel berhasil dihapus!');
    }
}
