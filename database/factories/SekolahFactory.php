<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Sekolah;

class SekolahFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sekolah::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->regexify('[A-Za-z0-9]{100}'),
            'alamat' => fake()->text(),
            'logo' => fake()->word(),
            'status' => fake()->randomElement(["aktif","nonaktif"]),
        ];
    }
}
