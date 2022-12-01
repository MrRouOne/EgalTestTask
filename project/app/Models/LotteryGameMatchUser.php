<?php

namespace App\Models;

use App\Events\CreatingLotteryGameMatchUserEvent;
use Egal\Core\Session\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property $id                        {@property-type field} {@primary-key}
 * @property $user_id                   {@property-type field}
 * @property $lottery_game_match_id     {@property-type field}
 * @property $created_at                {@property-type field}
 * @property $updated_at                {@property-type field}
 *
 * @action recordToMatch                       {@statuses-access logged} {@roles-access user}
 */
class LotteryGameMatchUser extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lottery_game_match_id',
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        'creating' => CreatingLotteryGameMatchUserEvent::class
    ];


    public static function actionRecordToMatch($attributes): array
    {
        $attributes['user_id'] = Session::getUserServiceToken()->getAuthInformation()['id'];
        return parent::actionCreate($attributes);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(LotteryGameMatch::class, 'lottery_game_match_id');
    }
}
