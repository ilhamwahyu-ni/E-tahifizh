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
        Sekolah::factory()->create([
            'nama' => 'sekolah maarif padang panjang',
            'alamat' => 'Alamat default untuk seeder', // Default address
            'logo' => 'logo_default.png', // Default logo path or identifier
            'status' => 'aktif', // Default status
        ]);
    }
}
