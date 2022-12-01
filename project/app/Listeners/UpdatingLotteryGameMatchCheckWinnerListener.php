<?php

namespace App\Listeners;

use App\Exceptions\MatchOverException;
use Egal\Core\Events\Event;

class UpdatingLotteryGameMatchCheckWinnerListener
{

    public function handle(Event $event)
    {
        if (!is_null($event->getModel()->getOriginal('winner_id'))) {
            throw new MatchOverException();
        }
    }

}
