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
            'npsn' => '12345678',
            'name' => 'Maarif',
            'ajaran' => '2024',
            'semester' => 1,
            'logo' => null
        ]);
    }
}
