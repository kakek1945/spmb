<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CapacityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\RegistrantController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\PublicSite\HomeController;
use App\Http\Controllers\PublicSite\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/daftar', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/daftar/sukses/{registrationNumber}', [RegistrationController::class, 'success'])
    ->name('registration.success');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/pendaftar', [RegistrantController::class, 'index'])->name('registrants.index');
        Route::get('/pendaftar/tambah', [RegistrantController::class, 'create'])->name('registrants.create');
        Route::post('/pendaftar', [RegistrantController::class, 'store'])->name('registrants.store');
        Route::get('/pendaftar/{id}', [RegistrantController::class, 'show'])->name('registrants.show');
        Route::get('/pendaftar/{id}/edit', [RegistrantController::class, 'edit'])->name('registrants.edit');
        Route::put('/pendaftar/{id}', [RegistrantController::class, 'update'])->name('registrants.update');
        Route::delete('/pendaftar/{id}', [RegistrantController::class, 'destroy'])->name('registrants.destroy');
        Route::get('/kapasitas', CapacityController::class)->name('capacity');
        Route::post('/kapasitas', [CapacityController::class, 'update'])->name('capacity.update');
        Route::get('/laporan', ReportController::class)->name('reports.index');
        Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    });
});
