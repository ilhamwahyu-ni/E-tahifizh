<?php

namespace App\Filament\Resources\RombelResource\Pages;

use Filament\Actions;

use App\Models\Semester;

use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
// Import PDF facade
use App\Models\Rombel; // Model Rombel
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\RombelResource;
use Symfony\Component\HttpFoundation\Response;
use Filament\Forms\Components\Select; // Komponen form

class EditRombel extends EditRecord
{
    protected static string $resource = RombelResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),

            // --- Action untuk Cetak Raport Tahfiz Kelas (Logika Langsung) ---
            Actions\Action::make('cetakRaportKelasPeriode')
                ->label('Cetak Raport Kelas')
                ->icon('heroicon-o-printer')
                ->color('info')
                // Tetap gunakan form HANYA untuk memilih Semester
                ->form([
                    Select::make('semester_id')
                        ->label('Pilih Semester Laporan')
                        ->options(
                            \App\Models\Semester::all()->pluck('nama_tipe', 'id') // Gunakan accessor
                        )
                        ->required()
                        ->placeholder('Pilih Semester'),
                ])
                // Gunakan ->action() untuk proses server-side
                ->action(function (array $data): ?Response { // Return type bisa Response atau null
                    // Dapatkan record Rombel yang sedang diedit
                    $rombel = $this->record;
                    $semesterId = $data['semester_id'] ?? null; // Ambil semester_id dari form
                    $tahunAjaranId = $rombel->tahun_ajaran_id ?? null; // Ambil tahun_ajaran_id dari Rombel

                    // --- VALIDASI ---
                    if (!$rombel || !$tahunAjaranId || !$semesterId) {
                        Log::error('Gagal memproses raport: Data Rombel/Semester/Tahun Ajaran tidak lengkap.', [
                            'rombel_id' => $rombel?->id,
                            'tahun_ajaran_id' => $tahunAjaranId,
                            'data_form' => $data
                        ]);
                        Notification::make()
                            ->title('Gagal memproses: Data tidak lengkap')
                            ->body('Pastikan Rombel memiliki Tahun Ajaran dan Anda memilih Semester.')
                            ->danger()->send();
                        return null; // Hentikan aksi jika data tidak lengkap
                    }
                    // --- AKHIR VALIDASI ---

                    try {
                        // 1. Ambil SEMUA siswa yang ada di Rombel ini
                        $querySiswa = $rombel->siswa(); // Gunakan nama relasi yang benar

                        // 2. Ambil data siswa LENGKAP dengan relasi yang DIFILTER
                        $students = $querySiswa->with([
                            'hafalanSiswas' => function ($query) use ($semesterId, $tahunAjaranId) {
                            $query->where('semester_id', $semesterId)
                                ->whereHas('semester', function ($subQuery) use ($tahunAjaranId) {
                                    $subQuery->where('tahun_ajaran_id', $tahunAjaranId);
                                })->with('surah')->orderBy('created_at', 'asc');
                        },
                            'rekapSemesterSiswas' => function ($query) use ($semesterId, $tahunAjaranId) {
                            $query->where('semester_id', $semesterId)
                                ->whereHas('semester', function ($subQuery) use ($tahunAjaranId) {
                                    $subQuery->where('tahun_ajaran_id', $tahunAjaranId);
                                });
                        },
                            'sekolah'
                        ])
                            ->orderBy('nama', 'asc')
                            ->get();

                        if ($students->isEmpty()) {
                            Notification::make()->title('Tidak ada data siswa untuk periode ini.')->warning()->send();
                            return null; // Hentikan jika tidak ada siswa
                        }

                        // 3. Hitung predikat
                        foreach ($students as $student) {
                            $student->setRelation('rombel', $rombel);
                            foreach ($student->hafalanSiswas as $hafalan) {
                                $hafalan->predikat = $this->hitungPredikat($hafalan->nilai);
                            }
                        }

                        // 4. Siapkan data tambahan
                        $semester = Semester::find($semesterId); // Ambil objek Semester
                        $tahunAjaran = TahunAjaran::find($tahunAjaranId); // Ambil objek TahunAjaran
                        $namaKepalaSekolah = "Nama Kepala Sekolah";
                        $lokasi = "Padang Panjang";
                        $tanggalLaporan = now()->translatedFormat('d F Y');

                        $pdfData = [
                            'students' => $students,
                            'semester' => $semester, // Kirim objek
                            'tahunAjaran' => $tahunAjaran, // Kirim objek
                            'namaKepalaSekolah' => $namaKepalaSekolah,
                            'lokasi' => $lokasi,
                            'tanggalLaporan' => $tanggalLaporan,
                        ];

                        // 5. Generate PDF
                        $pdf = Pdf::loadView('pdf.multi_student_tahfiz_report', $pdfData)
                            ->setPaper('a4', 'portrait');

                        // 6. Buat Response Symfony manual untuk preview (inline)
                        $namaFile = 'raport-tahfiz-' . str_replace(['/', '\\'], '-', optional($rombel)->nama_rombel ?? 'unknown') . '-' . optional($semester)->nama_tipe ?? 'unknown' . '-' . str_replace('/', '-', optional($tahunAjaran)->nama ?? 'unknown') . '.pdf';
                        return $pdf->download($namaFile);
                        // Kembalikan response langsung dari action
                        // return new Response(
                        //     $pdf->output(),
                        //     200,
                        //     [
                        //         'Content-Type' => 'application/pdf',
                        //         'Content-Disposition' => 'inline; filename="' . $namaFile . '"',
                        //     ]
                        // );

                    } catch (\Exception $e) {
                        Log::error('Error saat generate PDF raport: ' . $e->getMessage(), [
                            'rombel_id' => $this->record?->id,
                            'data' => $data,
                            'exception' => $e
                        ]);
                        Notification::make()
                            ->title('Terjadi Kesalahan Sistem')
                            ->body('Gagal membuat laporan PDF. Silakan cek log.')
                            ->danger()->send();
                        return null; // Hentikan jika ada error
                    }
                })
            // HAPUS ->url(...) dan ->shouldOpenUrlInNewTab(true)
            , // Koma jika DeleteAction ada setelah ini
            // Akhir Action Cetak Raport

            // Actions\DeleteAction::make(), // Pindahkan DeleteAction ke akhir jika perlu
        ];
    }

    // Pastikan helper function ini ada di dalam class EditRombel
    protected function hitungPredikat($nilai)
    {
        if ($nilai === null)
            return '-';
        return match (true) {
            $nilai >= 90 => 'Jayyid Jiddan',
            $nilai >= 79 => 'Jayyid',
            $nilai >= 68 => 'Maqbul',
            default => 'Rasib',
        };
    }



    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
