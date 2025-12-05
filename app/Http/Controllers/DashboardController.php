<?php

namespace App\Http\Controllers;

use App\Models\KategoriKelas;
use App\Models\KategoriMateri;
use App\Models\KategoriRegu;
use App\Models\Materi;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role == "Admin") {
            // Hitung total data utama
            $personel         = Personel::count();
            $kategoriKelas    = KategoriKelas::count();
            $kategoriRegu     = KategoriRegu::count();
            $kategoriMateri   = KategoriMateri::count();
            $materi           = Materi::count();

            return view('dashboard', [
                'title'           => 'Dashboard',
                'personel'        => $personel,
                'kategoriKelas'   => $kategoriKelas,
                'kategoriRegu'    => $kategoriRegu,
                'kategoriMateri'  => $kategoriMateri,
                'materi'          => $materi,
            ]);
        } else {
            $user = Auth::user();
            $personel = Personel::where('user_id', $user->id)->first();

            // Cek apakah personel ditemukan
            if (!$personel) {
                abort(404, "Data personel tidak ditemukan.");
            }

            $totalMateri = Materi::count();

            // Hitung jumlah materi yang sudah dikerjakan oleh personel ini
            $materiDikerjakan = \App\Models\PersonelMateri::where('personel_id', $personel->id)
                ->where('sudah_mengerjakan', 1)
                ->count();

            // Sisanya adalah materi belum dikerjakan
            $materiBelumDikerjakan = $totalMateri - $materiDikerjakan;
            if ($materiBelumDikerjakan < 0) {
                $materiBelumDikerjakan = 0;
            }

            return view('dashboard_personel', [
                'title' => "Dashboard",
                'totalMateri' => $totalMateri,
                'materiDikerjakan' => $materiDikerjakan,
                'materiBelumDikerjakan' => $materiBelumDikerjakan,
            ]);
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $personel = Personel::where('user_id', $user->id)->first();

        $request->validate([
            'tanggal_lahir' => 'nullable|date',
            // 'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update tanggal lahir
        if ($personel && $request->filled('tanggal_lahir')) {
            $personel->tanggal_lahir = $request->tanggal_lahir;
        }

        // Update password
        if ($request->filled('passwordlama')) {
            if (!Hash::check($request->passwordlama, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak sesuai.'
                ], 400);
            } else {
                $request->validate([
                    'password' => 'required|string|min:6|confirmed',
                ]);
                $user->password = Hash::make($request->password);
            }
        }

        // Update foto (disimpan di tabel personel)
        if ($request->hasFile('foto')) {
            if ($personel && $personel->foto && $personel->foto !== 'personel/foto/default.jpg') {
                Storage::disk('public')->delete($personel->foto);
            }
            $path = $request->file('foto')->store('personel/foto', 'public');
            if ($personel) {
                $personel->foto = $path;
            }
        }

        $user->save();
        if ($personel) $personel->save();

        return response()->json(['success' => true]);
    }
}
