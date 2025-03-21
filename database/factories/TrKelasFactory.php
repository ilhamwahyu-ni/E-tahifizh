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
        return [
            'tm_kelas_id' => TmKelas::factory(),
            'nama' => fake()->word(),
            'ruangan' => fake()->word(),
            'siswa_aktif' => fake()->numberBetween(-10000, 10000),
            'ajaran' => '2024',
            'semester' => 1,
            'status' => fake()->randomElement(["Aktif", "Tidak_Aktif"]),
            'user_id' => User::factory(),
        ];
    }
}
