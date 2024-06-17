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
            'email' => fake()->unique()->email(),
            'password' => 'secret',
            'photos' => [3,],
            'name' => fake()->name(),
            'age' => rand(18, 100),
            'gender' => ['Man', 'Woman', 'LGBTQ+'][rand(0, 2)],
            'phone' => fake()->phoneNumber(),
            'description' => fake()->text(150),
            'profile_email' => fake()->email(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birthday' => fake()->date(),
            'id_photo' => 1,
            'street_photo' => 1,
        ];
    }
}
