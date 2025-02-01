<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WasteReportController;
use App\Http\Controllers\Admin\WasteReportController as AdminWasteReportController;
use App\Http\Middleware\AdminMiddleware;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Tambahkan routes untuk waste reports
    Route::resource('waste-reports', WasteReportController::class);
});

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/waste-reports', [App\Http\Controllers\Admin\WasteReportController::class, 'index'])
        ->name('admin.waste-reports.index');
    Route::patch('/waste-reports/{id}/status', [App\Http\Controllers\Admin\WasteReportController::class, 'updateStatus'])
        ->name('admin.waste-reports.update-status');
    Route::get('/waste-reports/{id}', [App\Http\Controllers\Admin\WasteReportController::class, 'show'])
        ->name('admin.waste-reports.show');
});

// Route untuk registrasi pengangkut sampah
Route::middleware('guest')->group(function () {
    Route::get('/register/collector', [App\Http\Controllers\Auth\CollectorRegisterController::class, 'showRegistrationForm'])
        ->name('register.collector');
    Route::post('/register/collector', [App\Http\Controllers\Auth\CollectorRegisterController::class, 'register']);
});

// Route untuk halaman collector setelah login
Route::prefix('collector')->name('collector.')->middleware('auth')->group(function () {
    Route::get('/waste-reports', [App\Http\Controllers\Collector\WasteReportController::class, 'index'])
        ->name('waste-reports.index');
    Route::get('/waste-reports/{id}', [App\Http\Controllers\Collector\WasteReportController::class, 'show'])
        ->name('waste-reports.show');
    Route::post('/waste-reports/{id}/complete', [App\Http\Controllers\Collector\WasteReportController::class, 'complete'])
        ->name('waste-reports.complete');
});
