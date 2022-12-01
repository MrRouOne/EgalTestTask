<?php

namespace App\Listeners;

use App\Exceptions\MatchOverException;
use Egal\Core\Events\Event;

class CreatingLotteryGameMatchUserCheckClosureListener
{

    public function handle(Event $event): void
    {
        $model = $event->getModel();

        if (!is_null($model->match->getAttribute('winner_id'))) {
            throw new MatchOverException();
        }
    }

}
