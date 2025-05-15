<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => $this->faker->catchPhrase(),
            'description' => $this->faker->optional()->paragraph(),
            'demo_link'   => $this->faker->optional()->url(),
            'github_link' => $this->faker->optional()->url(),
            'image'       => $this->faker->optional()->imageUrl(640, 480, 'tech'),
            'status'      => $this->faker->randomElement(['planned', 'current', 'finished']),
        ];
    }
}
