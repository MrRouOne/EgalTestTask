<?php

namespace Database\Factories;

use App\Models\LotteryGame;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotteryGameFactory extends Factory
{

    protected $model = LotteryGame::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->title,
            'gamer_count' => $this->faker->numberBetween(5, 100),
            'reward_points' => $this->faker->numberBetween(50, 1000),
        ];
    }

}
