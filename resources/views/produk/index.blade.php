@extends('layouts.app')

@section('page_title', 'Produk & Resep')
@section('page_subtitle', 'Daftar menu minuman beserta komposisi bahan baku yang dibutuhkan')

@section('content')

{{-- TOMBOL TAMBAH PRODUK (Admin Only) --}}
@if(Auth::user()->isAdmin())
<div style="margin-bottom: 20px; display: flex; justify-content: flex-end;">
    <button type="button" onclick="document.getElementById('modalTambahProduk').style.display='flex'" style="display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; background: linear-gradient(135deg, #b45309, #d97706); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Tambah Produk Baru
    </button>
</div>
@endif

{{-- DAFTAR PRODUK --}}
@forelse($produks as $produk)
<div class="data-card" style="margin-bottom: 20px;">
    <div class="data-card-header">
        <h3>
            <span class="header-icon amber">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
            </span>
            {{ $produk->nama_produk }}
        </h3>
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 14px; font-weight: 700; color: #b45309;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
            @if(Auth::user()->isAdmin())
            <button type="button"
                onclick="bukaModalResep({{ $produk->id }}, '{{ addslashes($produk->nama_produk) }}')"
                style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 6px; color: #15803d; font-size: 12px; font-weight: 600; cursor: pointer;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Bahan
            </button>
            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                  onsubmit="return confirm('Hapus produk &quot;{{ $produk->nama_produk }}&quot;?\n\nSeluruh resep terkait juga akan dihapus.')">
                @csrf
                @method('DELETE')
                <button type="submit" style="color:#ef4444; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600;">Hapus Produk</button>
            </form>
            @endif
        </div>
    </div>

    {{-- TABEL RESEP --}}
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Bahan Baku</th>
                <th>Satuan</th>
                <th>Jumlah Dibutuhkan (per porsi)</th>
                @if(Auth::user()->isAdmin())
                <th style="text-align:center">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($produk->bahanBakus as $i => $bahan)
            <tr>
                <td class="cell-bold">{{ $i + 1 }}</td>
                <td class="cell-bold">{{ $bahan->nama_bahan }}</td>
                <td>{{ $bahan->satuan }}</td>
                <td>{{ number_format($bahan->pivot->jumlah_dibutuhkan, 2, ',', '.') }} {{ $bahan->satuan }}</td>
                @if(Auth::user()->isAdmin())
                <td style="text-align:center">
                    <button type="button"
                        onclick="bukaModalEditResep({{ $bahan->pivot->id }}, {{ $bahan->pivot->jumlah_dibutuhkan }}, '{{ addslashes($bahan->nama_bahan) }}', '{{ $bahan->satuan }}')"
                        style="color:#2563eb; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600; margin-right:8px;">Edit</button>
                    <form action="{{ route('produk.hapus-resep', $bahan->pivot->id) }}" method="POST"
                          onsubmit="return confirm('Hapus {{ $bahan->nama_bahan }} dari resep ini?')"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:#ef4444; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600;">Hapus</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isAdmin() ? 5 : 4 }}" style="text-align:center; padding:20px; color:#94a3b8; font-size:13px;">
                    Belum ada bahan baku di resep ini. Klik "Tambah Bahan" untuk menambahkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@empty
<div class="data-card" style="text-align:center; padding:40px; color:#94a3b8;">
    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:12px;"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
    <p style="font-size:14px; font-weight:500;">Belum ada produk yang terdaftar.</p>
    @if(Auth::user()->isAdmin())
    <p style="font-size:13px; margin-top:6px;">Klik tombol "Tambah Produk Baru" di atas untuk memulai.</p>
    @endif
</div>
@endforelse

{{-- MODAL TAMBAH PRODUK --}}
@if(Auth::user()->isAdmin())
<div id="modalTambahProduk" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
    <div style="background:#fff; border-radius:12px; width:100%; max-width:440px; margin:16px; box-shadow:0 20px 40px rgba(0,0,0,0.18); overflow:hidden;">
        <div style="background:#1e293b; color:#fff; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="width:30px; height:30px; background:rgba(217,119,6,0.25); border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </span>
                <h5 style="font-size:15px; font-weight:600; margin:0;">Tambah Produk Baru</h5>
            </div>
            <button type="button" onclick="document.getElementById('modalTambahProduk').style.display='none'" style="background:rgba(255,255,255,0.1); border:none; color:#fff; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
        <form action="{{ route('produk.store') }}" method="POST">
            @csrf
            <div style="padding:24px;">
                <div class="form-group">
                    <label class="form-label">Nama Produk <span class="form-label-sub">— nama menu minuman</span></label>
                    <input type="text" name="nama_produk" class="form-input" placeholder="Contoh: Kopi Susu Gula Aren" required>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Harga Jual <span class="form-label-sub">— harga per porsi (Rp)</span></label>
                    <input type="number" name="harga" class="form-input" placeholder="Contoh: 25000" min="0" required>
                </div>
            </div>
            <div style="padding:14px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="document.getElementById('modalTambahProduk').style.display='none'" style="padding:9px 18px; background:#fff; border:1.5px solid #e2e8f0; border-radius:7px; font-size:13px; font-weight:600; color:#475569; cursor:pointer;">Batal</button>
                <button type="submit" class="btn-primary" style="width:auto; padding:9px 20px; font-size:13px;">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL TAMBAH BAHAN KE RESEP --}}
