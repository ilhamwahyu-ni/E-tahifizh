<?php

namespace Database\Seeders;

use App\Models\Rombel;
use Illuminate\Database\Seeder;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rombel::factory()->count(5)->create();
    }
}
