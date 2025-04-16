<?php

namespace Database\Seeders;

use App\Models\Rombel; // Import Rombel
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Recommended import

class SiswaSeeder extends Seeder
{
    // use WithoutModelEvents; // Uncomment if needed

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing Rombels, making sure to load the 'sekolah' relationship
        // This assumes the Rombel model has a `belongsTo` relationship named 'sekolah'
        $rombels = Rombel::with('sekolah')->get();

        // Check if any Rombels exist
        if ($rombels->isEmpty()) {
            // Use command output if running via artisan console
            if ($this->command) {
                $this->command->warn('No Rombels found. Skipping Siswa seeding.');
            }
            return; // Stop if no Rombels to assign Siswa to
        }

        // For each Rombel, create some Siswa instances
        foreach ($rombels as $rombel) {
            // Ensure the rombel has a sekolah loaded - essential for recycling
            if (!$rombel->sekolah) {
                if ($this->command) {
                    $this->command->warn("Rombel ID {$rombel->id} is missing its Sekolah relationship. Skipping Siswa creation for this Rombel.");
                }
                continue; // Skip this Rombel if its Sekolah is missing
            }

            Siswa::factory()
                ->count(32) // Create 10 students per Rombel (adjust count as needed)
                ->recycle($rombel) // Use this specific Rombel instance
                ->recycle($rombel->sekolah) // Use the specific Sekolah instance from this Rombel
                ->create();
            // Note: The factory should handle setting 'rombel_id' and 'sekolah_id'
            // automatically when using recycle with model instances.
        }
    }
}
