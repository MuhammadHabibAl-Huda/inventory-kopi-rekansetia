<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\RiwayatStok;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     * Mengambil semua data bahan baku dan riwayat aktivitas stok.
     */
    public function index()
    {
        $semuaBahan = BahanBaku::all();
        // Ambil semua riwayat untuk ditampilkan di halaman (filter waktu dilakukan di frontend/PDF)
        $riwayat = RiwayatStok::with('bahanBaku')->latest()->get();

        return view('dashboard', compact('semuaBahan', 'riwayat'));
    }

    /**
     * Memproses penambahan stok dari supplier (restock).
     * Hanya boleh diakses oleh Admin.
     */
    public function restock(Request $request)
    {
        // Validasi input dari form web
        $request->validate([
            'bahan_id'     => 'required|exists:bahan_bakus,id',
            'jumlah_masuk' => 'required|integer|min:1',
            'supplier'     => 'required|string|max:255',
        ]);

        // Cari bahan baku yang ingin di-restock berdasarkan ID
        $bahan = BahanBaku::find($request->bahan_id);

        // Logika: Stok lama + Stok baru yang masuk
        $bahan->stok_sisa = $bahan->stok_sisa + $request->jumlah_masuk;
        $bahan->save();

        // Catat riwayat restock ke log gudang
        RiwayatStok::create([
            'bahan_baku_id' => $bahan->id,
            'jenis'         => 'Masuk',
            'jumlah'        => $request->jumlah_masuk,
            'keterangan'    => 'Restock Supplier — ' . $request->supplier
        ]);

        return redirect('/dashboard')->with('success', 'Stok bahan baku ' . $bahan->nama_bahan . ' berhasil ditambah!');
    }

    /**
     * Memproses pencatatan penyusutan stok.
     * Digunakan untuk mendokumentasikan bahan baku yang rusak, tumpah,
     * kadaluarsa, atau terbuang dalam proses operasional.
     * Hanya boleh diakses oleh Admin.
     */
    public function penyusutan(Request $request)
    {
        // Validasi input dari form penyusutan
        $request->validate([
            'bahan_id'        => 'required|exists:bahan_bakus,id',
            'jumlah_susut'    => 'required|integer|min:1',
            'jenis_penyusutan'=> 'required|string',
            'keterangan'      => 'nullable|string|max:500',
        ]);

        // Cari bahan baku yang mengalami penyusutan
        $bahan = BahanBaku::find($request->bahan_id);

        // Pastikan stok tidak menjadi negatif
        if ($request->jumlah_susut > $bahan->stok_sisa) {
            return back()->withErrors([
                'jumlah_susut' => 'Jumlah penyusutan (' . $request->jumlah_susut . ' ' . $bahan->satuan . ') melebihi stok yang tersedia (' . $bahan->stok_sisa . ' ' . $bahan->satuan . ').'
            ])->withInput();
        }

        // Kurangi stok sesuai jumlah penyusutan
        $bahan->stok_sisa = $bahan->stok_sisa - $request->jumlah_susut;
        $bahan->save();

        // Susun keterangan log
        $keteranganLog = 'Penyusutan — ' . $request->jenis_penyusutan;
        if ($request->filled('keterangan')) {
            $keteranganLog .= ' — ' . $request->keterangan;
        }

        // Catat penyusutan ke riwayat stok sebagai transaksi Keluar
        RiwayatStok::create([
            'bahan_baku_id' => $bahan->id,
            'jenis'         => 'Keluar',
            'jumlah'        => $request->jumlah_susut,
            'keterangan'    => $keteranganLog
        ]);

        return redirect('/dashboard')->with('success', 'Penyusutan stok ' . $bahan->nama_bahan . ' sebesar ' . $request->jumlah_susut . ' ' . $bahan->satuan . ' berhasil dicatat!');
    }
}