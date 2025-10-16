<?php

use App\Http\Controllers\ActivityReportController;
use App\Http\Controllers\AlumniDataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SemesterReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\StudentDataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Akses Tamu)
|--------------------------------------------------------------------------
*/

// Halaman Landing (untuk pengguna belum login)
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Registrasi
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman laporan kegiatan sederhana
Route::get('/laporankegiatan', function () {
    return view('lapkegiatanmhs');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Akses Terlindungi)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // API kegiatan bulanan
    Route::get('/api/kegiatan-bulanan', [ActivityReportController::class, 'getMonthlyCount']);

    // Manajemen user (profil/pengaturan)
    Route::resource('auth', UserController::class)->except(['show']);

    // ============================
    // Data Mahasiswa
    // ============================
    Route::get('/student-data', [StudentDataController::class, 'index'])->name('student_data.index');
    Route::put('/student-data/{id}/update-prodi', [StudentDataController::class, 'updateProdi'])->name('student_data.updateProdi');
    Route::put('/student-data/{id}/update-angkatan', [StudentDataController::class, 'updateAngkatan'])->name('student_data.updateAngkatan');
    // Route::get('/student-data/edit', [StudentDataController::class, 'edit'])->name('student_data.edit');
    Route::put('/student-data/{id}', [StudentDataController::class, 'update'])->name('student_data.update');
    Route::get('/student-data/{id}', [StudentDataController::class, 'show'])->name('student_data.show');

    // ============================
    // Laporan Semester
    // ============================
    Route::resource('semester_reports', SemesterReportController::class);
    Route::get('semester_reports/{semester_report}/download', [SemesterReportController::class, 'downloadPdf'])
        ->name('semester_reports.download_pdf');

    // ============================
    // Laporan Kegiatan & Alumni
    // ============================
    Route::resource('activity_reports', ActivityReportController::class);
    Route::resource('alumni_data', AlumniDataController::class);

    // Unduh PDF tambahan
    Route::get('activity_reports/{activityReport}/download', [ActivityReportController::class, 'downloadPdf'])->name('activity_reports.download_pdf');
    Route::get('alumni_data/{alumni_datum}/download', [AlumniDataController::class, 'downloadPdf'])->name('alumni_data.download_pdf');

    // ============================
    // Beasiswa
    // ============================
    Route::get('/beasiswa', [BeasiswaController::class, 'index'])->name('beasiswa.index');
});
