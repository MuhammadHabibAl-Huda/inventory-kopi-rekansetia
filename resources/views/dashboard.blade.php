@extends('layouts.app')

@section('page_title', 'Live Monitoring Stok')
@section('page_subtitle', 'Pantau kondisi stok bahan baku gudang secara real-time')

@section('content')
<!-- Summary Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-label">Total Jenis Bahan</div>
        <div class="stat-card-value">{{ $semuaBahan->count() }}</div>
        <div class="stat-card-sub">Bahan baku terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Aman</div>
        <div class="stat-card-value" style="color: #10b981;">
            {{ $semuaBahan->filter(fn($b) => $b->stok_sisa > $b->stok_minimum)->count() }}
        </div>
        <div class="stat-card-sub">Bahan di atas batas minimum</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Menipis</div>
        <div class="stat-card-value" style="color: #ef4444;">
            {{ $semuaBahan->filter(fn($b) => $b->stok_sisa <= $b->stok_minimum)->count() }}
        </div>
        <div class="stat-card-sub">Perlu segera restock</div>
    </div>
</div>

<!-- Stock Table -->
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
                <th style="text-align:center">Status</th>
                @if(Auth::user()->isAdmin())
                <th style="text-align:center">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($semuaBahan as $index => $bahan)
            <tr>
                <td class="cell-bold">{{ $index + 1 }}</td>
                <td class="cell-bold">{{ $bahan->nama_bahan }}</td>
                <td class="cell-bold">{{ number_format($bahan->stok_sisa, 0, ',', '.') }}</td>
                <td>{{ $bahan->satuan }}</td>
                <td>{{ number_format($bahan->stok_minimum, 0, ',', '.') }}</td>
                <td style="text-align:center">
                    @if($bahan->stok_sisa <= $bahan->stok_minimum)
                        <span style="color: #dc2626; font-weight: 600; font-size: 13px;">Menipis</span>
                    @else
                        <span style="color: #15803d; font-weight: 600; font-size: 13px;">Aman</span>
                    @endif
                </td>
                @if(Auth::user()->isAdmin())
                <td style="text-align:center">
                    <form action="{{ route('bahan-baku.destroy', $bahan->id) }}" method="POST"
                          onsubmit="return confirm('Hapus bahan baku &quot;{{ $bahan->nama_bahan }}&quot;?\n\nSeluruh riwayat stok terkait juga akan ikut terhapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:#ef4444; background:none; border:none; cursor:pointer; font-size:12px; font-weight:600;">Hapus</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection