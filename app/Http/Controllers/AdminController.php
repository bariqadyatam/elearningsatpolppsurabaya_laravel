<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'Admin')->get();
        $title = "Admin";

        return view('admin', compact('admins', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        // Simpan user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => 'Admin'
        ]);
        return redirect()->route('admin.index')->with('message', 'Admin berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $rules = [
            'nip' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'username' => 'required|string',
        ];

        // Kalau user sedang mengedit dirinya sendiri dan mengisi password lama → cek password lama & validasi password baru
        if ($request->filled('passwordlama')) {
            if (!Hash::check($request->passwordlama, $admin->password)) {
                return back()
                    ->withErrors(['passwordlama' => 'Password lama tidak sesuai.'])
                    ->withInput();
            }

            $rules['password'] = 'required|string|min:5|confirmed';
        }

        $request->validate($rules);

        // Update data
        $admin->update([
            'nip' => $request->nip,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $admin->password,
        ]);

        return redirect()
            ->route('admin.index')
            ->with('message', 'Admin berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        $admin->delete();

        return redirect()->route('admin.index')->with('message', 'Admin berhasil dihapus!');
    }
}
