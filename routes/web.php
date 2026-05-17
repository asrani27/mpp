<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserPermohonanController;
use App\Http\Controllers\User\UserFeedbackController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\Petugas\PetugasProfileController;
use App\Http\Controllers\Petugas\PetugasPermohonanController;

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('admin.dashboard');
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->middleware('auth')->name('user.dashboard');

// Petugas Routes
Route::get('/petugas/dashboard', [PetugasDashboardController::class, 'index'])->middleware('auth')->name('petugas.dashboard');

// Petugas Routes - Profil
Route::middleware('auth')->group(function () {
    Route::get('/petugas/profil', [PetugasProfileController::class, 'index'])->name('petugas.profil.index');
    Route::put('/petugas/profil', [PetugasProfileController::class, 'update'])->name('petugas.profil.update');
    Route::put('/petugas/profil/password', [PetugasProfileController::class, 'updatePassword'])->name('petugas.profil.updatePassword');
});

// Petugas Routes - Permohonan
Route::middleware('auth')->group(function () {
    Route::get('/petugas/permohonan', [PetugasPermohonanController::class, 'index'])->name('petugas.permohonan.index');
    Route::get('/petugas/permohonan/{permohonan}', [PetugasPermohonanController::class, 'show'])->name('petugas.permohonan.show');
    Route::put('/petugas/permohonan/{permohonan}/status', [PetugasPermohonanController::class, 'updateStatus'])->name('petugas.permohonan.updateStatus');
});

// User Routes - Profile
Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile.index');
    Route::put('/user/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
});

// User Routes - Feedback (CRUD)
Route::middleware('auth')->group(function () {
    Route::get('/user/feedback', [UserFeedbackController::class, 'index'])->name('user.feedback.index');
    Route::get('/user/feedback/create', [UserFeedbackController::class, 'create'])->name('user.feedback.create');
    Route::post('/user/feedback', [UserFeedbackController::class, 'store'])->name('user.feedback.store');
    Route::get('/user/feedback/{feedback}', [UserFeedbackController::class, 'show'])->name('user.feedback.show');
    Route::get('/user/feedback/{feedback}/edit', [UserFeedbackController::class, 'edit'])->name('user.feedback.edit');
    Route::put('/user/feedback/{feedback}', [UserFeedbackController::class, 'update'])->name('user.feedback.update');
    Route::delete('/user/feedback/{feedback}', [UserFeedbackController::class, 'destroy'])->name('user.feedback.destroy');
});

// User Routes - Permohonan
Route::middleware('auth')->group(function () {
    Route::get('/user/permohonan', [UserPermohonanController::class, 'index'])->name('user.permohonan.index');
    Route::get('/user/permohonan/create', [UserPermohonanController::class, 'create'])->name('user.permohonan.create');
    Route::post('/user/permohonan', [UserPermohonanController::class, 'store'])->name('user.permohonan.store');
    Route::get('/user/permohonan/{permohonan}', [UserPermohonanController::class, 'show'])->name('user.permohonan.show');
    Route::delete('/user/permohonan/{permohonan}', [UserPermohonanController::class, 'destroy'])->name('user.permohonan.destroy');
});

// Admin Routes - Permohonan (CRUD)
Route::middleware('auth')->group(function () {
    Route::get('/admin/permohonan', [App\Http\Controllers\Admin\PermohonanController::class, 'index'])->name('admin.permohonan.index');
    Route::get('/admin/permohonan/create', [App\Http\Controllers\Admin\PermohonanController::class, 'create'])->name('admin.permohonan.create');
    Route::post('/admin/permohonan', [App\Http\Controllers\Admin\PermohonanController::class, 'store'])->name('admin.permohonan.store');
    Route::get('/admin/permohonan/{permohonan}', [App\Http\Controllers\Admin\PermohonanController::class, 'show'])->name('admin.permohonan.show');
    Route::get('/admin/permohonan/{permohonan}/edit', [App\Http\Controllers\Admin\PermohonanController::class, 'edit'])->name('admin.permohonan.edit');
    Route::put('/admin/permohonan/{permohonan}', [App\Http\Controllers\Admin\PermohonanController::class, 'update'])->name('admin.permohonan.update');
    Route::delete('/admin/permohonan/{permohonan}', [App\Http\Controllers\Admin\PermohonanController::class, 'destroy'])->name('admin.permohonan.destroy');
    Route::post('/admin/permohonan/{permohonan}/status', [App\Http\Controllers\Admin\PermohonanController::class, 'updateStatus'])->name('admin.permohonan.updateStatus');
});

