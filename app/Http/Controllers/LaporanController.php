<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatStok;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Mencetak laporan riwayat aktivitas stok dalam format PDF.
     * Mendukung filter berdasarkan rentang tanggal melalui query string:
     *   ?tanggal_mulai=YYYY-MM-DD&tanggal_selesai=YYYY-MM-DD
     */
    public function cetakRiwayatPdf(Request $request)
    {
        // Ambil parameter filter tanggal dari query string
        $tanggalMulai   = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        // Bangun query dasar
        $query = RiwayatStok::with('bahanBaku')->latest();

        // Terapkan filter tanggal jika keduanya diisi
        if ($tanggalMulai && $tanggalSelesai) {
            // whereDate memastikan perbandingan hanya pada bagian tanggal (tanpa jam)
            $query->whereDate('created_at', '>=', $tanggalMulai)
                  ->whereDate('created_at', '<=', $tanggalSelesai);
        }

        $riwayat = $query->get();

        // Kirim data dan info filter ke template PDF
        $pdf = Pdf::loadView('laporan.riwayat_pdf', compact('riwayat', 'tanggalMulai', 'tanggalSelesai'));

        // Nama file otomatis menyesuaikan filter tanggal
        if ($tanggalMulai && $tanggalSelesai) {
            $namaFile = 'Laporan_Stok_RekanSetia_' . $tanggalMulai . '_sd_' . $tanggalSelesai . '.pdf';
        } else {
            $namaFile = 'Laporan_Stok_RekanSetia_' . date('Y-m-d') . '.pdf';
        }

        return $pdf->stream($namaFile);
    }
}