<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Models\LotteryGameMatchUser;
use Exception;

class CreatingLGMUserCheckAlreadyRecordListener extends AbstractListener
{
    /**
     * @throws Exception
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $record_exist = LotteryGameMatchUser::query()->where(
            [
                ['user_id', '=', $model->getAttribute('user_id')],
                ['lottery_game_match_id', '=', $model->getAttribute('lottery_game_match_id')],
            ]
        )->exists();

        if ($record_exist) {
            throw new Exception("You have already signed up for this match.", 400);
        }
    }
}
