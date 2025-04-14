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

        foreach ($levels as $level) {
            TmKelas::factory()->create([
                'level' => $level,
            ]);
        }
    }
}
