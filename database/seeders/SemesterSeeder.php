<?php

namespace Database\Seeders;

use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the specific TahunAjaran created in TahunAjaranSeeder
        $tahunAjaran = TahunAjaran::where('tahun', '2024/2026')->first();

        if ($tahunAjaran) {
            // Create Ganjil semester
            Semester::factory()->create([
                'nama' => 'Ganjil',
                'tahun_ajaran_id' => $tahunAjaran->id,
                'status' => 'aktif', // Default status
            ]);

            // Create Genap semester
            Semester::factory()->create([
                'nama' => 'Genap',
                'tahun_ajaran_id' => $tahunAjaran->id,
                'status' => 'nonaktif', // Default status, maybe only one is active? Adjust if needed.
            ]);
        } else {
            // Handle case where the TahunAjaran is not found, maybe log an error or create a default one
            // For now, we'll just skip creating semesters if the specific TahunAjaran doesn't exist.
            // Or, alternatively, create the TahunAjaran here if it's guaranteed to be needed.
            // Let's assume TahunAjaranSeeder runs first.
        }
    }
}
