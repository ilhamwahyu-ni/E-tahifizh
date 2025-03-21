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
        $sekolah = \App\Models\Sekolah::first();

        for ($i = 1; $i <= 6; $i++) {
            TmKelas::create([
                'sekolah_id' => $sekolah->id,
                'nama' => 'Kelas ' . $i,
                'tingkat' => $i
            ]);
        }
    }
}
