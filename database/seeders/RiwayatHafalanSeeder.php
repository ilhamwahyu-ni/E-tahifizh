<?php

namespace Database\Seeders;

use App\Models\RiwayatHafalan;
use Illuminate\Database\Seeder;

class RiwayatHafalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RiwayatHafalan::factory()->count(5)->create();
    }
}
