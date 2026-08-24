@extends('layouts.app')

@section('page_title', 'Live Monitoring Stok')
@section('page_subtitle', 'Pantau kondisi stok bahan baku gudang secara real-time')

@section('content')

@php
    // Pisahkan collection: aktif saja untuk statistik
    $bahanAktif   = $semuaBahan->where('is_active', true);
    $stokAman     = $bahanAktif->filter(function($b) { return $b->stok_sisa > $b->stok_minimum; })->count();
    $stokMenipis  = $bahanAktif->filter(function($b) { return $b->stok_sisa <= $b->stok_minimum; })->count();
@endphp

<!-- Summary Stats — hanya menghitung bahan AKTIF -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-label">Total Jenis Bahan</div>
        <div class="stat-card-value">{{ $semuaBahan->count() }}</div>
        <div class="stat-card-sub">{{ $bahanAktif->count() }} aktif &middot; {{ $semuaBahan->count() - $bahanAktif->count() }} nonaktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Aman</div>
        <div class="stat-card-value" style="color: #10b981;">
            {{ $stokAman }}
        </div>
        <div class="stat-card-sub">Bahan aktif di atas batas minimum</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Menipis</div>
        <div class="stat-card-value" style="color: #ef4444;">
            {{ $stokMenipis }}
        </div>
        <div class="stat-card-sub">Bahan aktif perlu segera restock</div>
    </div>
</div>

<!-- Stock Table — semua bahan (aktif & nonaktif) -->
<div class="data-card">
    <div class="data-card-header">
        <h3>
            <span class="header-icon amber">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </span>
            Daftar Stok Bahan Baku
        </h3>
        <span class="badge">{{ $semuaBahan->count() }} item</span>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan Baku</th>
                <th>Sisa Stok</th>
                <th>Satuan</th>
                <th>Batas Min.</th>
                <th style="text-align:center">Status Stok</th>
                <th style="text-align:center">Aktivitas</th>
                @if(Auth::user()->isAdmin())
                <th style="text-align:center">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($semuaBahan as $index => $bahan)
            <tr style="{{ !$bahan->is_active ? 'opacity: 0.5;' : '' }}">
                <td class="cell-bold">{{ $index + 1 }}</td>
                <td class="cell-bold">{{ $bahan->nama_bahan }}</td>
                <td class="cell-bold">{{ number_format($bahan->stok_sisa, 2, ',', '.') }}</td>
                <td>{{ $bahan->satuan }}</td>
                <td>{{ number_format($bahan->stok_minimum, 2, ',', '.') }}</td>
                <td style="text-align:center">
                    @if(!$bahan->is_active)
                        {{-- Bahan nonaktif: tidak tampilkan status stok --}}
                        <span style="color: #94a3b8; font-size: 13px;">—</span>
                    @elseif($bahan->stok_sisa <= $bahan->stok_minimum)
                        @if(Auth::user()->isAdmin())
                            {{-- Admin: Tulisan Menipis bisa diklik untuk quick restock --}}
                            <button
                                type="button"
                                class="btn-menipis-restock"
                                onclick="bukaModalQuickRestock({{ $bahan->id }}, '{{ addslashes($bahan->nama_bahan) }}', '{{ $bahan->satuan }}', {{ $bahan->stok_sisa }}, {{ $bahan->stok_minimum }})"
                                title="Klik untuk restock bahan ini"
                            >
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                                    <line x1="12" y1="9" x2="12" y2="13"/>
                                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                                </svg>
                                Menipis
                            </button>
                        @else
                            {{-- Non-admin: hanya teks biasa --}}
                            <span style="color: #dc2626; font-weight: 600; font-size: 13px;">Menipis</span>
                        @endif
                    @else
                        <span style="color: #15803d; font-weight: 600; font-size: 13px;">Aman</span>
                    @endif
                </td>
                <td style="text-align:center">
                    @if($bahan->is_active)
                        <span style="color: #10b981; font-weight: 600; font-size: 13px;">Aktif</span>
                    @else
                        <span style="color: #6b7280; font-weight: 600; font-size: 13px;">Nonaktif</span>
                    @endif
                </td>
                @if(Auth::user()->isAdmin())
                @php $aksiTeks = $bahan->is_active ? 'menonaktifkan' : 'mengaktifkan kembali'; @endphp
                <td style="text-align:center">
                    <form action="{{ route('bahan-baku.toggle-status', $bahan->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin {{ $aksiTeks }} bahan baku &quot;{{ $bahan->nama_bahan }}&quot;?')">
                        @csrf
                        @method('PATCH')
                        @if($bahan->is_active)
                            <button type="submit" style="color:#ef4444; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600;">Nonaktifkan</button>
                        @else
                            <button type="submit" style="color:#10b981; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600;">Aktifkan</button>
                        @endif
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isAdmin() ? 8 : 7 }}" style="text-align:center; padding:30px; color:#94a3b8;">
                    Belum ada bahan baku yang terdaftar.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(Auth::user()->isAdmin())
{{-- ====================================================
     MODAL QUICK RESTOCK (Admin Only)
     Muncul saat admin klik badge "Menipis" di tabel
     ==================================================== --}}
