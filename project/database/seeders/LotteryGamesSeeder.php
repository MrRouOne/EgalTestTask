<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;
use Illuminate\Database\Seeder;

class LotteryGamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dispatcher = LotteryGameMatch::getEventDispatcher();
        LotteryGameMatch::unsetEventDispatcher();

        $users = User::query()->get();

        LotteryGame::factory()
            ->has(
                LotteryGameMatch::factory()
                    ->count(3)
                    ->sequence(fn($sequence) => ['winner_id' => $users->random()])
                    ->hasAttached($users),
                'matches'
            )
            ->count(3)
            ->create();

        LotteryGameMatch::setEventDispatcher($dispatcher);
    }
}
