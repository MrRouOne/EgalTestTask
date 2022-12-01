<?php

namespace App\Listeners;

use App\Helpers\ValidatorHelper;
use Egal\Core\Events\Event;


class CreatingLotteryGameMatchValidateListener
{

    public function handle(Event $event): void
    {
        $model = $event->getModel();

        ValidatorHelper::validate($model->getAttributes(), [
            'game_id' => 'required|integer|exists:lottery_games,id',
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
        ]);

        $model->setAttribute('winner_id', NULL);
    }

}
