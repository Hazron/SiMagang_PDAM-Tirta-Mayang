<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//ADMIN
use App\Http\Controllers\Admin\dashboardAdminController;
use App\Http\Controllers\Admin\DataDosenController;
use App\Http\Controllers\Admin\PesertaController;


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
    Route::get('/admin/data-peserta', [PesertaController::class, 'index'])->name('data-magang');
    Route::post('/admin/store-peserta', [PesertaController::class, 'store'])->name('store-peserta');

    //DATA DOSEN/GURU PEMBIMBING
    Route::get('/admin/data-dosen', [DataDosenController::class, 'index'])->name('data-dosen');
    Route::post('/admin/store-dosen', [DataDosenController::class, 'store'])->name('store-dosen');
});

// ADMIN
// Route::middleware('guest')->group(function () {
//     Route::get('/dashboard-admin', [dashboardAdminController::class, 'index']);
// });

require __DIR__ . '/auth.php';
