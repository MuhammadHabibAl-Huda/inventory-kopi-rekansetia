<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mengubah semua kolom jumlah/stok dari integer ke decimal(10,2)
     * agar sistem mendukung nilai desimal (angka koma).
     */
    public function up(): void
    {
        // Tabel bahan_bakus: stok_sisa & stok_minimum
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->decimal('stok_sisa', 10, 2)->default(0)->change();
            $table->decimal('stok_minimum', 10, 2)->default(100)->change();
        });

        // Tabel riwayat_stoks: jumlah
        Schema::table('riwayat_stoks', function (Blueprint $table) {
            $table->decimal('jumlah', 10, 2)->change();
        });

        // Tabel reseps: jumlah_dibutuhkan
        Schema::table('reseps', function (Blueprint $table) {
            $table->decimal('jumlah_dibutuhkan', 10, 2)->change();
        });
    }

    /**
     * Rollback: kembalikan ke integer
     */
    public function down(): void
    {
        Schema::table('bahan_bakus', function (Blueprint $table) {
            $table->integer('stok_sisa')->default(0)->change();
            $table->integer('stok_minimum')->default(100)->change();
        });

        Schema::table('riwayat_stoks', function (Blueprint $table) {
            $table->integer('jumlah')->change();
        });

        Schema::table('reseps', function (Blueprint $table) {
            $table->integer('jumlah_dibutuhkan')->change();
        });
    }
};
