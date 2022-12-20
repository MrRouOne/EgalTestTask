<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Models\User;

class ClosureLGMatchSetWinnerListener extends AbstractListener
{
    public function handle(AbstractEvent $event): void
    {
        $model = $event->getModel();
        $winner = $model->users()->inRandomOrder()->first();

        $winner = $winner ?: User::query()->inRandomOrder()->firstOrFail();

        $model->update(['winner_id' => $winner->id]);
    }
}
