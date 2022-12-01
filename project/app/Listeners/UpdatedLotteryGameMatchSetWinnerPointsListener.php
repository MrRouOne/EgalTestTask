<?php

namespace App\Listeners;

use App\Models\User;
use Egal\Core\Events\Event;

class UpdatedLotteryGameMatchSetWinnerPointsListener
{

    public function handle(Event $event): void
    {
        $model = $event->getModel();

        $winner = $model->getAttribute('winner_id');
        $reward_points = $model->lotteryGame->getAttribute('reward_points');

        $user = User::query()->findOrFail($winner);
        $user->update(['points' => $user->getAttribute('points') + $reward_points]);
    }

}
