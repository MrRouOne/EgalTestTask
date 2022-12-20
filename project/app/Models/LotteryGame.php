<?php

namespace App\Models;

use Carbon\Carbon;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id                        {@property-type field} {@primary-key}
 * @property string $name                       {@property-type field}
 * @property integer $gamer_count               {@property-type field}
 * @property integer $reward_points             {@property-type field}
 * @property Carbon $created_at                 {@property-type field}
 * @property Carbon $updated_at                 {@property-type field}
 *
 * @property LotteryGameMatch $matches          {@property-type relation}
 *
 * @action getItems                             {@statuses-access guest|logged} {@roles-access admin|user}
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

    public function matches(): HasMany
    {
        return $this->hasMany(LotteryGameMatch::class, 'game_id');
    }
}