// Admin Routes - Masyarakat (CRUD)
Route::middleware('auth')->group(function () {
    Route::get('/admin/masyarakat', [App\Http\Controllers\Admin\MasyarakatController::class, 'index'])->name('admin.masyarakat.index');
    Route::get('/admin/masyarakat/create', [App\Http\Controllers\Admin\MasyarakatController::class, 'create'])->name('admin.masyarakat.create');
    Route::post('/admin/masyarakat', [App\Http\Controllers\Admin\MasyarakatController::class, 'store'])->name('admin.masyarakat.store');
    Route::get('/admin/masyarakat/{masyarakat}/edit', [App\Http\Controllers\Admin\MasyarakatController::class, 'edit'])->name('admin.masyarakat.edit');
    Route::put('/admin/masyarakat/{masyarakat}', [App\Http\Controllers\Admin\MasyarakatController::class, 'update'])->name('admin.masyarakat.update');
    Route::delete('/admin/masyarakat/{masyarakat}', [App\Http\Controllers\Admin\MasyarakatController::class, 'destroy'])->name('admin.masyarakat.destroy');
});

// Admin Routes - Petugas (CRUD)
Route::middleware('auth')->group(function () {
    Route::get('/admin/petugas', [App\Http\Controllers\Admin\PetugasController::class, 'index'])->name('admin.petugas.index');
    Route::get('/admin/petugas/create', [App\Http\Controllers\Admin\PetugasController::class, 'create'])->name('admin.petugas.create');
    Route::post('/admin/petugas', [App\Http\Controllers\Admin\PetugasController::class, 'store'])->name('admin.petugas.store');
    Route::get('/admin/petugas/{petugas}/edit', [App\Http\Controllers\Admin\PetugasController::class, 'edit'])->name('admin.petugas.edit');
    Route::put('/admin/petugas/{petugas}', [App\Http\Controllers\Admin\PetugasController::class, 'update'])->name('admin.petugas.update');
    Route::delete('/admin/petugas/{petugas}', [App\Http\Controllers\Admin\PetugasController::class, 'destroy'])->name('admin.petugas.destroy');
});

// Admin Routes - Layanan (CRUD)
Route::middleware('auth')->group(function () {
    Route::get('/admin/layanan', [App\Http\Controllers\Admin\LayananController::class, 'index'])->name('admin.layanan.index');
    Route::get('/admin/layanan/create', [App\Http\Controllers\Admin\LayananController::class, 'create'])->name('admin.layanan.create');
    Route::post('/admin/layanan', [App\Http\Controllers\Admin\LayananController::class, 'store'])->name('admin.layanan.store');
    Route::get('/admin/layanan/{layanan}/edit', [App\Http\Controllers\Admin\LayananController::class, 'edit'])->name('admin.layanan.edit');
    Route::put('/admin/layanan/{layanan}', [App\Http\Controllers\Admin\LayananController::class, 'update'])->name('admin.layanan.update');
    Route::delete('/admin/layanan/{layanan}', [App\Http\Controllers\Admin\LayananController::class, 'destroy'])->name('admin.layanan.destroy');
});

// Admin Routes - Instansi (CRUD)
Route::middleware('auth')->group(function () {
    Route::get('/admin/instansi', [App\Http\Controllers\Admin\InstansiController::class, 'index'])->name('admin.instansi.index');
    Route::get('/admin/instansi/create', [App\Http\Controllers\Admin\InstansiController::class, 'create'])->name('admin.instansi.create');
    Route::post('/admin/instansi', [App\Http\Controllers\Admin\InstansiController::class, 'store'])->name('admin.instansi.store');
    Route::get('/admin/instansi/{instansi}/edit', [App\Http\Controllers\Admin\InstansiController::class, 'edit'])->name('admin.instansi.edit');
    Route::put('/admin/instansi/{instansi}', [App\Http\Controllers\Admin\InstansiController::class, 'update'])->name('admin.instansi.update');
    Route::delete('/admin/instansi/{instansi}', [App\Http\Controllers\Admin\InstansiController::class, 'destroy'])->name('admin.instansi.destroy');
});

// Admin Routes - Feedback (Read & Delete)
Route::middleware('auth')->group(function () {
    Route::get('/admin/feedback', [App\Http\Controllers\Admin\FeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::get('/admin/feedback/{feedback}', [App\Http\Controllers\Admin\FeedbackController::class, 'show'])->name('admin.feedback.show');
    Route::delete('/admin/feedback/{feedback}', [App\Http\Controllers\Admin\FeedbackController::class, 'destroy'])->name('admin.feedback.destroy');
});

// Admin Routes - Laporan
Route::middleware('auth')->group(function () {
    Route::get('/admin/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/admin/laporan/export-petugas', [App\Http\Controllers\Admin\LaporanController::class, 'exportPetugas'])->name('admin.laporan.exportPetugas');
    Route::get('/admin/laporan/export-layanan', [App\Http\Controllers\Admin\LaporanController::class, 'exportLayanan'])->name('admin.laporan.exportLayanan');
    Route::get('/admin/laporan/export-permohonan', [App\Http\Controllers\Admin\LaporanController::class, 'exportPermohonan'])->name('admin.laporan.exportPermohonan');
    Route::get('/admin/laporan/export-feedback', [App\Http\Controllers\Admin\LaporanController::class, 'exportFeedback'])->name('admin.laporan.exportFeedback');
});

// Admin Routes - Pengaturan
Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan.index');
})->middleware('auth')->name('admin.pengaturan.index');