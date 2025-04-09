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
        TmKelas::factory()->count(5)->create();
    }
}
