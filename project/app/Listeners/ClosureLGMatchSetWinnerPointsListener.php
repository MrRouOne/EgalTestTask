<?php

namespace App\Listeners;

use App\Events\AbstractEvent;

class ClosureLGMatchSetWinnerPointsListener extends AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();

        $winner = $model->winner;
        $reward_points = $model->lotteryGame->getAttribute('reward_points');
        $winner->update(['points' => $winner->getAttribute('points') + $reward_points]);
    }
}
