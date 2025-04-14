<?php

namespace Database\Seeders;

use App\Models\RekapSemesterSiswa;
use App\Models\Siswa; // Import Siswa
use App\Models\Semester; // Import Semester
use App\Models\TahunAjaran; // Import TahunAjaran
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import exception
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Recommended import

class RekapSemesterSiswaSeeder extends Seeder
{
    // use WithoutModelEvents; // Uncomment if needed

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Find the specific TahunAjaran
        try {
            $tahunAjaran = TahunAjaran::where('nama', 'Tahun Ajaran 2024/2026')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            if ($this->command) {
                $this->command->error('Specific Tahun Ajaran "Tahun Ajaran 2024/2026" not found. Cannot seed RekapSemesterSiswa.');
            }
            return;
        }

        // 2. Find Semesters belonging ONLY to this TahunAjaran
        $semesters = Semester::where('tahun_ajaran_id', $tahunAjaran->id)->get();
        if ($semesters->isEmpty()) {
            if ($this->command) {
                $this->command->warn("No Semesters found for Tahun Ajaran ID {$tahunAjaran->id}. Skipping RekapSemesterSiswa seeding.");
            }
            return;
        }

        // 3. Find Siswa belonging to Rombels associated with this TahunAjaran
        // Assumes Siswa->rombel->tahunAjaran relationship exists
        $siswas = Siswa::whereHas('rombel', function ($query) use ($tahunAjaran) {
            $query->where('tahun_ajaran_id', $tahunAjaran->id);
        })->get();

        if ($siswas->isEmpty()) {
            if ($this->command) {
                $this->command->warn("No Siswa found associated with Rombels for Tahun Ajaran ID {$tahunAjaran->id}. Skipping RekapSemesterSiswa seeding.");
            }
            return;
        }

        // 4. Create RekapSemesterSiswa for combinations
        // Create one rekap per siswa per semester for this tahun ajaran
        foreach ($siswas as $siswa) {
            foreach ($semesters as $semester) {
                RekapSemesterSiswa::factory()
                    ->recycle($siswa)    // Use this specific Siswa
                    ->recycle($semester) // Use this specific Semester
                    ->create();
                    // Add any specific attributes needed for the rekap here if necessary
                    // ->create(['catatan_global' => 'Generated during seeding.']);
            }
        }

        // // Alternative: Create a fixed number of random combinations
        // // This might be less realistic but simpler if you just need some data.
        // if (!$siswas->isEmpty() && !$semesters->isEmpty()) {
        //     for ($i = 0; $i < 10; $i++) { // Create 10 random rekaps
        //         RekapSemesterSiswa::factory()
        //             ->recycle($siswas->random())
        //             ->recycle($semesters->random())
        //             ->create();
        //     }
        // }
    }
}
