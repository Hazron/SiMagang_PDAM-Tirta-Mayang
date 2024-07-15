<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//ADMIN
use App\Http\Controllers\Admin\dashboardAdminController;
use App\Http\Controllers\Admin\DataDosenController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\PresensiController;


use App\Http\Controllers\Homepage;

Route::get('/', [Homepage::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard-admin', [dashboardAdminController::class, 'index'])->name('dashboard-admin');

    // DATA PESERTA MAGANG
    Route::get('/admin/data-peserta', [PesertaController::class, 'view'])->name('data-magang');
    Route::get('data-peserta', [PesertaController::class, 'index'])->name('datapeserta');
    Route::post('/admin/store-peserta', [PesertaController::class, 'store'])->name('store-peserta');
    Route::get('/admin/data-peserta/{id}', [PesertaController::class, 'detail'])->name('detail-peserta');
    Route::delete('/admin/delete-peserta/{id}', [PesertaController::class, 'destroy'])->name('destroy-peserta');
    Route::put('/admin/edit-peserta/{id}', [PesertaController::class, 'edit'])->name('update-peserta');

    //DATA DOSEN/GURU PEMBIMBING
    Route::get('/admin/data-dosen', [DataDosenController::class, 'index'])->name('data-dosen');
    Route::get('data-dosen', [DataDosenController::class, 'data'])->name('datadosen');
    Route::post('/admin/store-dosen', [DataDosenController::class, 'store'])->name('store-dosen');
    Route::get('/admin/data-dosen/{id_pembimbing}', [DataDosenController::class, 'detail'])->name('detail-dosen');
    Route::post('/assign-dosen', [DataDosenController::class, 'assignDosen'])->name('assign.dosen');

    // DATA PRESENSI MAGANG
    Route::get('/admin/data-presensi', [PresensiController::class, 'index'])->name('data-presensi');
});

// ADMIN
// Route::middleware('guest')->group(function () {
//     Route::get('/dashboard-admin', [dashboardAdminController::class, 'index']);
// });

require __DIR__ . '/auth.php';
