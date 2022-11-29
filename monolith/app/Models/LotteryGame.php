<?php

namespace App\Models;

use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property $id {@property-type field} {@primary-key}
 * @property $name {@property-type field}
 * @property $gamer_count {@property-type field}
 * @property $reward_points {@property-type field}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getMetadata {@statuses-access guest|logged}
 * @action getItem {@statuses-access guest|logged}
 * @action getItems {@statuses-access logged} {@roles-access super_first_role|super_second_role}
 * @action create {@statuses-access logged} {@roles-access super_first_role,super_second_role}
 * @action update {@statuses-access logged}
 * @action delete {@statuses-access logged}
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

    public function lotteryGameMatches()
    {
        return $this->hasMany(LotteryGameMatch::class,'game_id');
    }
}
