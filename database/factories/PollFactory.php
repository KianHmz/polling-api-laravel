<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'choices' => [
                'Option A',
                'Option B',
                'Option C',
            ],
            'status' => 'active',
            'expires_at' => now()->addDays(rand(1, 10)),
        ];
    }
}
