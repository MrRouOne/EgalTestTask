<?php

namespace App\Models;

use App\Events\CreatingLotteryGameMatchUserEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id                        {@property-type field} {@primary-key}
 * @property integer $user_id                   {@property-type field}
 * @property integer $lottery_game_match_id     {@property-type field}
 * @property Carbon $created_at                 {@property-type field}
 * @property Carbon $updated_at                 {@property-type field}
 *
 * @property User $user                         {@property-type relation}
 * @property LotteryGameMatch $match            {@property-type relation}
 *
 * @action create                               {@statuses-access logged} {@roles-access admin|user}
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(LotteryGameMatch::class, 'lottery_game_match_id');
    }
}
