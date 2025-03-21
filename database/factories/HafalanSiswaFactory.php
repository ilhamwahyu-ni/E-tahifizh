<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\HafalanSiswa;
use App\Models\Siswa;
use App\Models\Surah;
use App\Models\Tahfidz;

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
            'surah_id' => fake()->numberBetween(1, 114),
            'tahfidz_id' => Tahfidz::factory(),
        ];
    }
}
