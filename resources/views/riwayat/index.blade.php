@extends('layouts.app')

@section('page_title', 'Laporan')
@section('page_subtitle', 'Riwayat mutasi stok & unduh laporan PDF')

@section('content')

{{-- FORM FILTER --}}
<div class="form-card" style="max-width: 100%; margin-bottom: 24px;">
    <div class="form-card-header" style="justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span class="header-icon blue">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            </span>
            <h3>Filter Riwayat</h3>
        </div>

        {{-- TOMBOL UNDUH LAPORAN (khusus admin) --}}
        @if(Auth::user()->isAdmin())
        @php
            // Jika ada filter aktif, pakai parameter filter.
            // Jika tidak ada filter (tampilan default = hari ini), kirim tanggal hari ini.
            $adaFilter = request()->hasAny(['tanggal_mulai','tanggal_selesai','jenis','bahan_id']);
            $pdfParams = $adaFilter
                ? request()->only(['tanggal_mulai','tanggal_selesai','jenis','bahan_id'])
                : ['tanggal_mulai' => now()->toDateString(), 'tanggal_selesai' => now()->toDateString()];
        @endphp
        <a id="btnUnduhLaporan"
           href="{{ route('laporan.riwayat.pdf', $pdfParams) }}"
           style="display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; background: linear-gradient(135deg, #1d4ed8, #2563eb); color: #fff; font-size: 13px; font-weight: 600; border-radius: 8px; text-decoration: none; transition: opacity 0.2s ease; white-space: nowrap;"
           onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="7 10 12 15 17 10"/>
                <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Unduh Laporan
        </a>
        @endif
    </div>
    <form method="GET" action="{{ route('riwayat.index') }}" class="form-body" id="formFilter">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 16px; align-items: flex-end;">
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
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-primary" style="width: auto; padding: 10px 18px; white-space: nowrap;">Terapkan</button>
                @if(request()->hasAny(['tanggal_mulai','tanggal_selesai','jenis','bahan_id']))
                <a href="{{ route('riwayat.index') }}" style="display: inline-flex; align-items: center; padding: 10px 14px; background: #fff; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 13px; font-weight: 600; color: #475569; text-decoration: none; white-space: nowrap;">Reset</a>
                @endif
            </div>
        </div>
    </form>
</div>

{{-- TABEL RIWAYAT --}}
<div class="data-card">
    <div class="data-card-header">
        <h3>
            <span class="header-icon blue">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </span>
            Riwayat Aktivitas
        </h3>
        <span style="font-size: 13px; color: #94a3b8; font-weight: 500;">{{ $riwayat->count() }} record ditemukan</span>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal &amp; Waktu</th>
                <th>Bahan Baku</th>
                <th>Status</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                @if(Auth::user()->isAdmin())
                <th style="text-align:center">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $key => $row)
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
                <td class="cell-bold">{{ number_format($row->jumlah, 2, ',', '.') }} {{ $row->bahanBaku->satuan ?? '' }}</td>
                <td>{{ $row->keterangan ?? '-' }}</td>
                @if(Auth::user()->isAdmin())
                <td style="text-align:center">
                    <form action="{{ route('riwayat.destroy', $row->id) }}" method="POST" onsubmit="return confirm('⚠️ Hapus record riwayat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:#ef4444; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600;">Hapus</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}" style="text-align:center; padding:30px; color:#94a3b8;">
                    Tidak ada data riwayat yang sesuai filter.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
    const formFilter = document.getElementById('formFilter');
    const btnUnduh   = document.getElementById('btnUnduhLaporan');

    if (formFilter && btnUnduh) {
        const baseUrl = "{{ route('laporan.riwayat.pdf') }}";
        // Tanggal hari ini sebagai fallback default
        const today   = "{{ now()->toDateString() }}";

        function updateUnduhUrl() {
            const data   = new FormData(formFilter);
            const params = new URLSearchParams();
            for (const [key, val] of data.entries()) {
                if (val) params.append(key, val);
            }

            // Jika semua field filter kosong → paksa tanggal hari ini
            // agar PDF yang diunduh = data yang tampil (default hari ini)
            if (!params.toString()) {
                params.append('tanggal_mulai', today);
                params.append('tanggal_selesai', today);
            }

            btnUnduh.href = baseUrl + '?' + params.toString();
        }

        // Set URL tombol saat halaman pertama dimuat
        updateUnduhUrl();

        // Perbarui URL setiap kali nilai filter berubah
        formFilter.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('change', updateUnduhUrl);
        });
    }
</script>
@endpush