<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    protected $fillable = ['bahan_baku_id', 'jenis', 'jumlah', 'keterangan'];

    // Relasi ke BahanBaku
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    // Accessor untuk status (mengubah 'Masuk'/'Keluar' menjadi 'MASUK'/'KELUAR')
    public function getStatusAttribute()
    {
        return strtoupper($this->jenis);
    }
}
