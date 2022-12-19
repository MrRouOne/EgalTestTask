<?php

namespace App\Listeners;

use App\Constants\LockTableModsConstants;
use App\Events\AbstractEvent;

class ClosureLGMatchTransactionListener extends TransactionListener
{
    public function handle(AbstractEvent $event): void
    {
        $this->transaction(
            $event,
            LockTableModsConstants::ACCESS_EXCLUSIVE,
            ClosureLGMatchCheckWinnerListener::class,
            ClosureLGMatchSetWinnerListener::class,
            ClosureLGMatchSetWinnerPointsListener::class,
        );
    }
}
