<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['nama_bahan', 'stok_sisa', 'satuan', 'stok_minimum'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi Kebalikan: 1 Bahan Baku bisa digunakan di banyak Produk
    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'reseps')
                    ->withPivot('jumlah_dibutuhkan')
                    ->withTimestamps();
    }
    
    public function riwayatStoks()
    {
        return $this->hasMany(RiwayatStok::class, 'bahan_baku_id');
    }

}