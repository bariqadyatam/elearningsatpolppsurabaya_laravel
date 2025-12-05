<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilevaluasiController;
use App\Http\Controllers\KategoriKelasController;
use App\Http\Controllers\KategoriMateriController;
use App\Http\Controllers\KategoriReguController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\PersonelController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Auth::routes();

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/loginproses', [AuthController::class, 'loginproses'])->name('loginproses');
Route::get('/otpform', [AuthController::class, 'otpform'])->name('otpform');
Route::post('/otpverify', [AuthController::class, 'otpverify'])->name('otpverify');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('lupapassword', [AuthController::class, 'lupaPasswordForm'])->name('password.request');
Route::post('lupapassword', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/personel', [PersonelController::class, 'index'])->name('personel.index')->middleware('auth');
Route::post('/personel', [PersonelController::class, 'store'])->name('personel.store')->middleware('auth');
Route::put('/personel/{id}', [PersonelController::class, 'update'])->name('personel.update')->middleware('auth');
Route::delete('/personel/{id}', [PersonelController::class, 'destroy'])->name('personel.destroy')->middleware('auth');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('auth');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store')->middleware('auth');
Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update')->middleware('auth');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy')->middleware('auth');

Route::get('/kategori_materi', [KategoriMateriController::class, 'index'])->name('kategori_materi.index')->middleware('auth');
Route::post('/kategori_materi', [KategoriMateriController::class, 'store'])->name('kategori_materi.store')->middleware('auth');
Route::put('/kategori_materi/{id}', [KategoriMateriController::class, 'update'])->name('kategori_materi.update')->middleware('auth');
Route::get('/kategori_materi_list/{id}', [KategoriMateriController::class, 'list'])->name('kategori_materi.list')->middleware('auth');
Route::delete('/kategori_materi/{id}', [KategoriMateriController::class, 'destroy'])->name('kategori_materi.destroy')->middleware('auth');

Route::get('/kategori_kelas', [KategoriKelasController::class, 'index'])->name('kategori_kelas.index')->middleware('auth');
Route::post('/kategori_kelas', [KategoriKelasController::class, 'store'])->name('kategori_kelas.store')->middleware('auth');
Route::put('/kategori_kelas/{id}', [KategoriKelasController::class, 'update'])->name('kategori_kelas.update')->middleware('auth');
Route::delete('/kategori_kelas/{id}', [KategoriKelasController::class, 'destroy'])->name('kategori_kelas.destroy')->middleware('auth');

Route::get('/pembelajaran', [PembelajaranController::class, 'index'])->name('pembelajaran.index')->middleware('auth');
Route::post('/pembelajaran', [PembelajaranController::class, 'store'])->name('pembelajaran.store')->middleware('auth');
Route::put('/pembelajaran/{id}', [PembelajaranController::class, 'update'])->name('pembelajaran.update')->middleware('auth');
Route::delete('/pembelajaran/{id}', [PembelajaranController::class, 'destroy'])->name('pembelajaran.destroy')->middleware('auth');

Route::get('/hasilevaluasi', [HasilevaluasiController::class, 'index'])->name('hasilevaluasi.index')->middleware('auth');
Route::get('/hasilevaluasi/{id}', [HasilevaluasiController::class, 'show'])->name('hasilevaluasi.show')->middleware('auth');
Route::get('/evaluasi/{id}', [HasilevaluasiController::class, 'evaluasishow'])->name('evaluasi.show')->middleware('auth');
Route::get('/evaluasicetak/{id}', [HasilevaluasiController::class, 'evaluasicetak'])->name('evaluasi.cetak')->middleware('auth');

