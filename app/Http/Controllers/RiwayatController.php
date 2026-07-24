<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatStok;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Menghapus satu record riwayat stok berdasarkan ID.
     * Hanya boleh diakses oleh Admin.
     */
    public function destroy($id)
    {
        // Proteksi: hanya Admin yang boleh menghapus riwayat
        if (!Auth::user()->isAdmin()) {
            return redirect('/dashboard')->withErrors(['error' => 'Akses ditolak. Hanya Admin yang dapat menghapus riwayat.']);
        }

        $riwayat = RiwayatStok::findOrFail($id);
        $riwayat->delete();

        return redirect('/dashboard')->with('success', 'Record riwayat aktivitas berhasil dihapus.');
    }
}
