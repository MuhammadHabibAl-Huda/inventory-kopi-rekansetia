<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStok;
use App\Models\BahanBaku;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Menampilkan halaman Riwayat Aktivitas Log Gudang
     * Default: Menampilkan riwayat HARI INI saja.
     * Filter: tanggal_mulai, tanggal_selesai, jenis, bahan_id
     */
    public function index(Request $request)
    {
        $query = RiwayatStok::with('bahanBaku')->latest();

        // Cek apakah pengguna sedang menggunakan filter pencarian/tanggal
        $adaFilterTanggal = $request->filled('tanggal_mulai') || $request->filled('tanggal_selesai');

        if (!$adaFilterTanggal) {
            // Jika TIDAK ADA filter tanggal, default tampilkan data HARI INI saja
            $query->whereDate('created_at', today());
        } else {
            // Jika ADA filter tanggal, jalankan filter rentang tanggal
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('created_at', '<=', $request->tanggal_selesai);
            }
        }

        // Filter jenis (Masuk / Keluar)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter bahan baku
        if ($request->filled('bahan_id')) {
            $query->where('bahan_baku_id', $request->bahan_id);
        }

        $riwayat    = $query->get();
        $semuaBahan = BahanBaku::orderBy('nama_bahan')->get();

        return view('riwayat.index', compact('riwayat', 'semuaBahan'));
    }

    /**
     * Menghapus 1 record riwayat stok
     */
    public function destroy($id)
    {
        $log = RiwayatStok::findOrFail($id);
        $log->delete();

        return redirect()->route('riwayat.index')->with('success', 'Record riwayat berhasil dihapus!');
    }
}