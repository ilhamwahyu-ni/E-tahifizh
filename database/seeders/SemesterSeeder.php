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

        // Create Ganjil semester using recycle
        Semester::factory()
            ->recycle($tahunAjaran) // Recycle the specific TahunAjaran instance
            ->create([
                'nama' => 'Ganjil',
                'status' => 'aktif', // Default status
            ]);

        // Create Genap semester using recycle
        Semester::factory()
            ->recycle($tahunAjaran) // Recycle the specific TahunAjaran instance
            ->create([
                'nama' => 'Genap',
                'status' => 'nonaktif', // Default status, maybe only one is active? Adjust if needed.
            ]);
    }
}
