<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Live Monitoring Stok utama.
     */
    public function index()
    {
        // Ambil semua bahan baku untuk ditampilkan di tabel (termasuk nonaktif)
        $semuaBahan = BahanBaku::orderBy('nama_bahan')->get();

        return view('dashboard', compact('semuaBahan'));
    }
}