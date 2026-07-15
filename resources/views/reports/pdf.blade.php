<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi KKN</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #18181b; }
        .title { font-size: 22px; font-weight: 800; margin-bottom: 4px; }
        .subtitle { color: #71717a; margin-bottom: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #ea580c; color: white; text-align: left; padding: 8px; }
        td { border: 1px solid #fed7aa; padding: 7px; }
        tr:nth-child(even) td { background: #fff7ed; }
        .count { text-align: center; font-weight: 700; }
    </style>
</head>
<body>
    <div class="title">Laporan Absensi Peserta KKN</div>
    <div class="subtitle">Tanggal status hari: {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Status Kehadiran Hari</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Pulang</th>
                <th>Alfa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    <td>{{ $row['nama'] }}</td>
                    <td>{{ $row['status_kehadiran_hari'] }}</td>
                    <td class="count">{{ $row['hadir'] }}</td>
                    <td class="count">{{ $row['izin'] }}</td>
                    <td class="count">{{ $row['pulang'] }}</td>
                    <td class="count">{{ $row['alfa'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
