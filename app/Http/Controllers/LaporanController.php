<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// // Import model yang diperlukan
// use App\Models\Rombel;
// use App\Models\Semester;
// use App\Models\TahunAjaran;
// use App\Models\Siswa;
// // Import PDF facade dan Response
// use Barryvdh\DomPDF\Facade\Pdf;
// use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\Log; // Import Log facade

// class LaporanController extends Controller
// {
//     public function generateRaportKelasPdf(Rombel $rombel, Semester $semester, TahunAjaran $tahunAjaran)
//     {
//         // Controller menerima instance model langsung berkat route model binding

//         $semesterId = $semester->id;
//         $tahunAjaranId = $tahunAjaran->id;

//         // 1. Ambil SEMUA siswa yang ada di Rombel ini
//         $querySiswa = $rombel->siswas(); // Gunakan nama relasi yang benar (plural)

//         // 2. Ambil data siswa LENGKAP dengan relasi hafalan & rekap yang DIFILTER per periode (gunakan whereHas jika perlu)
//         $students = $querySiswa->with([
//                 'hafalanSiswas' => function ($query) use ($semesterId, $tahunAjaranId) {
//                     $query->where('semester_id', $semesterId)
//                           // Jika TIDAK ADA tahun_ajaran_id di hafalan_siswas:
//                           ->whereHas('semester', function ($subQuery) use ($tahunAjaranId) {
//                               $subQuery->where('tahun_ajaran_id', $tahunAjaranId);
//                           })
//                           // Jika ADA tahun_ajaran_id di hafalan_siswas (setelah migrasi):
//                           // ->where('tahun_ajaran_id', $tahunAjaranId)
//                           ->with('surah')
//                           ->orderBy('created_at', 'asc');
//                 },
//                 'rekapSemesterSiswa' => function ($query) use ($semesterId, $tahunAjaranId) {
//                     $query->where('semester_id', $semesterId)
//                            // Jika TIDAK ADA tahun_ajaran_id di rekap_semester_siswas:
//                           ->whereHas('semester', function ($subQuery) use ($tahunAjaranId) {
//                               $subQuery->where('tahun_ajaran_id', $tahunAjaranId);
//                           });
//                           // Jika ADA tahun_ajaran_id di rekap_semester_siswas (setelah migrasi):
//                           // ->where('tahun_ajaran_id', $tahunAjaranId);
//                 },
//                 'sekolah' // Load relasi sekolah jika diperlukan di view
//             ])
//             ->orderBy('nama', 'asc')
//             ->get();

//         if ($students->isEmpty()) {
//             Log::warning("Percobaan cetak raport kelas gagal: Tidak ada siswa ditemukan untuk Rombel ID {$rombel->id}, Semester ID {$semesterId}, Tahun Ajaran ID {$tahunAjaranId}.");
//             abort(404, 'Tidak ada data siswa di rombel ini untuk periode yang dipilih.');
//         }

//         // 3. Hitung predikat untuk setiap hafalan setiap siswa
//         foreach ($students as $student) {
//              $student->setRelation('rombel', $rombel); // Pastikan relasi rombel ada
//             foreach ($student->hafalanSiswas as $hafalan) {
//                 $hafalan->predikat = $this->hitungPredikat($hafalan->nilai);
//             }
//         }

//         // 4. Siapkan data tambahan
//         $namaKepalaSekolah = "Nama Kepala Sekolah"; // Ambil dari setting/config
//         $lokasi = "Padang Panjang"; // Ambil dari setting/config
//         $tanggalLaporan = now()->translatedFormat('d F Y');

//         $pdfData = [
//             'students' => $students,
//             'semester' => $semester, // Kirim objek semester
//             'tahunAjaran' => $tahunAjaran, // Kirim objek tahun ajaran
//             'namaKepalaSekolah' => $namaKepalaSekolah,
//             'lokasi' => $lokasi,
//             'tanggalLaporan' => $tanggalLaporan,
//         ];

//         // 5. Generate PDF dari view
//         $pdf = Pdf::loadView('pdf.multi_student_tahfiz_report', $pdfData)
//                   ->setPaper('a4', 'portrait');

//         // 6. Buat Response Symfony manual untuk preview (inline)
//         $namaFile = 'raport-tahfiz-' . str_replace(['/', '\\'], '-', optional($rombel)->nama_rombel ?? 'unknown') . '-' . optional($semester)->nama_tipe ?? 'unknown' . '-' . str_replace('/', '-', optional($tahunAjaran)->nama ?? 'unknown') . '.pdf';


//         return new Response(
//             $pdf->output(),
//             200, // Status OK (integer)
//             [
//                 'Content-Type' => 'application/pdf',
//                 'Content-Disposition' => 'inline; filename="' . $namaFile . '"',
//             ]
//         );
//     }

//     // Helper function
//     protected function hitungPredikat($nilai)
//     {
//         if ($nilai === null) return '-';
//         return match (true) {
//             $nilai >= 90 => 'Jayyid Jiddan',
//             $nilai >= 79 => 'Jayyid',
//             $nilai >= 68 => 'Maqbul',
//             default => 'Rasib',
//         };
//     }
// }
