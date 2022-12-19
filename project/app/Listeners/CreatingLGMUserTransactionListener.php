<?php

namespace App\Listeners;

use App\Constants\LockTableModsConstants;
use App\Events\AbstractEvent;

class CreatingLGMUserTransactionListener extends TransactionListener
{
    public function handle(AbstractEvent $event): void
    {
        $this->transaction(
            $event,
            LockTableModsConstants::ACCESS_EXCLUSIVE,
            CreatingLGMUserAssignValidateListener::class,
            CreatingLGMUserCheckClosureListener::class,
            CreatingLGMUserCheckAlreadyRecordListener::class,
            CreatingLGMUserCheckGamerCountListener::class,
        );
    }
}
