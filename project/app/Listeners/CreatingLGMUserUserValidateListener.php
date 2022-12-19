<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\ValidatorHelper;

class CreatingLGMUserUserValidateListener extends AbstractListener
{
    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     */
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        ValidatorHelper::validate(
            $model->getAttributes(),
            [
                'lottery_game_match_id' => 'required|integer|exists:lottery_game_matches,id',
                'user_id' => 'required|integer|exists:users,id|owner',
            ]
        );
    }
}
