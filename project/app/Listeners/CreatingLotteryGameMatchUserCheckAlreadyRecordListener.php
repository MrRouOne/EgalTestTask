<?php

namespace App\Listeners;

use App\Models\LotteryGameMatchUser;
use Egal\Core\Events\Event;
use Exception;

class CreatingLotteryGameMatchUserCheckAlreadyRecordListener
{

    public function handle(Event $event): void
    {
        $model = $event->getModel();

        if (LotteryGameMatchUser::query()->where([
            ['user_id', '=', $model->getAttribute('user_id')],
            ['lottery_game_match_id', '=', $model->getAttribute('lottery_game_match_id')],
        ])->exists()) {
            throw new Exception("You have already signed up for this match.", 400);
        }
    }

}
