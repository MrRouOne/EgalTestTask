<?php

namespace Database\Factories;

use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LotteryGameMatchUserFactory extends Factory
{

    protected $model = LotteryGameMatchUser::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'lottery_game_match_id' => LotteryGameMatch::factory(),
        ];
    }

}
