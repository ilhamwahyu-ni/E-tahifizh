<?php

namespace Database\Factories;

use App\Models\PenilaianTahsin;
use App\Models\Siswa;
use App\Models\MateriTahsin;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenilaianTahsinFactory extends Factory
{
    protected $model = PenilaianTahsin::class;

    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'nilai_angka' => $this->faker->numberBetween(60, 100),
            'tanggal_penilaian' => $this->faker->dateTimeBetween('-6 months', 'now'),

        ];
    }
}
