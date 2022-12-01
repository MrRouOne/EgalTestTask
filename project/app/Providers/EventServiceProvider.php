<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Providers;

use App\Events\CreatingLotteryGameMatchEvent;
use App\Events\CreatingLotteryGameMatchUserEvent;
use App\Events\CreatingUserEvent;
use App\Events\UpdatedLotteryGameMatchEvent;
use App\Events\UpdatingLotteryGameMatchEvent;
use App\Events\UpdatingUserEvent;
use App\Listeners\CreatingLotteryGameMatchUserCheckAlreadyRecordListener;
use App\Listeners\CreatingLotteryGameMatchUserCheckClosureListener;
use App\Listeners\CreatingLotteryGameMatchUserCheckGamerCountListener;
use App\Listeners\CreatingLotteryGameMatchUserValidateListener;
use App\Listeners\CreatingLotteryGameMatchValidateListener;
use App\Listeners\CreatingUserHashPasswordListener;
use App\Listeners\CreatingUserValidateListener;
use App\Listeners\UpdatedLotteryGameMatchSetWinnerPointsListener;
use App\Listeners\UpdatingLotteryGameMatchCheckWinnerListener;
use App\Listeners\UpdatingLotteryGameMatchSetWinnerListener;
use App\Listeners\UpdatingUserHashPasswordListener;
use App\Listeners\UpdatingUserValidateListener;
use Egal\Core\Events\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * Определение обработчиков локальных событий
     */
    protected $listen = [
        // User
        CreatingUserEvent::class => [
            CreatingUserValidateListener::class,
            CreatingUserHashPasswordListener::class,
        ],
        UpdatingUserEvent::class => [
            UpdatingUserValidateListener::class,
            UpdatingUserHashPasswordListener::class
        ],
        // LotteryGameMatch
        CreatingLotteryGameMatchEvent::class => [
            CreatingLotteryGameMatchValidateListener::class,
        ],
        UpdatingLotteryGameMatchEvent::class => [
            UpdatingLotteryGameMatchSetWinnerListener::class,
            UpdatingLotteryGameMatchCheckWinnerListener::class,
        ],
        UpdatedLotteryGameMatchEvent::class => [
            UpdatedLotteryGameMatchSetWinnerPointsListener::class,
        ],
        // LotteryGameMatchUser
        CreatingLotteryGameMatchUserEvent::class => [
            CreatingLotteryGameMatchUserValidateListener::class,
            CreatingLotteryGameMatchUserCheckClosureListener::class,
            CreatingLotteryGameMatchUserCheckAlreadyRecordListener::class,
            CreatingLotteryGameMatchUserCheckGamerCountListener::class,
        ],
    ];

}
