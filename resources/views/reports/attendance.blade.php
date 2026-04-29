<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kehadiran Ekskul</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .school-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .report-title { font-size: 14px; text-transform: uppercase; border-bottom: 2px solid #000; padding-bottom: 5px; display: inline-block; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 3px 0; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th, table.data td { border: 1px solid #000; padding: 8px; text-align: left; }
        table.data th { background-color: #f2f2f2; }
        .footer { margin-top: 50px; text-align: right; }
        .status-hadir { color: green; font-weight: bold; }
        .status-izin { color: blue; }
        .status-sakit { color: orange; }
        .status-alfa { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">SISTEM MANAJEMEN EKSTRAKURIKULER</div>
        <div class="report-title">Laporan Kehadiran Peserta</div>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="100">Ekstrakurikuler</td>
                <td width="10">:</td>
                <td><strong>{{ $ekskul->nama }}</strong></td>
            </tr>
            <tr>
                <td>Pembina</td>
                <td>:</td>
                <td>{{ $ekskul->pembina->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pelatih</td>
                <td>:</td>
                <td>{{ $ekskul->pelatih->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>:</td>
                <td>{{ now()->translatedFormat('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">NIS</th>
                <th>Nama Siswa</th>
                <th width="100">Total Kehadiran</th>
                <th width="100">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $index => $data)
                <tr>
                    <td align="center">{{ $index + 1 }}</td>
                    <td>{{ $data['nis'] }}</td>
                    <td>{{ $data['nama'] }}</td>
                    <td align="center">{{ $data['hadir'] }} / {{ $data['total_sesi'] }}</td>
                    <td align="center">{{ $data['persentase'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
        <br><br><br>
        <p>( __________________________ )</p>
        <p>Petugas Administrasi</p>
    </div>
</body>
</html>
