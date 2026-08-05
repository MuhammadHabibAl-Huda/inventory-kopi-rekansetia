<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\RiwayatStok;

class BahanBakuController extends Controller
{
    /**
     * Menampilkan halaman Kelola Bahan Baku (Form Restock & Penyusutan)
     */
    public function index()
    {
        $semuaBahan = BahanBaku::all();

        return view('bahan-baku.index', compact('semuaBahan'));
    }

    /**
     * Memproses penambahan stok bahan baku dari supplier (Restock)
     */
    public function restock(Request $request)
    {
        $request->validate([
            'bahan_id'     => 'required|exists:bahan_bakus,id',
            'jumlah_masuk' => 'required|integer|min:1',
            'supplier'     => 'required|string|max:255',
        ]);

        $bahan = BahanBaku::findOrFail($request->bahan_id);
        $bahan->stok_sisa = $bahan->stok_sisa + $request->jumlah_masuk;
        $bahan->save();

        RiwayatStok::create([
            'bahan_baku_id' => $bahan->id,
            'jenis'         => 'Masuk',
            'jumlah'        => $request->jumlah_masuk,
            'keterangan'    => 'Restock Supplier — ' . $request->supplier
        ]);

        return redirect()->route('bahan-baku.index')->with('success', 'Stok bahan baku ' . $bahan->nama_bahan . ' berhasil ditambah!');
    }

    /**
     * Memproses pencatatan penyusutan bahan baku
     */
    public function penyusutan(Request $request)
    {
        $request->validate([
            'bahan_id'        => 'required|exists:bahan_bakus,id',
            'jumlah_susut'    => 'required|integer|min:1',
            'jenis_penyusutan' => 'required|string',
            'keterangan'      => 'nullable|string|max:500',
        ]);

        $bahan = BahanBaku::findOrFail($request->bahan_id);

        if ($request->jumlah_susut > $bahan->stok_sisa) {
            return back()->withErrors([
                'jumlah_susut' => 'Jumlah penyusutan (' . $request->jumlah_susut . ' ' . $bahan->satuan . ') melebihi stok yang tersedia (' . $bahan->stok_sisa . ' ' . $bahan->satuan . ').'
            ])->withInput();
        }

        $bahan->stok_sisa = $bahan->stok_sisa - $request->jumlah_susut;
        $bahan->save();

        $keteranganLog = 'Penyusutan — ' . $request->jenis_penyusutan;
        if ($request->filled('keterangan')) {
            $keteranganLog .= ' — ' . $request->keterangan;
        }

        RiwayatStok::create([
            'bahan_baku_id' => $bahan->id,
            'jenis'         => 'Keluar',
            'jumlah'        => $request->jumlah_susut,
            'keterangan'    => $keteranganLog
        ]);

        return redirect()->route('bahan-baku.index')->with('success', 'Penyusutan stok ' . $bahan->nama_bahan . ' sebesar ' . $request->jumlah_susut . ' ' . $bahan->satuan . ' berhasil dicatat!');
    }

    // Method untuk menambah jenis Bahan Baku baru (Master Data)
    public function storeMaster(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_bahan'   => 'required|string|max:255|unique:bahan_bakus,nama_bahan',
            'satuan'       => 'required|string|max:50',
            'stok_sisa'    => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
        ], [
            'nama_bahan.unique' => 'Nama bahan baku ini sudah terdaftar!',
        ]);

        // 2. Simpan ke database
        BahanBaku::create([
            'nama_bahan'   => $request->nama_bahan,
            'satuan'       => $request->satuan,
            'stok_sisa'    => $request->stok_sisa,
            'stok_minimum' => $request->stok_minimum,
        ]);

        // 3. Kembali ke halaman bahan baku dengan pesan sukses
        return redirect()->route('bahan-baku.index')
            ->with('success', 'Jenis bahan baku baru berhasil ditambahkan!');
    }

    // Method untuk menghapus jenis Bahan Baku (Master Data) beserta riwayatnya
    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $namaBahan = $bahan->nama_bahan;

        // Hapus bahan baku (riwayat terhapus otomatis via cascade di database)
        $bahan->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Bahan baku "' . $namaBahan . '" berhasil dihapus dari sistem.');
    }
}
