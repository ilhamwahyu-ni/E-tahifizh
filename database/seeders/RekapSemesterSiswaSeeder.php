<?php

namespace Database\Seeders;

use App\Models\RekapSemesterSiswa;
use App\Models\Siswa;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Log;

class RekapSemesterSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Cari Tahun Ajaran spesifik (sesuaikan nama jika perlu)
        $targetTahunAjaran = 'Tahun Ajaran 2024/2026'; // <-- Pastikan nama ini ada di DB Anda
        try {
            $tahunAjaran = TahunAjaran::where('nama', $targetTahunAjaran)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            if ($this->command) {
                $this->command->error("Tahun Ajaran \"{$targetTahunAjaran}\" tidak ditemukan. Seeder RekapSemesterSiswa tidak bisa dijalankan.");
            }
            return;
        }

        // 2. Cari Semester yang HANYA milik Tahun Ajaran ini
        $semesters = Semester::where('tahun_ajaran_id', $tahunAjaran->id)->get();
        if ($semesters->isEmpty()) {
            if ($this->command) {
                $this->command->warn("Tidak ada Semester ditemukan untuk Tahun Ajaran ID {$tahunAjaran->id}. Seeder RekapSemesterSiswa dilewati.");
            }
            return;
        }

        // 3. Cari Siswa yang Rombelnya terkait dengan Tahun Ajaran ini
        $siswas = Siswa::whereHas('rombel', function ($query) use ($tahunAjaran) {
            $query->where('tahun_ajaran_id', $tahunAjaran->id);
        })->get();

        if ($siswas->isEmpty()) {
            if ($this->command) {
                $this->command->warn("Tidak ada Siswa pada Rombel Tahun Ajaran ID {$tahunAjaran->id}. Seeder RekapSemesterSiswa dilewati.");
            }
            return;
        }

        $this->command->info("Membuat/Memperbarui Rekap Semester Siswa untuk Tahun Ajaran {$tahunAjaran->nama} (updateOrCreate)...");

        // 4. Buat/Update RekapSemesterSiswa untuk setiap kombinasi Siswa dan Semester
        foreach ($siswas as $siswa) {
            foreach ($semesters as $semester) {
                try {
                    RekapSemesterSiswa::updateOrCreate(
                        [
                            // Kunci unik untuk mencari record yang ada
                            'siswa_id' => $siswa->id,
                            'semester_id' => $semester->id,
                            // Catatan: Pastikan tabel rekap_semester_siswas TIDAK punya tahun_ajaran_id
                            // Jika ADA, tambahkan juga di sini: 'tahun_ajaran_id' => $tahunAjaran->id,
                        ],
                        [
                            // Nilai yang akan diisi/diperbarui
                            // Gunakan helper fake() untuk data dummy
                            'catatan_global_hafalan' => fake()->paragraph(1),
                            'catatan_global_tahsin' => fake()->paragraph(1),
                            // Tambahkan nilai default lain jika ada kolom lain di $fillable
                        ]
                    );
                } catch (\Exception $e) {
                    if ($this->command) {
                        $this->command->error("Gagal membuat/update rekap untuk Siswa ID: {$siswa->id}, Semester ID: {$semester->id}. Error: " . $e->getMessage());
                    }
                    Log::error("Seeder RekapSemesterSiswa (updateOrCreate) Error", [
                        'siswa_id' => $siswa->id,
                        'semester_id' => $semester->id,
                        'exception' => $e
                    ]);
                }
            }
        }
        $this->command->info('Seeder Rekap Semester Siswa (updateOrCreate) berhasil dijalankan.');
    }
}
