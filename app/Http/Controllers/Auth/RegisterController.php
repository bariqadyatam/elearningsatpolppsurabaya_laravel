<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\MultiLayerEncryptionService;
use App\Models\KategoriRegu;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';
    protected $encryptionService;

    public function __construct(MultiLayerEncryptionService $encryptionService)
    {
        $this->middleware('guest');
        $this->encryptionService = $encryptionService;
    }
public function showRegistrationForm()
{
    $kategoriRegu = KategoriRegu::all();
    return view('auth.register', compact('kategoriRegu'));
}
    protected function validator(array $data)
{
    return Validator::make($data, [
        'username'        => ['required', 'string', 'max:255', 'unique:users'],
        'nama'            => ['required', 'string', 'max:255'],
        'id_kategori_regu'=> ['required', 'exists:kategori_regus,id'],
        'tanggal_lahir'   => ['required', 'date'],
        'foto'            => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'password'        => ['required', 'string', 'min:8', 'confirmed'],
    ]);
}

    protected function create(array $data)
{
    $user = User::create([
        'username' => $data['username'],
        'password' => Hash::make($data['password']),
        'role'     => 'Personel',
    ]);

    // Cek foto upload
    $fotoPath = 'default.png'; // simpan di storage/app/public/personel/default.png

    if (request()->hasFile('foto')) {
        $fotoPath = request()->file('foto')->store('personel', 'public');
    }

    \App\Models\Personel::create([
        'user_id'         => $user->id,
        'nama'            => $data['nama'],
        'id_kategori_regu'=> $data['id_kategori_regu'],
        'tanggal_lahir'   => $data['tanggal_lahir'],
        'foto'            => $fotoPath,
    ]);

    return $user;
}
}
