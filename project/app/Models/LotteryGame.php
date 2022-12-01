<?php

namespace App\Models;


use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property $id                        {@property-type field} {@primary-key}
 * @property $name                      {@property-type field}
 * @property $gamer_count               {@property-type field}
 * @property $reward_points             {@property-type field}
 * @property $created_at                {@property-type field}
 * @property $updated_at                {@property-type field}
 *
 * @action getItems                     {@statuses-access guest|logged} {@roles-access admin|user}
 */
class LotteryGame extends EgalModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gamer_count',
        'reward_points',
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];


    public function lotteryGameMatches(): HasMany
    {
        return $this->hasMany(LotteryGameMatch::class, 'game_id');
    }
}
