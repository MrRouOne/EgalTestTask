<?php

namespace App\Listeners;

use Egal\Core\Events\Event;
use Exception;

class CreatingLotteryGameMatchUserCheckGamerCountListener
{

    public function handle(Event $event): void
    {
        $match = $event->getModel()->match;

        $max_count = $match->lotteryGame->getAttribute('gamer_count');
        $current_count = $match->users->count();

        if ($current_count >= $max_count) {
            throw new Exception("There is no recording space in the game.",400);
        }
    }

}
