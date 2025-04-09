<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Surah;

class SurahFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Surah::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'no' => fake()->numberBetween(-10000, 10000),
            'nama' => fake()->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
