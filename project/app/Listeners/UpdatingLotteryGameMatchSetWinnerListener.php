<?php

namespace App\Listeners;

use App\Models\LotteryGameMatch;
use App\Models\User;
use Egal\Core\Events\Event;

class UpdatingLotteryGameMatchSetWinnerListener
{

    public function handle(Event $event): void
    {
        $model = $event->getModel();

        $winner = $model->users()->inRandomOrder()->first();
        $winner = !$winner ? User::query()->inRandomOrder()->first() : $winner;

        $model->setAttribute('winner_id', $winner->id);
    }

}
