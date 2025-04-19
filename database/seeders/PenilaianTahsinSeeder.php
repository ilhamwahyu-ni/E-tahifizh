<?php

namespace Database\Seeders;

use App\Models\PenilaianTahsin;
use App\Models\Siswa;
use App\Models\MateriTahsin;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon; // Import Carbon

class PenilaianTahsinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Ambil data prasyarat dari database
        // Kita ambil semua untuk variasi, tapi bisa difilter jika perlu
        $siswas = Siswa::all();
        $materiTahsins = MateriTahsin::all();
        $semesters = Semester::with('tahunAjaran')->get(); // Eager load tahun ajaran
        // $tahunAjarans = TahunAjaran::all(); // Tidak perlu jika sudah di-load via semester

        // Periksa apakah data prasyarat ada
        if ($siswas->isEmpty() || $materiTahsins->isEmpty() || $semesters->isEmpty()) {
            $this->command->error('Seeder Penilaian Tahsin dibatalkan: Data Siswa/Materi/Semester tidak ditemukan.');
            return;
        }

        $recordCount = 200; // Jumlah record dummy yang ingin dibuat
        $this->command->info("Membuat {$recordCount} data Penilaian Tahsin (Manual)...");

        for ($i = 0; $i < $recordCount; $i++) {
            // Pilih data relasi secara acak
            $siswa = $siswas->random();
            $materi = $materiTahsins->random();
            $semester = $semesters->random();

            // Pastikan semester memiliki tahun ajaran terkait (seharusnya ada jika relasi benar)
            if (!$semester->tahunAjaran) {
                $this->command->warn("Skipping: Semester ID {$semester->id} tidak memiliki Tahun Ajaran terkait.");
                continue; // Lewati iterasi ini jika tidak ada tahun ajaran
            }
            $tahunAjaranId = $semester->tahunAjaran->id;

            // Generate data penilaian acak
            $nilai = rand(80, 100);
            $tanggal = Carbon::now()->subDays(rand(0, 180))->toDateString();

            // Gunakan updateOrCreate untuk membuat/memperbarui record
            // Kunci unik: kombinasi siswa, materi, semester, tahun ajaran
            PenilaianTahsin::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'materi_tahsin_id' => $materi->id,
                    'semester_id' => $semester->id,
                    'tahun_ajaran_id' => $tahunAjaranId,
                ],
                [
                    'nilai_angka' => $nilai,
                    'tanggal_penilaian' => $tanggal,
                    // created_at dan updated_at akan diisi otomatis oleh Eloquent
                ]
            );
        }

        $this->command->info('Seeder Penilaian Tahsin (Manual) berhasil dijalankan.');
    }
}

