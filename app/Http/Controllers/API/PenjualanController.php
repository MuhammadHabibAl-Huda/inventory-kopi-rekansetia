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
        // 1. Validasi membaca format "keranjang" dan input desimal
        $request->validate([
            'keranjang'                            => 'required|array|min:1',
            'keranjang.*.nama_produk'              => 'required|string',
            'keranjang.*.jumlah_terjual'           => 'required|numeric|min:1',
            'keranjang.*.tambahan'                 => 'nullable|array',
            'keranjang.*.tambahan.*.bahan_baku_id' => 'required|exists:bahan_bakus,id',
            'keranjang.*.tambahan.*.jumlah'        => 'required|numeric|min:0.01',
        ]);

        $kebutuhanBahan = [];

        // 2. Looping isi keranjang untuk menotal semua bahan baku
        foreach ($request->keranjang as $item) {
            $produk = Produk::where('nama_produk', $item['nama_produk'])->first();

            if (!$produk) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Produk "' . $item['nama_produk'] . '" tidak terdaftar di sistem.',
                ], 404);
            }

            // A. Hitung kebutuhan dari resep dasar
            foreach ($produk->bahanBakus as $bahan) {
                $idBahan = $bahan->id;
                $jumlahButuh = $bahan->pivot->jumlah_dibutuhkan * $item['jumlah_terjual'];

                // Jika bahan sudah ada di daftar kebutuhan, tambahkan nilainya. Jika belum, buat baru.
                if (isset($kebutuhanBahan[$idBahan])) {
                    $kebutuhanBahan[$idBahan]['jumlah'] += $jumlahButuh;
                    $kebutuhanBahan[$idBahan]['keterangan'][] = $item['jumlah_terjual'] . ' ' . $item['nama_produk'];
                } else {
                    $kebutuhanBahan[$idBahan] = [
                        'jumlah' => $jumlahButuh,
                        'keterangan' => [$item['jumlah_terjual'] . ' ' . $item['nama_produk']]
                    ];
                }
            }

            // B. Hitung kebutuhan dari Add-on (jika ada)
            if (isset($item['tambahan'])) {
                foreach ($item['tambahan'] as $addon) {
                    $idBahan = $addon['bahan_baku_id'];
                    $jumlahAddon = $addon['jumlah'];

                    if (isset($kebutuhanBahan[$idBahan])) {
                        $kebutuhanBahan[$idBahan]['jumlah'] += $jumlahAddon;
                        $kebutuhanBahan[$idBahan]['keterangan'][] = 'Add-on untuk ' . $item['nama_produk'];
                    } else {
                        $kebutuhanBahan[$idBahan] = [
                            'jumlah' => $jumlahAddon,
                            'keterangan' => ['Add-on untuk ' . $item['nama_produk']]
                        ];
                    }
                }
            }
        }

        // 3. CEK KECUKUPAN STOK SECARA GLOBAL
        $bahanModels = BahanBaku::whereIn('id', array_keys($kebutuhanBahan))->get()->keyBy('id');

        foreach ($kebutuhanBahan as $id => $dataKebutuhan) {
            $bahan = $bahanModels[$id];

            if ($bahan->stok_sisa < $dataKebutuhan['jumlah']) {
                return response()->json([
                    'status'          => 'error',
                    'message'         => 'Transaksi dibatalkan! Stok bahan baku [' . $bahan->nama_bahan . '] tidak mencukupi untuk keseluruhan pesanan.',
                    'stok_tersisa'    => $bahan->stok_sisa . ' ' . $bahan->satuan,
                    'total_dibutuhkan' => $dataKebutuhan['jumlah'] . ' ' . $bahan->satuan,
                ], 400);
            }
        }

        // 4. LAKUKAN PEMOTONGAN STOK + CATAT KE RIWAYAT
        DB::transaction(function () use ($kebutuhanBahan, $bahanModels) {
            foreach ($kebutuhanBahan as $id => $dataKebutuhan) {
                $bahan = $bahanModels[$id];

                // Kurangi stok
                $bahan->decrement('stok_sisa', $dataKebutuhan['jumlah']);

                // Gabungkan keterangan array menjadi string unik
                $teksKeterangan = 'POS — ' . implode(', ', array_unique($dataKebutuhan['keterangan']));

                // Catat riwayat
                RiwayatStok::create([
                    'bahan_baku_id' => $bahan->id,
                    'jenis'         => 'Keluar',
                    'jumlah'        => $dataKebutuhan['jumlah'],
                    'keterangan'    => $teksKeterangan,
                ]);
            }
        });

        // 5. Kirim respon sukses
        return response()->json([
            'status'       => 'success',
            'message'      => 'Seluruh transaksi di keranjang berhasil diproses. Stok telah dipotong otomatis.',
            'total_item'   => count($request->keranjang) . ' macam produk',
        ], 200);
    }
}
