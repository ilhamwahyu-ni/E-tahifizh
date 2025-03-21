<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TmKelas;
use App\Models\TrKelas;
use App\Models\User;

class TrKelasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrKelas::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Ensure we have at least one TmKelas
        if (TmKelas::count() === 0) {
            $sekolah = \App\Models\Sekolah::first() ?? \App\Models\Sekolah::factory()->create();
            for ($i = 1; $i <= 6; $i++) {
                TmKelas::create([
                    'sekolah_id' => $sekolah->id,
                    'nama' => 'Kelas ' . $i,
                    'tingkat' => $i
                ]);
            }
        }

        $tmKelas = TmKelas::inRandomOrder()->first();
        $section = chr(rand(65, 67)); // Generates A, B, or C

        return [
            'tm_kelas_id' => $tmKelas->id,
            'nama' => $tmKelas->nama . ' ' . $section,
            'ruangan' => 'Ruang ' . $tmKelas->tingkat . $section,
            'siswa_aktif' => fake()->numberBetween(20, 35),
            'ajaran' => '2024',
            'semester' => 1,
            'status' => 'Aktif',

        ];
    }
}
