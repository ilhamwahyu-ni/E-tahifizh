<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Siswa;
use App\Models\TrKelas;

class SiswaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Siswa::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tr_kelas_id' => TrKelas::factory(),
            'nisn' => fake()->regexify('[A-Za-z0-9]{255}'),
            'name' => fake()->name(),
            'gender' => fake()->randomElement(["Laki-laki","Perempuan"]),
        ];
    }
}
