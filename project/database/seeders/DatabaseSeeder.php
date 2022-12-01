<?php

namespace Database\Seeders;

use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
        ]);

        $users = User::factory()->count(5)->create();

        $dispatcher = LotteryGameMatch::getEventDispatcher();
        LotteryGameMatch::unsetEventDispatcher();

        LotteryGame::factory()
            ->has(LotteryGameMatch::factory()->count(3)
                ->sequence(fn($sequence) => ['winner_id' => $users->random()])
                ->hasAttached($users)
            )->count(3)->create();

        LotteryGameMatch::setEventDispatcher($dispatcher);
    }
}
