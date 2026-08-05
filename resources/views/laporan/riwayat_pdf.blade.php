<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Log Gudang Kedai Kopi Rekan Setia</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1a1a1a; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h2 { margin: 0; padding: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; color: #0f172a; }
        .header p { margin: 4px 0 0; font-size: 11px; color: #475569; }
        hr { border: none; border-top: 2px solid #334155; margin: 10px 0 8px; }

        .meta-table { width: 100%; font-size: 10px; color: #64748b; margin-bottom: 10px; }
        .meta-table td { border: none; padding: 0; }

        .filter-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
            font-size: 11px;
            color: #78350f;
        }
        .filter-all {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
            font-size: 11px;
            color: #0c4a6e;
        }
        .filter-row { margin-bottom: 3px; }

        table.data { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.data th, table.data td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; font-size: 10px; }
        table.data th { background-color: #f1f5f9; font-weight: 700; text-transform: uppercase; font-size: 9px; letter-spacing: 0.5px; color: #334155; }
        table.data tr:nth-child(even) td { background-color: #f8fafc; }

        .badge-masuk  { color: #15803d; font-weight: bold; }
        .badge-keluar { color: #dc2626; font-weight: bold; }

        .summary-box { margin-top: 14px; border-top: 1px solid #cbd5e1; padding-top: 10px; }
        .summary-table { width: 100%; font-size: 11px; }
        .summary-table td { border: none; padding: 3px 0; }
        .summary-label { color: #475569; }
        .summary-val-masuk  { color: #15803d; font-weight: 700; text-align: right; }
        .summary-val-keluar { color: #dc2626; font-weight: 700; text-align: right; }
        .summary-val-total  { color: #0f172a; font-weight: 700; text-align: right; }

        .footer { margin-top: 20px; font-size: 10px; color: #94a3b8; text-align: center; }
        .no-data { text-align: center; padding: 20px; color: #94a3b8; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Kedai Kopi Rekan Setia</h2>
        <p>Laporan Aktivitas Mutasi Stok Gudang</p>
        <hr>
        <table class="meta-table">
            <tr>
                <td style="text-align: left;">Sistem Inventory Kedai Kopi Rekan Setia</td>
                <td style="text-align: right;">Dicetak pada: {{ date('d-m-Y H:i') }}</td>
            </tr>
        </table>
    </div>

    {{-- INFO FILTER --}}
    @php
        $adaFilter  = $tanggalMulai || $tanggalSelesai || $jenis || $namaBahan;
        // Tentukan jenis mutasi dari data aktual (bukan hanya dari filter)
        $adaMasuk   = $riwayat->where('jenis', 'Masuk')->count() > 0;
        $adaKeluar  = $riwayat->where('jenis', 'Keluar')->count() > 0;
        if ($adaMasuk && $adaKeluar) {
            $labelJenis = 'MASUK - KELUAR';
        } elseif ($adaMasuk) {
            $labelJenis = 'MASUK';
        } elseif ($adaKeluar) {
            $labelJenis = 'KELUAR';
        } else {
            $labelJenis = '-';
        }
    @endphp

    @if($adaFilter)
    <div class="filter-box">
        @if($tanggalMulai && $tanggalSelesai)
        <span class="filter-row">Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }} &mdash; {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d F Y') }}</span><br>
        @elseif($tanggalMulai)
        <span class="filter-row">Dari: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }}</span><br>
        @elseif($tanggalSelesai)
        <span class="filter-row">Sampai: {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d F Y') }}</span><br>
        @endif
        <span class="filter-row">Jenis Mutasi: <strong>{{ $labelJenis }}</strong></span><br>
        @if($namaBahan)
        <span class="filter-row">Bahan Baku: <strong>{{ $namaBahan }}</strong></span><br>
        @endif
        <span class="filter-row">Total record: <strong>{{ $riwayat->count() }}</strong></span>
    </div>
    @else
    <div class="filter-all">
        <strong>Laporan Lengkap:</strong>
        Jenis Mutasi: <strong>{{ $labelJenis }}</strong> &nbsp;|&nbsp;
        Seluruh riwayat aktivitas stok gudang ({{ $riwayat->count() }} record)
    </div>
    @endif

    {{-- TABEL DATA --}}
    <table class="data">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="16%">Tanggal & Waktu</th>
                <th width="22%">Bahan Baku</th>
                <th width="10%">Status</th>
                <th width="10%">Jumlah</th>
                <th width="8%">Satuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $key => $row)
            <tr>
                <td style="text-align: center;">{{ $key + 1 }}</td>
                <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                <td><strong>{{ $row->bahanBaku->nama_bahan ?? 'Bahan Terhapus' }}</strong></td>
                <td>
                    <span class="{{ $row->status == 'MASUK' ? 'badge-masuk' : 'badge-keluar' }}">
                        {{ $row->status }}
                    </span>
                </td>
                <td style="text-align: right;">{{ number_format($row->jumlah, 0, ',', '.') }}</td>
                <td>{{ $row->bahanBaku->satuan ?? '-' }}</td>
                <td>{{ $row->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="no-data">
                    Tidak ada data riwayat pada filter yang dipilih.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- RINGKASAN / SUMMARY --}}
    @if($riwayat->count() > 0)
    @php
        $countMasuk  = $riwayat->where('jenis', 'Masuk')->count();
        $countKeluar = $riwayat->where('jenis', 'Keluar')->count();
    @endphp
    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td class="summary-label">Total Transaksi Masuk (Restock):</td>
                <td class="summary-val-masuk">{{ $countMasuk }} transaksi</td>
            </tr>
            <tr>
                <td class="summary-label">Total Transaksi Keluar (Penyusutan):</td>
                <td class="summary-val-keluar">{{ $countKeluar }} transaksi</td>
            </tr>
        </table>
    </div>
    @endif

    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh Sistem Inventory Kedai Kopi Rekan Setia &mdash; {{ date('d-m-Y H:i:s') }}
    </div>

</body>
</html>