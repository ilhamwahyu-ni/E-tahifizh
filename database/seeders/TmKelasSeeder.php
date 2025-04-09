<?php

namespace Database\Seeders;

use App\Models\TmKelas;
use Illuminate\Database\Seeder;

class TmKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = range(1, 6);
        $rombels = ['a', 'b', 'c'];

        foreach ($levels as $level) {
            foreach ($rombels as $rombel) {
                TmKelas::factory()->create([
                    'level' => (string)$level, // Cast level to string as per factory definition
                    'nama_rombel' => $rombel,
                ]);
            }
        }
    }
}
