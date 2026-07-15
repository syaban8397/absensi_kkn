<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    Route::get('/absensi', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/absensi/pagi', [AttendanceController::class, 'morning'])->name('attendances.morning');
    Route::get('/absensi/sore', [AttendanceController::class, 'evening'])->name('attendances.evening');
    Route::get('/absensi/data', [AttendanceController::class, 'history'])->name('attendances.history');
    Route::post('/absensi', [AttendanceController::class, 'store'])->name('attendances.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::patch('/absensi/{attendance}', [AdminDashboardController::class, 'update'])->name('attendances.update');

        Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/laporan/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
        Route::get('/laporan/excel', [ReportController::class, 'excel'])->name('reports.excel');
    });
});

require __DIR__.'/auth.php';
