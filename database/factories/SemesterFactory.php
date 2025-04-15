<?php

namespace Database\Factories;

use App\Models\Semester;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class SemesterFactory extends Factory
{
    protected $model = Semester::class;

    public function definition(): array
    {
        $tahunAjaran = TahunAjaran::inRandomOrder()->first() ?? TahunAjaran::factory()->create();

        return [
            'type' => $this->faker->randomElement([Semester::TYPE_GANJIL, Semester::TYPE_GENAP]),
            'is_active' => $this->faker->boolean(80),
            'tahun_ajaran_id' => $tahunAjaran->id,
        ];
    }

    public function active(): Factory
    {
        return $this->state(fn() => ['is_active' => true]);
    }

    public function inactive(): Factory
    {
        return $this->state(fn() => ['is_active' => false]);
    }

    public function ganjil(): Factory
    {
        return $this->state(fn() => ['type' => Semester::TYPE_GANJIL]);
    }

    public function genap(): Factory
    {
        return $this->state(fn() => ['type' => Semester::TYPE_GENAP]);
    }
}
