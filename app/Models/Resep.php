<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $fillable = ['produk_id', 'bahan_baku_id', 'jumlah_dibutuhkan'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}
