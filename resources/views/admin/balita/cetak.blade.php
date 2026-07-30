<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Balita</title>
    <style>
        @page {
            margin: 25px 20px;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10px;
            color: #1e2129;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
            border-bottom: 2px solid #3b5bfd;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            color: #3b5bfd;
        }
        .header p {
            margin: 2px 0 0;
            font-size: 9px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background-color: #3b5bfd;
            color: #ffffff;
            padding: 6px 4px;
            text-align: left;
            font-size: 9px;
        }
        tbody td {
            padding: 5px 4px;
            border-bottom: 1px solid #e2e5ec;
            font-size: 9px;
        }
        tbody tr:nth-child(even) {
            background-color: #f7f8fb;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            font-size: 8px;
            color: #999;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Data Balita</h2>
        <p>Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama Balita</th>
                <th class="text-center">Umur</th>
                <th class="text-center">JK</th>
                <th class="text-center">TB (cm)</th>
                <th class="text-center">BB (kg)</th>
                <th>Alamat</th>
                <th>Ekonomi</th>
                <th>Sanitasi</th>
                <th>Riwayat ASI</th>
                <th>Imunisasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($balita as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_balita }}</td>
                    <td class="text-center">{{ $item->umur }} bln</td>
                    <td class="text-center">{{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="text-center">{{ $item->tinggi_badan }}</td>
                    <td class="text-center">{{ $item->berat_badan }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->kondisi_ekonomi }}</td>
                    <td>{{ $item->sanitasi_lingkungan }}</td>
                    <td>{{ $item->riwayat_asi }}</td>
                    <td>{{ $item->status_imunisasi_dasar }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">Belum ada data balita.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total data: {{ $balita->count() }} balita
    </div>

</body>
</html>