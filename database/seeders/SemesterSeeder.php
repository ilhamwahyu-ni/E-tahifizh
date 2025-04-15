<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import exception

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the specific TahunAjaran created in TahunAjaranSeeder
        try {
            // Use firstOrFail to ensure it exists, matching RombelSeeder logic
            $tahunAjaran = TahunAjaran::where('nama', 'Tahun Ajaran 2024/2026')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            if ($this->command) {
                $this->command->error('Specific Tahun Ajaran "Tahun Ajaran 2024/2026" not found. Cannot seed Semesters.');
            }
            return; // Stop if the specific TahunAjaran isn't found
        }

        // Create Ganjil semester using recycle (type 1)
        Semester::factory()
            ->recycle($tahunAjaran) // Recycle the specific TahunAjaran instance
            ->create([
                'type' => 1, // 1: Ganjil
                'is_active' => true, // Default active status
            ]);

        // Create Genap semester using recycle (type 2)
        Semester::factory()
            ->recycle($tahunAjaran) // Recycle the specific TahunAjaran instance
            ->create([
                'type' => 2, // 2: Genap
                'is_active' => false, // Default inactive status
            ]);
    }
}
