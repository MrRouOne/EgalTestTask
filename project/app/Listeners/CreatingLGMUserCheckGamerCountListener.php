<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use Exception;

class CreatingLGMUserCheckGamerCountListener extends AbstractListener
{
    /**
     * @throws Exception
     */
    public function handle(AbstractEvent $event): void
    {
        $match = $event->getModel()->match;

        $max_count = $match->lotteryGame->getAttribute('gamer_count');
        $current_count = $match->users->count();

        if ($current_count >= $max_count) {
            throw new Exception("There is no recording space in the game.", 400);
        }
    }
}
