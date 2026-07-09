<?php

namespace Database\Factories;

use App\Models\Compte;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Compte>
 */
class CompteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'telephone' => $this->faker->unique()->phoneNumber(),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'password' => Hash::make('password'),
        ];
    }
}
