<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama_produk', 'harga'];

    // Relasi: 1 Produk memiliki banyak Bahan Baku lewat tabel resep
    public function bahanBakus()
    {
        return $this->belongsToMany(BahanBaku::class, 'reseps')
                    ->withPivot('jumlah_dibutuhkan')
                    ->withTimestamps();
    }
}