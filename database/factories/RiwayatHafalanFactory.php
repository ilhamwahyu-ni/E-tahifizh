<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\HafalanSiswa;
use App\Models\RiwayatHafalan;

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
            'hafalan_siswa_id' => HafalanSiswa::factory(),
            'catatan' => fake()->text(),
            'status' => fake()->randomElement(["baru","diperbarui","dihapus"]),
            'tanggal' => fake()->dateTime(),
        ];
    }
}
