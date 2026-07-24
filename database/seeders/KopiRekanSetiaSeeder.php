<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BahanBaku;
use App\Models\Produk;

class KopiRekanSetiaSeeder extends Seeder
{
    public function run()
    {
        // 1. Input Data Bahan Baku Awal di Gudang
        $kopi = BahanBaku::create([
            'nama_bahan' => 'Biji Kopi Arabika',
            'stok_sisa' => 5000, // 5000 gram (5 Kg)
            'satuan' => 'gram',
            'stok_minimum' => 500
        ]);

        $susu = BahanBaku::create([
            'nama_bahan' => 'Susu UHT Full Cream',
            'stok_sisa' => 10000, // 10000 ml (10 Liter)
            'satuan' => 'ml',
            'stok_minimum' => 1000
        ]);

        $gula = BahanBaku::create([
            'nama_bahan' => 'Sirup Gula Aren',
            'stok_sisa' => 2000, // 2000 ml (2 Liter)
            'satuan' => 'ml',
            'stok_minimum' => 200
        ]);

        // 2. Input Data Menu Produk Jualan
        $produk1 = Produk::create([
            'nama_produk' => 'Es Kopi Susu Gula Aren',
            'harga' => 20000
        ]);

        // 3. Mengunci Formula Resep (Menghubungkan Produk dengan Bahan Baku + Takarannya)
        // Menu "Es Kopi Susu Gula Aren" butuh: 20gr Kopi, 120ml Susu, dan 20ml Gula Aren
        $produk1->bahanBakus()->attach([
            $kopi->id => ['jumlah_dibutuhkan' => 20],
            $susu->id => ['jumlah_dibutuhkan' => 120],
            $gula->id => ['jumlah_dibutuhkan' => 20],
        ]);
    }
}