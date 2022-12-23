<?php

namespace App\Helpers;

use App\Constants\LockTableModsConstants;
use App\Events\AbstractEvent;
use Illuminate\Support\Facades\DB;

class TransactionHelper
{
    public static function transaction(AbstractEvent $event, string ...$listeners): void
    {
        DB::transaction(
            function () use ($event, $listeners) {
                foreach ($listeners as $listener) {
                    (new $listener)->handle($event);
                }
            }
        );
    }

    public static function transactionWithLock(
        AbstractEvent $event,
        string        $mode = LockTableModsConstants::ACCESS_EXCLUSIVE,
        string        ...$listeners
    ): void
    {
        $table = $event->getModel()->getTable();

        DB::transaction(
            function () use ($event, $mode, $table, $listeners) {
                DB::statement(
                    DB::raw("LOCK TABLE $table IN $mode MODE")
                );

                foreach ($listeners as $listener) {
                    (new $listener)->handle($event);
                }
            }
        );
    }
}
