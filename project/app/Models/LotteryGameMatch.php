<?php

namespace App\Models;

use App\Events\CreatingLotteryGameMatchEvent;
use App\Events\UpdatedLotteryGameMatchEvent;
use App\Events\UpdatingLotteryGameMatchEvent;
use App\Helpers\ValidatorHelper;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id                        {@property-type field} {@primary-key}
 * @property $game_id                   {@property-type field}
 * @property $start_date                {@property-type field}
 * @property $start_time                {@property-type field}
 * @property $winner_id                 {@property-type field}
 * @property $created_at                {@property-type field}
 * @property $updated_at                {@property-type field}
 *
 * @action create                       {@statuses-access logged} {@roles-access admin}
 * @action closure                      {@statuses-access logged} {@roles-access admin}
 * @action getItems                     {@statuses-access guest|logged} {@roles-access admin|user}
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
        'updating' => UpdatingLotteryGameMatchEvent::class,
        'updated' => UpdatedLotteryGameMatchEvent::class,
    ];


    public static function actionClosure($id): array
    {
        ValidatorHelper::validate(['id' => $id], [
            'id' => 'required|integer|exists:lottery_game_matches',
        ]);

        return self::actionUpdate($id, ['winner_id' => 1]);
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
        return $this->belongsToMany(User::class, 'lottery_game_match_users', 'lottery_game_match_id', 'user_id');
    }

}
