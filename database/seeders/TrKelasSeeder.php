<?php

namespace Database\Seeders;

use App\Models\TrKelas;
use Illuminate\Database\Seeder;

class TrKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TrKelas::factory()->count(5)->create();
    }
}
