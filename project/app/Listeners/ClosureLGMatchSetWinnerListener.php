<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Models\LotteryGameMatch;
use App\Models\User;

class ClosureLGMatchSetWinnerListener extends AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        $model = LotteryGameMatch::query()->lockForUpdate()->findOrFail($event->getModel()->getAttribute('id'));

        $winner = $model->users()->inRandomOrder()->first();
        $winner = $winner ?: User::query()->inRandomOrder()->firstOrFail();

        $model->update(['winner_id' => $winner->id]);
    }
}
