<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\ValidatorHelper;

class CreatingLGMatchValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        ValidatorHelper::validate(
            $model->getAttributes(), [
            'game_id' => 'required|integer|exists:lottery_games,id',
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            ]
        );

        $model->setAttribute('winner_id', null);
    }
}
