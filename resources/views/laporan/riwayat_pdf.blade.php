<!DOCTYPE html>
<html>
<head>
    <title>Laporan Log Gudang Kedai Kopi Rekan Setia</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1a1a1a; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 4px 0 0; font-size: 12px; color: #555; }
        hr { border: none; border-top: 2px solid #333; margin: 10px 0 6px; }
        .meta { display: flex; justify-content: space-between; font-size: 10px; color: #666; margin-bottom: 4px; }
        .filter-info {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
            font-size: 11px;
            color: #78350f;
        }
        .filter-info strong { font-weight: 700; }
        .filter-all {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
            font-size: 11px;
            color: #0c4a6e;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        th, td { border: 1px solid #ccc; padding: 7px 10px; text-align: left; font-size: 11px; }
        th { background-color: #f2f2f2; font-weight: 700; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; color: #444; }
        tr:nth-child(even) td { background-color: #fafafa; }
        .badge-masuk { color: #15803d; font-weight: bold; }
        .badge-keluar { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 10px; color: #888; text-align: center; }
        .no-data { text-align: center; padding: 20px; color: #888; font-style: italic; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Kedai Kopi Rekan Setia</h2>
        <p>Laporan Aktivitas Log Mutasi Stok Gudang</p>
        <hr>
        <div class="meta">
            <span>Sistem Inventory Kedai Kopi Rekan Setia</span>
            <span>Dicetak pada: {{ date('d-m-Y H:i') }}</span>
        </div>
    </div>

    {{-- Info Filter Tanggal --}}
    @if($tanggalMulai && $tanggalSelesai)
    <div class="filter-info">
        <strong>📅 Periode Laporan:</strong>
        {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }}
        &nbsp;—&nbsp;
        {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d F Y') }}
        &nbsp;|&nbsp; Total: {{ $riwayat->count() }} record
    </div>
    @else
    <div class="filter-all">
        <strong>📋 Laporan Lengkap:</strong> Menampilkan seluruh riwayat aktivitas stok gudang ({{ $riwayat->count() }} record)
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="16%">Tanggal & Waktu</th>
                <th width="22%">Bahan Baku</th>
                <th width="10%">Status</th>
                <th width="10%">Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $key => $row)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $row->bahanBaku->nama_bahan ?? 'Bahan Terhapus' }}</td>
                <td>
                    <span class="{{ $row->status == 'MASUK' ? 'badge-masuk' : 'badge-keluar' }}">
                        {{ $row->status }}
                    </span>
                </td>
                <td>{{ number_format($row->jumlah, 0, ',', '.') }}</td>
                <td>{{ $row->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="no-data">
                    Tidak ada data riwayat pada periode yang dipilih.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh Sistem Inventory Kedai Kopi Rekan Setia &mdash; {{ date('d-m-Y H:i:s') }}
    </div>

</body>
</html>