<div id="modalQuickRestock" style="display:none; position:fixed; inset:0; z-index:999; align-items:center; justify-content:center; background:rgba(15,23,42,0.55); backdrop-filter:blur(5px);">
    <div style="background:#fff; border-radius:14px; width:100%; max-width:500px; margin:16px; box-shadow:0 24px 48px rgba(0,0,0,0.22); overflow:hidden; animation: slideUpModal 0.28s cubic-bezier(0.34,1.56,0.64,1);">

        {{-- Header Modal --}}
        <div style="background: linear-gradient(135deg, #b45309, #d97706); color:#fff; padding:20px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="width:34px; height:34px; background:rgba(255,255,255,0.18); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                        <line x1="12" y1="22.08" x2="12" y2="12"/>
                    </svg>
                </span>
                <div>
                    <h5 style="font-size:15px; font-weight:700; margin:0; letter-spacing:-0.2px;">Quick Restock Bahan Baku</h5>
                    <p id="qr-subtitle" style="font-size:12px; margin:2px 0 0; opacity:0.82;">Input bahan masuk dari supplier</p>
                </div>
            </div>
            <button type="button" onclick="tutupModalQuickRestock()" style="background:rgba(255,255,255,0.15); border:none; color:#fff; width:30px; height:30px; border-radius:7px; cursor:pointer; font-size:18px; display:flex; align-items:center; justify-content:center; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">&times;</button>
        </div>

        {{-- Info Stok Saat Ini --}}
        <div id="qr-info-stok" style="margin:0; padding:14px 24px 0;">
            <div style="background:#fef3c7; border:1px solid #fcd34d; border-radius:8px; padding:10px 14px; display:flex; align-items:center; gap:10px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2" style="flex-shrink:0;">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <div style="font-size:13px; color:#92400e;">
                    Stok saat ini: <strong id="qr-stok-saat-ini">–</strong> &nbsp;|&nbsp; Batas minimum: <strong id="qr-stok-minimum">–</strong>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form id="formQuickRestock" action="{{ route('bahan-baku.restock') }}" method="POST">
            @csrf
            <input type="hidden" name="bahan_id" id="qr-bahan-id">
            <input type="hidden" name="redirect_to" value="dashboard">

            <div style="padding:20px 24px 8px;">
                {{-- Nama Bahan (readonly display) --}}
                <div class="form-group">
                    <label class="form-label">
                        Bahan Baku yang Direstok
                        <span class="form-label-sub">— dipilih otomatis dari tabel</span>
                    </label>
                    <div id="qr-nama-bahan-display" style="padding:10px 14px; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px; font-weight:600; color:#0f172a; display:flex; align-items:center; gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        <span id="qr-nama-bahan-text">–</span>
                    </div>
                </div>

                {{-- Jumlah Masuk --}}
                <div class="form-group">
                    <label class="form-label" for="qr-jumlah-masuk">
                        Jumlah Stok Tambahan
                        <span class="form-label-sub">— masukkan jumlah dari supplier</span>
                    </label>
                    <div style="position:relative;">
                        <input
                            type="number"
                            step="any"
                            name="jumlah_masuk"
                            id="qr-jumlah-masuk"
                            min="0.01"
                            required
                            placeholder="Contoh: 500"
                            class="form-input"
                            style="padding-right: 60px;"
                        >
                        <span id="qr-satuan-label" style="position:absolute; right:14px; top:50%; transform:translateY(-50%); font-size:13px; font-weight:600; color:#94a3b8;">–</span>
                    </div>
                </div>

                {{-- Nama Supplier --}}
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="qr-supplier">
                        Nama Supplier
                        <span class="form-label-sub">— nama penyuplai / tempat belanja</span>
                    </label>
                    <input
                        type="text"
                        name="supplier"
                        id="qr-supplier"
                        required
                        placeholder="Contoh: Toko Kopi Sumber Jaya"
                        class="form-input"
                    >
                </div>
            </div>

            {{-- Footer --}}
            <div style="padding:16px 24px 20px; display:flex; justify-content:flex-end; gap:10px; border-top:1px solid #f1f5f9; margin-top:20px;">
                <button type="button" onclick="tutupModalQuickRestock()" style="padding:10px 20px; background:#fff; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px; font-weight:600; color:#475569; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                    Batal
                </button>
                <button type="submit" style="display:inline-flex; align-items:center; gap:8px; padding:10px 22px; background:linear-gradient(135deg,#b45309,#d97706); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:opacity 0.2s;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Tambah ke Gudang
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
    /* Tombol badge Menipis yang bisa diklik (admin only) */
    .btn-menipis-restock {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        background: #fee2e2;
        color: #b91c1c;
        font-size: 12px;
        font-weight: 700;
        border: 1.5px solid #fca5a5;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        letter-spacing: 0.2px;
    }
    .btn-menipis-restock:hover {
        background: #dc2626;
        color: #fff;
        border-color: #dc2626;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(220,38,38,0.3);
    }
    .btn-menipis-restock:active {
        transform: translateY(0);
    }

    /* Animasi slide-up modal */
    @keyframes slideUpModal {
        from { opacity: 0; transform: translateY(24px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Stat card sub text */
    .stat-card-sub {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 6px;
    }
</style>
@endpush

@push('scripts')
@if(Auth::user()->isAdmin())
<script>
    // ── Buka modal Quick Restock ──────────────────────────────────────
    function bukaModalQuickRestock(id, nama, satuan, stokSisa, stokMin) {
        // Isi data ke form
        document.getElementById('qr-bahan-id').value       = id;
        document.getElementById('qr-nama-bahan-text').textContent = nama;
        document.getElementById('qr-satuan-label').textContent    = satuan;
        document.getElementById('qr-subtitle').textContent        = 'Restock untuk: ' + nama;

        // Tampilkan info stok
        const stokFmt = parseFloat(stokSisa).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        const minFmt  = parseFloat(stokMin).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('qr-stok-saat-ini').textContent = stokFmt + ' ' + satuan;
        document.getElementById('qr-stok-minimum').textContent  = minFmt + ' ' + satuan;

        // Reset field input
        document.getElementById('qr-jumlah-masuk').value = '';
        document.getElementById('qr-supplier').value     = '';

        // Tampilkan modal
        const modal = document.getElementById('modalQuickRestock');
        modal.style.display = 'flex';

        // Fokus ke field jumlah
        setTimeout(() => document.getElementById('qr-jumlah-masuk').focus(), 100);
    }

    // ── Tutup modal Quick Restock ─────────────────────────────────────
    function tutupModalQuickRestock() {
        document.getElementById('modalQuickRestock').style.display = 'none';
    }

    // ── Tutup modal jika klik backdrop ───────────────────────────────
    document.getElementById('modalQuickRestock').addEventListener('click', function(e) {
        if (e.target === this) tutupModalQuickRestock();
    });

    // ── Tutup modal dengan tombol Escape ─────────────────────────────
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupModalQuickRestock();
    });
</script>
@endif
@endpush