<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginproses(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Captcha wajib dicentang terlebih dahulu',
            'g-recaptcha-response.captcha' => 'Captcha tidak valid, coba lagi.',
        ]);

        $credentials = $request->only('username', 'password');

        // Validasi user dan password tanpa login langsung
        if (Auth::validate($credentials)) {
            $user = User::where('username', $request->username)->first();

            if ($user->role != 'Admin') {

                // Generate OTP 6 digit
                $otp = rand(100000, 999999);
                $user->otp_code = $otp;
                $user->otp_expired_at = now()->addMinutes(5);
                $user->save();

                // Kirim OTP ke email
                Mail::raw("Kode OTP Anda adalah: $otp (berlaku 5 menit), Jangan di sebarkan ke orang lain", function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Kode OTP Login Anda');
                });

                // Simpan user_id sementara di session
                session(['otp_user_id' => $user->id]);

                return redirect('otpform')->with('status', 'Kode OTP telah dikirim ke email Anda.');
            } else {
                Auth::login($user);
                return redirect('/dashboard');
            }
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function otpform()
    {
        return view('auth.otp');
    }

    public function otpverify(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $userId = session('otp_user_id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['otp' => 'Session OTP tidak ditemukan.']);
        }

        $user = User::find($userId);

        if (!$user || $user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if (Carbon::now()->greaterThan($user->otp_expired_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa.']);
        }

        // OTP valid → login user
        Auth::login($user);

        // Hapus OTP dari database
        $user->update(['otp_code' => null, 'otp_expired_at' => null]);
        session()->forget('otp_user_id');

        return redirect('/dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function lupaPasswordForm()
    {
        return view('auth.lupapassword');
    }

    // --- KIRIM LINK RESET PASSWORD ---
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Generate token reset (acak 64 karakter)
        $token = Str::random(64);

        // Simpan token ke kolom users
        $user->update([
            'reset_password_token' => $token,
        ]);

        // Buat URL reset password
        $resetUrl = url('reset-password/' . $token);

        // Kirim email
        Mail::raw("Klik tautan berikut untuk reset password Anda: $resetUrl", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Reset Password Akun Anda');
        });

        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }

    // --- FORM RESET PASSWORD ---
    public function resetPasswordForm($token)
    {
        // cari user berdasarkan token
        $user = User::where('reset_password_token', $token)->first();
        $email = $user ? $user->email : null;

        if (!$user) {
            return redirect('login')->withErrors(['email' => 'Token tidak valid atau sudah digunakan.']);
        }

        return view('auth.resetpassword', compact('token', 'email'));
    }

    // --- PROSES RESET PASSWORD ---
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        // cari user berdasarkan token
        $user = User::where('reset_password_token', $request->token)->first();

        if (!$user) {
            return back()->withErrors(['password' => 'Token tidak valid.']);
        }

        // update password & hapus token
        $user->update([
            'password' => Hash::make($request->password),
            'reset_password_token' => null,
        ]);

        return redirect('login')->with('status', 'Password berhasil direset. Silakan login.');
    }
}
