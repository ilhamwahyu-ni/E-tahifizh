<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Rombel;
use App\Models\Sekolah;
use App\Models\Siswa;

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
            'nama' => fake()->regexify('[A-Za-z0-9]{100}'),
            'nis' => fake()->regexify('[A-Za-z0-9]{20}'),
            'rombel_id' => Rombel::factory(),
            'sekolah_id' => Sekolah::factory(),
            'jenis_kelamin' => fake()->randomElement(["L","P"]),
            'status' => fake()->randomElement(["aktif","nonaktif","lulus","pindah"]),
        ];
    }
}
