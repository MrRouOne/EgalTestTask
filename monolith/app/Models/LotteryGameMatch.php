<?php

namespace App\Models;

use App\Events\CreatingLotteryGameMatchEvent;
use App\Events\UpdatedLotteryGameMatchEvent;
use App\Events\UpdatingLotteryGameMatchEvent;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'updated' => UpdatedLotteryGameMatchEvent::class,
        'updating' => UpdatingLotteryGameMatchEvent::class,
    ];

    public static function actionClosure($id)
    {
        $winner = self::query()->findOrFail($id)->users()->inRandomOrder()->first();
        $winner = !$winner ? User::query()->inRandomOrder()->first() : $winner;

        return self::actionUpdate($id, ['winner_id' => $winner->id]);
    }

    public function lotteryGame()
    {
        return $this->belongsTo(LotteryGame::class, 'game_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'lottery_game_match_users', 'lottery_game_match_id', 'user_id');
    }

}
