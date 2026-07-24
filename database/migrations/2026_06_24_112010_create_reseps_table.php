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
    Schema::create('reseps', function (Blueprint $table) {
        $table->id();
        
        // Menghubungkan resep ke ID produk di tabel produks
        $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
        
        // Menghubungkan resep ke ID bahan baku di tabel bahan_bakus
        $table->foreignId('bahan_baku_id')->constrained('bahan_bakus')->onDelete('cascade');
        
        // Takaran bahan baku yang dihabiskan untuk 1 porsi produk
        $table->integer('jumlah_dibutuhkan'); // Contoh: 30 (artinya butuh 30 gram atau 30 ml)
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
