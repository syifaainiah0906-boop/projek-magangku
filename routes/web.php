<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AlumniController; 
use App\Http\Controllers\SemesterReportController;
use App\Http\Controllers\AlumniDataController;


Route::get('/data-alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::post('logout', '\App\Http\Controllers\AuthController@logout')->name('logout');

// Rute untuk memproses pengiriman formulir
//Route::post('/laporan-semester', [ReportController::class, 'store'])->name('reports.store')->middleware('auth');

Route::resource('auth', UserController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('activity_reports', ActivityReportController::class);
    Route::resource('semester_reports', SemesterReportController::class);
    Route::resource('alumni_data', AlumniDataController::class);
});


Route::get('/landing', function () {
    return view('landing');
})->name('landing'); // Tambahkan ->name('landing') di sini

// Route::get('/register', function () {
//     return view('register');
// });

// Route::get('/login', function () {
//     return view('login');
// });

// Route::get('/dashboard', function () {
//     return view('dashboardmhs');
// });
Route::get('/laporankegiatan', function () {
    return view('lapkegiatanmhs');
});
