<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TahunAjaran::factory()->create([
            'tahun' => '2024/2026',
            'nama' => 'Tahun Ajaran 2024/2026',
            'is_active' => false,
        ]);
    }
}
