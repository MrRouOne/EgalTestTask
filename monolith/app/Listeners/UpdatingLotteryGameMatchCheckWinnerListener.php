<?php

namespace App\Listeners;

use Egal\Core\Events\Event;

class UpdatingLotteryGameMatchCheckWinnerListener
{

    public function handle(Event $event)
    {
        $model = $event->getModel();
        if ($model->getOriginal('winner_id') !== NULL) {
            throw new \Exception('The match is already over. The winner is announced.',400);
        }
    }

}
