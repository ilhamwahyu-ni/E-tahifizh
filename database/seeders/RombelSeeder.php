<?php

namespace Database\Seeders;

use App\Models\Rombel;
use App\Models\Sekolah;      // Import Sekolah
use App\Models\TahunAjaran; // Import TahunAjaran
use App\Models\TmKelas;     // Import TmKelas
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Recommended import
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import exception

class RombelSeeder extends Seeder
{
    // use WithoutModelEvents; // Uncomment if needed, depends on your event listeners

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing related models (assuming they were seeded before by DatabaseSeeder)
        $sekolahs = Sekolah::all();
        $tmKelases = TmKelas::all();

        // Get the specific TahunAjaran record
        try {
            $tahunAjaran = TahunAjaran::where('nama', 'Tahun Ajaran 2024/2026')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            if ($this->command) {
                $this->command->error('Specific Tahun Ajaran "Tahun Ajaran 2024/2026" not found. Please ensure TahunAjaranSeeder runs first and creates this record.');
            }
            return; // Stop if the specific TahunAjaran isn't found
        }

        // Check if other related models exist
        if ($sekolahs->isEmpty() || $tmKelases->isEmpty()) {
             // Use command output if running via artisan console
             if ($this->command) {
                 $this->command->warn('Missing required related data (Sekolah or TmKelas). Cannot seed Rombels effectively.');
             }
             // Optionally, create default ones if needed, or just return
             // Sekolah::factory()->create();
             // TmKelas::factory()->create();
             // $sekolahs = Sekolah::all(); // Re-fetch after creation
             // $tmKelases = TmKelas::all();
             return; // Stop if prerequisites aren't met
        }

        Rombel::factory()
            ->count(5) // Create 5 Rombels (adjust as needed)
            ->recycle($sekolahs)     // Recycle from existing Sekolahs (can still be multiple)
            ->recycle($tahunAjaran)  // Recycle the *specific* TahunAjaran instance
            ->recycle($tmKelases)    // Recycle from existing TmKelas instances (can still be multiple)
            ->create();
    }
}
