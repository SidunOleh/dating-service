<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Creator>
 */
class CreatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'password' => 'secret',
            'name' => fake()->name(),
            'age' => rand(18, 100),
            'gender' => ['Man', 'Woman', 'LGBTQ+'][rand(0, 2)],
            'phone' => fake()->phoneNumber(),
            'description' => fake()->text(150),
            'country' => fake()->country(),
            'full_address' => fake()->address(),
            'region' => fake()->state(),
            'city' => fake()->city(),
            'latitude' => fake()->latitude(24, 49),
            'longitude' => fake()->longitude(-125, -67),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birthday' => fake()->date(),
        ];
    }
}
