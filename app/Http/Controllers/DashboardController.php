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
        $semuaBahan = BahanBaku::all();

        return view('dashboard', compact('semuaBahan'));
    }
}