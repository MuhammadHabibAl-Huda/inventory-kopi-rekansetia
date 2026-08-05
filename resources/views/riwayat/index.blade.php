@extends('layouts.app')

@section('page_title', 'Riwayat Aktivitas')
@section('page_subtitle', 'Catatan log mutasi stok gudang')

@section('content')

{{-- FORM FILTER --}}
<div class="form-card" style="max-width: 100%; margin-bottom: 24px;">
    <div class="form-card-header">
        <span class="header-icon blue">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        </span>
        <h3>Filter Riwayat</h3>
    </div>
    <form method="GET" action="{{ route('riwayat.index') }}" class="form-body">
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
                <th>Tanggal & Waktu</th>
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
                <td class="cell-bold">{{ number_format($row->jumlah, 0, ',', '.') }}</td>
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