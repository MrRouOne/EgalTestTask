<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Models\User;

class ClosureLGMatchSetWinnerPointsListener extends AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        $winner = User::query()->lockForUpdate()->findOrFail($model->winner->getAttribute('id'));
        $reward_points = $model->lotteryGame->getAttribute('reward_points');
        $winner->update(['points' => $winner->getAttribute('points') + $reward_points]);
    }
}
