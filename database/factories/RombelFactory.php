<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Rombel;
use App\Models\Sekolah;
use App\Models\TahunAjaran;
use App\Models\TmKelas;

class RombelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rombel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tahun_ajaran_id' => TahunAjaran::factory(),
            'tm_kelas_id' => TmKelas::factory(),
            'sekolah_id' => Sekolah::factory(),
            'nama_rombongan' => fake()->company(),
            'status' => fake()->randomElement(["aktif", "nonaktif"]),
        ];
    }
}
