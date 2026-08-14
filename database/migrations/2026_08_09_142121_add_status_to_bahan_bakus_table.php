<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('bahan_bakus', function (Blueprint $table) {
        // Default bernilai true (1 = Aktif, 0 = Nonaktif)
        $table->boolean('is_active')->default(true)->after('stok_minimum');
    });
}

public function down(): void
{
    Schema::table('bahan_bakus', function (Blueprint $table) {
        $table->dropColumn('is_active');
    });
}
};