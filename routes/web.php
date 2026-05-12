<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\PembinaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\WaliKelasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Siswa Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Staff Auth
Route::get('/staff/login', [StaffAuthController::class, 'login'])->name('staff.login');
Route::post('/staff/login', [StaffAuthController::class, 'authenticate']);
Route::post('/staff/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'authenticate']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Wali Kelas Auth
Route::get('/wali-kelas/login', [WaliKelasController::class, 'showLogin'])->name('wali_kelas.login');
Route::post('/wali-kelas/login', [WaliKelasController::class, 'login']);
Route::post('/wali-kelas/logout', [WaliKelasController::class, 'logout'])->name('wali_kelas.logout');

// Admin Routes (using default web guard)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/ekskul', [AdminController::class, 'ekskulIndex'])->name('ekskul.index');
    Route::post('/ekskul', [AdminController::class, 'ekskulStore'])->name('ekskul.store');
    Route::get('/ekskul/template', [AdminController::class, 'ekskulTemplate'])->name('ekskul.template');
    Route::post('/ekskul/import', [AdminController::class, 'ekskulImport'])->name('ekskul.import');
    Route::put('/ekskul/{ekskul}', [AdminController::class, 'ekskulUpdate'])->name('ekskul.update');
    Route::delete('/ekskul/{ekskul}', [AdminController::class, 'ekskulDestroy'])->name('ekskul.destroy');
    
    Route::get('/staff', [AdminController::class, 'staffIndex'])->name('staff.index');
    Route::post('/staff', [AdminController::class, 'staffStore'])->name('staff.store');
    Route::get('/staff/template', [AdminController::class, 'staffTemplate'])->name('staff.template');
    Route::post('/staff/import', [AdminController::class, 'staffImport'])->name('staff.import');
    Route::post('/staff/{id}/reset', [AdminController::class, 'staffReset'])->name('staff.reset');
    
    Route::get('/siswa', [AdminController::class, 'siswaIndex'])->name('siswa.index');
    Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('siswa.store');
    Route::get('/siswa/template', [AdminController::class, 'siswaTemplate'])->name('siswa.template');
    Route::post('/siswa/import', [AdminController::class, 'siswaImport'])->name('siswa.import');
    Route::post('/siswa/{siswa}/reset', [AdminController::class, 'siswaReset'])->name('siswa.reset');

    Route::get('/wali-kelas', [AdminController::class, 'waliKelasIndex'])->name('wali-kelas.index');
    Route::post('/wali-kelas', [AdminController::class, 'waliKelasStore'])->name('wali-kelas.store');
    Route::get('/wali-kelas/template', [AdminController::class, 'waliKelasTemplate'])->name('wali-kelas.template');
    Route::post('/wali-kelas/import', [AdminController::class, 'waliKelasImport'])->name('wali-kelas.import');
    Route::post('/wali-kelas/{wali_kelas}/reset', [AdminController::class, 'waliKelasReset'])->name('wali-kelas.reset');
    Route::delete('/wali-kelas/{wali_kelas}', [AdminController::class, 'waliKelasDestroy'])->name('wali-kelas.destroy');

    Route::get('/settings', [AdminController::class, 'settingsIndex'])->name('settings.index');
    Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.store');
    
    Route::get('/journals', [AdminController::class, 'journalIndex'])->name('journal.index');
});

Route::middleware('auth:siswa')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/join/{ekskul}', [DashboardController::class, 'join'])->name('ekskul.join');
    Route::post('/dashboard/leave/{ekskul}', [DashboardController::class, 'leave'])->name('ekskul.leave');

    Route::get('/change-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/change-password', [PasswordController::class, 'update'])->name('password.update');
});

// Pelatih Routes
Route::middleware('auth:pelatih')->prefix('pelatih')->name('pelatih.')->group(function () {
    Route::get('/dashboard', [PelatihController::class, 'index'])->name('dashboard');
    Route::get('/ekskul/{ekskul}', [PelatihController::class, 'show'])->name('ekskul.show');
    Route::post('/ekskul/{ekskul}/kegiatan', [PelatihController::class, 'storeKegiatan'])->name('kegiatan.store');
    Route::get('/kegiatan/{kegiatan}/presensi', [PelatihController::class, 'presensi'])->name('presensi');
    Route::post('/kegiatan/{kegiatan}/presensi', [PelatihController::class, 'storePresensi'])->name('presensi.store');
    Route::get('/kegiatan/{kegiatan}/scan', [PelatihController::class, 'scan'])->name('presensi.scan');
    Route::post('/kegiatan/{kegiatan}/scan', [PelatihController::class, 'processScan'])->name('presensi.processScan');
    Route::post('/ekskul/{ekskul}/prestasi', [PelatihController::class, 'storePrestasi'])->name('prestasi.store');
    
    // Penilaian
    Route::get('/ekskul/{ekskul}/penilaian', [PelatihController::class, 'penilaian'])->name('penilaian');
    Route::post('/ekskul/{ekskul}/penilaian', [PelatihController::class, 'storePenilaian'])->name('penilaian.store');
});

// Pembina Routes
Route::middleware('auth:pembina')->prefix('pembina')->name('pembina.')->group(function () {
    Route::get('/dashboard', [PembinaController::class, 'index'])->name('dashboard');
    Route::get('/ekskul/{ekskul}/report', [PembinaController::class, 'show'])->name('report');
    Route::get('/ekskul/{ekskul}/report/pdf', [PembinaController::class, 'exportPDF'])->name('report.pdf');
    Route::post('/ekskul/{ekskul}/prestasi', [PembinaController::class, 'storePrestasi'])->name('prestasi.store');
});

// Wali Kelas Routes
Route::middleware('auth:wali_kelas')->prefix('wali-kelas')->name('wali_kelas.')->group(function () {
    Route::get('/dashboard', [WaliKelasController::class, 'dashboard'])->name('dashboard');
});
