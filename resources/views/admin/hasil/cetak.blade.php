<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SPK Stunting</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header h3 { margin: 5px 0 0; font-size: 13px; font-weight: normal; }
        .header p { margin: 5px 0 0; font-size: 10px; color: #666; }
        .title { text-align: center; margin-bottom: 20px; }
        .title h4 { margin: 0; font-size: 13px; text-transform: uppercase; }
        .title p { margin: 5px 0 0; font-size: 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background: #f5f5f5; font-weight: bold; text-align: left; border: 1px solid #ddd; padding: 7px; }
        td { border: 1px solid #ddd; padding: 7px; }
        tr:nth-child(even) { background: #fbfbfb; }
        .badge { display: inline-block; padding: 2px 6px; font-size: 10px; font-weight: bold; color: #fff; border-radius: 4px; }
        .badge-danger { background: #d9534f; }
        .badge-warning { background: #f0ad4e; color: #333; }
        .badge-success { background: #5cb85c; }
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; display: inline-block; text-align: center; width: 200px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Pemerintah Kabupaten Brebes</h2>
        <h3>Puskesmas Losari</h3>
        <p>Jl. Raya Losari TImur No. 44, Kecipir, Losari, Losari Kidul, Kec. Losari, Kabupaten Brebes, Jawa Tengah 52255</p>
    </div>
    <div class="title">
        <h4>Laporan Hasil Pemeringkatan Risiko Stunting Balita</h4>
        <p>Metode Simple Additive Weighting (SAW) — Tanggal: {{ date('d-m-Y') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:8%; text-align:center;">Ranking</th>
                <th style="width:25%;">Nama Balita</th>
                <th style="width:10%; text-align:center;">Umur</th>
                <th>Alamat</th>
                <th style="width:15%; text-align:center;">Skor (V)</th>
                <th style="width:15%; text-align:center;">Risiko</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil as $item)
                @php $kategori = \App\Services\SawService::kategoriRisiko($item->nilai_preferensi); @endphp
                <tr>
                    <td style="text-align:center; font-weight:bold;">{{ $item->ranking }}</td>
                    <td>{{ $item->balita->nama_balita }}</td>
                    <td style="text-align:center;">{{ $item->balita->umur }} bln</td>
                    <td>{{ $item->balita->alamat }}</td>
                    <td style="text-align:center; font-weight:bold; color:#1e3c72;">{{ $item->nilai_preferensi }}</td>
                    <td style="text-align:center;">
                        <span class="badge {{ $kategori === 'Risiko Tinggi' ? 'badge-danger' : ($kategori === 'Risiko Sedang' ? 'badge-warning' : 'badge-success') }}">{{ $kategori }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Losari, {{ date('d F Y') }}</p>
        <div class="signature">
            <p>Kepala Puskesmas Losari</p>
            <br><br><br>
            <p><strong>( ____________________ )</strong></p>
            <p>NIP. .................................</p>
        </div>
    </div>
</body>
</html>
