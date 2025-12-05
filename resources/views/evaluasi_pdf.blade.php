<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Evaluasi - {{ $test->nama_test }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        h2,
        h4 {
            text-align: center;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <h2>Laporan Hasil Evaluasi</h2>
    <h4>{{ $test->nama_test }} - Materi: {{ $test->materi->judul }}</h4>
    <hr>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Personel</th>
                <th>Regu</th>
                <th>Kelas</th>
                <th>Skor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->personel->nama ?? '-' }}</td>
                    <td>{{ $row->personel->kategoriRegu->nama ?? '-' }}</td>
                    <td>{{ $row->personel->kategoriRegu->kelas->nama ?? '-' }}</td>
                    <td>{{ $row->skor }}</td>
                    <td>{{ $row->sudah_mengerjakan ? 'Sudah' : 'Belum' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <div style="text-align:right;">
        <p>{{ now()->format('d-m-Y') }}</p>
        <p><strong>Admin Evaluasi</strong></p>
    </div>
</body>

</html>
