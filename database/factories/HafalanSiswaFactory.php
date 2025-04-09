<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\Surah;

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
            'tingkat_kelas' => fake()->regexify('[A-Za-z0-9]{10}'),
            'nilai' => fake()->regexify('[A-Za-z0-9]{10}'),
            'status_hafalan' => fake()->randomElement(["belum","proses","selesai"]),
        ];
    }
}
