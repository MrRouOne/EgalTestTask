<?php

namespace App\Listeners;

use App\Helpers\ValidatorHelper;
use Egal\Core\Events\Event;

class CreatingLotteryGameMatchUserValidateListener
{

    public function handle(Event $event): void
    {
        ValidatorHelper::validate($event->getModel()->getAttributes(), [
            'lottery_game_match_id' => 'required|integer|exists:lottery_game_matches,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);
    }

}
