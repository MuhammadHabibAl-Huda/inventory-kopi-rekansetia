@extends('layouts.app')

@section('page_title', 'Kelola Bahan Baku')
@section('page_subtitle', 'Input restock supplier & catat penyusutan bahan baku')

@section('content')
@if(Auth::user()->isAdmin())
<!-- BAGIAN A: TOMBOL BUKA MODAL (Admin Only) -->
<div style="margin-bottom: 20px; display: flex; justify-content: flex-end;">
    <button type="button" onclick="document.getElementById('modalTambahBahan').style.display='flex'" style="display: inline-flex; align-items: center; gap: 8px; padding: 9px 16px; background: linear-gradient(135deg, #b45309, #d97706); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        Tambah Jenis Bahan Baku
    </button>
</div>

<!-- FORM RESTOCK (Admin Only) -->
<div class="form-card" style="margin-bottom: 24px;">
    <div class="form-card-header">
        <span class="header-icon green">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                <line x1="12" y1="22.08" x2="12" y2="12" />
            </svg>
        </span>
        <h3>Form Input Bahan Baku Masuk</h3>
    </div>
    <form action="{{ route('bahan-baku.restock') }}" method="POST" class="form-body">
        @csrf
        <div class="form-group">
            <label class="form-label">Pilih Bahan Baku <span class="form-label-sub">— pilih barang aktif yang akan di-restock</span></label>
            <select name="bahan_id" required class="form-select">
                <option value="">-- Pilih Barang --</option>
                @foreach($bahanAktif as $bahan)
                <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }} ({{ $bahan->satuan }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Jumlah Stok Tambahan <span class="form-label-sub">— masukkan jumlah dari supplier</span></label>
            {{-- Ditambahkan step="any" dan min="0.01" agar bisa menerima koma --}}
            <input type="number" step="any" name="jumlah_masuk" min="0.01" required placeholder="Contoh: 500.5" class="form-input">
        </div>
        <div class="form-group">
            <label class="form-label">Nama Supplier <span class="form-label-sub">— nama penyuplai / tempat belanja</span></label>
            <input type="text" name="supplier" required placeholder="Contoh: Toko Kopi Sumber Jaya" class="form-input">
        </div>
        <button type="submit" class="btn-primary">Tambah ke Gudang</button>
    </form>
</div>
@endif

<!-- FORM PENYUSUTAN & ADD-ON (Semua Role) -->
<div class="form-card">
    <div class="form-card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span class="header-icon orange">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
            </span>
            <h3 style="margin: 0;">Pencatatan Penyusutan Bahan Baku</h3>
        </div>
        <!-- Tombol Buka Modal Add-on -->
        <button type="button" onclick="document.getElementById('modalAddon').style.display='flex'" style="display: inline-flex; align-items: center; gap: 7px; padding: 8px 14px; background: #f59e0b; color: #fff; font-size: 12px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Catat Add-on Manual
        </button>
    </div>
    <div class="form-body">
        <form action="{{ route('bahan-baku.penyusutan') }}" method="POST" onsubmit="return konfirmasiPenyusutan(this)">
            @csrf
            <div class="form-group">
                <label class="form-label">Pilih Bahan Baku <span class="form-label-sub">— bahan aktif yang mengalami penyusutan</span></label>
                <select name="bahan_id" required class="form-select" onchange="updateStokInfo(this)">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($bahanAktif as $bahan)
                    <option value="{{ $bahan->id }}" data-stok="{{ $bahan->stok_sisa }}" data-satuan="{{ $bahan->satuan }}">
                        {{ $bahan->nama_bahan }} — stok: {{ number_format($bahan->stok_sisa, 2, ',', '.') }} {{ $bahan->satuan }}
                    </option>
                    @endforeach
                </select>
                <div id="stok-info" style="display:none; margin-top:8px; padding:8px 12px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:6px; font-size:13px; color:#166534;">
                    <strong>Stok saat ini:</strong> <span id="stok-info-value">-</span>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Jumlah Penyusutan <span class="form-label-sub">— jumlah yang rusak/tumpah/terbuang</span></label>
                {{-- Ditambahkan step="any" dan min="0.01" agar bisa menerima koma --}}
                <input type="number" step="any" name="jumlah_susut" id="inputJumlahSusut" min="0.01" required placeholder="Contoh: 1.5" class="form-input" oninput="validasiJumlahSusut(this)">
                <div id="peringatan-susut" style="display:none; margin-top:8px; padding:8px 12px; background:#fee2e2; border:1px solid #fca5a5; border-radius:6px; font-size:13px; color:#991b1b;"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Penyusutan</label>
                <select name="jenis_penyusutan" required class="form-select">
                    <option value="">-- Pilih Jenis Penyusutan --</option>
                    <option value="Kerusakan">Kerusakan — bahan cacat / tidak layak pakai</option>
                    <option value="Tumpah">Tumpah — bahan tumpah saat penanganan</option>
                    <option value="Kadaluarsa">Kadaluarsa — bahan melewati tanggal kedaluwarsa</option>
                    <option value="Terbuang Proses Produksi">Terbuang Proses Produksi</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Keterangan Tambahan</label>
                <textarea name="keterangan" class="form-textarea" placeholder="Contoh: Susu tumpah saat steaming"></textarea>
            </div>
            <button type="submit" class="btn-danger-submit">Catat Penyusutan Bahan Baku</button>
        </form>
    </div>
</div>

<!-- BAGIAN B: MODAL TAMBAH BAHAN BARU (Admin Only) -->
<div id="modalTambahBahan" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
    <div style="background:#fff; border-radius:12px; width:100%; max-width:480px; margin:16px; box-shadow:0 20px 40px rgba(0,0,0,0.18); overflow:hidden;">
        <!-- Header Modal -->
        <div style="background:#1e293b; color:#fff; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="width:30px; height:30px; background:rgba(217,119,6,0.25); border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                </span>
                <h5 style="font-size:15px; font-weight:600; margin:0;">Tambah Jenis Bahan Baku Baru</h5>
            </div>
            <button type="button" onclick="document.getElementById('modalTambahBahan').style.display='none'" style="background:rgba(255,255,255,0.1); border:none; color:#fff; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
        <!-- Body Modal -->
        <form action="{{ route('bahan-baku.store-master') }}" method="POST">
            @csrf
            <div style="padding:24px;">
                <div class="form-group">
                    <label class="form-label">Nama Bahan Baku <span class="form-label-sub">— nama unik bahan yang akan didaftarkan</span></label>
                    <input type="text" name="nama_bahan" class="form-input" placeholder="Contoh: Sirup Hazelnut, Matcha Powder" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Satuan Ukuran <span class="form-label-sub">— satuan stok bahan ini</span></label>
                    <select name="satuan" class="form-select" required>
                        <option value="" selected disabled>-- Pilih Satuan --</option>
                        <option value="gram">gram (gr)</option>
                        <option value="ml">mili liter (ml)</option>
                        <option value="pcs">pieces (pcs)</option>
                        <option value="sachet">sachet</option>
                        <option value="kaleng">kaleng</option>
                    </select>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" step="any" name="stok_sisa" class="form-input" value="0" min="0" required>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Stok Minimum</label>
                        <input type="number" step="any" name="stok_minimum" class="form-input" value="10" min="0" required>
                    </div>
                </div>
            </div>
            <!-- Footer Modal -->
            <div style="padding:14px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="document.getElementById('modalTambahBahan').style.display='none'" style="padding:9px 18px; background:#fff; border:1.5px solid #e2e8f0; border-radius:7px; font-size:13px; font-weight:600; color:#475569; cursor:pointer;">Batal</button>
                <button type="submit" class="btn-primary" style="width:auto; padding:9px 20px; font-size:13px;">Simpan Bahan Baru</button>
            </div>
        </form>
    </div>
</div>

<!-- BAGIAN C: MODAL CATAT ADD-ON MANUAL (Semua Role) -->
<div id="modalAddon" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
    <div style="background:#fff; border-radius:12px; width:100%; max-width:480px; margin:16px; box-shadow:0 20px 40px rgba(0,0,0,0.18); overflow:hidden;">
        <!-- Header Modal -->
        <div style="background:#1e293b; color:#fff; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:10px;">
                <span style="width:30px; height:30px; background:rgba(245,158,11,0.25); border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                </span>
                <h5 style="font-size:15px; font-weight:600; margin:0;">Catat Add-on Manual</h5>
            </div>
            <button type="button" onclick="document.getElementById('modalAddon').style.display='none'" style="background:rgba(255,255,255,0.1); border:none; color:#fff; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
        <!-- Body Modal -->
        <form action="{{ route('bahan-baku.penyusutan') }}" method="POST">
            @csrf
            {{-- Hidden input untuk jenis penyusutan --}}
            <input type="hidden" name="jenis_penyusutan" value="Add-on Manual Kasir">
            
            <div style="padding:24px;">
                <div class="form-group">
                    <label class="form-label">Pilih Bahan Baku Tambahan</label>
                    <select name="bahan_id" required class="form-select">
                        <option value="" selected disabled>-- Pilih Bahan --</option>
                        @foreach($bahanAktif as $bahan)
                            <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }} (Stok: {{ number_format($bahan->stok_sisa, 2, ',', '.') }} {{ $bahan->satuan }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah Digunakan</label>
                    <input type="number" name="jumlah_susut" step="any" min="0.01" required class="form-input" placeholder="Contoh: 18.5">
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Keterangan / Nama Pesanan</label>
                    <input type="text" name="keterangan" required class="form-input" placeholder="Contoh: Extra Shot untuk pesanan Bpk. Budi">
                </div>
            </div>
            <!-- Footer Modal -->
            <div style="padding:14px 24px; background:#f8fafc; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="document.getElementById('modalAddon').style.display='none'" style="padding:9px 18px; background:#fff; border:1.5px solid #e2e8f0; border-radius:7px; font-size:13px; font-weight:600; color:#475569; cursor:pointer;">Batal</button>
                <button type="submit" style="padding:9px 20px; background:#f59e0b; color:#fff; border:none; border-radius:7px; font-size:13px; font-weight:600; cursor:pointer;">Simpan Add-on</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // --- Fungsi info stok saat bahan dipilih ---
    function updateStokInfo(selectEl) {
        const option = selectEl.options[selectEl.selectedIndex];
        const infoEl = document.getElementById('stok-info');
        const valueEl = document.getElementById('stok-info-value');
        if (selectEl.value && option) {
            const stok = parseFloat(option.getAttribute('data-stok'));
            const satuan = option.getAttribute('data-satuan');
            valueEl.textContent = `${stok.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})} ${satuan}`;
            infoEl.style.display = 'block';
        } else {
            infoEl.style.display = 'none';
        }
        // Reset peringatan saat bahan diganti
        document.getElementById('peringatan-susut').style.display = 'none';
        document.getElementById('inputJumlahSusut').value = '';
    }

    // --- Validasi real-time jumlah penyusutan vs stok tersedia ---
    function validasiJumlahSusut(inputEl) {
        const selectEl = document.querySelector('select[name="bahan_id"]');
        const peringatanEl = document.getElementById('peringatan-susut');
        if (!selectEl.value) return;
        const option = selectEl.options[selectEl.selectedIndex];
        const stokTersedia = parseFloat(option.getAttribute('data-stok'));
        const satuan = option.getAttribute('data-satuan');
        const jumlah = parseFloat(inputEl.value);
        if (!isNaN(jumlah) && jumlah > stokTersedia) {
            peringatanEl.textContent = `⚠ Jumlah penyusutan (${jumlah.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})} ${satuan}) melebihi stok yang tersedia (${stokTersedia.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})} ${satuan}).`;
            peringatanEl.style.display = 'block';
        } else {
            peringatanEl.style.display = 'none';
        }
    }

    // --- Konfirmasi dialog sebelum submit penyusutan ---
    function konfirmasiPenyusutan(formEl) {
        const selectEl = formEl.querySelector('select[name="bahan_id"]');
        const jumlahEl = formEl.querySelector('input[name="jumlah_susut"]');
        const jenisPenyusutanEl = formEl.querySelector('select[name="jenis_penyusutan"]');
        if (!selectEl.value || !jumlahEl.value || !jenisPenyusutanEl.value) return true;
        const namaBahan = selectEl.options[selectEl.selectedIndex].text.split(' —')[0];
        const jumlah = parseFloat(jumlahEl.value).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        const satuan = selectEl.options[selectEl.selectedIndex].getAttribute('data-satuan');
        const jenis = jenisPenyusutanEl.options[jenisPenyusutanEl.selectedIndex].text;
        // Cek jika jumlah melebihi stok, blokir submit
        const stokTersedia = parseFloat(selectEl.options[selectEl.selectedIndex].getAttribute('data-stok'));
        if (parseFloat(jumlahEl.value) > stokTersedia) {
            alert('Tidak dapat menyimpan. Jumlah penyusutan melebihi stok yang tersedia.');
            return false;
        }
        return confirm(`Konfirmasi Penyusutan:\n\nBahan: ${namaBahan}\nJumlah: ${jumlah} ${satuan}\nJenis: ${jenis}\n\nApakah data ini sudah benar?`);
    }

    // --- Tutup modal jika klik area luar (backdrop) ---
    document.getElementById('modalTambahBahan').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
    document.getElementById('modalAddon').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
</script>
@endpush