<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Import Semua Controller
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Kasubsi\KasubsiDashboardController;
use App\Http\Controllers\Kasi\KasiDashboardController;
use App\Http\Controllers\Kakan\KakanDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// --- PENGALIH ARUS DASHBOARD (REDIRECTOR) ---
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    
    return match($role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'kasubsi' => redirect()->route('kasubsi.dashboard'),
        'kasi'    => redirect()->route('kasi.dashboard'),
        'kakan'   => redirect()->route('kakan.dashboard'), 
        'kakanim' => redirect()->route('kakan.dashboard'), 
        default   => redirect()->route('user.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');


// ====================================================
// 1. AREA USER (PEMOHON)
// ====================================================
Route::middleware(['auth', 'role:user'])->group(function () {
    // Dashboard & Form Baru
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/bap/create', [UserDashboardController::class, 'create'])->name('user.bap.create');
    Route::post('/user/bap/store', [UserDashboardController::class, 'store'])->name('user.bap.store');

    // Lihat Detail Permohonan (Resi / Bukti Upload) - BARU
    Route::get('/user/bap/{id}', [UserDashboardController::class, 'show'])->name('user.bap.show');

    // Fitur Perbaikan / Edit (Revisi)
    Route::get('/user/bap/{id}/edit', [UserDashboardController::class, 'edit'])->name('user.bap.edit');
    Route::put('/user/bap/{id}/update', [UserDashboardController::class, 'update'])->name('user.bap.update');

    // AJAX Check Kuota (PENTING: Agar alert kuota muncul real-time)
    Route::get('/user/check-kuota', [UserDashboardController::class, 'checkKuota'])->name('user.check_kuota');
});


// ====================================================
// 2. AREA ADMIN (PETUGAS WAWANCARA)
// ====================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard & Pencarian
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Detail & Verifikasi
    Route::get('/admin/bap/{id}', [AdminDashboardController::class, 'show'])->name('admin.bap.show');
    Route::post('/admin/bap/{id}/verifikasi', [AdminDashboardController::class, 'verifikasi'])->name('admin.bap.verifikasi');

    // Fitur Update Jadwal / Reschedule oleh Admin
    Route::put('/admin/bap/{id}/update-jadwal', [AdminDashboardController::class, 'updateJadwal'])->name('admin.bap.update_jadwal');

    // Wawancara & Generate
    Route::get('/admin/bap/{id}/wawancara', [AdminDashboardController::class, 'wawancara'])->name('admin.bap.wawancara');
    Route::post('/admin/bap/{id}/generate', [AdminDashboardController::class, 'generateBap'])->name('admin.bap.generate');

    // Pembatalan
    Route::post('/admin/bap/{id}/batal', [AdminDashboardController::class, 'batalBap'])->name('admin.bap.batal');

    // Manajemen Kuota Harian
    Route::get('/admin/kuota', [AdminDashboardController::class, 'indexKuota'])->name('admin.kuota.index');
    Route::post('/admin/kuota', [AdminDashboardController::class, 'storeKuota'])->name('admin.kuota.store');
    Route::delete('/admin/kuota/{id}', [AdminDashboardController::class, 'destroyKuota'])->name('admin.kuota.destroy');
});


// ====================================================
// 3. AREA KASUBSI (VALIDASI)
// ====================================================
Route::middleware(['auth', 'role:kasubsi'])->group(function () {
    Route::get('/kasubsi/dashboard', [KasubsiDashboardController::class, 'index'])->name('kasubsi.dashboard');
    Route::post('/kasubsi/approve/{id}', [KasubsiDashboardController::class, 'approve'])->name('kasubsi.approve');
    Route::post('/kasubsi/batal/{id}', [KasubsiDashboardController::class, 'batalAcc'])->name('kasubsi.batal');
});


// ====================================================
// 4. AREA KASI (REVIEW BAPEN)
// ====================================================
Route::middleware(['auth', 'role:kasi'])->group(function () {
    Route::get('/kasi/dashboard', [KasiDashboardController::class, 'index'])->name('kasi.dashboard');
    Route::get('/kasi/preview/{id}', [KasiDashboardController::class, 'previewBapen'])->name('kasi.preview');
    Route::post('/kasi/bapen/{id}', [KasiDashboardController::class, 'storeBapen'])->name('kasi.storeBapen');
    Route::post('/kasi/batal/{id}', [KasiDashboardController::class, 'batalBapen'])->name('kasi.batal');
});


// ====================================================
// 5. AREA KAKANIM (TANDA TANGAN SK)
// ====================================================
Route::middleware(['auth', 'role:kakan'])->group(function () { 
    Route::get('/kakan/dashboard', [KakanDashboardController::class, 'index'])->name('kakan.dashboard');
    Route::get('/kakan/preview/{id}', [KakanDashboardController::class, 'previewSk'])->name('kakan.preview');
    Route::post('/kakan/sk/{id}', [KakanDashboardController::class, 'storeSk'])->name('kakan.storeSk');
    Route::post('/kakan/batal/{id}', [KakanDashboardController::class, 'batalSk'])->name('kakan.batal');
});


// ====================================================
// ROUTE PROFILE (DEFAULT LARAVEL)
// ====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';