<?php

namespace App\Listeners;

use App\Events\AbstractEvent;
use App\Helpers\TransactionHelper;

class ClosureLGMatchTransactionListener
{
    public function handle(AbstractEvent $event): void
    {
        TransactionHelper::transaction(
            $event,
            ClosureLGMatchCheckWinnerListener::class,
            ClosureLGMatchSetWinnerListener::class,
            ClosureLGMatchSetWinnerPointsListener::class,
        );
    }
}
