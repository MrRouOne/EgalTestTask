<?php

namespace App\Models;

use App\Events\ClosureLotteryGameMatchEvent;
use App\Events\CreatingLotteryGameMatchEvent;
use App\Helpers\ValidatorHelper;
use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer $id                        {@property-type field} {@primary-key}
 * @property integer $game_id                   {@property-type field}
 * @property Carbon $start_date                 {@property-type field}
 * @property Carbon $start_time                 {@property-type field}
 * @property integer $winner_id                 {@property-type field}
 * @property Carbon $created_at                 {@property-type field}
 * @property Carbon $updated_at                 {@property-type field}
 *
 * @property User $users                        {@property-type relation}
 * @property User $winner                       {@property-type relation}
 * @property LotteryGame $lottery_game          {@property-type relation}
 *
 * @action create                               {@statuses-access logged} {@roles-access admin}
 * @action closure                              {@statuses-access logged} {@roles-access admin}
 * @action getItems                             {@statuses-access guest|logged} {@roles-access admin|user}
 */
class LotteryGameMatch extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'start_date',
        'start_time',
        'winner_id',
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        'creating' => CreatingLotteryGameMatchEvent::class,
    ];

    /**
     * @throws \Egal\Model\Exceptions\ValidateException
     * @throws \Egal\Model\Exceptions\ObjectNotFoundException
     * @throws \Egal\Model\Exceptions\UpdateException
     */
    public static function actionClosure($id): array
    {
        ValidatorHelper::validate(
            ['id' => $id],
            ['id' => 'required|integer|exists:lottery_game_matches',]
        );

        $instance = static::query()->find($id);

        event(new ClosureLotteryGameMatchEvent($instance));

        return $instance->toArray();
    }

    public function lotteryGame(): BelongsTo
    {
        return $this->belongsTo(LotteryGame::class, 'game_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'lottery_game_match_users',
            'lottery_game_match_id',
            'user_id'
        );
    }
}
