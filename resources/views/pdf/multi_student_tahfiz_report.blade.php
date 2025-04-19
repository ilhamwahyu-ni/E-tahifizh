<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Raport Tahfiz Kelas</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif !important;
            font-size: 11px;
        }

        .page-container {
            page-break-after: always;
            padding: 5px;
            height: 98%;
            position: relative;
        }

        .page-container:last-child {
            page-break-after: avoid;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 15px;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .content-table th,
        .content-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }

        .content-table th {
            background-color: #f2f2f2;
        }

        .nilai-table th,
        .nilai-table td {
            text-align: center;
        }

        .catatan {
            border: 1px solid black;
            padding: 8px;
            margin-bottom: 10px;
            min-height: 40px;
            font-size: 10px;
        }

        .keterangan {
            margin-bottom: 20px;
            font-size: 9px;
        }

        .signature-section {
            width: 100%;
            margin-top: 25px;
            position: absolute;
            bottom: 30px;
        }

        .signature-box {
            width: 30%;
            float: left;
            text-align: center;
            margin-left: 2%;
            margin-right: 2%;
            font-size: 10px;
        }

        .signature-box.right {
            float: right;
        }

        .signature-box p {
            margin-bottom: 40px;
        }

        .clear {
            clear: both;
        }

        h4 {
            margin-bottom: 5px;
            margin-top: 0;
            text-align: center;
        }

        .header p {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 10px;
        }

        .kepsek-sig {
            margin-top: 15px;
            text-align: center;
            width: 100%;
            font-size: 10px;
        }

        .kepsek-sig p {
            margin-bottom: 40px;
        }
    </style>
</head>

<body>

    {{-- Loop setiap siswa --}}
    @foreach ($students as $student)
        <div class="page-container">
            <div class="header">
                <h4>HASIL EVALUASI TAHFIZ</h4>
                <p>
                    Tahun Ajaran: {{ htmlspecialchars($tahunAjaran->nama ?? '-', ENT_QUOTES, 'UTF-8') }} -
                    Semester: {{ htmlspecialchars($semester->nama_tipe ?? '-', ENT_QUOTES, 'UTF-8') }} <br>
                    Nama Siswa: {{ htmlspecialchars($student->nama ?? '-', ENT_QUOTES, 'UTF-8') }} (NIS:
                    {{ htmlspecialchars($student->nis ?? '-', ENT_QUOTES, 'UTF-8') }}) <br>
                    Kelas/Rombel:
                    {{ htmlspecialchars(optional($student->rombel)->nama_rombel ?? '-', ENT_QUOTES, 'UTF-8') }}
                </p>
            </div>

            <table class="content-table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 5%; text-align: center;">No</th>
                        <th rowspan="2" style="text-align: center;">Nama Surat</th>
                        <th rowspan="2" style="width: 15%; text-align: center;">Ayat</th>
                        <th colspan="2" style="text-align: center;">Nilai</th>
                    </tr>
                    <tr>
                        <th style="width: 10%; text-align: center;">Angka</th>
                        <th style="width: 15%; text-align: center;">Predikat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($student->hafalanSiswas as $index => $hafalan)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ htmlspecialchars(optional($hafalan->surah)->nama_surah ?? '-', ENT_QUOTES, 'UTF-8') }}
                            </td>
                            <td>{{ htmlspecialchars($hafalan->ayat ?? '-', ENT_QUOTES, 'UTF-8') }}</td>
                            <td style="text-align: center;">
                                {{ htmlspecialchars($hafalan->nilai ?? '-', ENT_QUOTES, 'UTF-8') }}</td>
                            <td style="text-align: center;">
                                {{ htmlspecialchars($hafalan->predikat ?? '-', ENT_QUOTES, 'UTF-8') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Belum ada data hafalan untuk semester ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="catatan">
                <strong>Catatan Yang Perlu Diperhatikan:</strong><br>
                {{ htmlspecialchars(optional($student->rekapSemesterSiswa)->catatan_guru ?? 'Tidak ada catatan.', ENT_QUOTES, 'UTF-8') }}
            </div>

            <div class="keterangan">
                <strong>Keterangan Predikat:</strong>
                100-90 : Jayyid Jiddan |
                89-79 : Jayyid |
                78-68 : Maqbul |
                &lt; 68 : Rasib
            </div>

            <div class="signature-section">
                <div class="signature-box">
                    Orang Tua / Wali Murid
                    <p>&nbsp;</p>
                    (..............................)
                </div>

                <div class="signature-box right">
                    {{ htmlspecialchars($lokasi ?? 'Padang Panjang', ENT_QUOTES, 'UTF-8') }},
                    {{ htmlspecialchars($tanggalLaporan ?? date('d F Y'), ENT_QUOTES, 'UTF-8') }} <br>
                    Guru Tahfiz
                    <p>&nbsp;</p>
                    <b><u>{{ htmlspecialchars(optional($student->rombel->guru)->nama ?? 'Nama Guru', ENT_QUOTES, 'UTF-8') }}</u></b>
                </div>

                <div class="clear"></div>

                <div class="kepsek-sig">
                    Mengetahui,<br>
                    Kepala
                    {{ htmlspecialchars(optional($student->sekolah)->nama_sekolah ?? 'Nama Sekolah', ENT_QUOTES, 'UTF-8') }}
                    <p>&nbsp;</p>
                    <b><u>{{ htmlspecialchars($namaKepalaSekolah ?? 'Nama Kepala Sekolah', ENT_QUOTES, 'UTF-8') }}</u></b>
                </div>
            </div>
        </div>
    @endforeach

</body>

</html>
