<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fournisseur>
 */
class FournisseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->postcode(),
            'nom' => fake()->firstNameMale(),
            'siege' => fake()->name(),
            'email' => fake()->firstNameMale() . '@'. fake()->firstNameFemale() .'.com',
            'telephon' => fake()->e164PhoneNumber(),
            'post' => fake()->postcode(),
        ];
    }
}
