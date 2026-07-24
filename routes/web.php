<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RiwayatController;

// ===== RUTE PUBLIK =====
// Arahkan root ke halaman login
Route::get('/', function () {
    return redirect('/login');
});

// Tampilkan form login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Proses form login
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
// Proses logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== RUTE YANG DILINDUNGI (harus login dulu) =====
Route::middleware('auth')->group(function () {
    // Dashboard utama (semua role)
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // ===== RUTE KHUSUS ADMIN =====
    // Input bahan baku (restock dari supplier)
    Route::post('/dashboard/restock', [DashboardController::class, 'restock']);

    // Pencatatan penyusutan stok (bahan rusak/tumpah/terbuang)
    Route::post('/dashboard/penyusutan', [DashboardController::class, 'penyusutan'])->name('dashboard.penyusutan');

    // Laporan PDF dengan filter tanggal (mendukung query string ?tanggal_mulai=&tanggal_selesai=)
    Route::get('/laporan/riwayat-pdf', [LaporanController::class, 'cetakRiwayatPdf'])->name('laporan.riwayat.pdf');

    // Hapus satu record riwayat stok
    Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
});