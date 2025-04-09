<?php

namespace Database\Seeders;

use App\Models\RekapSemesterSiswa;
use Illuminate\Database\Seeder;

class RekapSemesterSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RekapSemesterSiswa::factory()->count(5)->create();
    }
}
