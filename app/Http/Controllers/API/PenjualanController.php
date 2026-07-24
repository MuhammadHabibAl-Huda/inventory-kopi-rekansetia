<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\BahanBaku;
use App\Models\RiwayatStok;

class PenjualanController extends Controller
{
    public function terimaTransaksiPOS(Request $request)
    {
        // 1. Validasi data yang masuk dari POS
        $request->validate([
            'nama_produk'   => 'required|string',
            'jumlah_terjual' => 'required|integer|min:1',
        ]);

        // 2. Cari produk di database berdasarkan nama
        $produk = Produk::where('nama_produk', $request->nama_produk)->first();

        if (!$produk) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Produk "' . $request->nama_produk . '" tidak terdaftar di sistem resep.',
            ], 404);
        }

        // 3. Ambil semua bahan baku dari resep produk ini
        $resepBahan = $produk->bahanBakus;

        // 4. CEK KECUKUPAN STOK TERLEBIH DAHULU (sebelum ada pemotongan)
        foreach ($resepBahan as $bahan) {
            $totalDibutuhkan = $bahan->pivot->jumlah_dibutuhkan * $request->jumlah_terjual;

            if ($bahan->stok_sisa < $totalDibutuhkan) {
                return response()->json([
                    'status'         => 'error',
                    'message'        => 'Transaksi ditolak! Stok bahan baku [' . $bahan->nama_bahan . '] tidak mencukupi.',
                    'stok_tersisa'   => $bahan->stok_sisa . ' ' . $bahan->satuan,
                    'stok_dibutuhkan' => $totalDibutuhkan . ' ' . $bahan->satuan,
                ], 400);
            }
        }

        // 5. LAKUKAN PEMOTONGAN STOK + CATAT KE RIWAYAT
        //    Dibungkus DB::transaction agar jika satu gagal, semua dibatalkan
        DB::transaction(function () use ($resepBahan, $request) {
            foreach ($resepBahan as $bahan) {
                $totalDibutuhkan = $bahan->pivot->jumlah_dibutuhkan * $request->jumlah_terjual;

                // Kurangi stok
                $bahan->stok_sisa = $bahan->stok_sisa - $totalDibutuhkan;
                $bahan->save();

                // Catat ke riwayat aktivitas (ini yang sebelumnya hilang!)
                RiwayatStok::create([
                    'bahan_baku_id' => $bahan->id,
                    'jenis'         => 'Keluar',
                    'jumlah'        => $totalDibutuhkan,
                    'keterangan'    => 'Pemotongan otomatis POS — ' . $request->jumlah_terjual . ' Cup ' . $request->nama_produk,
                ]);
            }
        });

        // 6. Kirim respon sukses ke Postman / POS
        return response()->json([
            'status'      => 'success',
            'message'     => 'Stok berhasil dipotong dan dicatat ke riwayat aktivitas.',
            'produk'      => $request->nama_produk,
            'jumlah_porsi' => $request->jumlah_terjual . ' porsi',
        ], 200);
    }
}