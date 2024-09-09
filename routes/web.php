<?php

use App\Http\Controllers\Magang\profileMagangController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\setPasswordController;

//ADMIN
use App\Http\Controllers\Admin\dashboardAdminController;
use App\Http\Controllers\Admin\DataDosenController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\DepartemenController;
use App\Http\Controllers\Admin\LogbookController;

//MAGANG
use App\Http\Controllers\Magang\dashboardMagangController;
use App\Http\Controllers\Magang\PresensiMagangController;
use App\Http\Controllers\Magang\LogbookMagangController;
use App\Http\Controllers\Magang\profileMagangController as MagangProfileController;

//DEPARTEMEN
use App\Http\Controllers\Departemen\dashboardDepartemenController;
use App\Http\Controllers\Departemen\PesertaController as DepartemenPesertaController;
use App\Http\Controllers\Departemen\LogbookDepartemenController;

//DOSEN
use App\Http\Controllers\Dosen\dashboardDosenController;
use App\Http\Controllers\Dosen\ListPesertaController;

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
    Route::delete('/admin/delete-dosen/{id}', [DataDosenController::class, 'destroy'])->name('delete-dosen');
    Route::delete('/admin/destroy-dosen/{id}', [DataDosenController::class, 'destroy'])->name('destroy-dosen');


    // DATA PRESENSI MAGANG
    Route::get('/admin/data-presensi', [PresensiController::class, 'index'])->name('data-presensi');
    Route::get('presensi/datatables', [PresensiController::class, 'datatables'])->name('presensi.datatables');

    // DATA DEPARTEMEN
    Route::get('admin/data-departemen', [DepartemenController::class, 'index'])->name('data-departemen');
    Route::get('admin/data-departemen/{id_departemen}', [DepartemenController::class, 'detail'])->name('deatil-departemen');
    Route::post('admin/data-departemen/store', [DepartemenController::class, 'store'])->name('store-departemen');
    Route::delete('/admin/delete-departemen/{id}', [DepartemenController::class, 'destroy'])->name('delete-departemen');
    Route::put('/admin/update-departemen/{id}', [DepartemenController::class, 'update'])->name('update-departemen');
    Route::delete('/admin/delete-departemen/{id_departemen}/{user_id}', [DepartemenController::class, 'destroy'])->name('departemen.destroy');
    Route::post('/admin/assign-departemen/{departemen_id}', [DepartemenController::class, 'assignDepartemen'])->name('assign.departemen');

    //DATA LOGBOOK
    Route::get('admin/data-logbook', [LogbookController::class, 'index'])->name('data-logbook');
    Route::get('datatables-Logbook', [LogbookController::class, 'datatables'])->name('logbook.datatables');
    Route::get('/admin/logbook/{id}', [LogbookController::class, 'show']);
    Route::get('/admin/logbook/{user_id}/{tanggal}', [LogbookController::class, 'show'])->name('logbook.show');
});


Route::middleware(['auth', 'magang'])->group(function () {
    //DASHBOARD
    Route::get('/dashboard-magang', [dashboardMagangController::class, 'index'])->name('dashboard-magang');
    Route::post('presensi-magang/store', [dashboardMagangController::class, 'storePresensi'])->name('presensi-magang.store');
    Route::post('pulang-magang/store', [dashboardMagangController::class, 'pulangPresensi'])->name('pulang-magang.store');
    Route::post('logbook-magang/store', [dashboardMagangController::class, 'storeLogbook'])->name('logbook.store');

    // PRESENSI MAGANG
    Route::get('magang/presensi', [PresensiMagangController::class, 'index'])->name('magang.presensi');
    Route::get('/presensi/data', [PresensiMagangController::class, 'getData'])->name('magang.presensi.data');
    Route::post('/presensi/pulang', [PresensiMagangController::class, 'presensiPulang'])->name('magang.presensi.pulang');

    //LOGBOOK MAGANG
    Route::get('magang/logbook', [LogbookMagangController::class, 'index'])->name('magang.logbook');
    Route::get('/magang/logbook/data', [LogbookMagangController::class, 'getData'])->name('magang.logbook.data');
    Route::put('/magang/logbook/{id}', [LogbookMagangController::class, 'update'])->name('magang.logbook.update');
    Route::post('/magang/logbook/store', [LogbookMagangController::class, 'store'])->name('magang.logbook.store.table');
    Route::post('/logbook/store', [LogbookController::class, 'store'])->name('magang.logbook.store');

    //PROFILE MAGANG
    Route::get('magang/profile', [MagangProfileController::class, 'index'])->name('profile-magang');
    Route::post('magang/profile/updatefotoProfile', [MagangProfileController::class, 'updatefotoProfile'])->name('profilePicture-magang.update');
    Route::post('magang/profile/update', [MagangProfileController::class, 'updateProfile'])->name('profile-magang.update');

    //SET PASSWORD
    Route::get('magang/password', [setPasswordController::class, 'magangView'])->name('password-magang');
    Route::post('magang/password/update', [setPasswordController::class, 'updatePasswordMagang'])->name('password-magang.update');
});

Route::middleware(['auth', 'departemen'])->group(function () {
    Route::get('/dashboard-departemen', [dashboardDepartemenController::class, 'index'])->name('dashboard-departemen');

    Route::get('departemen/peserta', [DepartemenPesertaController::class, 'index'])->name('departemen.peserta');
    Route::get('/departemen/peserta/data', [DepartemenPesertaController::class, 'getData'])->name('departemen.peserta.data');
    Route::get('departemen/peserta/profile/{id}', [DepartemenPesertaController::class, 'detailView'])->name('profile-departemen');


    route::get('departemen/data-logbook', [LogbookDepartemenController::class, 'index'])->name('data-logbook-departemen');
    route::get('departemen/datatables-logbook', [LogbookDepartemenController::class, 'datatables'])->name('logbook-departemen.datatables');
    Route::get('/departemen/showModal/{user_id}/{tanggal}', [LogbookDepartemenController::class, 'showModal'])->name('logbook.showModal');
    Route::post('/departemen/approve-logbook', [LogbookDepartemenController::class, 'approveLogbook'])->name('logbook.approve');

});

Route::middleware(['auth', 'dosen'])->group(function () {
    route::get('/dashboard-dosen', [dashboardDosenController::class, 'index'])->name('dashboard-dosen');
    Route::get('dosen/list-peserta', [ListPesertaController::class, 'index'])->name('list-peserta-bimbingan-dosen');
    Route::get('data/bimbingan', [ListPesertaController::class . 'getData'])->name('peserta.data.dosen');
});

// ADMIN
// Route::middleware('guest')->group(function () {
//     Route::get('/dashboard-admin', [dashboardAdminController::class, 'index']);
// });

require __DIR__ . '/auth.php';
