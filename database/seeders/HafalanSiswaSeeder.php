<?php

namespace Database\Seeders;

use App\Models\HafalanSiswa;
use App\Models\Siswa; // Import Siswa
use App\Models\Semester; // Import Semester
use App\Models\Surah; // Import Surah
use App\Models\TahunAjaran; // Import TahunAjaran
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import exception
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Recommended import

class HafalanSiswaSeeder extends Seeder
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
                $this->command->error('Specific Tahun Ajaran "Tahun Ajaran 2024/2026" not found. Cannot seed HafalanSiswa.');
            }
            return;
        }

        // 2. Find Semesters belonging ONLY to this TahunAjaran
        $semesters = Semester::where('tahun_ajaran_id', $tahunAjaran->id)->get();
        if ($semesters->isEmpty()) {
            if ($this->command) {
                $this->command->warn("No Semesters found for Tahun Ajaran ID {$tahunAjaran->id}. Skipping HafalanSiswa seeding.");
            }
            return;
        }

        // 3. Find Siswa belonging to Rombels associated with this TahunAjaran
        $siswas = Siswa::whereHas('rombel', function ($query) use ($tahunAjaran) {
            $query->where('tahun_ajaran_id', $tahunAjaran->id);
        })->get();
        if ($siswas->isEmpty()) {
            if ($this->command) {
                $this->command->warn("No Siswa found associated with Rombels for Tahun Ajaran ID {$tahunAjaran->id}. Skipping HafalanSiswa seeding.");
            }
            return;
        }

        // 4. Find all Surahs (assuming SurahSeeder ran)
        $surahs = Surah::all();
        if ($surahs->isEmpty()) {
            if ($this->command) {
                $this->command->warn("No Surahs found. Skipping HafalanSiswa seeding.");
            }
            return;
        }

        // 5. Create HafalanSiswa records using random valid combinations
        // Create, for example, 50 hafalan records randomly assigning
        // a valid siswa, semester (from the correct TA), and surah.
        $recordCount = 200; // Adjust as needed
        for ($i = 0; $i < $recordCount; $i++) {
            HafalanSiswa::factory()
                ->recycle($siswas->random())    // Recycle a random valid Siswa
                ->recycle($semesters->random()) // Recycle a random valid Semester
                ->recycle($surahs->random())    // Recycle a random Surah
                ->create();
            // Note: The factory will likely set 'tingkat_kelas' based on the Siswa's Rombel->TmKelas,
            // or you might need to adjust the factory or pass it explicitly if needed.
            // ->create(['tingkat_kelas' => $siswa->rombel->tmKelas->tingkat]); // Example if needed
        }

        // // Alternative: Create one record per siswa per surah for one semester?
        // // This might create too many records depending on counts.
        // $targetSemester = $semesters->first(); // e.g., Ganjil
        // if ($targetSemester) {
        //     foreach ($siswas as $siswa) {
        //         foreach ($surahs as $surah) {
        //             HafalanSiswa::factory()
        //                 ->recycle($siswa)
        //                 ->recycle($targetSemester)
        //                 ->recycle($surah)
        //                 ->create();
        //         }
        //     }
        // }
    }
}
