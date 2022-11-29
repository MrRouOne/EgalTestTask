<?php

namespace Database\Factories;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotteryGameMatchFactory extends Factory
{

    protected $model = LotteryGameMatch::class;

    public function definition(): array
    {
        return [
            'game_id' => LotteryGame::factory(),
            'start_date' => $this->faker->date,
            'start_time' => $this->faker->time,
            'winner_id' => User::factory(),
        ];
    }

}
