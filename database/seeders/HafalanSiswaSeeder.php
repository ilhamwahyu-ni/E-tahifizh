<?php

namespace Database\Seeders;

use App\Models\HafalanSiswa;
use Illuminate\Database\Seeder;

class HafalanSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HafalanSiswa::factory()->count(5)->create();
    }
}
