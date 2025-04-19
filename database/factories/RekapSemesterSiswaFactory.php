<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\RekapSemesterSiswa;
use App\Models\Semester;
use App\Models\Siswa;

class RekapSemesterSiswaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RekapSemesterSiswa::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'catatan_global_hafalan' => $this->faker->paragraph(1), // Contoh catatan dummy hafalan
            'catatan_global_tahsin' => $this->faker->paragraph(1), // Contoh catatan dummy tahsin
        ];
    }
}
