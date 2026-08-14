@extends('layouts.app')

@section('page_title', 'Live Monitoring Stok')
@section('page_subtitle', 'Pantau kondisi stok bahan baku gudang secara real-time')

@section('content')

@php
    // Pisahkan collection: aktif saja untuk statistik
    $bahanAktif = $semuaBahan->where('is_active', true);
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
            {{ $bahanAktif->filter(fn($b) => $b->stok_sisa > $b->stok_minimum)->count() }}
        </div>
        <div class="stat-card-sub">Bahan aktif di atas batas minimum</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-label">Stok Menipis</div>
        <div class="stat-card-value" style="color: #ef4444;">
            {{ $bahanAktif->filter(fn($b) => $b->stok_sisa <= $b->stok_minimum)->count() }}
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
                        <span style="color: #dc2626; font-weight: 600; font-size: 13px;">Menipis</span>
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
@endsection