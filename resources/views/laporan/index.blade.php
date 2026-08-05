@extends('layouts.app')

@section('page_title', 'Cetak Laporan PDF')
@section('page_subtitle', 'Filter dan unduh laporan mutasi stok gudang dalam format PDF')

@section('content')

{{-- FORM FILTER --}}
<div class="form-card" style="max-width: 100%; margin-bottom: 24px;">
    <div class="form-card-header">
        <span class="header-icon blue">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        </span>

    </div>
    <form method="GET" action="{{ route('laporan.index') }}" class="form-body" id="formFilter">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" class="form-input" value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" class="form-input" value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Jenis Mutasi</label>
                <select name="jenis" class="form-select">
                    <option value="">-- Semua Jenis --</option>
                    <option value="Masuk" {{ request('jenis') == 'Masuk' ? 'selected' : '' }}>Masuk (Restock)</option>
                    <option value="Keluar" {{ request('jenis') == 'Keluar' ? 'selected' : '' }}>Keluar (Penyusutan)</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Bahan Baku</label>
                <select name="bahan_id" class="form-select">
                    <option value="">-- Semua Bahan --</option>
                    @foreach($semuaBahan as $bahan)
                    <option value="{{ $bahan->id }}" {{ request('bahan_id') == $bahan->id ? 'selected' : '' }}>
                        {{ $bahan->nama_bahan }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
            <button type="submit" class="btn-primary" style="width: auto; padding: 10px 20px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Tampilkan Preview
            </button>
            @if($filterAktif)
            <a href="{{ route('laporan.index') }}" style="display: inline-flex; align-items: center; padding: 10px 14px; background: #fff; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 13px; font-weight: 600; color: #475569; text-decoration: none;">Reset</a>
            @endif
            @if($filterAktif && $riwayat && $riwayat->count() > 0)
            <button type="button" onclick="cetakPdf()" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: linear-gradient(135deg, #1d4ed8, #3b82f6); color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; margin-left: auto;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Unduh PDF ({{ $riwayat->count() }} record)
            </button>
            @endif
        </div>
    </form>
</div>

{{-- PREVIEW TABEL --}}
@if($filterAktif)
<div class="data-card">
    <div class="data-card-header">
        <h3>
            <span class="header-icon blue">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </span>
            Preview Laporan
        </h3>
        <div style="display: flex; gap: 16px; font-size: 13px;">
            @if($riwayat && $riwayat->count() > 0)
            <span style="color: #15803d; font-weight: 600;">
                ↑ Masuk: {{ $riwayat->where('jenis','Masuk')->count() }} transaksi
            </span>
            <span style="color: #dc2626; font-weight: 600;">
                ↓ Keluar: {{ $riwayat->where('jenis','Keluar')->count() }} transaksi
            </span>
            <span style="color: #94a3b8; font-weight: 500;">{{ $riwayat->count() }} record</span>
            @endif
        </div>
    </div>

    @if($riwayat && $riwayat->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal & Waktu</th>
                <th>Bahan Baku</th>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $key => $row)
            <tr>
                <td class="cell-bold">{{ $key + 1 }}</td>
                <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                <td class="cell-bold">{{ $row->bahanBaku->nama_bahan ?? 'Bahan Terhapus' }}</td>
                <td>
                    @if($row->status == 'MASUK')
                        <span style="color: #15803d; font-weight: 600; font-size: 13px;">MASUK</span>
                    @else
                        <span style="color: #dc2626; font-weight: 600; font-size: 13px;">KELUAR</span>
                    @endif
                </td>
                <td class="cell-bold">{{ number_format($row->jumlah, 0, ',', '.') }}</td>
                <td>{{ $row->bahanBaku->satuan ?? '-' }}</td>
                <td>{{ $row->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align:center; padding:40px; color:#94a3b8;">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:10px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <p style="font-size:14px; font-weight:500;">Tidak ada data yang sesuai dengan filter yang dipilih.</p>
    </div>
    @endif
</div>
@else
{{-- STATE AWAL: belum ada filter --}}
<div class="data-card" style="text-align:center; padding:48px 24px;">
    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:14px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
    <p style="font-size:15px; font-weight:600; color:#475569; margin-bottom:6px;">Pilih filter di atas lalu klik "Tampilkan Preview"</p>
    <p style="font-size:13px; color:#94a3b8;">Anda bisa memilih periode, jenis mutasi, dan/atau bahan baku secara bebas dikombinasikan.<br>Setelah preview muncul, tombol Unduh PDF akan tersedia.</p>
</div>
@endif

@endsection

@push('scripts')
<script>
    function cetakPdf() {
        const form  = document.getElementById('formFilter');
        const data  = new FormData(form);
        let url     = '{{ route("laporan.riwayat.pdf") }}?';
        const params = [];

        for (const [key, val] of data.entries()) {
            if (val) params.push(encodeURIComponent(key) + '=' + encodeURIComponent(val));
        }

        window.open(url + params.join('&'), '_blank');
    }
</script>
@endpush