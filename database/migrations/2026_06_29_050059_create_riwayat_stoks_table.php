<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_stoks', function (Blueprint $table) {
            $table->id();
            
            // Menghubungkan ke tabel utama (bahan_bakus)
            // Jika data bahan baku dihapus, riwayatnya ikut terhapus (onDelete cascade)
            $table->foreignId('bahan_baku_id')->constrained('bahan_bakus')->onDelete('cascade');
            
            // Mencatat tipe aktivitas: 'Masuk' (Restock) atau 'Keluar' (Potong Stok POS)
            $table->enum('jenis', ['Masuk', 'Keluar']);
            
            // Jumlah fisik barang yang bergerak
            $table->integer('jumlah');
            
            // Catatan tambahan, contoh: "Penjualan 70 porsi" atau "Pasokan dari Supplier"
            $table->string('keterangan')->nullable();
            
            // Otomatis membuat kolom created_at (untuk catatan Tanggal & Jam otomatis)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_stoks');
    }
};