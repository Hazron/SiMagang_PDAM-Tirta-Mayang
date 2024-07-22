<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//ADMIN
use App\Http\Controllers\Admin\dashboardAdminController;
use App\Http\Controllers\Admin\DataDosenController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\LogbookController;

//MAGANG
use App\Http\Controllers\Magang\dashboardMagangController;
use App\Http\Controllers\Magang\profileController as MagangProfileController;

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
    Route::get('presensi/datatables', [PresensiController::class, 'datatables'])->name('presensi.datatables');

    // DATA DEPARTEMEN
    Route::get('admin/data-departemen', [DepartemenController::class, 'index'])->name('data-departemen');
    Route::get('admin/data-departemen/{id_departemen}', [DepartemenController::class, 'detail'])->name('deatil-departemen');
    Route::post('admin/data-departemen/store', [DepartemenController::class, 'store'])->name('store-departemen');

    //DATA LOGBOOK
    Route::get('admin/data-lobook', [LogbookController::class, 'index'])->name('data-logbook');
    Route::get('datatables-Logbook', [LogbookController::class, 'datatables'])->name('datatables-Logbook');
});

Route::middleware(['auth', 'magang'])->group(function () {
    Route::get('/dashboard-magang', [dashboardMagangController::class, 'index'])->name('dashboard-magang');
    Route::get('presensi-magang/store', [dashboardMagangController::class, 'index'])->name('presensi-magang');
    Route::post('presensi-magang/store', [dashboardMagangController::class, 'storePresensi'])->name('presensi-magang.store');

    Route::get('profile', [MagangProfileController::class, 'index'])->name('profile-magang');
});

// ADMIN
// Route::middleware('guest')->group(function () {
//     Route::get('/dashboard-admin', [dashboardAdminController::class, 'index']);
// });

require __DIR__ . '/auth.php';
