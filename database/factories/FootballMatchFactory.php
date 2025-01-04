<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FootballMatch>
 */
class FootballMatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_home' => $this->faker->city() . ' FC',
            'team_away' => $this->faker->city() . ' United',
            'match_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'stadium' => $this->faker->company() . ' Stadium',
        ];
    }
}
