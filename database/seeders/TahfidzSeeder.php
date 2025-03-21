<?php

namespace Database\Seeders;

use App\Models\Tahfidz;
use Illuminate\Database\Seeder;

class TahfidzSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tahfidz::factory()->count(5)->create();
    }
}
