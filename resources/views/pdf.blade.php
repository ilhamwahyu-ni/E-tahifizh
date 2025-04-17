<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rombel Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .data-row {
            margin-bottom: 10px;
            padding: 5px;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Data Rombongan Belajar</h2>
    </div>

    <div class="data-row">
        <span class="label">Sekolah:</span>
        <span>{{ $record->sekolah->nama }}</span>
    </div>

    <div class="data-row">
        <span class="label">Tahun Ajaran:</span>
        <span>{{ $record->tahunAjaran->nama }}</span>
    </div>

    <div class="data-row">
        <span class="label">Kelas:</span>
        <span>{{ $record->tmKelas->level }}</span>
    </div>

    <div class="data-row">
        <span class="label">Nama Rombongan:</span>
        <span>{{ $record->nama_rombongan }}</span>
    </div>

    <div class="data-row">
        <span class="label">Status:</span>
        <span>{{ $record->status }}</span>
    </div>
</body>

</html>
