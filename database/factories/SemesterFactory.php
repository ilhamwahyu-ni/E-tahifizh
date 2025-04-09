<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Semester;
use App\Models\TahunAjaran;

class SemesterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Semester::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->randomElement(["Ganjil","Genap"]),
            'tahun_ajaran_id' => TahunAjaran::factory(),
            'status' => fake()->randomElement(["aktif","nonaktif"]),
        ];
    }
}
