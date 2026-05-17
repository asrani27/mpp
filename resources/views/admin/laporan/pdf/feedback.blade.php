<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Feedback</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }

        .logo-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
            height: 100px;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            max-height: 100px;
        }

        .header-content {
            margin-left: 100px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 1px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 20px;
            font-weight: bold;
            margin: 1px 0;
            text-transform: uppercase;
        }

        .header p {
            font-size: 12px;
            margin: 3px 0;
        }

        .line {
            border-top: 2px solid black;
            margin: 10px 0 20px 0;
        }

        .judul {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul h4 {
            margin: 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
            font-size: 10px;
        }

        table th {
            font-weight: bold;
            font-size: 12px;
            background-color: rgb(201, 201, 201)
        }

        .rating {
            color: #f59e0b;
        }

        .ttd {
            width: 300px;
            float: right;
            margin-top: 20px;
            text-align: left;
        }

        .ttd p {
            margin: 3px 0;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">

            <div class="logo-container">
                <img src="{{ base_path('public/logo/pp.png') }}" width="80px">
            </div>
            <div class="header-content">
                <h1>PEMERINTAH DAERAH</h1>
                <h2>KABUPATEN PULANG PISAU</h2>
                <p>Jl.Oberlin Metar No 48, Kecamatan Kahayan Hilir, Kabupaten Pulang Pisau, Kalimantan Tengah 74871
                </p>
                    <br/>
            </div>

        </div>

        <div class="line"></div>

        <div class="judul">
            <h4>LAPORAN DATA FEEDBACK MASYARAKAT</h4>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                </tr>
            </thead>

            <tbody>
                @foreach($feedback as $index => $f)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($f->tanggal)->translatedFormat('d/m/Y') }}</td>
                    <td>{{ $f->user->name ?? '-' }}</td>
                    <td class="rating">
                        {{ str_repeat('*', $f->rating) }}{{ str_repeat('-', 5 - $f->rating) }} ({{ $f->rating }}/5)
                    </td>
                    <td>{{ $f->komentar }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="ttd">
            <p>Pulang Pisau, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Dinas</p>

            <br><br><br>

            <p><b>nama</b></p>
            <p>NIP.</p>
        </div>

    </div>

</body>

</html>