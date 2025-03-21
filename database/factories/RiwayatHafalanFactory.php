<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\RiwayatHafalan;
use App\Models\Siswa;
use App\Models\Surah;

class RiwayatHafalanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RiwayatHafalan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'surah_id' => fake()->numberBetween(1, 114),
            'tanggal_hafalan' => fake()->date(),
            'nilai' => fake()->numberBetween(-10000, 10000),


            'status' => fake()->randomElement(["Belum_Hafal", "Lancar", "Mutqin"]),
            'ajaran' => fake()->randomElement(['2023', '2024', '2025']),
            'semester' => fake()->randomElement([1, 2]),
        ];
    }
}
