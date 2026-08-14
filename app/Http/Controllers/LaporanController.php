<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatStok;
use App\Models\BahanBaku;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman Web Filter Cetak Laporan
     * Jika ada parameter filter, tampilkan juga preview data
     */
    public function index(Request $request)
    {
        $semuaBahan  = BahanBaku::orderBy('nama_bahan')->get();
        $riwayat     = null;
        $filterAktif = $request->hasAny(['tanggal_mulai', 'tanggal_selesai', 'jenis', 'bahan_id']);

        if ($filterAktif) {
            $query = RiwayatStok::with('bahanBaku')->latest();

            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('created_at', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('created_at', '<=', $request->tanggal_selesai);
            }
            if ($request->filled('jenis')) {
                $query->where('jenis', $request->jenis);
            }
            if ($request->filled('bahan_id')) {
                $query->where('bahan_baku_id', $request->bahan_id);
            }

            $riwayat = $query->get();
        }

        return view('laporan.index', compact('semuaBahan', 'riwayat', 'filterAktif'));
    }

    /**
     * Generate dan Download File PDF dengan filter lengkap
     */
    public function cetakRiwayatPdf(Request $request)
    {
        $tanggalMulai  = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $jenis         = $request->jenis;
        $bahanId       = $request->bahan_id;

        $query = RiwayatStok::with('bahanBaku');

        if ($tanggalMulai) {
            $query->whereDate('created_at', '>=', $tanggalMulai);
        }
        if ($tanggalSelesai) {
            $query->whereDate('created_at', '<=', $tanggalSelesai);
        }
        if ($jenis) {
            $query->where('jenis', $jenis);
        }
        if ($bahanId) {
            $query->where('bahan_baku_id', $bahanId);
        }

        $riwayat  = $query->latest()->get();
        $namaBahan = $bahanId ? BahanBaku::find($bahanId)?->nama_bahan : null;

        // Ringkasan total untuk PDF
        $totalMasuk  = $riwayat->where('jenis', 'Masuk')->sum('jumlah');
        $totalKeluar = $riwayat->where('jenis', 'Keluar')->sum('jumlah');

        $pdf = Pdf::loadView('laporan.riwayat_pdf', compact(
            'riwayat',
            'tanggalMulai',
            'tanggalSelesai',
            'jenis',
            'namaBahan',
            'totalMasuk',
            'totalKeluar'
        ));

        // Nama file dinamis berdasarkan filter
        $namaFile = 'Laporan_Stok_' . date('dMY');
        if ($jenis)    $namaFile .= '_' . $jenis;
        if ($namaBahan) $namaFile .= '_' . str_replace(' ', '_', $namaBahan);
        $namaFile .= '.pdf';

        return $pdf->download($namaFile);
    }
}
