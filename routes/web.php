<?php

use App\Http\Controllers\Admin\dashboardAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//ADMIN

Route::get('/', function () {
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//ADMIN
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [dashboardAdminController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
