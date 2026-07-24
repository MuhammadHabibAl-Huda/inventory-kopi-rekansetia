<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PenjualanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Di sini kita mendaftarkan jalur pintu masuk untuk sistem luar (POS).
*/

// Jalur khusus untuk menerima data transaksi dari POS Rekan Setia
// Kita ubah namanya jadi lebih umum (pos-sales)
Route::post('/webhook/pos-sales', [PenjualanController::class, 'terimaTransaksiPOS']);