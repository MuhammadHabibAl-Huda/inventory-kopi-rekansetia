<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

// ===== RUTE PUBLIK =====
// Arahkan root ke halaman login
Route::get('/', function () {
    return redirect('/login');
});

// Auth Route
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// ===== RUTE YANG DILINDUNGI (Harus Login) =====
Route::middleware('auth')->group(function () {

    // 1. Halaman Live Monitoring / Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Modul Kelola Bahan Baku (Restock & Penyusutan) - Semua user bisa akses
    Route::get('/bahan-baku', [BahanBakuController::class, 'index'])->name('bahan-baku.index');
    Route::post('/bahan-baku/restock', [BahanBakuController::class, 'restock'])->name('bahan-baku.restock');
    Route::post('/bahan-baku/penyusutan', [BahanBakuController::class, 'penyusutan'])->name('bahan-baku.penyusutan');

    // 3. Modul Riwayat Aktivitas - Semua user bisa lihat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // 4. Modul Produk - Semua user bisa lihat daftar produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');


    // ===== RUTE KHUSUS ADMIN =====
    Route::middleware('admin.only')->group(function () {

        // Laporan (Cetak PDF)
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/riwayat-pdf', [LaporanController::class, 'cetakRiwayatPdf'])->name('laporan.riwayat.pdf');

        // Hapus Riwayat Aktivitas
        Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');

        // Master Data Bahan Baku (Tambah & Hapus)
        Route::post('/bahan-baku/store-master', [BahanBakuController::class, 'storeMaster'])->name('bahan-baku.store-master');
        Route::delete('/bahan-baku/{id}', [BahanBakuController::class, 'destroy'])->name('bahan-baku.destroy');
        Route::patch('/bahan-baku/{id}/toggle-status', [BahanBakuController::class, 'toggleStatus'])->name('bahan-baku.toggle-status');

        // Master Data Produk & Resep (Tambah, Edit, Hapus)
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::post('/produk/{produkId}/resep', [ProdukController::class, 'tambahResep'])->name('produk.tambah-resep');
        Route::put('/produk/resep/{resepId}', [ProdukController::class, 'updateResep'])->name('produk.update-resep');
        Route::delete('/produk/resep/{resepId}', [ProdukController::class, 'hapusResep'])->name('produk.hapus-resep');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        // Manajemen User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

