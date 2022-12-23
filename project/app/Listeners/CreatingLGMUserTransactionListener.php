<?php

namespace App\Listeners;

use App\Constants\LockTableModsConstants;
use App\Events\AbstractEvent;
use App\Helpers\TransactionHelper;

class CreatingLGMUserTransactionListener
{
    public function handle(AbstractEvent $event): void
    {
        TransactionHelper::transactionWithLock(
            $event,
            LockTableModsConstants::ROW_EXCLUSIVE,
            CreatingLGMUserAssignValidateListener::class,
            CreatingLGMUserCheckClosureListener::class,
            CreatingLGMUserCheckAlreadyRecordListener::class,
            CreatingLGMUserCheckGamerCountListener::class,
        );
    }
}
