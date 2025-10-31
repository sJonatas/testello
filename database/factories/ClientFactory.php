<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => fake()->name,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
        ];
    }
}
