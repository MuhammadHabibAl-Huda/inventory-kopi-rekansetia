<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('bahan_bakus', function (Blueprint $table) {
        $table->id(); 
        $table->string('nama_bahan'); // Contoh: "Biji Kopi Espreso", "Susu UHT"
        $table->integer('stok_sisa')->default(0); // Volume stok riil di gudang
        $table->string('satuan'); // Standardisasi satuan, contoh: "gram", "ml"
        $table->integer('stok_minimum')->default(100); // Batas limit untuk alert stok menipis
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};
