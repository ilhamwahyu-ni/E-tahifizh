<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TahunAjaran;

class TahunAjaranFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TahunAjaran::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tahun' => fake()->unique()->numerify('####/####'),
            'nama' => 'Tahun Ajaran ' . fake()->unique()->numerify('####/####'),
            'is_active' => false,
        ];
    }

    public function active(): self
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }
}
