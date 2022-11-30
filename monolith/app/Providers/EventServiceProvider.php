<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Providers;

use App\Events\CreatingLotteryGameMatchEvent;
use App\Events\CreatingUserEvent;
use App\Events\DeletingUserEvent;
use App\Events\UpdatedLotteryGameMatchEvent;
use App\Events\UpdatingLotteryGameMatchEvent;
use App\Events\UpdatingUserEvent;
use App\Listeners\CreatingLotteryGameMatchValidateListener;
use App\Listeners\CreatingUserHashPasswordListener;
use App\Listeners\CreatingUserValidateListener;
use App\Listeners\DeletingUserCheckAdminListener;
use App\Listeners\UpdatedLotteryGameMatchSetWinnerPointsListener;
use App\Listeners\UpdatingLotteryGameMatchCheckWinnerListener;
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
        DeletingUserEvent::class => [
            DeletingUserCheckAdminListener::class,
        ],
        // LotteryGameMatch
        CreatingLotteryGameMatchEvent::class => [
            CreatingLotteryGameMatchValidateListener::class,
        ],
        UpdatedLotteryGameMatchEvent::class => [
            UpdatedLotteryGameMatchSetWinnerPointsListener::class,
        ],
        UpdatingLotteryGameMatchEvent::class => [
            UpdatingLotteryGameMatchCheckWinnerListener::class,
        ],
    ];

}
