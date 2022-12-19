<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use Exception;
use Illuminate\Support\Facades\DB;

class CreatingLGMUserCheckGamerCountListener extends AbstractListener
{
    /**
     * @throws Exception
     */
    public function handle(AbstractEvent $event): void
    {
        DB::beginTransaction();

        DB::statement(DB::raw('LOCK TABLE lottery_game_match_users IN ACCESS EXCLUSIVE MODE'));

        $match = $event->getModel()->match;

        $max_count = $match->lotteryGame->getAttribute('gamer_count');
        $current_count = $match->users->count();

        if ($current_count >= $max_count) {
            DB::rollBack();
            throw new Exception("There is no recording space in the game.", 400);
        }

        DB::commit();
    }
}
