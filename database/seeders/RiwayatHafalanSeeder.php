<?php

namespace Database\Seeders;

use App\Models\RiwayatHafalan;
use App\Models\HafalanSiswa; // Import HafalanSiswa
use App\Models\TahunAjaran; // Import TahunAjaran
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import exception
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Recommended import

class RiwayatHafalanSeeder extends Seeder
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
                $this->command->error('Specific Tahun Ajaran "Tahun Ajaran 2024/2026" not found. Cannot seed RiwayatHafalan.');
            }
            return;
        }

        // 2. Find HafalanSiswa records associated with Semesters from this TahunAjaran
        $hafalanSiswas = HafalanSiswa::whereHas('semester', function ($query) use ($tahunAjaran) {
            $query->where('tahun_ajaran_id', $tahunAjaran->id);
        })->get();

        if ($hafalanSiswas->isEmpty()) {
            if ($this->command) {
                $this->command->warn("No HafalanSiswa records found associated with Semesters for Tahun Ajaran ID {$tahunAjaran->id}. Skipping RiwayatHafalan seeding.");
            }
            return;
        }

        // 3. Create RiwayatHafalan records for each HafalanSiswa
        // Create a few riwayat records for each hafalan
        foreach ($hafalanSiswas as $hafalanSiswa) {
            // Create 1-3 riwayat records per hafalan (adjust as needed)
            $count = rand(1, 3);

            for ($i = 0; $i < $count; $i++) {
                RiwayatHafalan::factory()
                    ->recycle($hafalanSiswa) // Use this specific HafalanSiswa
                    ->create();
            }
        }

        // // Alternative: Create a fixed number of random riwayat records
        // $recordCount = 50; // Adjust as needed
        // for ($i = 0; $i < $recordCount; $i++) {
        //     RiwayatHafalan::factory()
        //         ->recycle($hafalanSiswas->random()) // Recycle a random valid HafalanSiswa
        //         ->create();
        // }
    }
}
