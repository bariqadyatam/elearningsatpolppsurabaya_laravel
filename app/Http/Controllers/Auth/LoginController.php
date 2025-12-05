<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enkripsi;
use App\Models\User;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\Twofish;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Arahkan user setelah login.
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        return '/dashboard'; // fallback
    }

    /**
     * Gunakan 'username' alih-alih 'email'.
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Validasi login menggunakan username.
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Captcha wajib dicentang terlebih dahulu',
            'g-recaptcha-response.captcha' => 'Captcha tidak valid, coba lagi.',
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