<div id="modalTambahResep" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
    <div style="background:#fff; border-radius:12px; width:100%; max-width:440px; margin:16px; box-shadow:0 20px 40px rgba(0,0,0,0.18); overflow:hidden;">
        <div style="background:#1e293b; color:#fff; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="width:30px; height:30px; background:rgba(16,185,129,0.2); border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </span>
                <h5 id="judulModalResep" style="font-size:15px; font-weight:600; margin:0;">Tambah Bahan ke Resep</h5>
            </div>
            <button type="button" onclick="document.getElementById('modalTambahResep').style.display='none'" style="background:rgba(255,255,255,0.1); border:none; color:#fff; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
        <form id="formTambahResep" action="" method="POST">
            @csrf
            <div style="padding:24px;">
                <div class="form-group">
                    <label class="form-label">Bahan Baku <span class="form-label-sub">— pilih bahan yang digunakan</span></label>
                    <select name="bahan_baku_id" class="form-select" required>
                        <option value="">-- Pilih Bahan Baku --</option>
                        @foreach($semuaBahan as $bahan)
                        <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }} ({{ $bahan->satuan }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Jumlah per Porsi <span class="form-label-sub">— takaran untuk 1 sajian</span></label>
                    <input type="number" name="jumlah_dibutuhkan" class="form-input" placeholder="Contoh: 30" min="0.1" step="any" required>
                </div>
            </div>
            <div style="padding:14px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="document.getElementById('modalTambahResep').style.display='none'" style="padding:9px 18px; background:#fff; border:1.5px solid #e2e8f0; border-radius:7px; font-size:13px; font-weight:600; color:#475569; cursor:pointer;">Batal</button>
                <button type="submit" class="btn-primary" style="width:auto; padding:9px 20px; font-size:13px; background: linear-gradient(135deg, #059669, #10b981);">Tambah ke Resep</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT JUMLAH BAHAN DI RESEP --}}
<div id="modalEditResep" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
    <div style="background:#fff; border-radius:12px; width:100%; max-width:420px; margin:16px; box-shadow:0 20px 40px rgba(0,0,0,0.18); overflow:hidden;">
        <div style="background:#1e293b; color:#fff; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="width:30px; height:30px; background:rgba(37,99,235,0.2); border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </span>
                <h5 id="judulModalEditResep" style="font-size:15px; font-weight:600; margin:0;">Edit Jumlah Bahan</h5>
            </div>
            <button type="button" onclick="document.getElementById('modalEditResep').style.display='none'" style="background:rgba(255,255,255,0.1); border:none; color:#fff; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
        <form id="formEditResep" action="" method="POST">
            @csrf
            @method('PUT')
            <div style="padding:24px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Jumlah per Porsi <span class="form-label-sub" id="satuanEditResep"></span></label>
                    <input type="number" name="jumlah_dibutuhkan" id="inputJumlahEditResep" class="form-input" min="0.1" step="any" required>
                </div>
            </div>
            <div style="padding:14px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="document.getElementById('modalEditResep').style.display='none'" style="padding:9px 18px; background:#fff; border:1.5px solid #e2e8f0; border-radius:7px; font-size:13px; font-weight:600; color:#475569; cursor:pointer;">Batal</button>
                <button type="submit" class="btn-primary" style="width:auto; padding:9px 20px; font-size:13px; background: linear-gradient(135deg, #1d4ed8, #3b82f6);">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    // Buka modal tambah bahan ke resep dengan produk ID yang sesuai
    function bukaModalResep(produkId, namaProduk) {
        document.getElementById('judulModalResep').textContent = 'Tambah Bahan ke Resep — ' + namaProduk;
        document.getElementById('formTambahResep').action = '/produk/' + produkId + '/resep';
        document.getElementById('modalTambahResep').style.display = 'flex';
    }

    // Buka modal edit jumlah bahan di resep
    function bukaModalEditResep(resepId, jumlahSaatIni, namaBahan, satuan) {
        document.getElementById('judulModalEditResep').textContent = 'Edit Jumlah — ' + namaBahan;
        document.getElementById('satuanEditResep').textContent = '— dalam ' + satuan;
        document.getElementById('inputJumlahEditResep').value = jumlahSaatIni;
        document.getElementById('formEditResep').action = '/produk/resep/' + resepId;
        document.getElementById('modalEditResep').style.display = 'flex';
    }

    // Tutup modal jika klik area luar
    ['modalTambahProduk', 'modalTambahResep', 'modalEditResep'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('click', function(e) {
            if (e.target === this) this.style.display = 'none';
        });
    });
</script>
@endpush
