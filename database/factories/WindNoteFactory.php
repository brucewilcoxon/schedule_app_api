<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WindNote>
 */
class WindNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d');
        return [
            'title' => $this->faker->realText(rand(15, 20)),
            'content' => $this->faker->realText(rand(20, 30)),
            'date' => $date,
        ];
    }
}
