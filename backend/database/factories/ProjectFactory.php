<?php

namespace Database\Factories;

use App\Models\User; // Ensure User is imported
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'        => $this->faker->company, // Changed from title to name, using company for variety
            'description' => $this->faker->optional()->paragraph(),
            'demo_link'   => $this->faker->optional()->url(),
            'github_link' => $this->faker->optional()->url(),
            'image'       => $this->faker->optional()->imageUrl(640, 480, 'tech'),
            'status'      => $this->faker->randomElement(['planned', 'current', 'finished']),
            'user_id'     => User::factory(), // Add user_id
        ];
    }
}
