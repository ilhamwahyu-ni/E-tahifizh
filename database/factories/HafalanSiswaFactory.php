<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\Surah;
use App\Models\TmKelas;
use App\Models\Semester;
use Illuminate\Support\Str;
use App\Models\HafalanSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class HafalanSiswaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HafalanSiswa::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'surah_id' => Surah::factory(),
            'semester_id' => Semester::factory(),
            'tingkat_kelas' => TmKelas::factory()->create()->level,
            'nilai' => fake()->numberBetween(80, 100),
            'status_hafalan' => fake()->randomElement(["belum", "proses", "selesai"]),
        ];
    }
}