Route::get('/kategori_regu', [KategoriReguController::class, 'index'])->name('kategori_regu.index')->middleware('auth');
Route::post('/kategori_regu', [KategoriReguController::class, 'store'])->name('kategori_regu.store')->middleware('auth');
Route::put('/kategori_regu/{id}', [KategoriReguController::class, 'update'])->name('kategori_regu.update')->middleware('auth');
Route::delete('/kategori_regu/{id}', [KategoriReguController::class, 'destroy'])->name('kategori_regu.destroy')->middleware('auth');

Route::get('/materi', [MateriController::class, 'index'])->name('materi.index')->middleware('auth');
Route::post('/materi', [MateriController::class, 'store'])->name('materi.store')->middleware('auth');
Route::get('/materi/{id}', [MateriController::class, 'show'])->name('materi.show')->middleware('auth');
Route::put('/materi/{id}', [MateriController::class, 'update'])->name('materi.update')->middleware('auth');
Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('materi.destroy')->middleware('auth');

Route::post('/quiz/store', [QuizController::class, 'store'])->name('quiz.store')->middleware('auth');
Route::put('/quiz/{id}', [QuizController::class, 'update'])->name('quiz.update')->middleware('auth');
Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('quiz.destroy')->middleware('auth');
Route::get('/quiz/kerjakan/{materi}', [QuizController::class, 'kerjakan'])->name('quiz.kerjakan')->middleware('auth');
Route::post('/quiz/submit/{materi}', [QuizController::class, 'submit'])->name('quiz.submit')->middleware('auth');

Route::post('/link/store', [LinkController::class, 'store'])->name('link.store')->middleware('auth');
Route::put('/link/{id}', [LinkController::class, 'update'])->name('link.update')->middleware('auth');
Route::delete('/link/{id}', [LinkController::class, 'destroy'])->name('link.destroy')->middleware('auth');
Route::get('/link/kerjakan/{materi}', [LinkController::class, 'kerjakan'])->name('link.kerjakan')->middleware('auth');
Route::post('/link/submit/{materi}', [LinkController::class, 'submit'])->name('link.submit')->middleware('auth');

Route::get('/test', [TestController::class, 'index'])->name('test.index')->middleware('auth');
Route::post('/test', [TestController::class, 'store'])->name('test.store')->middleware('auth');
Route::get('/test/{id}', [TestController::class, 'show'])->name('test.show')->middleware('auth');
Route::put('/test/{id}', [TestController::class, 'update'])->name('test.update')->middleware('auth');
Route::delete('/test/{id}', [TestController::class, 'destroy'])->name('test.destroy')->middleware('auth');

Route::post('/update-profile', [DashboardController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/sertifikat/generate', [MateriController::class, 'generate'])->name('sertifikat.generate')->middleware('auth');
Route::post('/sertifikat/store-batch', [MateriController::class, 'storeBatch'])->name('sertifikat.storeBatch')->middleware('auth');

// Quiz CRUD (Admin)
Route::post('/quiz/store', [QuizController::class, 'store'])->name('quiz.store')->middleware('auth');
Route::put('/quiz/{id}', [QuizController::class, 'update'])->name('quiz.update')->middleware('auth');
Route::delete('/quiz/{id}', [QuizController::class, 'destroy'])->name('quiz.destroy')->middleware('auth');

// Quiz Personel (per soal)
Route::get('/quiz/kerjakan/{test_id}', [QuizController::class, 'kerjakan'])->name('quiz.kerjakan')->middleware('auth');
// Inisialisasi: acak soal + set session

Route::get('/quiz/{test_id}/per-soal', [QuizController::class, 'perSoal'])->name('quiz.perSoal')->middleware('auth');
// Tampilkan soal per halaman

Route::post('/quiz/{test_id}/{quiz_id}/jawab', [QuizController::class, 'jawabPerSoal'])->name('quiz.jawabPerSoal')->middleware('auth');
// Simpan jawaban tiap soal + lanjut

Route::post('/quiz/submit/{test_id}', [QuizController::class, 'submit'])->name('quiz.submit')->middleware('auth');
// Hitung skor & simpan ke DB
