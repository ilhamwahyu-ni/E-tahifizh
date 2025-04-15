<?php

namespace Database\Factories;

use App\Models\Semester;
use App\Models\TahunAjaran; // Import TahunAjaran
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Semester>
 */
class SemesterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan ada TahunAjaran sebelum membuat Semester
        $tahunAjaran = TahunAjaran::inRandomOrder()->first() ?? TahunAjaran::factory()->create();

        return [
            'type' => $this->faker->randomElement([Semester::TYPE_GANJIL, Semester::TYPE_GENAP]),
            'is_active' => $this->faker->boolean(80), // 80% chance true
            'tahun_ajaran_id' => $tahunAjaran->id
        ];
    }
}
