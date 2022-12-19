<?php

namespace App\Providers;

use App\Events\ClosureLotteryGameMatchEvent;
use App\Events\CreatingLotteryGameMatchEvent;
use App\Events\CreatingLotteryGameMatchUserEvent;
use App\Events\CreatingUserEvent;
use App\Events\DeletingUserEvent;
use App\Events\UpdatingUserEvent;
use App\Listeners\ClosureLGMatchTransactionListener;
use App\Listeners\CreatingLGMatchValidateListener;
use App\Listeners\CreatingLGMUserTransactionListener;
use App\Listeners\CreatingUserValidateListener;
use App\Listeners\DeletingUserAssignValidateListener;
use App\Listeners\HashingPasswordListener;
use App\Listeners\UpdatingUserAssignValidateListener;
use Egal\Core\Events\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // User
        CreatingUserEvent::class => [
            CreatingUserValidateListener::class,
            HashingPasswordListener::class,
        ],
        UpdatingUserEvent::class => [
            UpdatingUserAssignValidateListener::class,
            HashingPasswordListener::class
        ],
        DeletingUserEvent::class => [
            DeletingUserAssignValidateListener::class,
        ],
        // LotteryGameMatch
        CreatingLotteryGameMatchEvent::class => [
            CreatingLGMatchValidateListener::class,
        ],
        ClosureLotteryGameMatchEvent::class => [
            ClosureLGMatchTransactionListener::class,
        ],
        // LotteryGameMatchUser
        CreatingLotteryGameMatchUserEvent::class => [
            CreatingLGMUserTransactionListener::class
        ],
    ];
}
