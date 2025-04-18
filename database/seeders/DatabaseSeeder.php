<?php

namespace Database\Seeders;

use App\Models\MateriTahsin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);


        //call BookSeeder
        $this->call(
            [
                    // BookSeeder::class,
                    // PostSeeder::class,
                    // ContactSeeder::class,
                SekolahSeeder::class,
                TmKelasSeeder::class,
                TahunAjaranSeeder::class,
                SemesterSeeder::class,
                SurahSeeder::class,
                RombelSeeder::class,
                SiswaSeeder::class,
                RekapSemesterSiswaSeeder::class,
                HafalanSiswaSeeder::class,
                MateriTahsinSeeder::class,
                PenilaianTahsinSeeder::class,
            ]
        );
    }
}
