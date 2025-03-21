<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sekolah::create([
            'npsn' => rand(1000000000, 9999999999),
            'nama' => 'Maarif',
            'tahun_ajaran' => '2024',
            'semester' => 1,
            'logo' => null
        ]);
    }
}
