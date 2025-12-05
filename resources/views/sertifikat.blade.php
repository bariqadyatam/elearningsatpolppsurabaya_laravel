<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        @page {
            margin: 0;
            size: 1950px 1270px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('{{ public_path("hasil.png") }}');
            background-size: cover;
            background-repeat: no-repeat;
            width: 1950px;
            height: 1270px;
            position: relative;
        }

        .nama {
            position: absolute;
            top: 600px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 72px;
            font-weight: bold;
            color: #000000;
        }
        .no{
            position: absolute;
            top: 400px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #000000;
        }
        .pernyataan{
            position: absolute;
            top: 440px;
            left: 15%;
            width: 70%;
            text-align: center;
            font-size: 30px;
            font-weight: medium;
            color: #000000;
        }

        .materi {
            position: absolute;
            top: 750px;
            left: 15%;
            width: 70%;
            text-align: center;
            font-size: 30px;
            color: #2c2c2c;
        }
        .jenis {
            position: absolute;
            top: 730px;
            left: 15%;
            width: 70%;
            text-align: center;
            font-size: 24px;
            color: #2c2c2c;
        }

        .deskripsi {
            position: absolute;
            top: 830px;
            left: 25%;
            width: 50%;
            text-align: center;
            font-size: 24px;
            color: #333333;
        }

        .tanggal {
            position: absolute;
            bottom: 280px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 32px;
            color: #333333;
        }
    </style>
</head>
<body>
    <div class="no">{{ $nomor_sertifikat }}</div>
    <div class="pernyataan">{{$pernyataan_sertifikat}}</div>
    <div class="nama">{{ $nama }}</div>
    <div class="nama">{{ $nama }}</div>
    <div class="jenis">Telah Mengikuti Pembelajaran  {{ $kategori ?? 'Telah Mengikuti Pembelajaran kategori' }}</div>
    <div class="materi">{{ $judul_materi ?? 'Telah Mengikuti Pembelajaran kategori' }}</div>
    <div class="deskripsi">{{$keterangan_sertifikat}}</div>
    <div class="tanggal">Surabaya, {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</div>
    @if($ttd_base64)
    <img src="{{ $ttd_base64 }}" 
     style="position: absolute; bottom: 110px; left: 50%; transform: translateX(-50%); height: 150px;">

    @endif


</body>
</html>
