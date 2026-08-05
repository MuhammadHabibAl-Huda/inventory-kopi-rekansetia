<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\BahanBaku;
use App\Models\Resep;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk beserta resepnya
     */
    public function index()
    {
        $produks    = Produk::with('bahanBakus')->get();
        $semuaBahan = BahanBaku::orderBy('nama_bahan')->get();

        return view('produk.index', compact('produks', 'semuaBahan'));
    }

    /**
     * Menyimpan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:produks,nama_produk',
            'harga'       => 'required|integer|min:0',
        ], [
            'nama_produk.unique' => 'Nama produk ini sudah terdaftar!',
        ]);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk "' . $request->nama_produk . '" berhasil ditambahkan!');
    }

    /**
     * Menghapus produk (resep ikut terhapus via cascade)
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $namaProduk = $produk->nama_produk;
        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk "' . $namaProduk . '" berhasil dihapus!');
    }

    /**
     * Menambahkan bahan baku ke resep sebuah produk
     */
    public function tambahResep(Request $request, $produkId)
    {
        $request->validate([
            'bahan_baku_id'      => 'required|exists:bahan_bakus,id',
            'jumlah_dibutuhkan'  => 'required|numeric|min:0.1',
        ]);

        $produk = Produk::findOrFail($produkId);

        // Cek apakah bahan sudah ada di resep produk ini
        $sudahAda = Resep::where('produk_id', $produkId)
                         ->where('bahan_baku_id', $request->bahan_baku_id)
                         ->exists();

        if ($sudahAda) {
            return back()->withErrors(['bahan_baku_id' => 'Bahan baku ini sudah ada di resep produk tersebut!']);
        }

        Resep::create([
            'produk_id'         => $produkId,
            'bahan_baku_id'     => $request->bahan_baku_id,
            'jumlah_dibutuhkan' => $request->jumlah_dibutuhkan,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Bahan baku berhasil ditambahkan ke resep ' . $produk->nama_produk . '!');
    }

    /**
     * Mengupdate jumlah bahan yang dibutuhkan di resep
     */
    public function updateResep(Request $request, $resepId)
    {
        $request->validate([
            'jumlah_dibutuhkan' => 'required|numeric|min:0.1',
        ]);

        $resep = Resep::findOrFail($resepId);
        $resep->update([
            'jumlah_dibutuhkan' => $request->jumlah_dibutuhkan,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Jumlah bahan dalam resep berhasil diperbarui!');
    }

    /**
     * Menghapus satu bahan dari resep produk
     */
    public function hapusResep($resepId)
    {
        $resep = Resep::findOrFail($resepId);
        $resep->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Bahan baku berhasil dihapus dari resep!');
    }
}
