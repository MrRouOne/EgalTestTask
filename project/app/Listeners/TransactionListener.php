<?php

namespace App\Listeners;

use App\Constants\LockTableModsConstants;
use App\Events\AbstractEvent;
use Illuminate\Support\Facades\DB;

class TransactionListener
{
    public function transaction(
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
