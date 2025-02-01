<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WasteReportController;
use App\Http\Controllers\Admin\WasteReportController as AdminWasteReportController;
use App\Http\Middleware\AdminMiddleware;

// Welcome page
Route::get('/', function () {
    return view('auth.login');
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
    // Dashboard route
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Collector routes
    Route::resource('collectors',   App\Http\Controllers\Admin\CollectorController::class, [
        'as' => 'admin'
    ]);

    // Existing waste report routes
    Route::get('/waste-reports', [App\Http\Controllers\Admin\WasteReportController::class, 'index'])
        ->name('admin.waste-reports.index');
    Route::patch('/waste-reports/{id}/status', [App\Http\Controllers\Admin\WasteReportController::class, 'updateStatus'])
        ->name('admin.waste-reports.update-status');
    Route::get('/waste-reports/{id}', [App\Http\Controllers\Admin\WasteReportController::class, 'show'])
        ->name('admin.waste-reports.show');

    Route::get('/statistics', [App\Http\Controllers\Admin\StatisticsController::class, 'index'])
        ->name('admin.statistics');
});

// Route untuk registrasi pengangkut sampah
Route::middleware('guest')->group(function () {
    Route::get('/register/collector', [App\Http\Controllers\Auth\CollectorRegisterController::class, 'showRegistrationForm'])
        ->name('register.collector');
    Route::post('/register/collector', [App\Http\Controllers\Auth\CollectorRegisterController::class, 'register']);
});

// Route untuk halaman collector setelah login
Route::prefix('collector')->name('collector.')->middleware('auth')->group(function () {
    // Daftar report yang tersedia (belum diambil)
    Route::get('/waste-reports', [App\Http\Controllers\Collector\WasteReportController::class, 'index'])
        ->name('waste-reports.index');

    // Daftar report yang sudah diambil oleh collector yang login
    Route::get('/waste-reports/my', [App\Http\Controllers\Collector\WasteReportController::class, 'myReports'])
        ->name('waste-reports.my-reports');

    // Mengambil report
    Route::post('/waste-reports/{id}/take', [App\Http\Controllers\Collector\WasteReportController::class, 'takeReport'])
        ->name('waste-reports.take');

    // Melihat detail report (hanya untuk report yang sudah diambil)
    Route::get('/waste-reports/{id}', [App\Http\Controllers\Collector\WasteReportController::class, 'show'])
        ->name('waste-reports.show');

    // Menyelesaikan report
    Route::post('/waste-reports/{id}/complete', [App\Http\Controllers\Collector\WasteReportController::class, 'complete'])
        ->name('waste-reports.complete');
});
