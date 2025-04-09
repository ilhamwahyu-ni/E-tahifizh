<?php

namespace Database\Seeders;

use App\Models\Surah;
use Illuminate\Database\Seeder;

class SurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Surah::factory()->count(5)->create();
    }
}
