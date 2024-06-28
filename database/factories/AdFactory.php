<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(rand(10, 100)),
            'link' => fake()->url(),
            'clicks_limit' => rand(100, 1000),
            'type' => ['block', 'popup'][rand(0, 1)],
        ];
    }
}
